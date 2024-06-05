<?php

namespace App\Livewire;

use App\AuditTrail;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Socket as SocketModel;

class Socket extends Component
{
    use WithPagination;

    #[Url (as: 'id')]
    public $id;
    public $form = [];

    public $url = '';


    public function render()
    {
        if ($this->id && !SocketModel::find($this->id)) {
            $this->id = '';
        }
    return view('livewire.Socket.index',
        [
            'results' => $this->id ? SocketModel::find($this->id) : SocketModel::paginate(10),
            'fillables' => (new SocketModel())->getFillable(),
            'url' => current(explode('?', url()->current())),
        ]);
    }

    public function create()
    {
        AuditTrail::logCreate($this->form, 'Socket');

        $Socket = new SocketModel();
        foreach ($this->form as $key => $value) {
            $Socket->$key = $value;
        }
        $Socket->save();

        session()->flash('message', 'Socket successfully Created.');
    }

    public function update()
    {
        AuditTrail::logUpdate($this->form, 'Socket', $this->id, 'Socket');
        $Socket = SocketModel::find($this->id);
        foreach ($this->form as $key => $value) {
            $Socket->$key = $value;
        }
        $Socket->save();

        session()->flash('message', 'Socket successfully Updated.');
    }

    public function delete($id)
    {
        AuditTrail::logDelete('Socket', $id);
        $FormFactor = SocketModel::find($id);
        $FormFactor->delete();

        AuditTrail::logDelete($this->form, $id);

        if ($this->id) {
            $this->id = null;
        } else {
            return redirect()->back();
        }
    }
}
