<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_info extends Model
{
    use HasFactory;
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_info';

	protected $fillable = [
		'user_id',
		'profile',
		'banner',
		'first_name',
		'middle_name',
		'last_name',
		'suffix_name',
		'sex',
		'perm_address',
		'tempo_address',
		'office_address',
        //github_id
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
}
