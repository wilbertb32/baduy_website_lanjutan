<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogoutConfirmationController extends Controller
{
    public function show(Request $request)
    {
        $intendedRoute = $request->query('intended', 'login');
        $previousUrl = $request->query('previous');
        
        return view('auth.confirm-logout', compact('intendedRoute', 'previousUrl'));
    }

    public function confirm(Request $request)
    {
        $intendedRoute = $request->input('intended', 'login');
        
        // Logout user
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman yang diminta
        return redirect()->route($intendedRoute)->with('success', 'You have been logged out successfully.');
    }

    public function cancel(Request $request)
    {
        // Debug untuk melihat apa yang diterima
        Log::info('Cancel method called', [
            'previous_url' => $request->input('previous_url'),
            'user_role' => Auth::user()->role ?? 'not logged in',
            'all_inputs' => $request->all()
        ]);

        $previousUrl = $request->input('previous_url');
        $user = Auth::user();
        
        // Cek apakah user masih login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Session expired');
        }
        
        // Cek apakah ada previous URL yang valid
        if ($previousUrl && 
            $previousUrl !== url()->current() && 
            $previousUrl !== route('auth.confirm-logout') &&
            filter_var($previousUrl, FILTER_VALIDATE_URL) &&
            parse_url($previousUrl, PHP_URL_HOST) === parse_url(url('/'), PHP_URL_HOST)) {
            
            Log::info('Redirecting to previous URL: ' . $previousUrl);
            return redirect($previousUrl)->with('info', 'Stayed logged in, returned to previous page');
        }
        
        // Fallback berdasarkan role user
        Log::info('Using role-based fallback for role: ' . $user->role);
        
        switch ($user->role) {
            case 'superadmin':
                return redirect()->route('superadmin.dashboard')->with('info', 'Stayed logged in as Superadmin');
                
            case 'admin':
                return redirect()->route('admin.dashboard')->with('info', 'Stayed logged in as Admin');
                
            default:
                return redirect()->route('homepage')->with('info', 'Stayed logged in');
        }
    }
}