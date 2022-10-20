<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;

class Post extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];

    public function getCategory() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function getSubcategory() {
        return $this->hasOne(SubCategory::class, 'id', 'sub_category_id');
    }

    public function getUser() {
        return $this->hasOne(User::class, 'id', 'author');
    }
}
