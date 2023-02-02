<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use App\Models\User;
class UserController extends Controller
{
    //

    public function index()
    {
       
    if(request()->ajax()) {
    return datatables()->of(User::select('*'))
    ->addColumn('action', 'user.action')
    ->rawColumns(['action'])
    ->addIndexColumn(
    )
    ->make(true);
    }
    return view('user.index');
    }
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        
    return view('user.create');
    }
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        
    $request->validate([
    'first_name' => 'required',
    'last_name' => 'required',
    'phone' => 'required',
    'email' => 'required',
    'password' => 'required',
    ]);
    $user = new user;
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->phone_number = $request->phone;
    $user->email = $request->email;
    $user->password = $request->password;
    
    $user->save();
    return redirect()->route('users.index')
    ->with('success','User has been created successfully.');
    }
    /**
    * Display the specified resource.
    *
    * @param  \App\user  $user
    * @return \Illuminate\Http\Response
    */
    public function show(User $user)
    {
    return view('users.show',compact('user'));
    } 
    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\User  $user
    * @return \Illuminate\Http\Response
    */
    public function edit(User $user)
    {
    return view('user.edit',compact('user'));
    }
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\user  $user
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        
    $request->validate([
    'first_name' => 'required',
    'last_name' => 'required',
    'phone_number' => 'required',
    'email' => 'required',
    'password' => 'required',


    
    ]);
    $user = user::find($id);
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->phone_number= $request->phone_number;
    $user->email = $request->email;
    $user->password = $request->password;
   
    $user->save();
    return redirect()->route('users.index')
    ->with('success','User Has Been updated successfully');
    }
    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\User  $company
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request)
    {
    $com = User::where('id',$request->id)->delete();
    return Response()->json($com);
    }
    }
    
