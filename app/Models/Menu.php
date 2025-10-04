<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $primaryKey = 'id_menu';
    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion', 'icono', 'url', 'visible'];
}
