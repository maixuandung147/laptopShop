<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Suggets;

class SuggestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_suggests = Suggets::paginate(1);
        return view('admin.suggest.list',compact('list_suggests'));
    }
    public function fetch_data(Request $request){
        if ($request->ajax()) {
            if ($request->get('sort') == 1) {
                $list_suggests = Suggets::where('status',1)->paginate(1);
                return view('admin.suggest.pagin',compact('list_suggests')); 
            } 
            else if($request->get('sort') == 2) 
            {
                $list_suggests = Suggets::where('status',0)->orWhere('status',null)->paginate(1);
                return view('admin.suggest.pagin',compact('list_suggests')); 
            } 
            else 
            {
                $query = $request->get('query');
                $list_suggests = Suggets::where('email', 'LIKE', '%' . $query . '%')->paginate(1);
                return view('admin.suggest.pagin',compact('list_suggests')); 
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
        $suggest=Suggets::find($id); 
        $suggest->status = 1;
        $suggest->save();  
        return response()->json(['data'=>$suggest],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $suggest=Suggets::find($id);
        $suggest->delete($id);
        return response()->json(['data'=>'removed','success'=>'Xóa thành công'],200);
    }
}
