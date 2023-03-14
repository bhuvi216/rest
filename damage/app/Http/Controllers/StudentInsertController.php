<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class StudentInsertController extends Controller
{
   public function insert_form(){
        return view('insert_form');
   }
   public function insert(Request $request){
        $name = $request->input('student_name');
        DB::insert('insert into student ( name) values ( ?)',[$name]);
        return "successfully completed";
   }


}
