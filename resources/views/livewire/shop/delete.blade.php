<div>
    <div class="flex-flex-wrap">
        <div class="w-full my-6 pr-0 lg:pr-2">
            <p class="text-xl pb-6 flex items-center dark:text-white">
                Delete Shop
            </p>
            <div class="leading-loose p-5 bg-white dark:bg-gray-800 dark:text-white rounded shadow-xl">
                Apakah kamu yakin ingin menghapus {{ $name }}?
                <div class="mt-6">
                    <button wire:click="destroyShop"
                        class="px-4 py-1 text-white font-light tracking-wider bg-red-700 rounded"
                        type="submit">Delete</button>
                    <button wire:click="$emit('closeShop')"
                        class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 dark:bg-blue-600 rounded">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>