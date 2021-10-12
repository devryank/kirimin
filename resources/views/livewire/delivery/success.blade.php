<div>
    <div class="flex-flex-wrap">
        <div class="w-full my-6 pr-0 lg:pr-2">
            <p class="text-xl pb-6 flex items-center dark:text-white">
                Ceklis Pesanan
            </p>
            <div class="leading-loose p-5 bg-white dark:bg-gray-800 dark:text-white rounded shadow-xl">
                Apakah kamu yakin ingin menceklis pesanan {{ $name }}?
                <div class="mt-6">
                    <button wire:click="$emit('closeDelivery')"
                        class="px-4 py-1 text-white font-light tracking-wider bg-red-700 rounded"
                        type="submit">Batal</button>
                    <button wire:click="CheckDelivery"
                        class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 dark:bg-blue-600 rounded">Ceklis</button>
                </div>
            </div>
        </div>
    </div>
</div>