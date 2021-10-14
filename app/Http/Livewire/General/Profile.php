<?php

namespace App\Http\Livewire\General;

use App\Models\User;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Profile extends Component
{
    use WithPagination;
    use WithFileUploads;

    // page
    public $profile = true;
    public $updateProfile = false;
    public $historyTrx = false;

    // update profile
    public $userId;
    public $name;
    public $email;
    public $phone;
    public $defaultPhoto;
    public $photo;
    public $password;
    public $password_confirmation;

    // history trx
    protected $trxs;
    public $paginate = 10;

    public function mount()
    {
        $this->userId = Auth::user()->id;
    }

    public function render()
    {
        if ($this->profile) {
            $user = User::findOrFail($this->userId);
            return view('livewire.general.profile', [
                'user' => $user,
            ])->extends('layouts.general')->section('content');
        }

        if ($this->updateProfile) {
            return view('livewire.general.profile')->extends('layouts.general')->section('content');
        }

        if ($this->historyTrx) {
            $this->trxs = Transaction::where('user_id', Auth::user()->id)->paginate($this->paginate);
            return view('livewire.general.profile', [
                'trxs' => $this->trxs,
            ])->extends('layouts.general')->section('content');
        }
    }

    public function profile()
    {
        $this->profile = true;
        $this->updateProfile = false;
        $this->historyTrx = false;
    }

    public function openUpdateProfile()
    {
        $this->updateProfile = true;
        $this->historyTrx = false;
        $this->profile = false;

        $this->userId = Auth::user()->id;
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->phone = Auth::user()->phone;
        $this->defaultPhoto = Auth::user()->profile_photo_path;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:11', 'max:13'],
            'photo' => ['nullable', 'max:10000'],
            'password' => [
                'nullable', 'min:6', 'confirmed'
            ],
        ]);

        if (request()->user()->hasPermissionTo('update users')) {
            if (empty($this->photo)) { // not change image
                $imageName = $this->defaultPhoto;
            } else { // change image 
                $this->validate([
                    'photo' => ['mimes:jpeg,jpg,png,gif'],
                ]);
                $imageName = date('mdYHis') . $this->photo->getClientOriginalName();
                $this->photo->storeAs('/public/profile', $imageName);
                @unlink('storage/profile/' . $this->defaultPhoto);
            }
            $user = User::findOrFail($this->userId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'profile_photo_path' => $imageName,
            ]);
            if (!empty($this->password)) {
                $user->update([
                    'password' => Hash::make($this->password),
                ]);
            }
            $this->reset(['password', 'password_confirmation']);

            $this->profile = true;
            $this->updateProfile = false;
            $this->historyTrx = false;

            session()->flash('color', 'green');
            session()->flash('message', 'Profile berhasil diubah');
        }
    }

    public function cancel()
    {
        $this->profile();
    }

    public function historyTrx()
    {
        $this->historyTrx = true;
        $this->updateProfile = false;
        $this->profile = false;
    }
}
