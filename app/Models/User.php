<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_tenant',
        'tenant_activated_at',
        'tenant_entry_count',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'tenant_activated_at' => 'datetime',
        ];
    }

    /**
     * Activate user as tenant
     */
    public function activateAsTenant()
    {
        $this->update([
            'is_tenant' => true,
            'tenant_activated_at' => now(),
            'tenant_entry_count' => $this->tenant_entry_count + 1,
        ]);
    }

    /**
     * Deactivate user as tenant
     */
    public function deactivateAsTenant()
    {
        $this->update([
            'is_tenant' => false,
            'tenant_activated_at' => null,
        ]);
    }

    /**
     * Check if user is a tenant
     */
    public function isTenant(): bool
    {
        return $this->is_tenant === true;
    }

    /**
     * Get tenant entry count
     */
    public function getTenantEntryCount(): int
    {
        return $this->tenant_entry_count ?? 0;
    }

    /**
     * Increment tenant entry count
     */
    public function incrementTenantEntry()
    {
        $this->increment('tenant_entry_count');
    }
}
