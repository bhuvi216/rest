<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(){
        $todos = Todo::all();
        return view('ajax',['todos'=>$todos]);
    }
    public function add(Request $request){
        if($request->ajax()){
            $todo = new Todo;
            $todo->title = $request->title;
            $todo->save();

            return view('ajax',['todos'=>$last_todo]);
        }
    }
    public function update(Request $request, ){
        if($request->ajax()){
            $todo = Todo::find();
            $todo->title = $request->title;
            $todo->save();
            return "OK";
        }
    }
    public function delete(Request $request){
        if($request->ajax()){
            $todo = Todo::find();
            $todo->delete();
            return "OK";
        }
    }
    public function done(Request $request,$id){
        if($request->ajax()){
            $todo = Todo::find($id);
            $todo->status = 2;
            $todo->save();
            return "OK";
        }
    }


}
