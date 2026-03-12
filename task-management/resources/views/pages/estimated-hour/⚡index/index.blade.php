<div>

    <div class="flex flex-col gap-6">

        {{-- HEADER --}}
        <div>
            <flux:heading size="xl">
                Estimated Hours
            </flux:heading>

            <flux:text class="text-gray-500 mt-1">
                Manage Estimated Hours
            </flux:text>
        </div>

        {{-- TABLE --}}
        <div class="w-full">
            <flux:card>

                <flux:table :paginate="$this->estimated_hours">

                    <flux:table.columns>
                        <flux:table.column>Value</flux:table.column>
                        <flux:table.column>Name</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach ($this->estimated_hours as $estimated_hour)
                            <flux:table.row :key="$estimated_hour->id">

                                <flux:table.cell class="font-medium">
                                    {{ $estimated_hour->value }}
                                </flux:table.cell>

                                <flux:table.cell>
                                    {{ $estimated_hour->name }}
                                </flux:table.cell>

                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>

                </flux:table>

            </flux:card>
        </div>
    </div>
</div>
