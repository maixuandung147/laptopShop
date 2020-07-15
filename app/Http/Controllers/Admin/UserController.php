<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $list_users = User::paginate(2);
        return view('admin.user.list',compact('list_users'));
    }
    public function fetch_data(Request $request){
        if ($request->ajax()) {
            if ($request->get('sort') == 1) {
                $list_users = User::where('level',1)->paginate(2);
                return view('admin.user.pagin',compact('list_users')); 
            } 
            else if($request->get('sort') == 2) 
            {
                $list_users = User::where('level',0)->orWhere('level',null)->paginate(2);
                return view('admin.user.pagin',compact('list_users')); 
            } 
            else 
            {
                $query = $request->get('query');
                $list_users = User::where('fullname', 'LIKE', '%' . $query . '%')->orWhere('email', 'LIKE', '%' . $query . '%')->paginate(2);
                return view('admin.user.pagin',compact('list_users')); 
            }
            
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::find($id);   
        return response()->json(['data'=>$user],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::find($id);   
        return response()->json(['data'=>$user],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user= User::find($id);
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->level = $request->level;
        $user->save();
        return response()->json(['data'=>$user,'success'=>'Sửa thành công'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::find($id);
        $user->delete($id);
        return response()->json(['data'=>'removed','success'=>'Xóa thành công'],200);
    }
}
