<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database;
use Illuminate\Support\Facades\DB;

class staffinsertcontroller extends Controller
{
    public function insert_form(){
        return view('insert_form');
    }
    public function insert(Request $request){
        $name = $request->input('staff_name');
        $name = $request->input('staff_department');
        $name = $request->input('staff_mail id');
        DB::insert('insert into abcd(id, name, department, mailid) values (?, ?)', [1, 'Dayle','testing', 'dayle@gamil.com']);
        return "record inserted successfully";
    }
}

