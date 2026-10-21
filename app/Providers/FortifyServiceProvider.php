<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Contracts\VerifyEmailResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('passkeys', function (Request $request) {
            $credentialId = $request->input('credential.id');

            return Limit::perMinute(10)->by(
                ($credentialId ?: $request->session()->getId()).'|'.$request->ip()
            );
        });

        //loginview
        Fortify::loginView(function () {
            return view('auth.login');
        });

        //registration view
        Fortify::registerView(function () {
            return view('auth.register'); 
        });

        //email verify view
        Fortify::verifyEmailView(function () {
        return view('auth.verify-email');
        });

        // Redirect after Registration using route name
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request) {
                return redirect()->route('verification.notice');
            }
        });

        // return password reset view

        Fortify::resetPasswordView(function (Request $request) {
        return view('auth.reset-password', ['request' => $request]);
        });

        // return forgot password  view

            Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password'); 
        });

        // Custom redirect after clicking email verification link
        $this->app->instance(VerifyEmailResponse::class, new class implements VerifyEmailResponse {
            public function toResponse($request)
            {
                
                return redirect()->route('login')->with('status', 'Email verified successfully!');
                                
            }
        });

        // Redirect after Login using route name
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request) {
                $user = $request->user();

                // Check user roles and redirect to appropriate named routes
                return match ($user->role) {
                    'Admin'    => redirect()->route('admin.overview'),
                    'Academic officer'   => redirect()->route('staffs.overview'),
                    'Student' => redirect()->route('students.overview'),
                    'Finance officer' => redirect()->route('staffs.overview'),
                    'IT officer' => redirect()->route('staffs.overview'),
                    default    => redirect()->route('students.overview'),
                };
            }     
        });



    }
}
