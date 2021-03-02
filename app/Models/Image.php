<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
    	'name','image_file','provider_id'
    ];
    public function provider()
    {
        return $this->belongsTo('App\Models\Provider', 'provider_id');
    }
}
