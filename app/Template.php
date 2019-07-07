<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'template';
    protected $primaryKey = 'template_id';
    protected $fillable = [
        'name',
    ];

    public $timestamps = false;

    // one to many
    public function checklist(){
    	return $this->hasMany('App\Checklist','template_id','template_id');
        // (Class relasi, foreign_key, primary_key)
    }  

    // many through
    public function item()
    {
        return $this->hasManyThrough(
            'App\Item',
            'App\Checklist',
            'template_id',
            'checklist_id',
            'template_id',
            'checklist_id'
        );
    }    
}
