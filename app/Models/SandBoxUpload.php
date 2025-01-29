<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SandBoxUpload extends Model
{
    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "pet_point",
        "uuid"
    ];
}
