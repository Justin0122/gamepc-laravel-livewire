<?php

namespace App\Livewire;

use App\AuditTrail;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Generation as GenerationModel;

class Generation extends Component
{
    use WithPagination;

    #[Url (as: 'id')]
    public $id;
    public $form = [];

    public $url = '';


    public function render()
    {
        if ($this->id && !GenerationModel::find($this->id)) {
            $this->id = '';
        }
    return view('livewire.Generation.index',
        [
            'results' => $this->id ? GenerationModel::find($this->id) : GenerationModel::paginate(10),
            'fillables' => (new GenerationModel())->getFillable(),
            'url' => current(explode('?', url()->current())),
        ]);
    }

    public function create()
    {
        AuditTrail::logCreate($this->form, 'Generation');

        $Generation = new GenerationModel();
        foreach ($this->form as $key => $value) {
            $Generation->$key = $value;
        }
        $Generation->save();

        session()->flash('message', 'Generation successfully Created.');
    }

    public function update()
    {
        AuditTrail::logUpdate($this->form, 'Generation', $this->id, 'Generation');

        $Generation = GenerationModel::find($this->id);
        foreach ($this->form as $key => $value) {
            $Generation->$key = $value;
        }
        $Generation->save();

        $this->dispatch('update');

        session()->flash('message', 'Generation successfully Updated.');
    }

    public function delete($id)
    {
        AuditTrail::logDelete('Generation', $id);
        $Generation = GenerationModel::find($id);
        $Generation->delete();
        session()->flash('message', 'Generation successfully Deleted.');

        if ($this->id) {
            $this->id = null;
        } else {
            return redirect()->back();
        }
    }
}
