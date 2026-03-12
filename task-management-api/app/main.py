from fastapi import FastAPI, HTTPException
from pydantic import BaseModel, Field
from typing import List, Optional
import pandas as pd
from jcopml.utils import load_model

API_ENDPOINT = "/api/sort-tasks"

# 1. Inisialisasi FastAPI
app = FastAPI(title="Task Prioritization AI API", version="1.0")

# 2. Load Model
try:
    model = load_model("model/task-management-NB_calib.pkl")
except Exception as e:
    print(f"Error loading model: {e}")


# 3. Validasi Input
class TaskItem(BaseModel):
    id: str = Field(..., description="ID unik dari tugas")
    title: str
    description: Optional[str] = ""
    user_id: Optional[str] = ""
    category: str
    story_point: int
    estimated_hour: float
    due_date: str
    created_at: str


class TaskRequest(BaseModel):
    tasks: List[TaskItem]


class TaskResponseItem(TaskItem):
    priority: str
    order: int


class TaskResponse(BaseModel):
    tasks: List[TaskResponseItem]


# 4. API ENDPOINT
@app.post(API_ENDPOINT, response_model=TaskResponse)
def sort_tasks(payload: TaskRequest):
    """
    API Endpoint untuk memprioritaskan dan mengurutkan tugas menggunakan Machine Learning.

    Alur Kerja:
    1. Menerima payload JSON berisi daftar tugas.
    2. Melakukan ekstraksi fitur (menggabungkan judul & deskripsi, menghitung sisa hari).
    3. Memasukkan fitur ('combined_text', 'category', 'estimated_hours', 'story_points', 'days_to_due') ke model Naive Bayes.
    4. Model memprediksi level prioritas ('Critical', 'High', 'Medium', 'Low').
    5. Mengurutkan tugas berdasarkan:
       - Prediksi Prioritas (Critical -> Low)
       - Sisa hari (Tenggat waktu terdekat)
       - Estimasi waktu (Paling cepat selesai)
    6. Mengembalikan daftar tugas yang sudah diurutkan beserta tag `priority` dan nomor `order`.

    Args:
        payload (TaskRequest): Objek pydantic yang berisi list of TaskItem.

    Returns:
        TaskResponse: Dictionary JSON dengan key 'tasks' yang berisi list tugas berurut.
    """
    try:
        tasks_data = [task.dict() for task in payload.tasks]
        df = pd.DataFrame(tasks_data)

        df["estimated_hours"] = df["estimated_hour"]
        df["story_points"] = df["story_point"]
        df["combined_text"] = (
            df["title"].fillna("") + " " + df["description"].fillna("")
        )

        df["days_to_due"] = (
            pd.to_datetime(df["due_date"]) - pd.to_datetime(df["created_at"])
        ).dt.days.clip(lower=0)

        features = [
            "combined_text",
            "category",
            "estimated_hours",
            "story_points",
            "days_to_due",
        ]
        input_fitur = df[features]

        df["priority_pred"] = model.predict(input_fitur)

        priority_map = {"Critical": 1, "High": 2, "Medium": 3, "Low": 4}
        df["prio_rank"] = df["priority_pred"].map(priority_map)

        df_sorted = df.sort_values(
            by=["prio_rank", "days_to_due", "estimated_hours"],
            ascending=[True, True, True],
        ).reset_index(drop=True)

        df_sorted["order"] = df_sorted.index + 1

        hasil_response = []
        for _, row in df_sorted.iterrows():
            hasil_response.append(
                {
                    "id": str(row["id"]),
                    "title": row["title"],
                    "description": row["description"],
                    "user_id": row["user_id"],
                    "category": row["category"],
                    "story_point": row["story_point"],
                    "estimated_hour": row["estimated_hour"],
                    "due_date": row["due_date"],
                    "created_at": row["created_at"],
                    "priority": row["priority_pred"],
                    "order": row["order"],
                }
            )

        return {"tasks": hasil_response}

    except Exception as e:
        raise HTTPException(status_code=400, detail=str(e))
