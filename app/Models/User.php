<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','user_types','activation_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * User's personal information
     *
     * @return \illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userInformation()
    {
        return $this->hasOne('App\Models\user_info');
    }
    /**
     * Projects the User is included
     *
     * @return \illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany('App\Models\developer');
    }
    /**
     * User's created Discussion
     *
     * @return \illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussions()
    {
        return $this->hasMany('App\Models\discussion');
    }
    /**
     * User's created Discussion Comments
     *
     * @return \illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussion_comments()
    {
        return $this->hasMany('App\Models\discussion_comments');
    }
    /**
     * User's Discussion votes
     *
     * @return \illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussion_votes()
    {
        return $this->hasMany('App\Models\discussion_vote');
    }
    /**
     * User's Discussion notifications
     *
     * @return \illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussion_notif()
    {
        return $this->hasMany('App\Models\discussion_notif');
    }
    /**
     * User's created Tasks
     *
     * @return \illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdTask()
    {
        return $this->hasMany('App\Models\task');
    }
}
