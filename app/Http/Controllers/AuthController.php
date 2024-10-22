<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

use Hash;
use Session;
use App\Models\User;
use nusoap_client;

class AuthController extends Controller
{

    public function showLogin()
    {
        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('index');
        }
        return view('MasterApp.login');
    }

    public function pimpinan()
    {
        return view('MasterApp.Dashboard');
    }

    public function test()
    {
        $username = '198801072018015001';
        $password = 'unhas2015';
        $client = new nusoap_client("http://apps.unhas.ac.id/nusoap/serviceApps.php");
        $client->setCredentials("informatikaUNHAS", "createdbyMe", "basic");
        $result = $client->call("login2", array("username" => $username, "password" => md5($password)));
        $result = json_decode($result);
        dd($result);
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

        // Store validated data
        $validatedData = $validator->validated();

        // Store registration details temporarily (without saving user to database yet)
        session([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'fakultas_id' => null,
            'prodi_id' => null,
            'request' => 1,
            'role_id' => 6,
        ]);

        // Generate OTP and send it via email
        $otp = mt_rand(100000, 999999);
        session(['otp' => $otp, 'otp_expiry' => now()->addMinutes(5)]);

        // Send OTP email to the registered email
        Mail::to($validatedData['email'])->send(new OtpMail($otp));
    }

    public function verifyOtp(Request $request)
    {
        // Validate the OTP input
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        // Retrieve the OTP and its expiry from session
        $storedOtp = session('otp');
        $otpExpiry = session('otp_expiry');

        if ($storedOtp == $request->otp && now()->lessThanOrEqualTo($otpExpiry)) {
            // OTP is valid, register the user
            $newUser = new User();
            $newUser->name = session('name');
            $newUser->email = session('email');
            $newUser->password = session('password');
            $newUser->fakultas_id = session('fakultas_id');
            $newUser->prodi_id = session('prodi_id');
            $newUser->request = session('request');
            $newUser->role_id = session('role_id');
            $newUser->save();

            // Clear session after successful registration
            session()->forget(['otp', 'otp_expiry', 'name', 'email', 'password', 'fakultas_id', 'prodi_id', 'request', 'role_id']);

            return redirect()->back()->with('success', 'OTP verified successfully! Your registration is complete.');
        } else {
            // OTP is invalid or expired
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }
    }

    public function login(Request $request)
    {
        $username = $request->input('email');
        $password = $request->input('password');
        $client = new nusoap_client("http://apps.unhas.ac.id/nusoap/serviceApps.php");
        $client->setCredentials("informatikaUNHAS", "createdbyMe", "basic");
        $result = $client->call("login2", array("username" => $username, "password" => md5($password)));
        $result = json_decode($result);

        # Checking as apps user
        if ($result != NULL) {
            $simpan = User::firstOrCreate([
                'email' => $result->userAccount,
            ], [
                'name' => $result->userNama,
                'password' => bcrypt($password)
            ]);

            Auth::login($simpan);
            if (auth()->user()->role_id == null) {
                return redirect()->route('request_role');
            } else {
                // if (auth()->user()->id == 3 || auth()->user()->id == 379 || auth()->user()->id == 382) {
                return redirect()->route('index');
                // } else {
                //     Auth::logout();
                //     return redirect()->route('index');
                // }               

            }
        } else {
            #checking local db
            Auth::attempt(['email' => $username, 'password' => $password]);
            if (Auth::check()) {
                if (auth()->user()->role_id == null) {
                    return redirect()->route('request_role');
                } else {
                    // if (auth()->user()->id == 3 || auth()->user()->id == 379 || auth()->user()->id == 382) {
                    return redirect()->route('index');
                    // } else {
                    //     Auth::logout();
                    //     return redirect()->route('index');
                    // }
                }
            } else {
                return redirect()->back()->withInput()->withErrors(['pesan' => 'wrong password or username']);
            }
        }
    }
    public function master()
    {
        return view('MasterApp.ChangeApp');
    }
    public function map()
    {
        return view('MasterApp.map');
    }
    public function search()
    {
        $results = session()->get('search_results');

        if ($results) {
            return view('search', ['results' => $results]);
        } else {
            return redirect()->route('home');
        }
    }
    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('home');
    }
}
