<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class ModalComponent extends Component
{

    public $isOpen = false;
    public $component = '';
    public $params = null;
    public $Nobackdrop = null;
    

    protected $listeners = ['show:global-modal' => 'open', 'close:global-modal' => 'close'];

    public function open($component, $params = null, $Nobackdrop = null)
    {
        $this->isOpen = true;
        $this->component = $component;
        $this->params = $params;
        $this->Nobackdrop = $Nobackdrop;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.components.modal-component');
    }
}
