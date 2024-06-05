<?php

namespace App\Livewire;

use App\AuditTrail;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Url;
use Livewire\Component;

class PartsCreate extends Component
{
    #[Url(as: 'type')]
    public string $selectedPart = "cpu";
    public array $form;

    private string $queryString = '';


    public function render()
    {

        $columns = Schema::getColumnListing('my_pcs');
        //remove the last 3 columns
        array_pop($columns);
        array_pop($columns);
        array_pop($columns);

        //remove the 1st 2 columns
        array_shift($columns);
        array_shift($columns);


        $dropdownData = $this->getDropdownData();

        foreach ($columns as $key => $value) {
            $columns[$key] = substr($value, 2, -2);
        }

        return view('livewire.parts-create', [
            'partTypes' => $columns,
            'fields' => $this->getColumnsFromType() ?? [],
            'dropdownData' => $dropdownData ?? [],
        ]);
    }


    private function getColumnsFromType(): array
    {
        switch ($this->selectedPart){
            case 'case':
                $this->selectedPart = 'pc_case';
                break;
            case 'casecooler':
                $this->selectedPart = 'case_cooler';
                break;
            case 'cpucooler':
                $this->selectedPart = 'cpu_cooler';
                break;

            default:
                break;
        }
        //get the schema from the part type
        $columns = Schema::getColumnListing($this->selectedPart . 's');

        //remove the last 3 columns
        array_pop($columns);
        array_pop($columns);
        array_pop($columns);

        //remove the id column
        array_shift($columns);
        return $columns;
    }

    public function createPart(): void
    {
        // Create an instance of the selected part type model
        $partTypeModel = 'App\\Models\\Parts\\' . ucfirst($this->selectedPart);

        // Create a new part with the form data
        $newPart = new $partTypeModel;

        // Set the attributes of the new part
        foreach ($this->form as $field => $value) {
            $newPart->{$field} = $value;
        }

        // Save the new part to the database
        $newPart->save();

        $id = $newPart->id;
        AuditTrail::logCreate($this->form, $this->selectedPart, $id);

        $this->reset('form');

        session()->flash('message', 'Part created successfully.');
    }

    public function getDropdownData(): array
    {
        $columns = $this->getColumnsFromType();
        $dropdownData = [];

        foreach ($columns as $column) {
            if (str_starts_with($column, 'FK')) {
                $columnName = substr($column, 2, -2);
                $dropdownData[$column] = $this->getDropdownDataFromTable(strtolower($columnName) . 's');
            }
        }

        return $dropdownData;
    }

    private function getDropdownDataFromTable(string $table): LengthAwarePaginator
    {
        return DB::table($table)->where('Name', 'like', '%' . $this->queryString . '%')->paginate(10);
    }
}
