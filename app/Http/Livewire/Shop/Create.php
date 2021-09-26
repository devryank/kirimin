<?php

namespace App\Http\Livewire\Shop;

use App\Models\Shop;
use App\Models\Address;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AddressController;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $photo;
    public $address;

    public $userAddress = [];

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
            if (!is_numeric($this->province)) {
                $this->reset(['province', 'city', 'kecamatan', 'kelurahan', 'listCity', 'listKecamatan', 'listKelurahan']);
            }
            if (empty($provinces)) {
                $provinces = json_decode((new AddressController)->province());
            }

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

        if ($this->address == 'user') {
            $this->reset(['province', 'city', 'kecamatan', 'kelurahan', 'listCity', 'listKecamatan', 'listKelurahan']);
            $this->userAddress = (array) json_decode(Auth::user()->address);
            $this->jalan = $this->userAddress['jalan'];
            $this->rt = $this->userAddress['rt'];
            $this->rw = $this->userAddress['rw'];
            $this->no = $this->userAddress['no'];
            $this->kelurahan = $this->userAddress['kelurahan'];
            $this->kecamatan = $this->userAddress['kecamatan'];
            $this->city = $this->userAddress['kota'];
            $this->province = $this->userAddress['provinsi'];
            $this->kodepos = $this->userAddress['kodepos'];
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

            if ($this->address == 'user') {
                $this->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'photo' => ['required', 'mimes:jpeg,jpg,png,gif', 'max:10000'],
                ]);
            }
            if ($this->address == 'new') {
                $this->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'photo' => ['required', 'mimes:jpeg,jpg,png,gif', 'max:10000'],
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

            $imageName = date('mdYHis') . date('mdYHis') . $this->photo->getClientOriginalName();

            if (empty($checkAddress)) { // tidak ditemukan alamat yang sama

                DB::transaction(function () {
                    $imageName = date('mdYHis') . date('mdYHis') . $this->photo->getClientOriginalName();
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
                        'photo' => $imageName,
                        'address_id' => $address->id, // last insert id
                    ]);
                });
            }

            if (!empty($checkAddress)) {
                Shop::create([
                    'user_id' => Auth::user()->id,
                    'name' => $this->name,
                    'photo' => $imageName,
                    'address_id' => $checkAddress->id,
                ]);
            }

            $this->photo->storeAs('/public/toko', $imageName);

            $this->reset(['province', 'city', 'kecamatan', 'kelurahan', 'listCity', 'listKecamatan', 'listKelurahan']);

            $this->emit('shopStored');
        } else {
            $this->emit('shopProhibited', 'create');
        }
    }
}
