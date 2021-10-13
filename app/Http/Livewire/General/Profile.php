<?php

namespace App\Http\Livewire\General;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
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
    public $photo;

    public function mount()
    {
        $this->userId = Auth::user()->id;
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->phone = Auth::user()->phone;
        $this->photo = Auth::user()->profile_photo_path;
    }

    public function render()
    {
        if ($this->profile) {
            $user = Auth::user();
            return view('livewire.general.profile', [
                'user' => $user,
            ])->extends('layouts.general')->section('content');
        }

        if ($this->updateProfile) {
            return view('livewire.general.profile')->extends('layouts.general')->section('content');
        }

        if ($this->historyTrx) {
            return view('livewire.general.profile', [])->extends('layouts.general')->section('content');
        }
    }

    public function profile()
    {
        $this->profile = true;
        $this->updateProfile = false;
        $this->historyTrx = false;
    }

    public function historyTrx()
    {
        $this->historyTrx = true;
        $this->updateProfile = false;
        $this->profile = false;
    }

    public function openUpdateProfile()
    {
        $this->updateProfile = true;
        $this->historyTrx = false;
        $this->profile = false;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required'],
            'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:11', 'max:13'],
            'photo' => ['nullable', 'mimes:jpeg,jpg,png,gif', 'max:10000'],
        ]);

        if (request()->user()->hasPermissionTo('update users')) {
            if ($this->photo == 'profile.png') { // not change image
                $imageName = $this->photo;
            } else { // change image 
                $imageName = date('mdYHis') . $this->photo->getClientOriginalName();
                $this->photo->storeAs('/public/profile', $imageName);
                // @unlink('storage/profile/' . $this->photo);
            }
            $user = User::findOrFail($this->userId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'profile_photo_path' => $imageName,
            ]);
            // $this->emit('userStored');

            $this->profile = true;
            $this->updateProfile = false;
            $this->historyTrx = false;
        }
    }

    public function cancel()
    {
        $this->profile();
    }
}
