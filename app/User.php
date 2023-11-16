<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Permissions\HasPermissionsTrait;

class User extends Authenticatable
{
    use Notifiable, HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function contentGroups(){
        return $this->hasMany(UserContentGroups::class);
    }

    public function userContentGroups(){
        return $this->belongsToMany(ContentGroup::class, UserContentGroups::class);
    }

    public function getContentGroup()
    {
        return $this->userContentGroups()->get();
    }

    public function bu(){
        return $this->hasMany(UserBu::class);
    }

    public function userBus(){
        return $this->belongsToMany(Bu::class, UserBu::class);
    }

    public function getBu()
    {
        return $this->userBus()->get();
    }

    public function userContentGroupsIds(){
        return $this->belongsToMany(ContentGroup::class, UserContentGroups::class)->pluck('user_content_groups.content_group_id');
    }

    public function getUserContentGroup()
    {
        return $this->userContentGroups()->pluck('name')->first();
    }
}
