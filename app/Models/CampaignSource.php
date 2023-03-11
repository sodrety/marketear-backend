<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignSource extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function channel()
    {
        return $this->hasOne(Channel::class, 'id', 'channel_id');
    }
}
