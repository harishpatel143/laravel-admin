<?php

namespace Multidots\Admin\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Multidots\Admin\Notifications\AdminResetPasswordNotification;

class Administrator extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable,
        CanResetPassword,
        Notifiable;

    protected $fillable = [
        'role_id', 'first_name', 'last_name', 'username', 'email', 'password', 'avatar', 'status', 'last_login'
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
     * Create a new Eloquent model instance.
     * Set the connection and table name
     * 
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.administrators_table'));

        parent::__construct($attributes);
    }

    /**
     * One user belongs to only one role.
     * 
     * @return type
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user's full name.
     *
     * @param  string  $value
     * @return string
     */
    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    /**
     * Hash password by bcrypt before save in database.
     *
     * @param type $password
     */
    public function setPasswordAttribute($password)
    {
        if (isset($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    /**
     * Get the only active records
     * 
     * @param type $query
     * @return type Illuminate\Support\Collection
     */
    public function scopeActive($query)
    {
        return $query->where('status', '=', config('admin.ADMIN_CONST.STATUS_ACTIVE'));
    }

    /**
     * Check the avatar path and if image is not available so return default_user image.
     * 
     * @return string
     */
    public function getAvatarAttribute()
    {
        if (!empty($this->attributes['avatar']) && file_exists(public_path() . config('admin.public-js-css') . config('admin.ADMIN_CONST.ADMIN_IMAGE_URL') . $this->attributes['avatar'])) {
            return config('admin.public-js-css') . config('admin.ADMIN_CONST.ADMIN_IMAGE_URL') . $this->attributes['avatar'];
        } else {
            return config('admin.public-js-css') . config('admin.ADMIN_CONST.ADMIN_IMAGE_URL') . 'avatar.png';
        }
    }

    //Send password reset notification
//    public function sendPasswordResetNotification($token)
//    {
//        $this->notify(new AdminResetPasswordNotification($token));
//    }
}
