<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validate;
use Auth;
use App\User;
use App\Model\Orders;
use App\Model\Order_Detail;
use Illuminate\Support\Facades\File;
use App\Model\Products;
use App\Model\Suggets;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.user.register');

    }

    public function getLogin()
    {
        return view('user.user.login');
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
        $this->validate($request, 
            [
                'fullname' => 'required|max:255',
                'email' => 'required|email|unique:users,email',
                'username' => 'required|max:16|unique:users,username',
                'password' => 'required|min:6|max:25',
                'confirm_password' => 'required|same:password',
                'telephone' => 'required|unique:users,telephone'
            ],
            [
                'email.required' => 'Vui lòng nhập email.',
                'email.email' => 'Email không hợp lệ.',
                'email.unique' => 'Email đã tồn tại.',
                'username.unique' => 'Tên tài khoản đã tồn tại.',
                'password.required' => 'Vui lòng nhập mật khẩu.',
                'confirm_password.same' => 'Mật khẩu không khớp.',
                'password.min' => 'Mật khẩu không được dưới 6 ký tự.',
                'password.max' => 'Mật khẩu tối đa không quá 25 ký tự.',
                'telephone.unique' => 'Số điện thoại đã tồn tại.',
                'telephone.max' => 'Số điện thoại không quá 10 chữ số.'
            ]
        );

        $user = new User();
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->telephone = $request->telephone;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $user->image = rand(0,100000).'.'.$file->getClientOriginalName();
            $file->move( public_path() . '/avatar/', $user->image); 
        }
        else {
            $user->image = 'avatar.jpg';
        }
        $user->save();

        return redirect()->route('home')->with('success','Đã đăng ký tài khoản thành công');
    }

    public function setLogin(Request $request)
    {
        $this->validate($request,
            [
                'email' => 'required|email',
                'password' => 'required|min:6|max:25'
            ],
            [
                'email.required' => 'Vui lòng nhập email.',
                'email.email' => 'Email không hợp lệ.',
                'password.required' => 'Vui lòng nhập mật khẩu.',
                'password.min' => 'Mật khẩu không được dưới 6 ký tự.',
                'password.max' => 'Mật khẩu tối đa không quá 25 ký tự.',
            ]
        );

        $credentials = array(
            'email'=>$request->email, 
            'password'=>$request->password
        );

        if(Auth::attempt($credentials)){
        
            if(Auth::user()->level != 0){
                return redirect()->route('home.index');
            }

            return redirect()->home()->with(['flag'=>'success', 'message'=>'Đăng nhập thành công']);
        }

        else 
            return redirect()->back()->with(['flag'=>'danger', 'message'=>'Không thể đăng nhập. Vui lòng kiểm tra lại tài khoản hoặc mật khẩu!']);
    }

    public function logOut()
    {
        Auth::logout();
        return redirect()->route('home');
    }
    public function order_user($id){
        $user = User::find($id);
        $list_orders = Orders::where('user_id',$id)->get();
        return view('user.user.order_user', compact('user','list_orders'));
    }
    public function product_user($id){
        $user = User::find($id);
        $list_orders = Orders::where('user_id',$id)->get();
        $products = Products::with('product_images')->get();
        $detali = null;
        foreach ($list_orders as $value) {
            $detali[] =Order_Detail::where('order_id',$value->id)->pluck('product_id');
        }
        return view('user.user.product_user', compact('user','detali','products'));
    }
    public function change_password($id){
        $user = User::where('id', $id)->first();
        return view('user.user.change_password', compact('user'));
    }
    public function pass_updatae($id,Request $request){
         $this->validate($request, 
            [
                'password' => 'required|min:6|max:25',
                'confirm_password' => 'required|same:password'
            ],
            [
                'password.required' => 'Vui lòng nhập mật khẩu.',
                'confirm_password.same' => 'Mật khẩu không khớp.',
                'password.min' => 'Mật khẩu không được dưới 6 ký tự.',
                'password.max' => 'Mật khẩu tối đa không quá 25 ký tự.',
            ]
        );
        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->route('change-password',$id)->with('success','Đã đổi mật khẩu thành công');
    }
    public function suggest_user($id){
        $user = User::find($id);
        $suggests = Suggets::where('user_id',$id)->get();
        return view('user.user.suggest_user', compact('user','suggests'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->first();
        return view('user.user.my_account', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return view('user.user.account_information', compact('user'));
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
        $user = User::find($id);
        $user->fullname = $request->fullname;
        $user->telephone = $request->telephone;
        $user->sex = $request->sex;
        if($request->hasFile('image')){
            if ($user->image != 'avatar.jpg') {
                File::delete(public_path('avatar/'.$user->image));
            }
            $file = $request->file('image');
            $user->image = rand(0,100000).'.'.$file->getClientOriginalName();
            $file->move( public_path() . '/avatar/', $user->image); 
        }
        $user->save();
        return redirect()->back()->with('success','Đã cập nhật tài khoản');
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
