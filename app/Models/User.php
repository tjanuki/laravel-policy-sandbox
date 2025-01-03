<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Gate;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        ];
    }

    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole(string $role) : bool
    {
        if (Context::hasHidden('roles')) {
            return in_array($role, Context::getHidden('roles'));
        }

        return $this->roles->contains('name', $role);
    }

    public function hasAnyRoles(array $roles) : bool
    {
        if (Context::hasHidden('roles')) {
            return !empty(array_intersect($roles, Context::getHidden('roles')));
        }

        return $this->roles()->whereIn('name', $roles)->exists();
    }

    public static function scopeVisibleTo(Builder $builder, User $user)
    {
        if (Gate::allows('viewAny', User::class)) {
            return $builder;
        }

        return $builder->where('id', $user->id);
    }

}
