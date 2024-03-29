<?php

namespace App\Http\Controllers;
use App\Models\user;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(){
        if (! Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }
        if (! Gate::allows('sys_admin')) {
            return view('referensi.user.index',[
                'data'=>User::pegawaisatker()->search()->paginate(15)->withQueryString(),
                'notifikasi'=>Notification::Notif()
            ]);
        }
        return view('referensi.user.index',[
            'data'=>User::search()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function create(){
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.user.create',[
            'notifikasi'=>Notification::Notif()
        ]);
    }
    
    public function store(Request $request){
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        $messages = [
            'NIP.unique' => 'NIP Sudah Didaftarkan',
            'satker.numeric' => 'Kode Satker Harus Berupa Angka'
        ];
        
        $ValidatedData=$request->validate(
            [
                'nama'=>'required|max:255',
                'nip'=>'required|min_digits:18|max_digits:18|unique:users',
                'satker'=>'required|min_digits:6|max_digits:6',
                'password'=>'required',
            ], $messages);

        $ValidatedData['password'] = Hash::make($ValidatedData['password']);
        user::create([
            'nama'=>$ValidatedData['nama'],
            'nip'=>$ValidatedData['nip'],
            'satker'=>$ValidatedData['satker'],
            'password'=>$ValidatedData['password'],
        ]);
        return redirect('/user');
    }

    public function edit(user $user)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.user.update',[
            'data'=> $user,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function update(Request $request, user $user)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        $messages = [
            'NIP.unique' => 'NIP Sudah Didaftarkan',
            'satker.numeric' => 'Kode Satker Harus Berupa Angka'
        ];
        
        $ValidatedData=$request->validate([
            'nama'=>'required|max:255',
            'nip'=>'required|min_digits:18|max_digits:18:unique:users,nip,'.$user->id,
            'satker'=>'required|min_digits:6|max_digits:6',
        ], $messages);

        $user->update([
            'nama'=>$ValidatedData['nama'],
            'nip'=>$ValidatedData['nip'],
            'satker'=>$ValidatedData['satker'],
        ]);
        return redirect('/user');
    }

    public function destroy(user $user)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        $user->delete();
        return redirect('/user');
    }
}
