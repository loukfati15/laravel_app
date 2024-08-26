<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Superuser;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Region;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $regions = Region::all();
        return view('auth.register', compact('regions'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:superusers'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'N_telephone' => ['required', 'string', 'max:20'],
            'region_number' => ['required', 'array'],
            'poste' => ['required', 'string', 'max:100'],
        ]);

        $superuser = Superuser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'approved' => false,
            'N_telephone' => $request->N_telephone,
            'poste' => $request->poste,
            'user_id' => uniqid(), // Generate a unique user ID
        ]);

        $superuser->regions()->attach($request->region_number);

        event(new Registered($superuser));

        Auth::login($superuser);

        if (!$superuser->approved) {
            Auth::logout();
            return redirect('/approval-required');
        }

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Show the approval required notice.
     *
     * @return \Illuminate\View\View
     */
    public function approvalRequired()
    {
        return view('auth.approval-required');
    }
}
