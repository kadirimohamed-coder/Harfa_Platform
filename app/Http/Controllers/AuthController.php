<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // ─────────────────────────────────────────
    // Login
    // ─────────────────────────────────────────
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if($request->filled('redirect')){
                return redirect($request->redirect) ;
            }
            
            if(auth()->user()->role === 'craftsman'){
                return redirect()->route('craftsman.bookings') ;
            }
            return $this->redirectByRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ])->onlyInput('email');
    }

    // ─────────────────────────────────────────
    // Register
    // ─────────────────────────────────────────
    public function showRegister(Request $request)
    {
        return view('auth.register', ['defaultRole' => $request->query('role', 'client')]);
    }

    public function register(Request $request)
    {
        // 'regex:/^(?:\+212|0)([5-7])[0-9]{8}$/'
        $data = $request->validate([
            'name'                  => 'required|string|max:120',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|min:6|confirmed',
            'phone'                 => ['required','string','max:20'],
            'city'                  => 'nullable|string|max:80',
            'role'                  => 'required|in:client,craftsman',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'phone'    => $data['phone'] ?? null,
            'city'     => $data['city'] ?? null,
            'role'     => $data['role'],
            'status'   => 'active',
            'points'   => $data['role'] === 'craftsman' ? 100 : 0,
        ]);

        // Auto-create craftsman profile
        if ($user->role === 'craftsman') {
            $user->craftsman()->create([
                'availability_status' => true,
                'experience_years'    => 0,
            ]);
        }

        Auth::login($user);
        return $this->redirectByRole($user);
    }

    // ─────────────────────────────────────────
    // Logout
    // ─────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // ─────────────────────────────────────────
    // Profile
    // ─────────────────────────────────────────
    public function editProfile()
    {
        return view('auth.profile', ['user' => auth()->user()]);
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */ //buch update t5dam 
        $user = auth()->user();

        $data = $request->validate([
            'name'    => 'required|string|max:120',
            'phone'   => 'nullable|string|max:20',
            'city'    => 'nullable|string|max:80',
            'address' => 'nullable|string|max:200',
            'photo'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) Storage::disk('public')->delete($user->photo);
            $data['photo'] = $request->file('photo')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('status', 'Profil mis à jour avec succès.');
    }

    // ─────────────────────────────────────────
    // Helper
    // ─────────────────────────────────────────
    private function redirectByRole(User $user): \Illuminate\Http\RedirectResponse
    {
        return match ($user->role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'craftsman' => redirect()->route('craftsman.profile'),
            default     => redirect()->route('client.dashboard'),
        };
    }
}