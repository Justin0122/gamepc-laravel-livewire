<?php

namespace App\Livewire\User;

use App\Livewire\PcParts;
use App\Models\PcPart;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Livewire\Component;
use App\Models\MyPc as mypcs;

class Mypc extends Component
{
    protected $listeners = [
        'getPart' => 'getPart',
        'addToBuild' => 'addToBuild'
    ];

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        if (!auth()->check()) {
            return view('livewire.user.mypc');
        }

        $parts = $this->getMyPcParts();
        $total = $this->calculateCost($parts);

        $pcParts = new PcParts();
        $fields = $pcParts->fields();

        return view('livewire.user.mypc', [
            'parts' => $parts,
            'fields' => $fields,
            'total' => $total
        ]);
    }

    protected function getMyPcParts(): Collection|array
    {
        return mypcs::query()
            ->leftJoin('cpus', 'cpus.id', '=', 'my_pcs.FKCPUId')
            ->leftJoin('cpu_coolers', 'cpu_coolers.id', '=', 'my_pcs.FKCPUCoolerId')
            ->leftJoin('motherboards', 'motherboards.id', '=', 'my_pcs.FKMotherboardId')
            ->leftJoin('gpus', 'gpus.id', '=', 'my_pcs.FKGPUId')
            ->leftJoin('rams', 'rams.id', '=', 'my_pcs.FKRAMId')
            ->leftJoin('storages', 'storages.id', '=', 'my_pcs.FKStorageId')
            ->leftJoin('psus', 'psus.id', '=', 'my_pcs.FKPSUId')
            ->leftJoin('pc_cases', 'pc_cases.id', '=', 'my_pcs.FKCaseId')
            ->leftJoin('case_coolers', 'case_coolers.id', '=', 'my_pcs.FKCaseCoolerId')
            ->select(
                'my_pcs.*',
                'cpus.Name as CpuName', 'cpus.Price as CpuPrice', 'cpus.id as CpuId',
                'cpu_coolers.Name as Cpu_coolerName', 'cpu_coolers.Price as Cpu_coolerPrice', 'cpu_coolers.id as Cpu_coolerId',
                'motherboards.Name as MotherboardName', 'motherboards.Price as MotherboardPrice', 'motherboards.id as MotherboardId',
                'gpus.Name as GpuName', 'gpus.Price as GpuPrice', 'gpus.id as GpuId',
                'rams.Name as RamName', 'rams.Price as RamPrice', 'rams.id as RamId',
                'storages.Name as StorageName', 'storages.Price as StoragePrice', 'storages.id as StorageId',
                'psus.Name as PsuName', 'psus.Price as PsuPrice', 'psus.id as PsuId',
                'pc_cases.Name as Pc_caseName', 'pc_cases.Price as Pc_casePrice', 'pc_cases.id as Pc_caseId',
                'case_coolers.Name as Case_coolerName', 'case_coolers.Price as Case_coolerPrice' , 'case_coolers.id as Case_coolerId'
            )
            ->where('my_pcs.FKUserId', '=', auth()->user()->id)
            ->get();
    }

    protected function calculateCost($parts)
    {
        $total = 0;
        foreach ($parts as $part) {
            $total += $part->CpuPrice;
            $total += $part->Cpu_coolerPrice;
            $total += $part->MotherboardPrice;
            $total += $part->GpuPrice;
            $total += $part->RamPrice;
            $total += $part->StoragePrice;
            $total += $part->PsuPrice;
            $total += $part->Pc_casePrice;
            $total += $part->Case_coolerPrice;
        }
        return number_format((float)$total, 2, '.', '');
    }

    public function removeFromBuild($partType, $partId): void
    {
        $partType1 = $partType;
        if ($partType == 'pc_case') {
            $partType = 'case';
        }
        $partType = 'FK' . str_replace(' ', '', ucwords(str_replace('_', ' ', $partType))) . 'Id';
        $myPc = mypcs::where('FKUserId', auth()->user()->id)->where('deleted_at', null)->first();
        $myPc->$partType = null;
        $myPc->save();
        session()->flash('message', PcPart::findPartName($partType1, $partId)->Name . ' removed from build successfully.'  ?? ucfirst($partType1) . ' removed from build successfully.');
    }

    public function clearBuild(): void
    {
        $myPc = mypcs::where('FKUserId', auth()->user()->id)->where('deleted_at', null)->first();
        $parts = ['CPU', 'CPUCooler', 'Motherboard', 'GPU', 'RAM', 'Storage', 'PSU', 'Case', 'CaseCooler'];
        foreach ($parts as $part) {
            $partType = 'FK' . $part . 'Id';
            $myPc->$partType = null;
        }
        $myPc->save();
        $this->dispatch('Cleared');
    }

    public function getPart($partType, $partId): void
    {
        //search for part in database
        $part = PcPart::findPartName($partType, $partId);
        //if part is not found, return
        if (!$part) {
            return;
        }
        //if part is found, set the part type and part id
        $this->partType = $partType;
        $this->partId = $partId;
    }

    public function addToBuild($partType, $partId): void
    {
        $pcParts = new PcParts();
        $pcParts->addToBuild($partType, $partId);
    }
}
