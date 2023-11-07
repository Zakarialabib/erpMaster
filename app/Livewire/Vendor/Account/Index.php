<?php

declare(strict_types=1);

namespace App\Livewire\Vendor\Account;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $user;
    public $name;
    public $phone;
    public $email;
    public $address;
    public $city;
    public $country;
    public $password;

    protected $rules = [
        'email'    => 'required|email',
        'name'     => 'required|string',
        'address'  => 'nullable|max:255',
        'phone'    => 'required|numeric|max:1O',
        'password' => 'required|min:8',
        'city'     => 'nullable|string',
        'country'  => 'nullable',
    ];

    public function mount(): void
    {
        $this->user = User::whereId(Auth::user()->id)->first();
        $this->name = $this->user->name;
        $this->address = $this->user->address;
        $this->phone = $this->user->phone;
        $this->city = $this->user->city;
        $this->country = $this->user->country;
        $this->email = $this->user->email;
        $this->password = $this->user->password;
    }

    public function store(): void
    {
        $this->validate();

        if ($this->password !== '') {
            $this->user->password = bcrypt($this->password);
        }

        $this->user->update();

        $this->alert('success', 'Account updated successfully', [
            'position'          => 'top-end',
            'timer'             => 3000,
            'toast'             => true,
            'text'              => '',
            'confirmButtonText' => 'Ok',
            'cancelButtonText'  => 'Cancel',
            'showCancelButton'  => false,
            'showConfirmButton' => false,
        ]);
    }

    public function render()
    {
        return view('livewire.vendor.account.index')->extends('layouts.vendor');
    }
}
