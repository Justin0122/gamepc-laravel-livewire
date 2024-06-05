<?php

namespace App\Livewire;

use App\Models\MyPc;
use App\Models\PcPart;
use App\Models\PcPart as Part;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PcParts extends Component
{

    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';
    public int $perPage = 16;
    #[Url(as: 'type',history: true)]
    public string $partType = 'cpu'; // default to cpu

    public array $filters = [];
    public array $filterValues = [];
    public array $appliedFilters = [];

    public $filterSearch = [];

    public $myPc;

    protected $listeners = [
        'load-more' => 'loadMore',
    ];
    private string $searchString;

    public function loadMore(): void
    {
        $this->perPage += 16;
    }

    public function fields(): array
    {
        return MyPc::getSchema();
    }

    public function mount(): void
    {

    }
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $modelClass = 'App\\Models\\Parts\\' . ucfirst($this->partType);
        $query = $modelClass::query();

        $query = $this->applyFilters($query);

        $parts = $query->simplePaginate(10);

        if ($parts->isEmpty()) {
            $this->resetPage();
            $parts = $query->simplePaginate(10);
        }

        // Retrieve user's PC parts
        $myPcParts = Auth::check() ? MyPc::where('FKUserId', auth()->user()->id)->first() : null;

        // Get part images
        $PcPartModel = new Part($this->partType);
        $parts = $PcPartModel->getImages($parts);

        // Prepare fields for the table
        $fields = $this->fields();

        // Transform part type fields to Names
        $partTypeFields = $this->getPartTypeFields();
        foreach ($parts as $part) {
            foreach ($partTypeFields as $field) {
                $part->$field = $part->$field->Name;
            }
        }

        return view('livewire.pc-parts', [
            'parts' => $parts,
            'fields' => $fields,
            'myPcParts' => $myPcParts,
            'filters' => $this->filters,
            'appliedFilters' => $this->appliedFilters ?? null,
        ]);
    }


    protected function applyFilters($query)
    {
        // Apply search filter
        if (!empty($this->search)) {
            $this->searchString = strtolower($this->search);
            $query->where(function ($query) {
                $query->where(strtolower($this->partType) . 's.Name', 'like', '%' . $this->searchString . '%');

                $partTypeFields = $this->getPartTypeFields();
                foreach ($partTypeFields as $field) {
                    $query->orWhereHas($field, function ($q) {
                        $q->where('Name', 'like', '%' . $this->searchString . '%');
                    });
                }
            });
        }
        // Apply the filters
        foreach ($this->filterValues as $filter => $value) {
            try {
                $query->whereHas($filter, function ($q) use ($value) {
                    $q->where('Name', $value);
                });
            } catch (\Exception) {
                continue;
            }
        }
        return $query;
    }

    private function getPartTypeFields(): array
    {
        $partTypeFields = [
            'cpu' => ['Brand', 'Socket', 'Generation'],
            'motherboard' => ['Brand', 'Socket'],
            'ram' => ['Brand', 'MemoryType'],
            'case_cooler' => ['Brand'],
            'cpu_cooler' => ['Brand', 'Generation'],
            'gpu' => ['Brand'],
            'pc_case' => ['Brand', 'FormFactor'],
            'psu' => ['Brand', 'FormFactor'],
            'storage' => ['Brand']
        ];
        $this->filters = [];

        $fields = $partTypeFields[$this->partType] ?? [];

        foreach ($fields as $field) {
            $filter = 'App\\Models\\' . ucfirst($field);
            $search = $this->filterSearch[$field] ?? '';
            $this->filters[$field] = $filter::where('Name', 'like', '%' . $search . '%')->take(10)->get();
        }

        return $fields;
    }

    public function addToBuild($partType, $partId): void
    {
        // Map part types to their corresponding class names
        $partTypeMap = [
            'pc_case' => 'Pc_case',
            'case_cooler' => 'CaseCooler',
            'cpu_cooler' => 'CpuCooler',
        ];

        $partType = $partTypeMap[strtolower($partType)] ?? $partType;

        $partName = PcPart::findPartName($partType, $partId)->Name;

        session()->flash('message', $partName . ' added to build successfully');

        if ($partType == 'Pc_case') {
            $partType = 'case';
        }
        $fkKey = 'FK' . ucfirst($partType) . 'Id';

        $myPc = MyPc::where('FKUserId', auth()->user()->id)->firstOrNew([]);
        $myPc->$fkKey = $partId;
        $myPc->FKUserId = auth()->user()->id;
        $myPc->save();
    }

    public function removeFromBuild($partType): void
    {
        if ($partType == 'Pc_case') {
            $partType = 'case';
        }

        $partType = 'FK' . str_replace(' ', '', ucwords(str_replace('_', ' ', $partType))) . 'Id';
        $myPc = MyPc::where('FKUserId', auth()->user()->id)->first();
        $myPc->$partType = null;
        $myPc->save();
        session()->flash('message', 'Part removed from build successfully.');
    }

    public function addFilter($filter, $value): void
    {
        $this->filterValues[$filter] = $value;
        $this->filters[$filter] = $value;
        $this->appliedFilters[$filter] = $value;
    }

    public function clearFilter($filter): void
    {
        unset($this->filterValues[$filter]);
        unset($this->filters[$filter]);
        unset($this->appliedFilters[$filter]);
    }

    public function clearAllFilters(): void
    {
        $this->filterValues = [];
        $this->filters = [];
        $this->appliedFilters = [];
    }

}
