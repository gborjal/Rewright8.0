<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    protected $fillable = [
        'owner_id',
    	'text',
        'size',
    	'active',
    	'update_ts'
    ];

    /**
     * Users 
     *
     * @return \illuminate\Database\Eloquent\Relations\HasMany
     */
    public function developers()
    {
        return $this->hasMany('App\Models\developer');
    }
    /**
     * Discussions 
     *
     * @return \illuminate\Database\Eloquent\Relations\HasMany
     */
    public function discussions()
    {
        return $this->hasMany('App\Models\discussion');
    }
}
