<?php

namespace App\Http\Livewire\Input;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\OtpMail;
use App\Models\Fakultas;
use App\Models\Prodi;

class GuestRegistration extends Component
{
    public $fakultasList, $prodiList;
    public $fakultas = null, $prodi = null;

    public function mount()
    {
        $this->fakultasList = Fakultas::all();
        $this->prodiList = Prodi::where('jenjang', 'sarjana')->get();
    }

    public function register(Request $request)
    {
        // Validate the registration form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ], [
            'email.unique' => 'This email address is already registered. Please choose another one.',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'register') // Assign the 'register' error bag
                ->withInput();
        }

        // Store validated data temporarily (without saving user to database yet)
        $validatedData = $validator->validated();
        session([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'fakultas_id' => $this->fakultas,
            'prodi_id' => $this->prodi,
            'request' => 0,
            'role_id' => 6,
        ]);

        // Generate OTP and send it via email
        $otp = mt_rand(100000, 999999);
        session(['otp' => $otp, 'otp_expiry' => now()->addMinutes(10), 'showOtpForm' => true]);

        Mail::to($validatedData['email'])->send(new OtpMail($otp));
        return redirect()->back()->with('showOtpForm', true);
    }

    public function render()
    {
        return view('livewire.input.guest-registration');
    }
}
