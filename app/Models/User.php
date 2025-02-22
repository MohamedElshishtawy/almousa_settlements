<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Evaluation\UserEvaluate;
use App\Office\Office;
use App\Task\History;
use App\Task\LastReadedHistory;
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

    public function getRoleAttribute(): Role|null
    {
        $enRole = $this->getRoleNames()->first();
        return $enRole ? Role::findByName($enRole) : null;
    }

    public function isBelongsToOffice($officeId)
    {
        if (!$this->office) {
            return true;
        }
        return $this->office->id === $officeId;
    }

    public function AuthorizeOffice($officeId)
    {
        if (!$this->office || $this->office->id === $officeId) {
            return true;
        }
        abort(403, 'You are not authorized to access this page');
    }

    public function lastReadedLog()
    {
        return $this->hasOne(LastReadedLog::class);
    }

    public function tasksHistories()
    {
        return $this->hasMany(History::class);
    }

    public function tasksLastReadedHistories()
    {
        return $this->hasMany(LastReadedHistory::class);
    }


    // evaluates user makes
    public function getEvaluatesAttribute()
    {
        return UserEvaluate::where('evaluator_id', $this->id)->get();
    }

    // evaluates user receives
    public function getEvaluationsAttribute()
    {
        return UserEvaluate::where('evaluated_id', $this->id)->get();
    }

    public function getEvaluatorAttribute()
    {
        $userRole = $this->role;
        $evaluatorId = $userRole->evaluator_id;
        if (!$evaluatorId) {
            return [];
        }
        $role = Role::find($evaluatorId);
        return User::HaveRole($role->name)->get();
    }


}
