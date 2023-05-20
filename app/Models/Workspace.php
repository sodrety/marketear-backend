<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = ['name', 'category_id', 'type', 'user_id'];

    protected $table = 'workspaces';

    public function category() {
        return $this->hasOne(WorkspaceCategory::class,'id','category_id');
    }

    public function urls() {
        return $this->hasMany(WorkspaceUrl::class);
    }

    public function sources () {
        return $this->hasMany(CampaignSource::class)->with('creator','intents');
    }

    public function channels ()
    {
        return $this->hasMany(WorkspaceUrl::class)->select('workspace_id','channel_id')->distinct();
    }
}
