<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Validator;
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
        $result = $client->call("login2", array("username" => $username,"password" =>md5($password)));
        $result = json_decode($result);
        dd($result);
    }

    public function login(Request $request)
    {
        $username = $request->input('email');
        $password = $request->input('password');
        $client = new nusoap_client("http://apps.unhas.ac.id/nusoap/serviceApps.php");
        $client->setCredentials("informatikaUNHAS", "createdbyMe", "basic");
        $result = $client->call("login2", array("username" => $username,"password" =>md5($password)));
        $result = json_decode($result);

        # Checking as apps user
        if ($result != NULL) {
            $simpan = User::firstOrCreate([
                    'email' => $result->userAccount,
                ],[
                    'name' => $result->userNama,
                    'password' => bcrypt($password)
                ]);

            Auth::login($simpan);
            if (auth()->user()->role_id == null) {
                return redirect()->route('request_role');
            }else {
                // if (auth()->user()->id == 3 || auth()->user()->id == 379 || auth()->user()->id == 382) {
                    return redirect()->route('index');
                // } else {
                //     Auth::logout();
                //     return redirect()->route('index');
                // }               
                
            }
        }else{
            #checking local db
            Auth::attempt(['email' => $username, 'password' => $password]);
            if (Auth::check()) {
                if (auth()->user()->role_id == null) {
                    return redirect()->route('request_role');
                }else{
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
