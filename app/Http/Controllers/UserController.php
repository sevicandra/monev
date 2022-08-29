<?php

namespace App\Http\Controllers;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{

    public function index(){
        if (! Gate::any(['sys_admin', 'admin_satker'], auth()->user()->id)) {
            abort(403);
        }

        return view('referensi.user.index',[
            'data'=>User::all(),
        ]);
    }

    public function create(){
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.user.create');
    }
    
    public function store(Request $request){
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $messages = [
            'NIP.unique' => 'NIP Sudah Didaftarkan',
            'email.unique' => 'Email Sudah Didaftarkan',
            'satker.numeric' => 'Kode Satker Harus Berupa Angka'
        ];
        
        $ValidatedData=$request->validate(
            [
                'nama'=>'required|max:255',
                'nip'=>'required|min:18|max:18|unique:users',
                'email'=>'required|email|unique:users',
                'satker'=>'required|min:6|max:6',
                'password'=>'required',
            ], $messages);

        $ValidatedData['password'] = Hash::make($ValidatedData['password']);
        user::create([
            'nama'=>$ValidatedData['nama'],
            'nip'=>$ValidatedData['nip'],
            'satker'=>$ValidatedData['satker'],
            'email'=>$ValidatedData['email'],
            'password'=>$ValidatedData['password'],
        ]);
        return redirect('/user');
    }

    public function edit(user $user)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.user.update',[
            'data'=> $user
        ]);
    }

    public function update(Request $request, user $user)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $messages = [
            'NIP.unique' => 'NIP Sudah Didaftarkan',
            'email.unique' => 'Email Sudah Didaftarkan',
            'satker.numeric' => 'Kode Satker Harus Berupa Angka'
        ];
        
        $ValidatedData=$request->validate([
            'nama'=>'required|max:255',
            'nip'=>'required|min:18|max:18',
            'email'=>'required|email',
            'satker'=>'required|min:6|max:6',
        ], $messages);

        $user->update([
            'nama'=>$ValidatedData['nama'],
            'nip'=>$ValidatedData['nip'],
            'satker'=>$ValidatedData['satker'],
            'email'=>$ValidatedData['email'],
        ]);
        return redirect('/user');
    }

    public function destroy(user $user)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $user->delete();
        return redirect('/user');
    }
}
