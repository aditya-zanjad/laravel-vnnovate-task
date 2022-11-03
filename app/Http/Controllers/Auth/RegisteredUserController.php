<?php

namespace App\Http\Controllers\Auth;

use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register')
            ->with('cities', City::select(['id', 'name'])->get());
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      =>  ['required', 'string', 'max:255'],
            'email'     =>  ['required', 'string', 'email', 'max:255', 'unique:users'],
            'gender'    =>  ['required', 'string', 'size:1', 'in:m,f,o'],
            'city_id'   =>  ['required', 'numeric', 'integer', 'exists:cities,id'],
            'password'  =>  ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'              =>  $request->name,
            'email'             =>  $request->email,
            'gender'            =>  $request->gender,
            'city_id'           =>  $request->city_id,
            'password'          =>  Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
