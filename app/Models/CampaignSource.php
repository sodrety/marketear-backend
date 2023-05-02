<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CampaignSource extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "campaign_sources";

    public function channel()
    {
        return $this->hasOne(Channel::class, 'id', 'channel_id');
    }

    public function historys()
    {
        return $this->hasMany(CampaignSourceHistory::class);
    }
}
