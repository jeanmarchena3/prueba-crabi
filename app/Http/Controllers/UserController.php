<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class UserController extends Controller
{
    public function create(UserRequest $request){
        try {
            $isInBlacklist = $this->callCheckBlackList($request->firstname, $request->lastname, $request->email);

            if ($isInBlacklist) {
                return response()->json(["meta"=>["success"=>false, "errors"=>"User in blacklist"]], 400);
            }
            
            $user = new UserResource(User::create([
                "firstname" => $request->firstname,
                "lastname" => $request->lastname,
                "email" => $request->email,
                "password" => $request->password
            ]));
        
            return response()->json(["meta"=>["success"=>true, "errors"=> null], "data"=>$user], 201);
        } catch (Exception $e) {
            return response()->json(["meta"=>["success"=>false, "errors"=>[$e]]], 400);
        }
    }

    public function show($id){
        try {
            $user = new UserResource(User::findOrFail($id));
            return response()->json(["meta"=>["success"=>true, "errors"=> null], "data"=>$user],201);

        } catch (ModelNotFoundException $e) {
            return response()->json(["meta"=>["success"=>false, "errors"=> "User not found"]],404);
        }
    }
}
