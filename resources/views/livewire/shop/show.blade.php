<div>
    <div class="flex-flex-wrap">
        <div class="w-full my-6 pr-0 lg:pr-2">
            <p class="text-xl pb-6 flex items-center dark:text-white">
                {{ $name }}
            </p>
            <div class="leading-loose p-5 bg-white dark:bg-gray-800 rounded shadow-xl">
                <div class="grid grid-cols-4 gap-4 dark:text-white">
                    @php
                    $i = 0;
                    @endphp
                    @foreach ($permissions as $permission)
                    @php
                    if($i == 0 OR $i % 4 == 0) {
                    echo '<div>';
                        }
                        @endphp
                        - {{ $permission }} <br>
                        @php
                        $i += 1;
                        if($i == 0 OR $i % 4 == 0) {
                        echo '</div>';
                    }
                    @endphp
                    @endforeach
                </div>
                <div class="mt-6">
                    <button wire:click.prevent="$emit('closeRole')"
                            class="px-4 py-1 text-white font-light tracking-wider bg-red-700 rounded">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>