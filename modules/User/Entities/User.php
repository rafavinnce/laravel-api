<?php

namespace Modules\User\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasRoles;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_users';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_superuser' => 'boolean',
        'is_staff' => 'boolean',
        'is_alert_phone' => 'boolean',
        'is_alert_mail' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name', 'avatar'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'is_active',
        'is_superuser', 'is_staff', 'is_alert_phone', 'is_alert_mail', 'retention_list_limit',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the user's avatar.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's full name.
     *
     * @return array
     */
    public function getAvatarAttribute()
    {
        return [
            'xs'   => 'https://www.gravatar.com/avatar/'.md5($this->email).'?s=80&d=mm',
            'sm'   => 'https://www.gravatar.com/avatar/'.md5($this->email).'?s=120&d=mm',
            'md'   => 'https://www.gravatar.com/avatar/'.md5($this->email).'?s=240&d=mm',
            'lg'   => 'https://www.gravatar.com/avatar/'.md5($this->email).'?s=480&d=mm',
            'xl'   => 'https://www.gravatar.com/avatar/'.md5($this->email).'?s=1024&d=mm',
        ];
    }

    /**
     * Hash the password given.
     *
     * @param string $password
     */
    public function setPasswordAttribute($password)
    {
        if (Hash::needsRehash($password)) {
            $password = Hash::make($password);
        }

        $this->attributes['password'] = $password;
    }
}
