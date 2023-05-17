<div class="">
    @if($isOpen)
    <div class="relative z-10 " aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- ESTO ES EL BACKGROUND --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @if($Nobackdrop==null) wire:click="close" @endif></div>
        {{-- / ESTO ES EL BACKGROUND --}}

        {{-- ESTO ES EL CONTENIDO DE LOS MODALS QUE VIENEN DE LOS COMPONENTES --}}
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                @livewire($component, ['params' => $params])
            </div>
        </div>
    </div>

    @endif
</div>
