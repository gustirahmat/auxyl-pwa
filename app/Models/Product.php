<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'product_id';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'supplier_id',
        'price_supplier',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'product_stock' => 'integer',
        'price_selling' => 'decimal:0',
        'price_supplier' => 'decimal:0',
    ];

    public function relatedCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function relatedSupplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }

    public function relatedPhotos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class, 'product_id', 'product_id');
    }

    public function relatedCart(): HasOne
    {
        return $this->hasOne(Cart::class, 'product_id', 'product_id')->where('user_id', '=', Auth::id());
    }
}
