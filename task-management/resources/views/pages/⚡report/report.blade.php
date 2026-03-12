<div>
    <div class="flex flex-col gap-6">

        {{-- HEADER --}}
        <div>
            <flux:heading size="xl">
                Reports
            </flux:heading>

            <flux:text class="text-gray-500 mt-1">
                Downloadable reports of your projects and tasks.
            </flux:text>
        </div>

        {{-- FORM --}}
        <flux:card class="w-full max-w-md space-y-6">
            <flux:field>
                <flux:label for="project-id">
                    Select Project
                </flux:label>

                <flux:select wire:model="project" placeholder="Choose project...">
                    <flux:select.option value="">Choose project</flux:select.option>
                    @foreach($projects as $p)
                        <flux:select.option value="{{ $p->id }}">{{ $p->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </flux:field>

            <flux:button variant="primary" color="emerald" wire:click="downloadReport" class="w-max">
                Download Report
            </flux:button>
        </flux:card>
    </div>
</div>
