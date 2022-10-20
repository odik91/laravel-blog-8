<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;

class SubCategory extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
