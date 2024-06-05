<?php

namespace App\Livewire;

use App\AuditTrail;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FormFactor as FormFactorModel;

class FormFactor extends Component
{
    use WithPagination;

    #[Url (as: 'id')]
    public $id;
    public $form = [];

    public $url = '';

    public function render()
    {
        if ($this->id && !FormFactorModel::find($this->id)) {
            abort(404);
        }
        return view('livewire.FormFactor.index',
            [
                'results' => $this->id ? FormFactorModel::find($this->id) : FormFactorModel::paginate(10),
                'fillables' => (new FormFactorModel())->getFillable(),
                'url' => current(explode('?', url()->current())),
            ]);
    }

    public function create()
    {
        AuditTrail::logCreate($this->form, 'Formfactor');

        $FormFactor = new FormFactorModel();
        foreach ($this->form as $key => $value) {
            $FormFactor->$key = $value;
        }
        $FormFactor->save();

        session()->flash('message', 'Formfactor successfully Created.');


    }

    public function update()
    {
        AuditTrail::logUpdate($this->form, 'Formfactor', $this->id, 'FormFactor');

        $FormFactor = FormFactorModel::find($this->id);
        foreach ($this->form as $key => $value) {
            $FormFactor->$key = $value;
        }
        $FormFactor->save();

        session()->flash('message', 'Formfactor successfully Updated.');
    }

    public function delete($id)
    {

        AuditTrail::logDelete('FormFactor', $id);
        $FormFactor = FormFactorModel::find($id);
        $FormFactor->delete();

        session()->flash('message', 'Formfactor successfully Deleted.');

        if ($this->id) {
            $this->id = null;
        } else {
            return redirect()->back();
        }

    }
}
