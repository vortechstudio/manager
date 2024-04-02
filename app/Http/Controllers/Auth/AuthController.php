<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Auth;
use Exception;
use Hash;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Log;
use Session;
use Str;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        return match ($provider) {
            'google' => $this->verifyUser($user, 'google'),
        };
    }

    private function verifyUser($user, string $provider)
    {
        $gUser = $user;
        $user = User::query()->where('email', $gUser->email)->first();
        if (! $user) {
            $user = User::query()->create([
                'name' => $gUser->name ?? $gUser->nickname,
                'email' => $gUser->email ?? generateReference(10).'@vst.local',
                'password' => Hash::make('password0000'),
                'email_verified_at' => now(),
                'admin' => false,
                'uuid' => Str::uuid(),
            ]);
            $user->logs()->create(['user_id' => $user->id, 'action' => 'Création du compte']);

            if (! $user->socials()->where('provider', $provider)->exists()) {
                $user->socials()->create([
                    'provider' => $provider,
                    'provider_id' => $gUser->id,
                    'avatar' => $gUser->avatar,
                    'user_id' => $user->id,
                ]);
            }

            $user->profil()->firstOrCreate(['user_id' => $user->id]);
            $user->services()->create([
                'status' => true,
                'premium' => false,
                'user_id' => $user->id,
                'service_id' => 1,
            ]);

            $user->logs()->create(['user_id' => $user->id, 'action' => 'Affiliation au service: Accès de base']);

            return redirect()->route('auth.setup-register', [$provider, $user->email]);
        }

        Auth::login($user);

        return redirect()->route('home');
    }

    public function setupView(string $provider, string $email)
    {
        return view('auth.setupView', compact('provider', 'email'));
    }

    public function setupRegister(Request $request, string $provider, string $email)
    {
        $request->validate([
            'password' => 'required|min:8',
        ]);

        try {
            $user = User::where('email', $email)->firstOrFail();

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);
        } catch (Exception $exception) {
            Log::emergency($exception->getMessage(), [$exception]);
        }

        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect()->route('home');
    }

    public function confirmPasswordForm()
    {
        return view('auth.password');
    }

    public function confirmPassword(Request $request)
    {
        if (! Hash::check($request->password, $request->user()->password)) {
            toastr()
                ->addError('Mot de passe erronée', "Vérification d'accès !");
        }

        $request->session()->passwordConfirmed();

        return redirect()->intended();
    }
}
