<div class="container mx-auto px-4">
    @if($this->id)
        {{ __('Edit') }}
        @include('livewire.crud.edit')
    @else
        {{ __('') }}
        @include('livewire.Transaction.create')
    @endif
</div>
