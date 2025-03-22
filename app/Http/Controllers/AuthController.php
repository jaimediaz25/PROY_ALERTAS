<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon; 
use Illuminate\Support\Facades\Http;

class AuthController extends Controller {
    
    public function showLoginForm() {
        return view('auth.login');
    }
    

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        $response = Http::post('http://localhost:3001/api/auth/login', [
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ]);
    
        if (!$response->successful()) {
            $error = $response->json()['error'] ?? 'Error desconocido';
            
            // Manejar específicamente el error de bloqueo
            if ($response->status() === 403) {
                return back()->withErrors(['email' => $error]);
            }
            
            return back()->withErrors(['email' => $error]);
        }
    
        session(['user' => $response->json()['user']]);
        return redirect()->intended('/home');
    }

    
    public function showRegisterForm() {
        return view('auth.register');
    }
    

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'edad' => 'required|integer',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $response = Http::post('http://localhost:3001/api/users', [
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'edad' => $request->edad,
            'email' => $request->email,
            'password' => $request->password,
            'rol' => 'usuario'
        ]);

        if ($response->successful()) {
            return redirect('/login')->with('success', 'Registro exitoso');
        }

        $error = $response->json()['error'] ?? 'Error al registrar';
        return back()->withErrors(['email' => $error]);
    }

    
    public function showForgotPasswordForm() {
        return view('auth.reset-password');
    }
    

    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
    
        $response = Http::put('http://localhost:3001/api/users/update-password', [
            'email' => $request->email,
            'password' => $request->password
        ]);
    
        if ($response->successful()) {
            return redirect('/login')->with('success', 'Contraseña actualizada');
        }
    
        $error = $response->json()['error'] ?? 'Error al actualizar';
        return back()->withErrors(['email' => $error]);
    }
    
    
    public function logout() {
        session()->forget('user');
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/login');
    }
}