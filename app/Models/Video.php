<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    
    protected $fillable = [
    	'name','video_file','provider_id','thumbnail'
    ];
    public function provider()
    {
        return $this->belongsTo('App\Models\Provider', 'provider_id');
    }
}
