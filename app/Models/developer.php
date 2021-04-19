<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class developer extends Model
{
    use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'developers';

    protected $fillable = [
    	'project_id',
    	'user_id',
    	'role',
    	'update_ts'
    ];
    /**
     * User's personal information
     *
     * @return \illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function user(){
    	 return $this->belongsTo('App\Models\User');
    }
    /**
     * Project information
     *
     * @return \illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function project(){
         return $this->belongsTo('App\Models\project');
    }
}
