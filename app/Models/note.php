<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class note extends Model
{
    use HasFactory;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notes';

    protected $fillable = [
    	'physician_id',
        'patient_id',
        'task_exer_data_id',
    	'title',
    	'text',
        'image',
        'active'
    ];
    /**
     * Physician Information
     *
     * @return \illuminate\Database\Eloquent\Relations\BelongsTo 
     */
    public function assignedBy()
    {
        return $this->belongsTo('App\Models\user');
    }
}
