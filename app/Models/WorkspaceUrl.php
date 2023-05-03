<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkspaceUrl extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'workspace_id',
        'channel_id'
    ];

    protected $table = 'workspace_urls';

    public function channel ()
    {
        return $this->hasOne(Channel::class, 'id', 'channel_id');
    }

}
