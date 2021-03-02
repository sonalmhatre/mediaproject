<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
	protected $table = 'videos';
    protected $fillable = [
    		'name','video_file','provider_id'
        ];
}
