<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPanelShield;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function penjual()
    {
        return $this->hasOne(Penjual::class);
    }

    public function pembeli()
    {
        return $this->hasOne(Pembeli::class);
    }

    // public function canAccessPanel(Panel $panel): bool
    // {
    //     return match ($panel->getId()) {
    //         'admin' => $this->can('access_panel_admin'),
    //         'penjual' => $this->can('access_panel_penjual'),
    //         default => false,
    //     };
    // }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'penjual') {
            return $this->hasRole('penjual') && $this->penjual->status_verifikasi === 'verified';
        }

        if ($panel->getId() === 'admin') {
            return $this->hasRole('super_admin'); // atau role lain sesuai panel admin kamu
        }

        return false;
    }
}
