<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Routing\Controller as BaseController;
use \Firebase\JWT\JWT;
class UserController extends Controller
{
        public function login()
        {
        $key = $this->key;
        
        if($_POST["email"] == null or $_POST["password"] == null or $_POST["email"] == "" or $_POST["password"] == "" )
        {
            return response()->json([
                    'message' => 'todos los campos deben rellenarse', 'code' => 400
                ], 400);
        }
        $users = User::where('email', $_POST['email'])->first();

        if (empty($users))
        {
            return response()->json([
                    'message' => 'el email introducido no es valido', 'code' =>401
                ], 400); // mail no autorizado 
        }
        if($_POST["password"] == decrypt($users->password))
        {
            $tokenParams = [
                'user' => $users,
                'random' => time()
            ];
            $token = JWT::encode($tokenParams, $key);
            return response()->json([
                'token'=> $token,
            ]);
        }
        else
        {
            return response()->json([
                    'message' => 'contraseña incorrecta', 'code' => 400
                ], 400);
        }

    }
    public function store(Request $request)
        {  
        
        $user = new User();
        $key = $this->key;

        if ($request->name==null or $request->email==null or $request->password==null or $request->passwordConfirm==null) 
        {
             return response()->json([
                    'message' => 'todos los campos deben de rellenarse', 'code' => 404
                ]);
        }   
        if (strlen($password = $_POST['password']) < 8)
        {
            return response()->json([
                    'message' => 'la contraseña debe tener al menos 8 caracteres','code'=>411
                ]);
        } 
        if(preg_match('/\s/',$request->name) == true){
            return response()->json([
                    'message' => 'el nombre no debe contener espacios', 'code'=>400
                ]);
        }
        $users = User::where('email', $request->email)->first();
        if (isset($_POST['email']) == true && empty($_POST['email']) == false)
        {
            $email = $_POST['email'];
            if(filter_var($email, FILTER_VALIDATE_EMAIL) == true)
            {
               // ok
            }else
            {
             return response()->json([
                    'message' => 'se debe introducir un correo válido'
                ]);
            }
        }

        if($_POST["passwordConfirm"] == $_POST["password"])
        {  
           
            $user->name = $request->name;
           

            $user->email = $request->email;
            $user->password = encrypt($request->password);

            $user->role_id = $request->role_id;

            $user->save();
            
            $tokenParams = [ 
            'user' => $user,
            ];
            $token = JWT::encode($tokenParams, $key);
            return response()->json([
               'token' => $token, 'message' => 'se ha registrado un usuario correctamente'
            ]);
        }
        else
        {
            return response()->json([
                    'message' => 'las contraseñas deben coincidir'
                ]);
        }
    }

}
