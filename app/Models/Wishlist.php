<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';

    protected $fillable = [
        'user_id', 'tourism_info_id','slug','name'
    ];

    protected $hidden = [];

    protected $casts = [
        'user_id' => 'integer',
        'tourism_info_id' => 'integer'
    ];


    public function scopeMyWishlist($query)
    {
        $query->where('user_id',auth()->user()->id);
    }

    /*public function scopeTourism($query)
    {
        $query->where('tourism_info_id',$this->tourism_info_id);

    }*/
}