<?php

namespace App\Models;

use App\Commons\APICode;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'phone_number', 'facebook', 'instagram', 'status', 'is_admin'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'is_admin' => 'integer',
        'status' => 'integer',
        'survey'=> 'array'
    ];

    const STATUS_DEACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const USER_DEFAULT = 0;
    const USER_ADMIN = 1;

    public function isAdmin()
    {
        return $this->is_admin === self::USER_ADMIN;
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function validateLogin($data)
    {
        $validateData = $data->all();
        $resp = (Object)[
            'code' => APICode::WRONG_PARAMS,
            'message' => ''
        ];
        $rules = [
            'email' => 'required',
            'password' => 'required'
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

    public function validateRegister($data)
    {
        $validateData = $data->all();
        $resp = (Object)[
            'code' => APICode::WRONG_PARAMS,
            'message' => ''
        ];
        $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];
        $message_errors = [
            'required' => ':attribute wajib di isi,',
            'confirmed'=>':attribute harus sama dengan confirm :attribute,',
            'min'=>':attribute minimal 8 karakter',
            'unique'=>':attribute sudah terdaftar'];
        $validator = Validator::make($validateData, $rules, $message_errors);
        if ($validator->fails()) {
            $resp->message = $validator->messages();
        } else {
            $resp->code = APICode::SUCCESS;
        }
        return $resp;
    }

    public function create($data)
    {
        $this->name = $data->name;
        $this->email = $data->email;
        $this->password = Hash::make($data->password);
        $this->phone_number = $data->phone_number;
        $this->gender = $data->gender;
        $this->survey = json_encode( array(
            'tourism_name'=>$data->survey_tourism,
            'location'=>$data->survey_location,
            'reason'=>$data->survey_reason
        ));


        $this->save();
        return $this;
    }

    public static function getUserDetail($user_id)
    {
        $user_detail = self::find($user_id);

        return $user_detail;
    }

    public function updatePassword($data)
    {
        $user = self::find($data->user_id);
        $user->password = bcrypt($data->password_new);
        $user->save();
        return $user;
    }

    /**
     * Roll API Key
     */
    public function generateApiToken()
    {
        do {
            $this->api_token = Str::random(60);
        } while ($this->where('api_token', $this->api_token)->exists());
        $this->save();
    }

    public function generateApiToken1()
    {
        $this->api_token = Str::random(60);
        $this->save();

        return $this->api_token;
    }


}