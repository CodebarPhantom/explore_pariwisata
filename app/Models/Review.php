<?php

namespace App\Models;


use App\Commons\APICode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Models\ReviewImage;
use Carbon\Carbon;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'user_id', 'place_id', 'score', 'comment', 'status'
    ];

    protected $hidden = [];

    protected $casts = [
        'user_id' => 'integer',
        'place_id' => 'integer',
        'score' => 'float',
        'status' => 'integer',
        'created_at'=>'datetime'
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVE = 0;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->select('id','name','email');
    }

    public function place()
    {
        return $this->hasOne(Place::class, 'id', 'place_id');
    }
    
    public function images()
    {
        return $this->hasMany(ReviewImage::class);
    }


    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::parse($value)->translatedFormat('d M Y');
    }

    public function validateCreate($data)
    {
        $validateData = $data->all();
        $resp = (Object)[
            'code' => APICode::WRONG_PARAMS,
            'message' => ''
        ];
        $rules = [
            'place_id' => 'required',
            'score' => 'required',
            'comment' => 'required',
        ];
        $message_errors = [];
        $validator = Validator::make($validateData, $rules, $message_errors);
        if ($validator->fails()) {
            $resp->message = $validator->messages();
        } else {
            $resp->code = APICode::SUCCESS;
        }
        return $resp;
    }


}