<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = ['name', 'category_id', 'type', 'user_id'];

    protected $table = 'projects';

    public function category() {
        return $this->hasOne(ProjectCategory::class,'id','category_id');
    }

    public function urls() {
        return $this->hasMany(ProjectUrl::class);
    }

    public function sources () {
        return $this->hasMany(CampaignSource::class)->with('creator','intents');
    }

    public function channels ()
    {
        return $this->hasMany(ProjectUrl::class)->select('project_id','channel_id')->distinct();
    }
}
