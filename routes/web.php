<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register/{name},{pass},{type}', function ($name, $pass, $type) {
    if ($name && $pass && $type) {
        if (!(User::where('name', $name)->exists())) {
            if (in_array($type, ['admin', 'advance', 'basic'])) {
                $user = new user;
                $user->name = $name;
                $user->password = Hash::make($pass);
                $user->type = $type;
                $user->email = $name . '@lala.com';

                $user->save();

                echo 'User created with id ' . $user->id;
                echo '<br /><a href="' . url('/setup/' . $name . ',' . $pass) . '">Setup</a>';
            } else {
                echo "Enter a Valid type <br /> allowed types ['admin', 'advance', 'basic']";
            }
        } else {
            echo 'name already exists';
        }
    }
});

Route::get('/setup/{name},{password}', function ($name, $password) {
    $creds = [
        'name' => $name,
        'password' => $password,
    ];

    if (Auth::attempt($creds)) {
        $auth = Auth::user();
        $abilities = $auth->type == 'admin' ? '["create", "update", "delete"]' : ($auth->type == "advance" ? '["create", "update"]' : '["none"]');
        $token = $auth->createToken('admin-token', json_decode($abilities));

        return [
            'token' => $token->plainTextToken,
            'abilities' => json_decode($abilities)
        ];
    } else {
        return redirect('/register/' . $name . ',' . $password . ',EnterType');
    }
});
