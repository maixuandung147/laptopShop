<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Promotions;
use App\Model\Products;
use App\Http\Requests\PromotionRequest;
use Carbon\Carbon;
use App\Model\Suppliers;
use Validator;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotions = Promotions::get();
        $dt = Carbon::today();
        foreach ($promotions as $item) {
            if ($item->end_date < $dt->toDateString() ) {
               $item->status = 0;
           }else{
                $item->status = 1;
           }
           $promotion = Promotions::find($item->id);
           $promotion->status = $item->status;
           $promotion->save();
        }
        $list_promotions = Promotions::paginate(1);
        $products = NULL;
        return view('admin.promotion.list',compact('list_promotions','products'));
    }
    public function ajax($idSup){
        $products = Products::where('supplier_id',$idSup)->get();
        return response()->json(['data'=>$products],200);
    }
    public function fetch_data(Request $request){
        if ($request->ajax()) {
            if ($request->get('sort') == 1) {
                $list_promotions = Promotions::where('status',1)->paginate(1);
                $products = NULL;
                return view('admin.promotion.pagin',compact('list_promotions','products')); 
            } 
            else if($request->get('sort') == 2) 
            {
                $list_promotions = Promotions::where('status',0)->orWhere('status',null)->paginate(1);
                $products = NULL;
                return view('admin.promotion.pagin',compact('list_promotions','products')); 
            } 
            else 
            {
                $query = $request->get('query');
                $list_promotions = Promotions::paginate(1);
                $products = Products::where('name', 'LIKE', '%' . $query . '%')->get();
                return view('admin.promotion.pagin',compact('list_promotions','products')); 
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
        $suppliers = Suppliers::get();
        return view('admin.promotion.add_promotion',compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PromotionRequest $request)
    {
        if ($request->end_date >= $request->start_date) {
            $dt = Carbon::today();
            $promotion = new Promotions();
            $promotion->user_id  = $request->user_id   ;
            $promotion->product_id  = $request->product_id   ;
            $products = Products::where('id',$request->product_id )->first();
            if ($products->price - 10 <$request->price ) {
                return redirect()->route('promotion.create')->with('thongbao','Giá khuyễn mãi lớn hơn giá gốc');
            } else {
                $promotion->price  = $request->price   ;
            }
            
            $promotion->start_date  = $request->start_date   ;
            $promotion->end_date  = $request->end_date   ;
           if ($request->end_date < $dt->toDateString() ) {
               $promotion->status = 0;
           }else{
                $promotion->status = 1;
           }
           $promotion->save();
            return redirect()->route('promotion.index')->with('thongbao','Thêm thành công'); 
        }else {
            return redirect()->route('promotion.create')->with('thongbao','End_date phải sau ngày Start_date'); 
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
    public function edit($id)
    {
        $promotion=Promotions::find($id);   
        $products = Products::get();
        return response()->json(['products'=>$products,'data'=>$promotion],200);
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
        $validator = Validator::make($request->all(),
            [
                'price' => 'required'
            ],
        [
            'price.required' => 'Please Enter Name Price',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>'true','mess'=>$validator->errors()],200);
        }
        $products = Products::where('id',$request->product_id )->first();
        if ($products->price - 10 >= $request->price) {
            if ($request->end_date >= $request->start_date ) {
            $dt = Carbon::today();
            $promotion= Promotions::find($id);
            if ($request->end_date < $dt->toDateString() ) {
                   $promotion->status = 0;
               }else{
                    $promotion->status = 1;
               }
            $promotion->update($request->all());
            $products = Products::get();
            return response()->json(['data'=>$promotion,'products'=>$products,'success'=>'Sửa thành công'],200);
            }else { 
                return response()->json(['errorss'=>'true','thongbao'=>'End_date phải sau ngày Start_date'],200);
            }
        } else {
            return response()->json(['errorsss'=>'true','thongbaoo'=>'Giá khuyễn mãi lớn hơn giá gốc'],200);
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
        $promotion=Promotions::find($id);
        $promotion->delete($id);
        return response()->json(['data'=>'removed','success'=>'Xóa thành công'],200);
    }
}
