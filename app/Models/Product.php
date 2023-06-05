<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Paket;
use App\Models\User;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['id_category,id_user,id_paket,title,images,price,sold,stock,rating,location,description'];

    public function franchisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_category', 'id');
    }

    public function paket(): BelongsTo
    {
        return $this->belongsTo(Paket::class, 'id_paket', 'id');
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'id_product', 'id');
    }
}