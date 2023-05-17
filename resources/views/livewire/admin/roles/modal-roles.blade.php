<div class="animate__animated  animate__fadeIn">
    <div
        class="relative transform rounded-md bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg ">
        <div class="bg-white justify-left items-left text-left pt-5 pb-4  sm:pb-4 rounded-t-lg sm:px-16">
            <div class="sm:flex sm:items-start">
                {{-- ESTO ES EL TITULO DEL MODAL --}}
                <div class="mt-3 text-start sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class=" admin-text-bold font-semibold leading-6 text-gray-900" id="modal-title">Create new role:</h3>
                        <p class="admin-text-bold-2"> </p>
                </div>
            </div>
        </div>
        {{-- ESTO ES EL CONTENIDO DEL MODAL --}}
        <div class="bg-white px-4 pt-5 pb-4 sm:px-6 sm:pb-4">
            <div class="sm:flex sm:flex-col sm:items-start w-full admin-text-bold">
                <div class="w-full">
                        <div class="w-full">
                            {{-- <p class="control is-expanded has-icons-right w-full">
                                <input class="input w-full rounded-md @error('participante') bg-red-200 @enderror" type="text" placeholder="@error('nota') {{ $message }} @else Nota del Candidato... @enderror" wire:model.debounce.500="nota" />
                            </p> --}}
                        </div>
                        {{-- <code>
                            {{$participante}}
                        </code> --}}
                </div>
            </div>
        </div>


        {{-- ESTOS SON LOS BOTONOES DEL MODAL --}}
        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 rounded-b-lg">
            <button wire:click="registrarNota" type="button"
                class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 sm:ml-3 sm:w-auto">Agregar</button>
            <button type="button" wire:click="$emit('close:global-modal')"
                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
        </div>
    </div>
</div>