<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Products;
use App\Model\Product_Image;
use App\Model\Promotions;
use Cart;
use Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Cart::content();    //content nó như kiểu danh sách ta dùng foreach 
        return view('user.cart.cart', compact('cart'));
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
       
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {   
          // dd(Cart::content());
        Cart::remove($rowId);
      
        return response()->json(['data'=>'removed'],200);
    }

    public function addCart(Request $request, $id)
    {
        $product = Products::find($id);
        $productImage = Product_Image::where('product_id', $id)->first();
        $promotionPrice = Promotions::where('product_id', $id)->where('end_date', '<', GETDATE())->take(1)->orderBy('created_at', 'ASC')->get();
        if($request->promotionPrice > 0)
        {
            $price = $request->promotionPrice;  //Đây là thỏa đk mã giảm giá
           
        }
        else{
            $price = $product->price;
        }
        
        $quantity = (int)$request->quantity;    //chuyền từ chuỗi sang int SỐ
        $qty = $product['quantity'] - $quantity;    // trừ số lượng trong DATA
        $quantityProducts = $product['quantity'];

        if($qty<0 || $qty=0)
        {
            return redirect()->back()->with('thongbao', 'Sản phẩm không đủ số lượng');
        }

        else
        {
            $qty = $quantity;   
        }
        //kiem tra so luong san pham khi add cart 
        $cartContent = Cart::content();
        
        foreach($cartContent as $value){
            
            if(($value->qty + $qty) > $quantityProducts){   // nếu số lượng giỏ hàng lơn hơn sản phẩm
                return redirect()->back()->with('thongbao', 'Sản phẩm không đủ số lượng nha');
            }
        }

        $cart = Cart::add(array('id'=>(int)$id, 'qty' => $qty, 'name'=> $product->name, 'price'=> $price, 'options' => ['img'=>$productImage->path] )); //thêm sản phẩm vào giỏ hàng

        return back()->with('message', 'Mua' .$product->name. 'thành công' );
    }

    public function getUpdateCart(Request $request)
    {
        
        Cart::update($request->rowId, $request->qty);

    }
}
