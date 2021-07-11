<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'product_price',
        'cart_qty',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'cart_qty' => 'integer',
        'product_price' => 'decimal:0',
    ];

    protected $with = ['relatedProduct.relatedCategory', 'relatedProduct.relatedPhotos'];

    public function relatedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function relatedProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id')->withDefault();
    }
}
