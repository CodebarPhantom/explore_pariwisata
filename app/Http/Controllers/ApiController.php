<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    public $status, $code;

    public function __construct()
    {
        $this->status = 'success';
        $this->code = 200;
    }
    
    public function setResponse($data)
    {
        return response(array_merge($data, ['status' => $this->status]), $this->code);
    }
}
