<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                'max:100'
            ],
            'password' => [
                'required',
                'string',
            ]
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 100 karakter.',
            'password.required' => 'Password wajib diisi.'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'login.'])
                ->withInput($request->except('password'));
        }

        if (isset($user->status) && $user->status !== 'active') {
            return back()
                ->withErrors(['email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.'])
                ->withInput($request->except('password'));
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['password' => 'Password yang Anda masukkan salah.'])
                ->withInput($request->except('password'));
        }

        Auth::login($user, $request->filled('remember'));

        $request->session()->regenerate();

        Log::info('User login successful', [
            'user_id' => $user->id,
            'email'   => $user->email,
            'ip'      => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return redirect()->intended('/')
            ->with('success', 'Login berhasil! Selamat datang, ' . $user->name . '!');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Log::info('User logout', [
                'user_id' => Auth::id(),
                'email'   => Auth::user()->email
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Anda telah berhasil logout.');
    }

    public function profileMahasiswa(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:20',
            'nama_lengkap' => 'required|string|max:255',
            'prodi_id' => 'required|exists:prodi,id',
            'jalur_masuk' => 'required|string|max:50',
            'no_hp' => 'required|string|max:20',
            'semester_saat_ini' => 'required|integer|min:1',
            'ukt_awal' => 'required|numeric|min:0',
            'piutang_semester_lalu' => 'nullable|numeric|min:0',
        ]);

        $user = Auth::user();
        if ($user->role !== 'mahasiswa') {
            abort(403, 'Hanya mahasiswa yang dapat mengisi profil ini.');
        }

        Mahasiswa::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'nim' => $request->nim,
                'nama_lengkap' => $request->nama_lengkap,
                'prodi_id' => $request->prodi_id,
                'jalur_masuk' => $request->jalur_masuk,
                'no_hp' => $request->no_hp,
                'semester_saat_ini' => $request->semester_saat_ini,
                'ukt_awal' => $request->ukt_awal,
                'piutang_semester_lalu' => $request->piutang_semester_lalu ?? 0,
            ]
        );

        return redirect()->route('dashboard')->with('success', 'Profil berhasil disimpan');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('id', Auth::id())->first();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
