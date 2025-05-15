<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = User::all();
        return view('profile.index', compact("profiles"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|unique:Users,email',
            'password' => 'required|confirmed',
        ]);
        $profiles = new User;
        $profiles->name = $request->name;
        $profiles->email = $request->email;
        $profiles->password = bcrypt($request->password);
        $profiles->save();

        if($profiles)
        {
            return redirect('/profile')->with('message', 'User Created Successfully!');
        }else{
            return redirect()->back()->with('error', 'Something went wrong!, Please try again.');
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
        $profiles = User::find($id);
        return view('profile.show', compact("profiles"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profiles = User::find($id);
        return view('profile.edit', compact("profiles"));
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
       
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);
         $profile = User::find($request->id);

        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->save();

        if ($request->password != '') {
            $profile->password = bcrypt($request->password);
            $profile->save();
        }

        if($profile)
        {
            return redirect('/profile')->with('message', 'User Updated Successfully');
        }else{
             return back()->with('error', 'Something went wrong!, Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profiles = User::findOrFail($id);
        $profiles->delete();
        if($profiles)
        {
            return redirect('/profile')->with('message', 'User Deleted Successfully');
        }
    }
}
