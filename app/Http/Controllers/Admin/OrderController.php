<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Orders;
use Carbon\Carbon;
use App\Model\Order_Detail;
use App\Model\Promotions;
use Mail;
use App\Mail\MailNotify;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_orders = Orders::paginate(3);
        return view('admin.order.list',compact('list_orders'));
    }
    public function fetch_data(Request $request){
        if ($request->ajax()) {
            if ($request->get('sort') == 1) {
                $list_orders = Orders::where('deliver_status',0)->orWhere('deliver_status',null)->paginate(3);
                return view('admin.order.pagin',compact('list_orders')); 
            } 
            else if($request->get('sort') == 2) 
            {
                $list_orders = Orders::where('deliver_status',1)->paginate(3);
                return view('admin.order.pagin',compact('list_orders')); 
            } 
            else if($request->get('sort') == 3) 
            {
                $list_orders = Orders::where('deliver_status',2)->paginate(3);
                return view('admin.order.pagin',compact('list_orders')); 
            } 
            else 
            {
                $query = $request->get('query');
                $list_orders = Orders::where('email', 'LIKE', '%' . $query . '%')->paginate(3);
                return view('admin.order.pagin',compact('list_orders')); 
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
        $user = Orders::find($id);
        $list_detailrs = Order_Detail::where('order_id',$id)->get();
        $status = Orders::find($id);
        $promotions = Promotions::get();
        return view('admin.order.detailr', compact('user','list_detailrs','status','promotions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order=Orders::find($id);   
        return response()->json(['data'=>$order],200);
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
        $order= Orders::find($id);

        if ($request->deliver_status == 0 || $request->deliver_status == 1) {
            $order->delivery_date = NULL;
            $order->deliver_status = $request->deliver_status;
            $order->save();
        }
        else {
            $order->delivery_date = Carbon::now('Asia/Ho_Chi_Minh');
            $order->deliver_status = 2;
            $order->save();
        }
       
        if ($request->deliver_status == 1) {
            $order_details = Order_Detail::where('order_id',$id)->get(); // nhớ ngang đay là chạy GIT: php artisan serve
            Mail::to($order->email)->send(new MailNotify($order, $order_details));
        }
             
        return response()->json(['data'=>$order,'success'=>'Sửa thành công'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Orders::find($id);
        $order->delete();
        return response()->json(['data'=>'removed','success'=>'Xóa thành công'],200);
    }
}
