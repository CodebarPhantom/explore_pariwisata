<?php


namespace App\Models;


use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class PlaceMenu extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'description', 'price'];

    protected $table = 'place_menus';

    protected $fillable = [
        'place_id', 'name', 'description', 'price', 'thumb'
    ];

    protected $hidden = [];

    protected $casts = [
        'place_id' => 'integer'
    ];
}
