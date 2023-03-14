<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Database;
use Illuminate\Support\Facades\DB;

class Employeemanagementcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $employees = DB::table('employees')
        ->leftJoin('city', 'employees.city_id', '=', 'city.id')
        ->leftJoin('department', 'employees.department_id', '=', 'department.id')

        ->select('employees.*', 'department.name as department_name', 'department.id as department_id', 'division.name as division_name', 'division.id as division_id')
        ->paginate(5);

        return view('employees-mgmt/index', ['employees' => $employees]);
    }
    public function create()
    {
        // $cities = City::all();
        // $states = State::all();

        $departments = Department::all();

        return view('employees-mgmt/create', ['departments' => $departments,]);
    }
    public function store(Request $request)
    {
        $this->validateInput($request);
        // Upload image
        $path = $request->file('picture')->store('avatars');
        $keys = ['lastname', 'firstname', 'middlename', 'address', 'city_id', 'state_id', 'country_id', 'zip',
        'age', 'birthdate', 'date_hired', 'department_id', 'department_id', 'division_id'];
        $input = $this->createQueryInput($keys, $request);
        $input['picture'] = $path;
        // Not implement yet
        // $input['company_id'] = 0;
        Employee::create($input);

        return redirect()->intended('/employee-management');
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);


        $departments = Department::all();

        return view('Employees-mgmt/edit', ['Employee' => $employee,'departments' => $departments,]);
    }
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $this->validateInput($request);
        // Upload image
        $keys = ['lastname', 'firstname', 'middlename', 'address',
        'age', 'birthdate', 'date_hired', 'department_id', 'department_id', 'division_id'];
        $input = $this->createQueryInput($keys, $request);
        if ($request->file('picture')) {
            $path = $request->file('picture')->store('avatars');
            $input['picture'] = $path;
        }

        Employee::where('id', $id)
            ->update($input);

        return redirect()->intended('/employeemanagement');
    }
    public function destroy($id)
    {
        Employee::where('id', $id)->delete();
        return redirect()->intended('/employeemanagement');
    }
    public function search(Request $request) {
        $constraints = [
            'firstname' => $request['firstname'],
            'department.name' => $request['department_name']
            ];
        $employees = $this->doSearchingQuery($constraints);
        $constraints['department_name'] = $request['department_name'];
        return view('employees-mgmt/index', ['employees' => $employees, 'searchingVals' => $constraints]);
    }
    private function doSearchingQuery($constraints) {
        $query = DB::table('employees')

        ->leftJoin('department', 'employees.department_id', '=', 'department.id')

        ->select('employees.firstname as employee_name', 'employees.*','department.name as department_name', 'department.id as department_id', 'division.name as division_name', 'division.id as division_id');
        $fields = array_keys($constraints);
        $index = 0;
        foreach ($constraints as $constraint) {
            if ($constraint != null) {
                $query = $query->where($fields[$index], 'like', '%'.$constraint.'%');
            }

            $index++;
        }
        return $query->paginate(5);
    }
    public function load($name) {
        $path = storage_path().'/app/avatars/'.$name;
       if (file_exists($path)) {

       }
   }

   private function validateInput($request) {
       $this->validate($request, [
           'lastname' => 'required|max:60',
           'firstname' => 'required|max:60',
           'middlename' => 'required|max:60',
           'address' => 'required|max:120',


           'age' => 'required',
           'birthdate' => 'required',
           'date_hired' => 'required',
           'department_id' => 'required',

       ]);
   }

   private function createQueryInput($keys, $request) {
       $queryInput = [];
       for($i = 0; $i < sizeof($keys); $i++) {
           $key = $keys[$i];
           $queryInput[$key] = $request[$key];
       }

       return $queryInput;
   }
}
