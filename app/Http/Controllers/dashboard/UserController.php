<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $users)
    {
        $q = $request->input('q');
        
        $active = 'Users';

        $users = $users->when($q, function($query) use ($q) {
            return $query->where('name', 'like', '%' .$q. '%')
                         ->orwhere('email', 'like', '%' .$q. '%');
        })

        ->paginate(10);

        $request = $request->all();
        return view('dashboard/user/list', [
            'users' => $users,
            'request' => $request,
            'active' => $active
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = 'User';
        $users = User::all();
        return view('dashboard/user/form', [
            'users' => $users,
            'active' => $active,
            'button' =>'Create',
            'url'    =>'dashboard.user.store'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' =>'required',
            'email' =>'required',
            'alamat' =>'required',
            'password' => 'required|min:8', // Tambahkan validasi untuk password baru
            'password_confirmation' => 'same:password', // Pastikan konfirmasi password sama dengan password
        ]);
    
        if ($validator->fails()) {
            return redirect()
                ->route('dashboard.user.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            //Simpan data User
            $user = new User(); //Tambahkan ini untuk membuat objek User
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->alamat = $request->input('alamat');

        // Menginput password jika ada input baru
        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Menyimpan
        $user->save();
        
        $messageKey = 'user.store';
        return redirect()
            ->route('dashboard.user')
            ->with('message', __('message.user.store', ['name' => $request->input('name')]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $active = 'Users';
        return view('dashboard/user/form', [
            'active' => $active,
            'user'   => $user,
            'button' =>'Update',        
            'url'    =>'dashboard.user.update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
{
    // Validasi input
    $validator = Validator::make($request->all(), [
        'name' =>'required',
        'email' =>'required',
        'alamat' =>'required',
        'password' => 'nullable|min:8', // Tambahkan validasi untuk password baru
        'password_confirmation' => 'same:password', // Pastikan konfirmasi password sama dengan password
    ]);

    // Jika validasi gagal
    if($validator->fails()){
        return redirect()->back()
                ->withErrors($validator)
                ->withInput();
    } else {
        // Mengupdate atribut user
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->alamat = $request->input('alamat');

        // Mengupdate password jika ada input baru
        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Menyimpan perubahan
        $user->save();
        
        $messageKey = 'user.update';
        return redirect()
            ->route('dashboard.user')
            ->with('message', __('message.user.update', ['name' => $request->input('name')]));

    }
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $name = $user->name;
        $user->delete();
        $messageKey = 'user.delete';
        return redirect()
                ->route('dashboard.user')
                ->with('message', __('message.user.delete', ['name' => $name]));
        //
    }
}
