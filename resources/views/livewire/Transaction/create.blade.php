<div class="create flex flex-col p-4 bg-white shadow-md rounded-lg dark:bg-gray-800">
    <x-notification />
    <form wire:submit.prevent="checkout" class="space-y-4">
            <div class="flex flex-col">
                <select wire:model.lazy="form.payment_method" class="text-center text-2xl font-bold text-gray-900 dark:text-black-100">
                    <option value="PayPal">PayPal</option>
                    <option value="iDeal">iDeal</option>
                </select>
            </div>
        <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300" >
            Bestel
        </button>
    </form>
</div>
