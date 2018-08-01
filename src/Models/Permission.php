<?php

namespace Multidots\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Multidots\Admin\Traits\Permissions;

class Permission extends Model
{
    
    use Permissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'title', 'permission_key', 'status'
    ];

    /**
     * It define many to many relationship.
     * Administrator has many permission.
     *
     * @return type
     */
    public function role()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Define the parent relation
     * 
     * @return type
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Define the child relation
     * 
     * @return type
     */
    public function childrens()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotDeleted($query)
    {
        return $query->where('status', '<>', config('app.ADMIN_CONST.STATUS_DELETE'));
    }
}
