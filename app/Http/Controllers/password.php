<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Password;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
class passwordController extends Controller
{
	const SECRETKEY = "CONTRASEÑASECRETA";
        public function index()
        {  
        
        $password = new Password();
        $key = $this->key;
        $user = parent::getUserFromToken();
        $user_id = $user->id; 
        $passwords = Password::where('user_id', $user_id)->get();
        $decodedPasswords = [];
        $categories = Password::where('user_id', $user_id)->get();

        foreach ($passwords as $password) 
        {   
            array_push($decodedPasswords, self::decodePassword($password->password));    
        }

        $passwordTitles = [];
        $passwordIDs = [];
        $passwordValues = [];
        $categoryNames = [];

        foreach ($passwords as $password) 
        {   
            array_push($passwordTitles, $password->title);
            array_push($passwordIDs, $password->id);
            if($password->category_id == null )
            {
                array_push($categoryNames, null);
            }
            else{
                array_push($categoryNames, $password->category->name);
            }
            
        }	    
        return response()->json ([
                'titles' => $passwordTitles,
                'IDs' => $passwordIDs,
                'passwordValues' => $decodedPasswords,
                'categories'=> $categoryNames
            ],200);
        
        
    }
        private function decodePassword($hash)
    {
        $password = openssl_decrypt($hash, "AES-128-ECB", self::SECRETKEY);
      
        private function encodePassword($password)
    {
        $hash = $hash = openssl_encrypt($password, "EPA-456-POF", self::SECRETKEY);
        return $hash;

    }
}
