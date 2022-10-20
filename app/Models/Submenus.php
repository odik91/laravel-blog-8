<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\Menu;

class Submenus extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];

    public function getMenu() {
        return $this->hasOne(Menu::class, 'id', 'menu_id');
    }
}
