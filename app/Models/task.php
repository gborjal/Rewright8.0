<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tasks_board';

    protected $fillable = [
    	'project_id',
        'user_id',
    	'title',
    	'text',
        'image',
        'exer_data',
        'frequency',
        'active'
    ];
    /**
     * User Information
     *
     * @return \illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedBy()
    {
        return $this->belongsTo('App\Models\user');
    }
    /**
     * Project Information
     *
     * @return \illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Models\project');
    }
    /**
     * User Information
     *
     * @return \illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedTo()
    {
        return $this->belongsTo('App\Models\assigned_to');
    }
    /**
     * notifs
     *
     * @return \illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany('App\Models\task_notif');
    }
    /**
     * exer_datas
     *
     * @return \illuminate\Database\Eloquent\Relations\HasMany
     */
    /*
    public function exer_datas()
    {
        return $this->hasMany('App\Models\task_exer_data');
    }
    */
}
