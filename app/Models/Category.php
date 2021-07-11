<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    use HasFactory;

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'category_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_name',
        'category_icon',
        'category_gender',
    ];

    public function getCategoryGenderAttribute($value): string
    {
        if ($value == 0) {
            return 'Wanita';
        } elseif ($value == 1) {
            return 'Pria';
        }

        return 'Unisex';
    }

    public function getCategoryIconAttribute($value): string
    {
        if (App::environment('production')) {
            return $value;
        }

        return asset($value);
    }

    public function relatedProducts(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }
}
