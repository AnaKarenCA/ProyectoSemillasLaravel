<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuAsignado extends Model
{
    protected $table = 'menuasignado';
    protected $primaryKey = 'id_menuAsignado';
    public $timestamps = false;

    protected $fillable = [
        'id_rol',
        'id_menu',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }
}
