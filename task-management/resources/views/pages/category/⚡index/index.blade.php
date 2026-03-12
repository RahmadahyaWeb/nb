<div>

    <div class="flex flex-col gap-6">

        {{-- HEADER --}}
        <div>
            <flux:heading size="xl">
                Categories
            </flux:heading>

            <flux:text class="text-gray-500 mt-1">
                Manage Categories
            </flux:text>
        </div>

        {{-- TABLE --}}
        <div class="w-full">
            <flux:card>

                <flux:table :paginate="$this->categories">

                    <flux:table.columns>
                        <flux:table.column>Name</flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach ($this->categories as $category)
                            <flux:table.row :key="$category->id">

                                <flux:table.cell class="font-medium">
                                    {{ $category->name }}
                                </flux:table.cell>

                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>

                </flux:table>

            </flux:card>
        </div>
    </div>
</div>
