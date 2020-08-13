<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $userList = User::orderBy('name','asc')->get();
        if(isset($request->addUser)){
            return view('UserManagement.list')->with('susscessMessage', 'User registered successfully')->with('userList', $userList);
        }
        return view('UserManagement.list')->with('userList', $userList);
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = User::find($request->id);
            $name = $user->name;
            $user->name = $request->name;
            if($request->password != null && $request->password != ''){
                $user->password = bcrypt($request->password);
            }
            $user->is_admin = $request->is_admin;
            $user->surname = $request->surname;
            $user->profiles = $request->profiles;
            $user->email = $request->email;
            $user->save();

            $userList = User::orderBy('name','asc')->get();
            return view('UserManagement.list')->with('susscessMessage','username "' . $name . '" edit successfully')->with('userList', $userList);
        }else{

            if (!isset($request->id)) {
                return redirect()->route('home');
            }

            $user = User::find($request->id);
            return view('UserManagement.edit')->with('user', $user);
        }
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $name = $user->name;
        $user->delete();
        $userList = User::orderBy('name','asc')->get();
        return view('UserManagement.list')->with('susscessMessage', 'username "' . $name . '" deleted successfully')->with('userList', $userList);
    }

}
