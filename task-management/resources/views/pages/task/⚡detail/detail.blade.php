<div>
    <div class="flex flex-col gap-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">

            <div>
                <flux:heading size="xl">
                    Tasks
                </flux:heading>

                <flux:text class="text-gray-500 mt-1">
                    Manage your tasks efficiently
                </flux:text>
            </div>

            <div>
                <flux:modal.trigger name="add-task">
                    <flux:button size="sm" variant="primary">
                        Create
                    </flux:button>
                </flux:modal.trigger>
            </div>

        </div>

        @if (session()->has('success'))
            <div class="p-4 rounded-lg bg-green-50 text-green-700 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- SMART SORT ACTION BAR --}}
        <div class="">
            <flux:card class="p-4">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    {{-- TEXT --}}
                    <div class="flex-1">
                        <flux:text class="font-semibold text-base">
                            🤖 AI Task Ordering
                        </flux:text>

                        <flux:text class="text-sm text-gray-500 mt-1">
                            Automatically reorder tasks using AI prediction based on multiple task attributes.
                        </flux:text>
                    </div>

                    {{-- BUTTON --}}
                    <div class="w-full sm:w-auto">
                        <flux:modal.trigger name="auto-sort-task">
                            <flux:button size="sm" variant="outline" class="w-full sm:w-auto">
                                Apply Smart Sort
                            </flux:button>
                        </flux:modal.trigger>
                    </div>

                </div>

            </flux:card>
        </div>

        {{-- PROJECT DETAIL CARD --}}
        @if ($this->project)
            <div>
                <flux:card class="p-4 sm:p-6">

                    <div class="flex flex-col gap-4">

                        {{-- HEADER --}}
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">

                            {{-- PROJECT NAME --}}
                            <flux:heading size="lg" class="break-words">
                                {{ $this->project->name }}
                            </flux:heading>

                            {{-- DATE --}}
                            <span class="text-sm text-gray-500 sm:text-right">
                                {{ \Carbon\Carbon::parse($this->project->start_date)->format('d M Y') }}
                                -
                                {{ \Carbon\Carbon::parse($this->project->end_date)->format('d M Y') }}
                            </span>

                        </div>

                        {{-- DESCRIPTION --}}
                        <flux:text class="text-gray-600">
                            {{ $this->project->description }}
                        </flux:text>

                    </div>

                </flux:card>
            </div>
        @endif

        {{-- TABLE --}}
        <div class="w-full">
            <flux:card>

                <div class="mb-6">
                    <flux:dropdown>
                        <flux:button icon:trailing="chevron-down">
                            Columns
                        </flux:button>

                        <flux:menu class="w-48" keep-open>
                            @foreach ($visible_columns as $col => $is_visible)
                                <flux:menu.checkbox wire:click="toggleColumn('{{ $col }}')"
                                    :checked="$is_visible">
                                    {{ ucfirst(str_replace('_', ' ', $col)) }}
                                </flux:menu.checkbox>
                            @endforeach
                        </flux:menu>
                    </flux:dropdown>
                </div>

                <flux:table :paginate="$this->tasks">
                    <flux:table.columns sticky class="bg-white dark:bg-zinc-900">
                        @if ($visible_columns['order'])
                            <flux:table.column sticky class="bg-white dark:bg-zinc-900">Order</flux:table.column>
                        @endif
                        @if ($visible_columns['title'])
                            <flux:table.column>Title</flux:table.column>
                        @endif
                        @if ($visible_columns['description'])
                            <flux:table.column>Description</flux:table.column>
                        @endif
                        @if ($visible_columns['priority'])
                            <flux:table.column>Priority</flux:table.column>
                        @endif
                        @if ($visible_columns['category'])
                            <flux:table.column>Category</flux:table.column>
                        @endif
                        @if ($visible_columns['story_point'])
                            <flux:table.column>Story Point</flux:table.column>
                        @endif
                        @if ($visible_columns['estimated_hour'])
                            <flux:table.column>Estimated Hour</flux:table.column>
                        @endif
                        @if ($visible_columns['due_date'])
                            <flux:table.column>Due Date</flux:table.column>
                        @endif
                        @if ($visible_columns['status'])
                            <flux:table.column>Status</flux:table.column>
                        @endif
                        <flux:table.column>Action</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>

                        @forelse ($this->tasks as $task)
                            <flux:table.row :key="$task->id">

                                {{-- ORDER --}}
                                @if ($visible_columns['order'])
                                    <flux:table.cell sticky class="font-semibold bg-white dark:bg-zinc-900">
                                        {{ $task->order }}
                                    </flux:table.cell>
                                @endif

                                {{-- TITLE --}}
                                @if ($visible_columns['title'])
                                    <flux:table.cell class="font-semibold ">
                                        {{ $task->title }}
                                    </flux:table.cell>
                                @endif

                                {{-- DESCRIPTION (truncate) --}}
                                @if ($visible_columns['description'])
                                    <flux:table.cell class="text-gray-600">
                                        <flux:tooltip content="{{ $task->description }}">
                                            {{ \Illuminate\Support\Str::limit($task->description, 50) }}
                                        </flux:tooltip>
                                    </flux:table.cell>
                                @endif

                                {{-- Priority --}}
                                @if ($visible_columns['priority'])
                                    <flux:table.cell>
                                        @php
                                            $priority = $task->priority;

                                            $color = match ($priority) {
                                                'Low' => 'lime',
                                                'Medium' => 'yellow',
                                                'High' => 'orange',
                                                'Critical' => 'red',
                                                default => 'zinc',
                                            };
                                        @endphp

                                        @if ($priority)
                                            <flux:badge :color="$color">
                                                {{ ucfirst(str_replace('_', ' ', $priority)) }}
                                            </flux:badge>
                                        @else
                                            <flux:badge color="zinc">
                                                N/A
                                            </flux:badge>
                                        @endif
                                    </flux:table.cell>
                                @endif

                                {{-- CATEGORY --}}
                                @if ($visible_columns['category'])
                                    <flux:table.cell>
                                        <span>
                                            {{ $task->category->name }}
                                        </span>
                                    </flux:table.cell>
                                @endif

                                {{-- STORY POINT --}}
                                @if ($visible_columns['story_point'])
                                    <flux:table.cell>
                                        @php
                                            $sp = $task->story_point->value;
                                            if ($sp <= 3) {
                                                $color = 'bg-green-100 text-green-700';
                                            } elseif ($sp <= 8) {
                                                $color = 'bg-yellow-100 text-yellow-700';
                                            } else {
                                                $color = 'bg-red-100 text-red-700';
                                            }
                                        @endphp
                                        <span class="px-2 py-1 rounded-full {{ $color }}">
                                            {{ $task->story_point->value }} ({{ $task->story_point->name }})
                                        </span>
                                    </flux:table.cell>
                                @endif

                                {{-- ESTIMATED HOUR --}}
                                @if ($visible_columns['estimated_hour'])
                                    <flux:table.cell>
                                        @php
                                            $eh = $task->estimated_hour->value;
                                            if ($eh <= 8) {
                                                $color = 'bg-blue-100 text-blue-700';
                                            } elseif ($eh <= 24) {
                                                $color = 'bg-amber-100 text-amber-700';
                                            } else {
                                                $color = 'bg-red-100 text-red-700';
                                            }
                                        @endphp
                                        <span class="px-2 py-1 rounded-full {{ $color }}">
                                            {{ $task->estimated_hour->value }} Hour
                                            ({{ $task->estimated_hour->name }})
                                        </span>
                                    </flux:table.cell>
                                @endif

                                {{-- DUE DATE --}}
                                @if ($visible_columns['due_date'])
                                    <flux:table.cell>
                                        @php
                                            $due = \Carbon\Carbon::parse($task->due_date);
                                            $is_urgent = $due->isToday() || $due->isPast();
                                        @endphp

                                        <span
                                            class="{{ $is_urgent ? 'text-red-600 font-semibold' : 'text-gray-700' }}">
                                            {{ $due->format('d M Y') }}
                                        </span>

                                    </flux:table.cell>
                                @endif

                                {{-- STATUS --}}
                                @if ($visible_columns['status'])
                                    <flux:table.cell>
                                        <span class="uppercase">
                                            {{ $task->status }}
                                        </span>
                                    </flux:table.cell>
                                @endif

                                {{-- EDIT --}}
                                <flux:table.cell>
                                    <flux:modal.trigger name="add-task">
                                        <flux:button size="sm" variant="outline"
                                            wire:click="edit({{ $task->id }})" :loading="false">
                                            Edit
                                        </flux:button>
                                    </flux:modal.trigger>

                                        <flux:button size="sm" variant="danger" wire:click="delete({{ $task->id }})" :loading="false">Delete</flux:button>
                                </flux:table.cell>

                            </flux:table.row>

                        @empty

                            <flux:table.row>
                                <flux:table.cell colspan="6">
                                    <div class="flex flex-col items-center justify-center py-10 text-center">

                                        <div class="text-gray-400 text-lg font-semibold">
                                            No tasks available
                                        </div>

                                        <div class="text-sm text-gray-500 mt-1">
                                            You haven't created any tasks yet. <br> Start by adding a new task to manage
                                            your
                                            work effectively.
                                        </div>

                                        <div class="mt-5">
                                            <flux:modal.trigger name="add-task">
                                                <flux:button variant="primary">
                                                    Add New Task
                                                </flux:button>
                                            </flux:modal.trigger>
                                        </div>

                                    </div>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse

                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>
    </div>

    <flux:modal name="add-task" class="w-full sm:w-96 md:w-225 lg:w-250 xl:w-300" @close="resetForm()">
        <div class="space-y-6">

            {{-- HEADER --}}
            <div>
                <flux:heading size="lg">Add New Task</flux:heading>
                <flux:text class="mt-2">Add your new task</flux:text>
            </div>

            {{-- FORM --}}
            <form wire:submit="{{ $is_edit ? 'update' : 'save' }}"
                class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

                {{-- TITLE --}}
                <flux:field class="col-span-2">
                    <flux:label>Title</flux:label>
                    <flux:input wire:model.defer="title" type="text" placeholder="Enter task title" />
                    <flux:error name="title" />
                </flux:field>

                {{-- DESCRIPTION --}}
                <flux:field class="col-span-2">
                    <flux:label>Description</flux:label>
                    <flux:textarea wire:model.defer="description" rows="3" placeholder="Describe the task..." />
                    <flux:error name="description" />
                </flux:field>

                {{-- CATEGORY --}}
                <flux:field>
                    <flux:label>Category</flux:label>
                    <flux:select wire:model.defer="category_id">
                        <option value="">Select Category</option>
                        @foreach ($this->categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </flux:select>
                    <flux:error name="category_id" />
                </flux:field>

                {{-- STORY POINT --}}
                <flux:field>
                    <flux:label>Complexity</flux:label>
                    <flux:select wire:model.defer="story_point_id">
                        <option value="">Select Complexity</option>
                        @foreach ($this->story_points as $point)
                            <option value="{{ $point->id }}">
                                {{ $point->value }} | ({{ $point->name }})
                            </option>
                        @endforeach
                    </flux:select>
                    <flux:error name="story_point_id" />
                </flux:field>

                {{-- ESTIMATED HOUR --}}
                <flux:field>
                    <flux:label>Estimated Duration</flux:label>
                    <flux:select wire:model.defer="estimated_hour_id">
                        <option value="">Select Duration</option>
                        @foreach ($this->estimated_hours as $hour)
                            <option value="{{ $hour->id }}">
                                {{ $hour->value }} jam | ({{ $hour->name }})
                            </option>
                        @endforeach
                    </flux:select>
                    <flux:error name="estimated_hour_id" />
                </flux:field>

                {{-- DUE DATE --}}
                <flux:field>
                    <flux:label>Due Date</flux:label>
                    <flux:input wire:model.defer="due_date" type="date" />
                    <flux:error name="due_date" />
                </flux:field>

                {{-- STATUS --}}
                <flux:field>
                    <flux:label>Status</flux:label>
                    <flux:select wire:model.defer="status">
                        <option value="">Select Status</option>
                        <option value="todo">Todo</option>
                        <option value="in_progress">In Progress</option>
                        <option value="review">Review</option>
                        <option value="done">Done</option>
                    </flux:select>
                    <flux:error name="status" />
                </flux:field>

                {{-- NOTES --}}
                <flux:field class="col-span-2">
                    <flux:label>Notes</flux:label>
                    <flux:textarea wire:model.defer="notes" rows="3" placeholder="Additional notes..." />
                    <flux:error name="notes" />
                </flux:field>

                {{-- ORDER --}}
                @if ($order && $order != 0)
                    <flux:field>
                        <flux:label>Order</flux:label>
                        <flux:input wire:model.defer="order" type="number" min="1" />
                        <flux:error name="order" />
                    </flux:field>
                @endif

                {{-- ACTION --}}
                <div class="col-span-2 flex items-center justify-end mt-4">
                    <flux:button type="submit" variant="primary">
                        {{ $is_edit ? 'Update Task' : 'Save Task' }}
                    </flux:button>
                </div>

            </form>
        </div>
    </flux:modal>

    <flux:modal name="auto-sort-task" class="w-full sm:w-96" dismissible="true">

        <div class="space-y-5">

            {{-- HEADER --}}
            <div>
                <flux:heading size="lg">
                    AI Smart Task Ordering
                </flux:heading>

                <flux:text class="mt-2 text-gray-600">
                    The system will automatically reorder tasks using a Naive Bayes model
                    based on the following features:
                </flux:text>
            </div>

            {{-- MODEL FEATURES --}}
            <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
                <li><strong>Category</strong> – Task classification context</li>
                <li><strong>Priority</strong> – Assigned urgency level</li>
                <li><strong>Estimated Hours</strong> – Expected completion time</li>
                <li><strong>Story Points</strong> – Task complexity score</li>
                <li><strong>Combined Text</strong> – Title and description analysis</li>
                <li><strong>Days to Due</strong> – Remaining time before deadline</li>
            </ul>

            {{-- INFO BOX --}}
            <div class="bg-blue-50 text-blue-700 p-3 rounded-lg text-sm">
                The task order will be permanently updated based on AI prediction.
                You can manually adjust the order afterward if needed.
            </div>

            {{-- ACTIONS --}}
            <div class="flex justify-end gap-3 pt-3">

                <flux:button variant="primary" wire:click="auto_sort" wire:loading.attr="disabled">
                    <span wire:loading.remove>
                        Apply AI Ordering
                    </span>

                    <span wire:loading>
                        Processing...
                    </span>
                </flux:button>

            </div>

        </div>

    </flux:modal>

    <flux:modal name="delete-task" class="min-w-88">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete task?</flux:heading>

                <flux:text class="mt-2">
                    You're about to delete this task.<br>
                    This action cannot be reversed.
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button wire:click="confirmDelete" variant="danger">Delete task
                </flux:button>
            </div>
        </div>
    </flux:modal>

</div>
