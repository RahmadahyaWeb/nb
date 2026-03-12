<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">

        {{-- SUMMARY CARDS --}}
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">

            {{-- TOTAL PROJECT --}}
            <div class="rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">
                <div class="text-sm text-neutral-500">Total Project</div>
                <div class="mt-2 text-3xl font-bold">
                    {{ $projects->count() }}
                </div>
            </div>

            {{-- TOTAL TASK --}}
            <div class="rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">
                <div class="text-sm text-neutral-500">Total Task</div>
                <div class="mt-2 text-3xl font-bold">
                    {{ $projects->sum('total_task') }}
                </div>
            </div>

            {{-- TOTAL DONE --}}
            <div class="rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">
                <div class="text-sm text-neutral-500">Total Completed</div>
                <div class="mt-2 text-3xl font-bold text-green-600">
                    {{ $projects->sum('total_done') }}
                </div>
            </div>

        </div>

        {{-- PROJECT LIST --}}
        <div class="flex-1 space-y-4 overflow-auto rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">

            @forelse ($projects as $project)
                <div class="rounded-lg border border-neutral-200 p-5 dark:border-neutral-700">

                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold">
                            {{ $project->name }}
                        </h3>

                        <span class="text-sm font-medium">
                            {{ $project->percentage }}%
                        </span>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="mt-3 h-2 w-full rounded bg-neutral-200 dark:bg-neutral-700">
                        <div class="h-2 rounded bg-blue-600" style="width: {{ $project->percentage }}%"></div>
                    </div>

                    {{-- Stats --}}
                    <div class="mt-4 grid grid-cols-2 gap-4 text-sm md:grid-cols-4">
                        <div>Todo: <strong>{{ $project->total_todo }}</strong></div>
                        <div>In Progress: <strong>{{ $project->total_in_progress }}</strong></div>
                        <div>Review: <strong>{{ $project->total_review }}</strong></div>
                        <div>Done: <strong class="text-green-600">{{ $project->total_done }}</strong></div>
                    </div>

                    <div class="mt-2 text-xs text-neutral-500">
                        {{ $project->total_done }} / {{ $project->total_task }} tasks completed
                    </div>

                </div>
            @empty
                <div class="text-center text-neutral-500">
                    No project found.
                </div>
            @endforelse

        </div>

    </div>
</div>
