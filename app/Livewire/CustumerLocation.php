<?php

namespace App\Livewire;

use Livewire\Component;

class CustumerLocation extends Component
{

    public $customer;
    public $latitude;
    public $longitude;

    public function mount()
    {
  
        $this->latitude = -15.7801;
        $this->longitude = -47.9292;
    }

    public function saveLocation()
    {
        $this->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

      
        session()->flash('message', 'Coordenadas salvas com sucesso!');
    }

    public function render()
    {
        return view('livewire.custumer-location');
    }
}
