<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $table = 'checklist';

    protected $primaryKey = 'checklist_id';

    protected $fillable = [
        'template_id', 'object_domain', 'object_id', 'description', 'is_completed', 
        'completed_at', 'updated_by', 'due', 'urgency', 
    ];

    // one to many
    public function item(){
    	return $this->hasMany('App\Item','checklist_id','checklist_id');
        // (Class relasi, foreign_key, primary_key)
    }

    public function template(){
    	return $this->belongsTo('App\Template','template_id','template_id');
    }

}
