<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        $data = array(
            'ip'=> $request->ip(),
            'username'=>Auth::user()->username,
            'branch'=>Auth::user()->branch_id,
            'role'=>Auth::user()->role,
            'agent'=>$request->header('User-Agent')
        );
        DB::table('userlogs')->insert($data);

        $role = Auth::user()->role;
        $checkrole = explode(',', $role);  // However you get role
       
        if (in_array('admin', $checkrole)) {
            //session(['isadmin' => 'admin']);
           return redirect(RouteServiceProvider::HOME);
        } else {
            return redirect(RouteServiceProvider::SALES);
        }        
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
