<?php

namespace App\Http\Livewire\History;

use App\Models\Shop;
use App\Models\User;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $indexTrx = true;
    public $detailTrx;

    public $search;
    public $paginate = 10;

    public $trxId;
    public $userId;
    public $items;
    public $total;
    protected $address;


    protected $updateQueryString = [
        ['search' => ['except' => '']]
    ];

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        $shop = Shop::where('user_id', Auth::user()->id)->first();
        $transactions = $this->search === NULL     ?
            Transaction::where('shop_id', $shop->id)->where('status', 'success')->groupBy('user_id')->orderBy('id', 'asc')->paginate($this->paginate) :
            Transaction::where('shop_id', $shop->id)->where('status', 'success')->groupBy('user_id')->orderBy('id', 'asc')->where('trx_id', 'like', '%' . $this->search . '%')->paginate($this->paginate);

        return view('livewire.history.index', [
            'transactions' => $transactions,
            'items' => $this->items,
            'total' => $this->total,
            'address' => $this->address
        ]);
    }

    public function closeTransactionHandler()
    {
        $this->indexTrx = false;
        $this->detailTrx = false;
    }

    public function detailTransaction($id, $trxId)
    {
        $this->closeTransactionHandler();
        $this->trxId = $trxId;
        $this->userId = $id;
        $shop = Shop::where('user_id', Auth::user()->id)->first();
        $this->items = Transaction::where('user_id', $this->userId)->where('status', 'success')->where('shop_id', $shop->id)->get();
        $this->total = 0;
        foreach ($this->items as $item) {
            $this->total += $item->qty == 0 ? $item->custom_price : $item->qty * $item->product->price;
        }
        $this->detailTrx = true;

        $user = User::findOrFail($this->userId);
        $this->address = json_decode($user->address);
    }
}
