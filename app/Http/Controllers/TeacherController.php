<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class TeacherController extends Controller
{
    //
    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Teacher::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $student = Teacher::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($student));

        Auth::guard('teacher')->login($student);

        return redirect(RouteServiceProvider::TEACHERHOME);
    }


    public function teacherlogin(Request $request)
    {
        // dd($request->all());
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('teacher')->attempt($credentials)) {
            $request->session()->regenerate();
// dd("kk");
            return redirect()->intended('teacher-dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function teacherlogout(Request $request): RedirectResponse
    {
        Auth::guard('teacher')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
