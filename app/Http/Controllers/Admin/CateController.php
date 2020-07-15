<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Categoies;
use App\Model\Products;
use App\Model\Order_Detail;
use Validator;
use App\Http\Requests\CategoryRequest;

class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_categories = Categoies::paginate(6);
        $children = Categoies::with('childrenCategories')->where('parent_id',0)->get();
        return view('admin.category.list',compact('list_categories','children'));
    }
    public function fetch_data(Request $request){
        if ($request->ajax()) {
            $query = $request->get('query');
            $list_categories = Categoies::where('name', 'LIKE', '%' . $query . '%')->paginate(6);
            $children = Categoies::with('childrenCategories')->where('parent_id',0)->get();
            return view('admin.category.pagin',compact('list_categories','children'));
            // ở đây ta bỏ table vào 1 file khac đe clcik no ko bị lỗi cả body vào 
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $children = Categoies::with('childrenCategories')->where('parent_id',0)->get();
        return view('admin.category.add_category', compact('children'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        Categoies::create($request->all());
        return redirect()->route('category.index')->with('thongbao','Thêm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category=Categoies::find($id);
        return response()->json(['data'=>$category],200);
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
                'name' => 'required|min:3|max:255'
            ],
        [
            'name.required' => 'Please Enter Name Category',
            'name.min' => 'Attribute length of 3-255 characters ',
            'name.max' => 'Attribute length of 3-255 characters ',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>'true','mess'=>$validator->errors()],200);
        }
        $category= Categoies::find($id);
        $category->name = $request->name;
        if ($request->parent_id != 0) {
            $category->parent_id = $request->parent_id;
                    }
        else {
            $category->parent_id = 0;

        }
        
        $category->desription = $request->desription;
        $category->save();
        $children = Categoies::get();
        return response()->json(['data'=>$category,'children'=>$children,'success'=>'Sửa thành công'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function children($item,$id)
    {
        $categori =Categoies::find($item);
        $childrenIDs = $categori->childrenCategories->pluck('id');
         $a = 0;
        if ($childrenIDs->count() == 0 || $childrenIDs->count() == null) {
            $product = Products::where('category_id',$categori->id)->get();
           
            foreach ($product as $value) {
                $list_detail = Order_Detail::where('product_id',$value->id)->get();
                if ($list_detail->count() > 0) {
                    $a++;

                }
            }
            if ($a == 0) {  
                $categori->delete();
                $category =Categoies::find($id);
                if ($category != null) {
                    $category->delete();
                }
            }
        }
        else {
            foreach ($childrenIDs as $value) {
                $this->children($value,$item);                                 
            }
            
        }        
    return $a;
        
    }
    public function destroy($id)
    {
        $category =Categoies::find($id);
        $childrenIDs = $category->childrenCategories->pluck('id');
        $a = 0;
        if ($childrenIDs->count() == 0 || $childrenIDs->count() == null) {
            $product = Products::where('category_id',$category->id)->get();
            
            foreach ($product as $value) {
                $list_detail = Order_Detail::where('product_id',$value->id)->get();
                if ($list_detail->count() > 0) {
                    $a++;
                    
                }
            }

            if ($a == 0) {  
                $category->delete();
                return response()->json(['data'=>'removed','success'=>'Xóa thành công'],200);
            }
            else {
                return response()->json(['errors'=>'true','error'=>'Không thể xóa'],200);
            }
        }
        else {
            foreach ($childrenIDs as $item) {
                $a = $this->children($item,$id);                                 
            }
            if ($a == 0 ) {  
                $categori =Categoies::find($id);
                if ($categori == null) {
                    return response()->json(['data'=>'removed','success'=>'Xóa thành công'],200);
                }
                else {
                   return response()->json(['errors'=>'true','error'=>'Không thể xóa'],200); 
                }
                
            }
            else {
                return response()->json(['errors'=>'true','error'=>'Không thể xóa'],200);
        }

                       
        }
    }
}
