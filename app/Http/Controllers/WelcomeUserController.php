<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

class WelcomeUserController extends Controller
{
    public function saludo($nombre)
    {
        return view('welcome2', ['nombre'=>$nombre]);
    }
    public function saludoNick($nombre, $nickname)
    {
        return view('welcome2', ['nombre'=>$nombre, 'nickname'=>$nickname]);
    }
}