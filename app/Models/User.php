<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Office\Office;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     * @name      <string>
     * @phone     <string>
     * @password  <string>
     * @role      <string>
     * @role_ar   <string>
     * @office_id <int>
     */
    protected $table = 'users';
    protected $fillable = [
        'name',
        'phone',
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
    ];

    function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function getRoleArAttribute()
    {
        $enRole = $this->getRoleNames()->first();
        return $enRole ? __('roles_permissions.'.$enRole) : '';
    }

    public function getRoleAttribute(): Role
    {
        $enRole = $this->getRoleNames()->first();
        return Role::findByName($enRole);
    }

    public function isBelongsToOffice($officeId)
    {
        if (!$this->office) {
            return true;
        }
        return $this->office->id === $officeId;
    }

}
