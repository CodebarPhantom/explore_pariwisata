<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PlaceMenuTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'description', 'price'];
}
