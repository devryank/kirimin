<?php

namespace App\Actions\Fortify;

use App\Http\Controllers\AddressController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'roles' => ['required', 'in:seller,user'],
            'province' => ['required'],
            'city' => ['required'],
            'kecamatan' => ['required'],
            'kelurahan' => ['required'],
            'rt' => ['required'],
            'rw' => ['required'],
            'kodepos' => ['required'],
            'jalan' => ['required'],
            'no' => ['required'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:11', 'max:13'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $province = json_decode((new AddressController)->province_detail($input['province']));
        $input['province'] = $province->nama;

        $city = json_decode((new AddressController)->city_detail($input['city']));
        $input['city'] = $city->nama;

        $kecamatan = json_decode((new AddressController)->kecamatan_detail($input['kecamatan']));
        $input['kecamatan'] = $kecamatan->nama;

        $kelurahan = json_decode((new AddressController)->kelurahan_detail($input['kelurahan']));
        $input['kelurahan'] = $kelurahan->nama;

        $address = [
            'jalan' => $input['jalan'],
            'rt' => $input['rt'],
            'rw' => $input['rw'],
            'no' => $input['no'],
            'kecamatan' => $input['kecamatan'],
            'kelurahan' => $input['kelurahan'],
            'kota' => $input['city'],
            'provinsi' => $input['province'],
            'kodepos' => $input['kodepos'],
        ];

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'phone' => $input['phone'],
            'address' => json_encode($address),
        ])->assignRole($input['roles']);
    }
}
