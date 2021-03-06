<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $createUser = false;
    public $editUser = false;
    public $deleteUser = false;
    public $search;
    public $paginate = 10;

    protected $listeners = [
        'refreshUser' => '$refresh',
        'userStored' => 'userStoredHandler',
        'userUpdate' => 'userUpdateHandler',
        'closeUser' => 'closeUserHandler',
        'userProhibited' => 'userProhibitedHandler',
        'userDestroyed' => 'userDestroyedHandler',
    ];

    protected $updateQueryString = [
        ['search' => ['except' => '']]
    ];

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }

    public function render()
    {
        $users = $this->search === NULL     ?
            User::orderBy('id', 'asc')->paginate($this->paginate) :
            User::orderBy('id', 'asc')->where('name', 'like', '%' . $this->search . '%')->paginate($this->paginate);
        // dd($users);
        return view('livewire.user.index', [
            'users' => $users,
        ]);
    }

    public function closeUserHandler()
    {
        $this->editUser = false;
        $this->createUser = false;
        $this->deleteUser = false;
    }

    public function createUser()
    {
        $this->closeUserHandler();
        $this->createUser = true;
    }

    public function userStoredHandler()
    {
        $this->closeUserHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'User successfully created');
    }

    public function editUser($id)
    {
        $this->closeUserHandler();
        $this->editUser = true;
        $this->emit('userEdit', $id);
    }

    public function userUpdateHandler()
    {
        $this->closeUserHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'User successfully updated');
    }

    public function userProhibitedHandler($action)
    {
        $this->closeUserHandler();
        session()->flash('color', 'red');
        session()->flash('message', 'You are not allowed to ' . $action . ' an user');
    }

    public function deleteUser($id)
    {
        if (Auth::user()->hasRole('super-admin') or Auth::user()->id == $id) {
            $this->closeUserHandler();
            $user = User::findOrFail($id);
            $this->deleteUser = true;
            $this->emit('deleteUser', $user); // User/Delete.php
        } else {
            $this->emit('userProhibited', 'delete');
        }
    }

    public function userDestroyedHandler($name)
    {
        $this->closeUserHandler();
        session()->flash('color', 'green');
        session()->flash('message', 'Successfully delete user ' . $name);
    }
}
