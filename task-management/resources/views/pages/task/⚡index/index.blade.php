<div>
    <div class="flex flex-col gap-6">

        {{-- HEADER --}}
        <div class="flex items-center justify-between">

            <div>
                <flux:heading size="xl">
                    Projects
                </flux:heading>

                <flux:text class="text-gray-500 mt-1">
                    Manage your projects efficiently
                </flux:text>
            </div>

            <div>
                <flux:modal.trigger name="add-project">

                    <flux:button size="sm" variant="primary">
                        Create
                    </flux:button>
                </flux:modal.trigger>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="w-full">
            <flux:card>

                <flux:table :paginate="$this->projects">
                    <flux:table.columns>
                        <flux:table.column>Name</flux:table.column>
                        <flux:table.column>Description</flux:table.column>
                        <flux:table.column>Start Date</flux:table.column>
                        <flux:table.column>End Date</flux:table.column>
                        <flux:table.column></flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>

                        @forelse ($this->projects as $project)
                            <flux:table.row :key="$project->id">

                                {{-- NAME --}}
                                <flux:table.cell class="font-semibold">
                                    {{ $project->name }}
                                </flux:table.cell>

                                {{-- DESCRIPTION (truncate) --}}
                                <flux:table.cell class="text-gray-600">
                                    {{ $project->description }}
                                </flux:table.cell>

                                {{-- START DATE --}}
                                <flux:table.cell>
                                    <span class="text-gray-700">
                                        {{ date('d-m-Y', strtotime($project->start_date)) }}
                                    </span>
                                </flux:table.cell>

                                {{-- END DATE --}}
                                <flux:table.cell>
                                    <span class="text-gray-700">
                                        {{ date('d-m-Y', strtotime($project->end_date)) }}
                                    </span>
                                </flux:table.cell>

                                <flux:table.cell>
                                    <flux:button size="sm" wire:click="edit({{ $project->id }})">
                                        Edit
                                    </flux:button>

                                    <flux:dropdown>
                                        <flux:button size="sm" icon:trailing="chevron-down">
                                            More
                                        </flux:button>

                                        <flux:menu>
                                            <flux:menu.item href="{{ route('tasks.detail', $project) }}">Details
                                            </flux:menu.item>
                                            <flux:menu.item wire:click="delete({{ $project->id }})"
                                                variant="danger">
                                                Delete
                                            </flux:menu.item>
                                        </flux:menu>
                                    </flux:dropdown>
                                </flux:table.cell>

                            </flux:table.row>

                        @empty

                            <flux:table.row>
                                <flux:table.cell colspan="6">
                                    <div class="flex flex-col items-center justify-center py-10 text-center">

                                        <div class="text-gray-400 text-lg font-semibold">
                                            No projects available
                                        </div>

                                        <div class="text-sm text-gray-500 mt-1">
                                            You haven't created any projects yet. <br> Start by adding a new task to
                                            manage
                                            your
                                            work effectively.
                                        </div>

                                        <div class="mt-5">
                                            <flux:modal.trigger name="add-project">
                                                <flux:button variant="primary">
                                                    Add New Project
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

    <flux:modal name="add-project" class="w-full sm:w-96 md:w-225 lg:w-250 xl:w-300" @close="resetForm()">
        <div class="space-y-6">

            {{-- HEADER --}}
            <div>
                <flux:heading size="lg">{{ $editingProjectId ? 'Update' : 'Add New' }} Project</flux:heading>
                <flux:text class="mt-2">{{ $editingProjectId ? 'Update' : 'Add' }} your {{ $editingProjectId ? 'existing' : 'new' }}  Project</flux:text>
            </div>

            {{-- FORM --}}
            <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

                {{-- NAME --}}
                <flux:field class="col-span-2">
                    <flux:label>Name</flux:label>
                    <flux:input wire:model.defer="name" type="text" placeholder="Enter project name" />
                    <flux:error name="name" />
                </flux:field>

                {{-- DESCRIPTION --}}
                <flux:field class="col-span-2">
                    <flux:label>Description</flux:label>
                    <flux:textarea wire:model.defer="description" rows="3" placeholder="Describe the task..." />
                    <flux:error name="description" />
                </flux:field>

                {{-- START DATE --}}
                <flux:field>
                    <flux:label>Start Date</flux:label>
                    <flux:input wire:model.defer="start_date" type="date" />
                    <flux:error name="start_date" />
                </flux:field>

                {{-- END DATE --}}
                <flux:field>
                    <flux:label>End Date</flux:label>
                    <flux:input wire:model.defer="end_date" type="date" />
                    <flux:error name="end_date" />
                </flux:field>

                {{-- ACTION --}}
                <div class="col-span-2 flex items-center justify-end mt-4">
                    <flux:button type="submit" variant="primary">
                        {{ $editingProjectId ? 'Update Project' : 'Save Project' }}
                    </flux:button>
                </div>

            </form>
        </div>
    </flux:modal>


    <flux:modal name="delete-project" class="min-w-88">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete project?</flux:heading>

                <flux:text class="mt-2">
                    You're about to delete this project.<br>
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
