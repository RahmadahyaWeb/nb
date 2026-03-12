<div class="space-y-6">

    <flux:card class="p-8 space-y-6">

        <div class="space-y-2">
            <h1 class="text-3xl font-bold">Task Management App</h1>
            <p class="text-gray-600 leading-relaxed">
                Aplikasi ini membantu developer mengelola banyak tugas dalam berbagai project
                dan menentukan prioritas secara otomatis menggunakan algoritma Naive Bayes.
            </p>
        </div>

        <div class="border-t pt-6 space-y-4">
            <h2 class="text-xl font-semibold">Tujuan Aplikasi</h2>
            <ul class="list-disc list-inside space-y-2 text-gray-700">
                <li>Mengelola task dalam banyak project secara terstruktur.</li>
                <li>Membantu menentukan prioritas tugas secara otomatis.</li>
                <li>Menyediakan ringkasan progres dalam satu dashboard.</li>
                <li>Menyediakan laporan dalam format CSV.</li>
            </ul>
        </div>

        <div class="border-t pt-6 space-y-6">
            <h2 class="text-xl font-semibold">Alur Kerja Aplikasi</h2>

            <div class="space-y-4 text-gray-700">
                <div>
                    <h3 class="font-semibold">1. Login</h3>
                    <p>User masuk ke sistem menggunakan email dan password untuk mengakses dashboard dan project miliknya.</p>
                </div>

                <div>
                    <h3 class="font-semibold">2. Membuat Project</h3>
                    <p>User membuat project baru sebagai wadah untuk mengelompokkan task-task yang berkaitan.</p>
                </div>

                <div>
                    <h3 class="font-semibold">3. Menambahkan Task</h3>
                    <p>Di dalam project, user menambahkan task yang ingin dikerjakan dan dapat memperbarui statusnya sesuai progres.</p>
                </div>

                <div>
                    <h3 class="font-semibold">4. Apply Smart Sort</h3>
                    <p>
                        User menekan tombol <span class="font-medium">Apply Smart Sort</span>.
                        Sistem akan mengirim data task ke API machine learning untuk dihitung prioritasnya.
                    </p>
                </div>

                <div>
                    <h3 class="font-semibold">5. Monitoring & Laporan</h3>
                    <p>
                        Dashboard menampilkan ringkasan seluruh project.
                        User dapat mengunduh laporan task dalam format CSV.
                    </p>
                </div>
            </div>
        </div>

        <div class="border-t pt-6 space-y-4">
            <h2 class="text-xl font-semibold">Bagaimana Naive Bayes Bekerja</h2>

            <p class="text-gray-700 leading-relaxed">
                Naive Bayes adalah algoritma klasifikasi berbasis probabilitas yang menggunakan
                Teorema Bayes untuk menentukan kemungkinan suatu task termasuk dalam kategori
                prioritas tertentu.
            </p>

            <div class="bg-gray-100 p-4 rounded-lg font-mono text-sm">
                P(Class | Data) = (P(Data | Class) × P(Class)) / P(Data)
            </div>

            <div class="space-y-3 text-gray-700">
                <p><strong>Prosesnya:</strong></p>
                <ul class="list-disc list-inside space-y-2">
                    <li>Data task dikirim dari Laravel ke API FastAPI.</li>
                    <li>Model menghitung probabilitas prioritas setiap task.</li>
                    <li>Task dengan probabilitas tertinggi ditempatkan di urutan teratas.</li>
                    <li>Hasil dikirim kembali ke aplikasi dan ditampilkan ke user.</li>
                </ul>
            </div>
        </div>

        <div class="border-t pt-6 space-y-4">
            <h2 class="text-xl font-semibold">Arsitektur Sistem</h2>

            <ul class="list-disc list-inside space-y-2 text-gray-700">
                <li>Backend: Laravel 12 + Livewire</li>
                <li>Database: MySQL</li>
                <li>Machine Learning API: Python FastAPI</li>
                <li>Container: Docker (Laravel Sail)</li>
            </ul>

            <div class="bg-gray-100 p-4 rounded-lg font-mono text-sm">
                User → Laravel → FastAPI (Naive Bayes) → Laravel → User
            </div>
        </div>

    </flux:card>

</div>
