<?php

namespace Multidots\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'status'
    ];

    /**
     * One to many relationship.
     * One role belongs to many administrator.
     * 
     * @return type
     */
    public function user()
    {
        return $this->hasMany(User::class);
    }

    /**
     * It define to many to many relationship to permission.
     *
     * @return type
     */
    public function permission()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('status', '<>', config('admin.ADMIN_CONST.STATUS_DELETE'));
    }

    /**
     * Get the only not admin records
     * 
     * @param type $query
     * @return type
     */
    public function scopeNotInAdmin($query)
    {
        return $query->where('name', 'NOT LIKE', '%admin%');
    }
}
