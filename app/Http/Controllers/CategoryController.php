<?php

namespace App\Http\Controllers;
use App\category;
use App\User;
use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
class CategoryController extends Controller
{
    public function index()
    {
      $key = $this->key;
      $headers = getallheaders();
      $token = $headers['Authorization'];
      $user = JWT::decode($token, $key, array('HS256'));
      $idUser = $user->user->id;
      $userCategories = Category::where('user_id', $idUser)->get();

      $categories = [];

        foreach ($userCategories as $category){
          $categories[] = $category;
        }
        return response()->json([
        'categorias'=> $categories,
        ]);
    }
    
    public function store(Request $request)
        {  
        $key = $this->key;
        $headers = getallheaders();
        $token = $headers['Authorization'];
        $user = JWT::decode($token, $key, array('HS256'));
        $category = new Category();
        $user_id = $user->user->id;
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
        $categories = Category::where('user_id', $user_id)->get();

      
        foreach ($categories as $category) 
        {
                  echo $category->name;
            if ($request->name == $category->name) 
            {
                return response()->json([
                    'message' => 'la categoria introducida ya esta registrada'
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
                'message' => 'se ha registrado una categoria correctamente'
            ]);
            }

        }

                $category->name = $request->name;
                $category->user_id = $user_id;
                $category->save();
                $tokenParams = [ 
            'category' => $category,
            ];
            $token = JWT::encode($tokenParams, $key);
            return response()->json([
                'message' => 'se ha registrado una categoria correctamente'
            ]);

        
    }
    public function destroy(Category $category)
    {
        $headers = getallheaders();
        $token = $headers['Authorization'];
        $key = $this->key;
        $userData = JWT::decode($token, $key, array('HS256'));    
        $id = $_POST['id'];
        $category = Category::find($id);
        if (is_null($category)) {
          return $this->error(400,'la categoria no existe');
          }else{
            $category_name = Category::where('id',$id)->first()->name;
            Category::destroy($id);
            return $this->success('categoria borrada', $category_name);
        }
    }
    public function updateCategory(Category $category)
    {
        $headers = getallheaders();
        $token = $headers['Authorization'];
        $key = $this->key;
        $userData = JWT::decode($token,$key, array('HS256'));
        $id_category = $_POST['id'];
        $newName = $_POST['name'];
        $category = Category::find($id_category);
        echo $category;

        if ($request->newname==null && $request->newEmail==null && $request->newPassword==null) 
        {
             return response()->json([
                    'message' => 'no has modificado la categoria', 'code' => 404
                ]);
        } 
        if(preg_match('/\s/',$request->newname) == true){
            return response()->json([
                    'message' => 'el nombre no debe contener espacios', 'code'=>200
                ]);
        }
        if(!empty($_POST['name'])){
          $category->name = $newName;
        
        $category->save();
        return response(200, "categoria modificada");
        }
    }
}
