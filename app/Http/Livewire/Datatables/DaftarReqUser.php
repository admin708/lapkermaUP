<?php

namespace App\Http\Livewire\Datatables;

use Livewire\Component;
use App\Models\User;

use Illuminate\Support\Facades\Mail;

use App\Mail\ActivationAccepted;
use App\Mail\ActivationDeclined;

class DaftarReqUser extends Component
{
    public $userRequestList;

    public function mount()
    {
        $this->userRequestList = User::where('request', 0)->get();
    }

    public function requestAccepted($id)
    {
        $user = User::find($id); // Retrieve the single User instance by ID

        if ($user) {
            $user->update(['request' => 1]); // Update the request status
            Mail::to($user->email)->send(new ActivationAccepted($user->name)); // Pass $user->name to the mail class
        }
        $this->dispatchBrowserEvent('refresh-page');
    }

    public function requestDenied($id, $email)
    {
        $user = User::find($id);

        if ($user) {
            Mail::to($user->email)->send(new ActivationDeclined($user->name));
            $user->delete();
        }

        $this->dispatchBrowserEvent('refresh-page');
    }

    public function render()
    {
        return view('livewire.datatables.daftar-req-user');
    }
}
