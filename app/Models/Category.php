<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];

    public function subcategory() {
        return $this->belongsTo(SubCategory::class);
    }

    public function getCategory() {
        return $this->belongsTo(Post::class);
    }
}
