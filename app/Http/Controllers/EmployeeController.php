<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function employee()
    {
        $employees = User::all();
        return view('admin.employee',compact('employees'));
    }

    public function employeeAdd(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required'],
            'photo' => ['required'],
        ]);
        if($request->photo)
        {
            $photo = uniqid()."_".$request->photo->getClientOriginalName();
            $request->photo->storeAs('images',$photo);
        }else{
            $photo = 'default.jpg';
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->user_photo = $photo;
        $user->save();

        return back();
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function employeeDetail()
    {
        $employees = User::all();
        return view('admin.employee_detail',compact('employees'));
    }

    public function empSearch(Request $request)
    {
        $emp = User::find($request->emp_id);
        return $emp;
    }

    public function roleChange(Request $request)
    {
        $user = User::find($request->user_id);
        $user->role = $request->role;
        $user->save();
        return back();
    }

    public function empDelete($id)
    {
        $emp = User::find($id);
        $emp->delete();
        return back();
    }

    public function cashierProfile()
    {
        return view('profile');
    }
}
