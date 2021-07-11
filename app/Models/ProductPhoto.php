<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ProductPhoto extends Model
{
    use HasFactory;

    public function getImageUrlAttribute($value): string
    {
        if (App::environment('production')) {
            return $value;
        }

        return asset($value);
    }
}
