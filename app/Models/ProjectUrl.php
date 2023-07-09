<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUrl extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'project_id',
        'channel_id'
    ];

    protected $table = 'project_urls';

    public function channel ()
    {
        return $this->hasOne(Channel::class, 'id', 'channel_id');
    }

}
