<?php

namespace App\Models;

use App\Models\CategoryEducation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    use HasFactory;

     public function category(): BelongsTo
    {
        return $this->belongsTo(CategoryEducation::class, 'id_category_education
', 'id');
    }
}
