<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalApis extends Model
{
    use HasFactory;

    public function endpoints()
    {
        return $this->hasMany(ExternalApiEndpoints::class, 'external_api_id');
    }
}
