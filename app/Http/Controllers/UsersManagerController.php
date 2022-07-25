<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersManagerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        if(Auth::user()->usr_rol_id == 1) {
            return view('admin_dashboard');
        } else {
            return view('welcome');
        }
    }

    public function roles() {
        $role = Role::withTrashed()->get();
        return response()->json(['roles' => $role]);
    }

    public function users() {
        $user = User::with('role')->withTrashed()->get();
        return response()->json(['users' => $user]);
    }

    public function store(Request $request) {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required',
            'password' => 'required|string|required_with:confirm_password|same:confirm_password|min:8',
            'confirm_password' => 'required|min:8',
        ]);

        $userData = new User();
        $userData->usr_rol_id = $request->input('role');
        $userData->usr_name = $request->input('name');
        $userData->email = $request->input('email');
        $userData->password = Hash::make($request->input('password'));
        $userData->save();

        
        return response()->json(['message' => 'Data is successfully retrieve']);
    }


    public function destroy($id) {
        User::where('id', $id)->delete();
        return response()->json(['message' => 'Has been Deleted']);
    }

    public function restore($id) {
        User::withTrashed()->find($id)->restore();
        return response()->json(['message' => 'Has been Restored']);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'editName' => 'required|string|max:255',
            'editEmail' => 'required|string|email|max:255',
            'editRole' => 'required',
        ]);

        $userData = User::find($id);

        $userData->usr_rol_id = $request->input('editRole');
        $userData->usr_name = $request->input('editName');
        $userData->email = $request->input('editEmail');

        if($request->input('editPassword')) {
            $request->validate([
                'editPassword' => 'required|string|required_with:editConfirm_password|same:editConfirm_password|min:8',
                'editConfirm_password' => 'required|min:8',
            ]);
            $userData->password = Hash::make($request->input('editPassword'));
        }
        $userData->save();

        return response()->json(['message' => 'Has been Updated']);
    }

}
