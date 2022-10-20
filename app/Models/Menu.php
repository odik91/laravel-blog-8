<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Models\Submenus;

class Menu extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];

    public function getSubMenu() {
        return $this->hasMany(Submenus::class);
    }
}
