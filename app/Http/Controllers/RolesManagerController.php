<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RolesManagerController extends Controller
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

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|min:5|max:255',
        ]);

        $roleData = new Role();
        $roleData->rol_name = $request->input('name');
        $roleData->rol_description = $request->input('description');
        $roleData->save();

    }

    public function destroy($id) {
        Role::where('rol_id', $id)->delete();
    }

    public function restore($id) {
        Role::where('rol_id', $id)->restore();
    }

    public function update(Request $request, $id) {
        $request->validate([
            'editName' => 'required|string|min:5|max:255',
        ]);

        $roleData = Role::find($id);

        $roleData->rol_name = $request->input('editName');
        $roleData->rol_description = $request->input('description');
        $roleData->save();
    }

}
