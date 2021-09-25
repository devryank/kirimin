<?php

namespace App\Http\Livewire\Shop;

use App\Models\Shop;
use App\Models\Address;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AddressController;

class Create extends Component
{
    public $name;
    public $address;

    public $defaultAddress = [];

    public $jalan;
    public $rt;
    public $rw;
    public $no;
    public $kodepos;
    public $province;
    public $city;
    public $kecamatan;
    public $kelurahan;

    public $listCity = [];
    public $listKecamatan = [];
    public $listKelurahan = [];

    public function render()
    {
        $provinces = [];
        if ($this->address == 'new') {
            $provinces = json_decode((new AddressController)->province());


            if (!empty($this->province)) {
                $this->listCity = json_decode((new AddressController)->city($this->province));
                $this->listCity = $this->listCity->kota_kabupaten;
            }
            if (!empty($this->city)) {
                $this->listKecamatan = json_decode((new AddressController)->kecamatan($this->city));
                $this->listKecamatan = $this->listKecamatan->kecamatan;
            }
            if (!empty($this->kecamatan)) {
                $this->listKelurahan = json_decode((new AddressController)->kelurahan($this->kecamatan));
                $this->listKelurahan = $this->listKelurahan->kelurahan;
            }
        }

        if ($this->address == 'default') {
            $this->reset(['province', 'city', 'kecamatan']);
            $this->defaultAddress = (array) json_decode(Auth::user()->address);
            $this->jalan = $this->defaultAddress['jalan'];
            $this->rt = $this->defaultAddress['rt'];
            $this->rw = $this->defaultAddress['rw'];
            $this->no = $this->defaultAddress['no'];
            $this->kelurahan = $this->defaultAddress['kelurahan'];
            $this->kecamatan = $this->defaultAddress['kecamatan'];
            $this->city = $this->defaultAddress['kota'];
            $this->province = $this->defaultAddress['provinsi'];
            $this->kodepos = $this->defaultAddress['kodepos'];
        }


        return view('livewire.shop.create', [
            'provinces' => $provinces,
        ]);
    }

    public function store()
    {
        if (request()->user()->hasPermissionTo('create shops')) {

            $checkAddress = Address::where('jalan', $this->jalan)
                ->where('rt', $this->rt)
                ->where('rw', $this->rw)
                ->where('no', $this->no)
                ->where('kodepos', $this->kodepos)
                ->where('kelurahan', $this->kelurahan)
                ->first();

            if ($this->address == 'default') {
                $this->validate([
                    'name' => ['required', 'string', 'max:255'],
                ]);
            }
            if ($this->address == 'new') {
                $this->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'address' => ['required'],
                    'province' => ['required'],
                    'city' => ['required'],
                    'kecamatan' => ['required'],
                    'kelurahan' => ['required'],
                    'rt' => ['required'],
                    'rw' => ['required'],
                    'kodepos' => ['required'],
                    'jalan' => ['required'],
                    'no' => ['required'],
                ]);

                $province = json_decode((new AddressController)->province_detail($this->province));
                $this->province = $province->nama;

                $city = json_decode((new AddressController)->city_detail($this->city));
                $this->city = $city->nama;

                $kecamatan = json_decode((new AddressController)->kecamatan_detail($this->kecamatan));
                $this->kecamatan = $kecamatan->nama;

                $kelurahan = json_decode((new AddressController)->kelurahan_detail($this->kelurahan));
                $this->kelurahan = $kelurahan->nama;
            }

            if (empty($checkAddress)) {
                DB::transaction(function () {
                    $address = Address::create([
                        'jalan' => $this->jalan,
                        'rt' => $this->rt,
                        'rw' => $this->rw,
                        'no' => $this->no,
                        'kecamatan' => $this->kecamatan,
                        'kelurahan' => $this->kelurahan,
                        'kota' => $this->city,
                        'provinsi' => $this->province,
                        'kodepos' => $this->kodepos,
                    ]);
                    Shop::create([
                        'user_id' => Auth::user()->id,
                        'name' => $this->name,
                        'address_id' => $address->id, // last insert id
                    ]);
                });
            }

            if (!empty($checkAddress)) {
                Shop::create([
                    'user_id' => Auth::user()->id,
                    'name' => $this->name,
                    'address_id' => $checkAddress->id,
                ]);
            }

            $this->reset(['kecamatan', 'kelurahan', 'province', 'city', 'listCity', 'listKecamatan', 'listKelurahan']);

            $this->emit('shopStored');
        } else {
            $this->emit('shopProhibited', 'create');
        }
    }
}
