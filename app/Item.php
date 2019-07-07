<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $table = 'item';

    protected $primaryKey = 'item_id';

    protected $fillable = [
        'checklist_id', 'description', 'asignee_id', 'task_id', 'is_completed', 
        'completed_at', 'updated_by', 'due', 'urgency', 
    ];

    public function checklist(){
    	return $this->belongsTo('App\Checklist','checklist_id','checklist_id');
    }


}
