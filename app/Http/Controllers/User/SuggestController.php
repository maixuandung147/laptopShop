<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Suggets;
use App\Model\Categoies;
use App\Model\Products;

class SuggestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categoies::where('parent_id','!=',0)->get();
        return view('user.suggest.suggest_user',compact('categories'));
    }
    public function ajax($idCate){
        $products = Products::where('category_id',$idCate)->get();
        return response()->json(['data'=>$products],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $suggest = new Suggets();
        $suggest->email = $request->email ;
        $suggest->username = $request->fullname ;
        $suggest->telephone = $request->telephone ;
        $products = Products::where('id',$request->product_id)->first();
        $suggest->name_product = $products->name;
        $suggest->content = $request->content ;
        $suggest->status = 0 ;
        $suggest->save();
        return redirect()->route('create-suggest')->with('thongbao','Cám ơn bạn đã góp ý! Chúng tôi sẽ liên hệ bạn sớm nhất!'); 
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
        //
    }
}
