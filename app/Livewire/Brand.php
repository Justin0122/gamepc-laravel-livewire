<?php

namespace App\Livewire;

use App\AuditTrail;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Brand as BrandModel;

class Brand extends Component
{
    use WithPagination;

    #[Url (as: 'id')]
    public $id;
    public $form = [];

    public $url = '';

    public function render()
    {
        if ($this->id && !BrandModel::find($this->id)) {
            $this->id = '';
        }
    return view('livewire.Brand.index',
        [
            'results' => $this->id ? BrandModel::find($this->id) : BrandModel::paginate(10),
            'fillables' => (new BrandModel())->getFillable(),
            'url' => current(explode('?', url()->current())),
        ]);
    }

    public function create()
    {
        AuditTrail::logCreate($this->form, 'Brand');
        $Brand = new BrandModel();
        foreach ($this->form as $key => $value) {
            $Brand->$key = $value;
        }
        $Brand->save();

        session()->flash('message', 'Brand successfully Created.');
    }

    public function update()
    {
        AuditTrail::logUpdate($this->form, 'Brand', $this->id, 'Brand');

        $Brand = BrandModel::find($this->id);
        foreach ($this->form as $key => $value) {
            $Brand->$key = $value;
        }
        $Brand->save();

        session()->flash('message', 'Brand successfully Updated.');
    }

    public function delete($id)
    {
        AuditTrail::logDelete('Brand', $id);
        $FormFactor = BrandModel::find($id);
        $FormFactor->delete();

        session()->flash('message', 'Brand successfully Deleted.');

        if ($this->id) {
            $this->id = null;
        } else {
            return redirect()->back();
        }

    }
}
