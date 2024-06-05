<?php

namespace App\Livewire;
use App\AuditTrail;
use App\Models\PcPart;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class Part extends Component
{
    use WithFileUploads;

    #[Url(as: 'id')]
    public int $partId;
    public array $form = [];

    public $images = [];
    public string $partType = 'cpu';

    public function mount(): void
    {
        $this->partType = request()->segment(2);
    }

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {

        $part = $this->getPart();
        $this->form = $part->toArray();
        unset($this->form['created_at']);
        unset($this->form['updated_at']);
        unset($this->form['deleted_at']);

        return view('livewire.part', [
            'part' => $part,
            'fields' => $this->getFields($part),
            'photos' => $this->getImages() ?? [],
        ]);
    }

    protected function getImages(): array
    {
        $path = 'parts/' . $this->partType . '/' . $this->partId;
        $images = glob(public_path('storage/' . $path . '/*'));
        return array_map(function ($image) use ($path) {
            return $path . '/' . basename($image);
        }, $images);
    }

    protected function getPart()
    {
        $modelClass = 'App\\Models\\Parts\\' . ucfirst($this->partType);

        if (auth()->check() && auth()->user()->can('edit products')) {
            $part = $modelClass::withTrashed()->find($this->partId);
        } else {
            $part = $modelClass::find($this->partId);
        }
        unset($part['id']);
        unset($part['created_at']);
        unset($part['updated_at']);

        return $part;
    }


    public function getFields($part): array
    {
        $fields = ['Brand' => $part->brand()->first()->Name];

            $commonFields = ['Socket', 'Generation', 'MemoryType', 'Supports', 'FormFactor'];

            foreach ($commonFields as $field) {
                $methodName = $this->getFieldMethodName($field);
                if (method_exists($part, $methodName)) {
                    $fields[$field] = $part->$methodName()->first()->Name;
                }
        }
        return $fields;
    }

    protected function getFieldMethodName($field): ?string
    {
        // The left is what is shown in the UI, the right is the method name
        $fieldMappings = [
            'Socket' => 'socket',
            'Generation' => 'generation',
            'MemoryType' => 'memorytype',
            'Supports' => 'memorytype',
            'FormFactor' => 'formfactor',
        ];
        return $fieldMappings[$field] ?? null;
    }

    public function updatePart(): void
    {
        $id = $this->partId;
        AuditTrail::logUpdate($this->form, $this->partType, $id);

        unset($this->form['image']);
        $sql = "UPDATE " . $this->partType . "s SET ";
        foreach ($this->form as $key => $value) {
            $sql .= $key . " = '" . $value . "', ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE Id = " . $this->partId;
        $this->sql($sql);


        session()->flash('message', 'Part Updated Successfully.');
    }

    public function deletePart(): void
    {
        $sql = "UPDATE " . $this->partType . "s SET deleted_at = NOW() WHERE id = " . $this->partId;
        $this->sql($sql);
        AuditTrail::logDelete($this->partType, $this->partId);

        session()->flash('message', 'Part Deleted Successfully.');
    }

    public function restorePart(): void
    {
        $sql = "UPDATE " . $this->partType . "s SET deleted_at = NULL WHERE id = " . $this->partId;
        $this->sql($sql);
        AuditTrail::logRestore($this->partType, $this->partId);

        session()->flash('message', 'Part Restored Successfully.');
    }

    public function sql($sql): void
    {
        $connection = app('db')->connection();
        $modelClass = 'App\\Models\\Parts\\' . ucfirst($this->partType);
        $part = $modelClass::withTrashed()->find($this->partId);
        $connection->statement($sql);
        $part->save();
    }

    public function addToBuild(): void
    {
        $pcParts = new PcParts();
        $pcParts->addToBuild($this->partType, $this->partId);
    }

    public function savePhoto(): void
    {
        foreach($this->images as $image){
            $image->storeAs('parts' . '/' .  $this->partType . '/' . $this->partId, $image->getClientOriginalName(), 'public');
        }
        session()->flash('message', 'Images Saved Successfully.');

    }

    public function deletePhoto($photo): void
    {
        $path = public_path('storage/parts/' . $this->partType . '/' . $this->partId . '/' . $photo);
        unlink($path);
        session()->flash('message', 'Image Deleted Successfully.');
    }

}
