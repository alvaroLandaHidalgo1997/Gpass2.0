<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \Firebase\JWT\JWT;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $key = 'asiioipkdnfsdSDasdadwdasaasd';


private static function decodeToken()
    {  
        $headers = getallheaders();
        if(isset($headers['Authorization'])) 
        {
            $token = $headers['Authorization'];
            $tokenDecoded = JWT::decode($token, self::TOKEN_KEY, array('HS256'));
            return $tokenDecoded;
        }
    }

protected function getUserFromToken()
    {
        $decodedToken = self::decodeToken();
        $user = self::findUser($decodedToken->email);
        return $user;
    }
    protected function findUser($email)
    {
        $user = User::where('email',$email)->first();       
        return $user;
        
    }

}
