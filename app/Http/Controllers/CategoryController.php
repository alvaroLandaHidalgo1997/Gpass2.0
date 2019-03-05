<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getUserFromToken()
    {
        $decodedToken = self::decodeToken();
        $user = self::findUser($decodedToken->email);
        return $user;
    }
    public function store(Request $request)
        {  
        $user = getUserFromToken();
        $category = new Category();
        $key = $this->key;
        $user_id = $user->id;

        if ($request->name==null ) 
        {
             return response()->json([
                    'message' => 'no se puede crear una categoria en blanco', 'code' => 404
                ]);
        }   
        if(preg_match('/\s/',$request->name) == true){
            return response()->json([
                    'message' => 'el nombre no debe contener espacios', 'code'=>400
                ]);
        }
        foreach ($category as $key => $value) 
        {
            if ($request->name == $value->name) 
            {
                return response()->json([
                    'message' => 'la categoria introducida ya está registrada'
                ]);
            }else{


				$category->name = $request->name;
                $category->user_id = $user_id;
            	$category->save();
            	$tokenParams = [ 
            'category' => $category,
            ];
            $token = JWT::encode($tokenParams, $key);
            return response()->json([
               'token' => $token, 'message' => 'se ha registrado una categoria correctamente'
            ]);
            }

        }
        
    }
}
