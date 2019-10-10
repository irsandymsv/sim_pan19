<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Role;
use App\Divisi;

class UserController extends Controller
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

    public function index()
    {
    	$users = User::where("id", "<>", Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();
        return view('user.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $roles = Role::all();
        $divisi = Divisi::all();
        return view('user.create', [
            'roles' => $roles,
            'divisi' => $divisi
        ]);
    }

    public function store(Request $req)
    {
        $data = $req->all();

    	Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required'],
            'phone_number' => ['required', 'numeric'],
            'gender' => ['required'],
            // 'divisi_id' => ['required']
        ]);

        $newUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
            'phone_number' => $data['phone_number'],
            'gender' => $data['gender'],
            'avatar' => "user/default_user.png"
            // 'divisi_id' => $data['divisi_id']
        ]);

        return redirect()->route('admin.user.show', $newUser->id);
    }

    public function show($id_user = null)
    {
        if (is_null($id_user)) {
            $user = Auth::user();
            $link = "Profile";
        } else {
            $user = User::findOrFail($id_user);
            $link = "User";
        }
        
    	return view('user.detail', [
            'user' => $user,
            'link' => $link
        ]);
    }

    public function edit($id_user = null)
    {
        if (is_null($id_user)) {
            $user = Auth::user();
            $link = "Profile";
        } else {
            $user = User::find($id_user);
            $link = "User";
        }
        
        $roles = Role::all();
        $divisi = Divisi::all();
        return view('user.edit', [
            'user' => $user,
            'roles' => $roles,
            'divisi' => $divisi,
            'link' => $link
        ]);
    }

    public function update(Request $req, $id_user)
    {
        $user = User::find($id_user);
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:100',
            'phone_number' => 'required|numeric',
            'gender' => 'required',
            'role_id' => 'sometimes|required',
            // 'divisi_id' => 'sometimes|required',
            'email' => [
                'required','string','email','max:255',
                Rule::unique('users')->ignore($user)
            ],
        ])->validate();

        $user->name = $req->name;
        $user->email = $req->email;
        $user->phone_number = $req->phone_number;
        $user->gender = $req->gender;
        $user->alamat = $req->alamat;

        if ($req->hasFile('avatar')) {
            Storage::delete("$user->avatar");
            $fileName = "avatar_".$user->id.'.'.$req->file('avatar')->getClientOriginalExtension();
            $path = $req->file('avatar')->storeAs('user', $fileName);

            $user->avatar = $path;
        }

        if ($req->is('admin/*')) {
            $user->role_id = $req->role_id;
            // $user->divisi_id = $req->divisi_id;
            $user->save();

            return redirect()->route('admin.user.show', $user->id)->with("updateProfile", "Profil Berhasil diubah");
        }
        else{
            $user->save();
            return redirect()->route('profile')->with("updateProfile", "Profil Berhasil diubah");
        }

        

    }

    public function destroy($id_user)
    {
        
    	if (Auth::id() == $id_user) {
            return back()->with("selfDelete_error", "Tidak dapat menghapus akun sendiri");
        } else {
            $user = User::find($id_user);
            if ($user->avatar != "user/default_user.png") {
                Storage::delete("$user->avatar");
            }

            $user->delete();
            return redirect()->route('admin.user.index');
        }
        
    }

    public function resetPassword($id_user = null)
    {
        if (is_null($id_user)) {
            $user = Auth::user();
            $link = "Profile";
        } else {
            $user = User::findOrFail($id_user);
            $link = "user";
        }
        
        return  view('user.resetPassword', [
            'user' => $user,
            'link' => $link
        ]);
    }

    public function updatePassword(Request $req, $id_user)
    {
        $validateData = $req->validate([
            'password' => 'required|confirmed|min:8'
        ]);

        $user = User::findOrFail($id_user);
        $user->password = Hash::make($req->password);
        $user->save();

        if ($req->is('admin/*')) {
            return redirect()->route('admin.user.show', $id_user)->with('resetPassword', "Password berhasil diubah");
        } else {
            return redirect()->route('profile')->with('resetPassword', "Password berhasil diubah");
        }
    }

    // public function deleteUSer()
    // {
    //     Storage::deleteDirectory('user');
    //     echo "deleted";
    // }
}
