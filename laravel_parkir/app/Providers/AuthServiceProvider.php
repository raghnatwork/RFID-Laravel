<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Log; // <-- PENTING: Tambahkan ini

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        // Log::info('AuthServiceProvider boot method dipanggil.'); // Debugging: Konfirmasi boot method dipanggil

        // Gate 'create-user': Hanya super_admin
        Gate::define('create-user', function (User $user) {
            Log::info('Mengevaluasi Gate create-user. User Role: ' . ($user ? $user->role : 'NULL'));
            $result = $user && $user->role === 'super_admin';
            Log::info('create-user Gate hasil: ' . ($result ? 'TRUE' : 'FALSE'));
            return $result;
        });

        // Gate 'access-admin-features': Admin dan Super Admin
        Gate::define('access-admin-features', function (User $user) {
            Log::info('Mengevaluasi Gate access-admin-features. User Role: ' . ($user ? $user->role : 'NULL'));
            $result = $user && ($user->role === 'admin' || $user->role === 'super_admin');
            Log::info('access-admin-features Gate hasil: ' . ($result ? 'TRUE' : 'FALSE'));
            return $result;
        });

        // Gate::before: Super admin bisa melakukan apapun
        Gate::before(function (User $user, string $ability) {
            Log::info('Mengevaluasi Gate::before. User Role: ' . ($user ? $user->role : 'NULL') . '. Ability: ' . $ability);
            if ($user && $user->role === 'super_admin') {
                Log::info('Gate::before memberikan TRUE karena super_admin.');
                return true;
            }
            // Log::info('Gate::before mengembalikan NULL.'); // Mengembalikan null berarti Gate lain yang akan dievaluasi
            return null;
        });
    }
}