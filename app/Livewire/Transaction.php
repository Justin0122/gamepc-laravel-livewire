<?php

namespace App\Livewire;

use App\AuditTrail;
use App\Models\MyPc;
use App\Models\PcPart;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction as TransactionModel;
use Mollie\Laravel\Facades\Mollie;
use function Webmozart\Assert\Tests\StaticAnalysis\string;

class Transaction extends Component
{
    use WithPagination;

    #[Url (as: 'id')]
    public $id;
    public $form = [];

    public $url = '';


    public function render()
    {
        if ($this->id && !TransactionModel::find($this->id)) {
            $this->id = '';
        }
        return view('livewire.Transaction.index',
            [
                'results' => $this->id ? TransactionModel::find($this->id) : TransactionModel::paginate(10),
                'fillables' => (new TransactionModel())->getFillable(),
                'url' => current(explode('?', url()->current())),
            ]);
    }

    public function create()
    {
        $Transaction = new TransactionModel();
        foreach ($this->form as $key => $value) {
            $Transaction->$key = $value;
        }
        $Transaction->save();
    }




    public function update()
    {
        $Transaction = TransactionModel::find($this->id);
        foreach ($this->form as $key => $value) {
            $Transaction->$key = $value;
        }
        $Transaction->save();
    }

    public function delete($id)
    {
        $Transaction = TransactionModel::find($id);
        $Transaction->delete();

        return redirect()->route(strtolower('Transaction'));
    }

    public function checkout()
    {

        $myPc = myPc::where('FKUserId', Auth::user()->id)->get();
        $pcParts = $myPc[0]->getAttributes();
        $myPcId = $pcParts['MyPcId'];
        //dd($myPc);
        array_pop($pcParts);
        array_pop($pcParts);
        array_pop($pcParts);

        array_shift($pcParts);
        array_shift($pcParts);

        $totalPrice = 0;

        foreach ($pcParts as $key => $pcPart) {
            if (!$pcPart) {
                continue;
            }

            $partType = strtolower(substr($key, 2, -2));
            switch ($partType) {
                case 'case':
                    $partType = 'pc_case';
                    break;
                case 'casecooler':
                    $partType = 'case_cooler';
                    break;
                case 'cpucooler':
                    $partType = 'cpu_cooler';
                    break;
                default:
                    break;
            }
            $partModel = new PcPart($partType);
            $partModel->removeStock($pcPart, $partType);

            $price = $partModel->getPrice($pcPart, $partType);
            if($price != 0 || $price != null) {
                $totalPrice += $price;
            }
        }


        $this->form['total_price'] = $totalPrice;
        $this->form['FKMyPcId'] = $myPcId;
        $this->form['FKUserId'] = Auth::user()->id;
        $this->form['status'] = 'Shipped';
        $this->form['shipped_at'] = date(now());
        //dd($this->form);

        $this->create();
        AuditTrail::logTransactionCreate($this->form, 'Transaction', $myPcId);

        $mollieApiKey = config('mollie.api_key');
        Mollie::api()->setApiKey($mollieApiKey);

        $this->payment(number_format((float)$totalPrice, 2, '.', '') );
    }


    public function payment($price) {
        if($price < 10) {
            session()->flash('message', 'Price is too low!');
            return back();
        }
        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => strval($price)
            ],
            "description" => "Test payment",
            "redirectUrl" => env('APP_URL') . ':8000/success',
            "webhookUrl" => "https://yourwebsite.com/payment/webhook",
        ]);

        return redirect($payment->getCheckoutUrl(), 303);
    }

}
