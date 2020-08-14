<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Redirect;
use DB;
use Auth;
use Session;
use File;
use App\Model\Post;
use App\Model\Catagory;
use Storage;

class PostManagementController extends Controller
{
    public $errorFiles = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getList(){
        $list = Post::query()
        ->join('catagory', 'post.catagory_id', "=", "catagory.id")
        ->join('menu', 'catagory.menu_id', "=", "menu.id")
        ->orderBy('post.order_number', 'asc')
        ->get(['post.id as id', 'post.name as name' , 'post.description' , 'catagory.name as catagory_name', 'menu.name as menu_name']);
        return $list;
    }
    
    public function index(Request $request)
    {
        $list = $this->getList();
        return view('PostManagement.list')->with('list', $list);
    }
    
    public function edit(Request $request)
    {
        if ($request->isMethod('post')) {
            $item = Post::find($request->id);
            if ($request->name == $item->name) {
                $keyUnikey = "required|min:3|max:256";
            } else {
                $keyUnikey = "required|unique:post|min:3|max:256";
            }
            $request->validate([
                'name' => $keyUnikey,
            ]);
            
            $item = Post::find($request->id);
            $name = $item->name;
            $item->setAttributeMap($request->all());
             $item->content = $this->replaceContentUrl($item->content);
            $item->save();
            $list = $this->getList();
            return view('PostManagement.list')->with('susscessMessage', 'Post name "' . $name . '" edit successfully')
            ->with('list', $list);
        } else {
            if (!isset($request->id)) {
                return redirect()->route('home');
            }
            $item = Post::query()
            ->join('catagory', 'post.catagory_id', "=", "catagory.id")
            ->join('menu', 'catagory.menu_id', "=", "menu.id")
            ->where('post.id', '=' , $request->id)
            ->get(['post.id as id', 'post.name as name' , 'post.description', 'post.content' , 'post.catagory_id as catagory_id', 'menu.id as menu_id', 'catagory.name as catagory_name', 'menu.name as menu_name'])
            ->first();
            return view('PostManagement.main')->with('item', $item)->with('popupMode', $request->popupMode);
        }
    }
    
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|unique:post|min:3',
            ]);
            
            $item = new Post;
            $item->setAttributeMap($request->all());
            $item->content = $this->replaceContentUrl($item->content);
            $item->order_number = Post::where("catagory_id" , "=" , $item->catagory_id)->max("order_number") + 1;
            $item->save();
            return view('PostManagement.main')->with('susscessMessage', 'Add Post successfully');
        } else {
            if(isset($request->catagory_id)){
                $catagory = Catagory::find($request->catagory_id);
                $menu_id = $catagory->menu_id;
                return view('PostManagement.main')->with('catagory_id', $request->catagory_id)->with('menu_id', $menu_id)->with('popupMode', $request->popupMode);
            }
            return view('PostManagement.main');
        }
    }
    
    public function delete(Request $request)
    {
        $item = Post::find($request->id);
        $name = $item->name;
        $item->delete();
        $list = $this->getList();
        return view('PostManagement.list')->with('susscessMessage', 'Post name "' . $name . '" deleted successfully')->with('list', $list);
    } 
    
    public function show(Request $request)
    {
        $item = Post::find($request->id);
        $itemCatagory = Catagory::find($item->catagory_id);
        return view('PostManagement.show')->with('item', $item)->with('itemCatagory', $itemCatagory);
    }
    
    public function replaceContentUrl($content){
        $parts = explode('font-family:', $content);
        
        $temp = "";
        foreach($parts as $index=>$str){
            if($index == 0){
                $temp = $str;
            }else{

                $str = str_replace('&quot;', ",.,.,.,.?.", $str);
                $tempParts = explode(';', $str);
                $temp2 = "";
                foreach($tempParts as $index1=>$str1){
                    if($index1 == 0){
                        $temp2 = str_replace(',.,.,.,.?.', "'", $str1);
                    }else{
                        $temp2 = $temp2 . ";" . $str1 ;
                    }
                }
                $temp2 = str_replace( ",.,.,.,.?.",'&quot;', $temp2);
                $temp = $temp . "font-family:" . $temp2;
            }
        }
        $content = $temp;
        $parts = explode('"', $content);
        foreach($parts as $str){
            if (strpos($str, 'storage') == false && strpos($str, 'app') == false && (strpos($str, '.jpg') !== false || strpos($str, '.png') !== false || strpos($str, '.gif') !== false)) {
                $part1s = explode(' ', $str);
                $str = $part1s[0];
                $contents = file_get_contents($str);
                $name = substr($str, strrpos($str, '/') + 1);
                $name = uniqid() . "_" . $name;
                Storage::put($name, $contents);
                $content = str_replace($str, "/storage/app/" . $name, $content);
            }
        }
        return $content;
        
    }
    
    public function move(Request $request)
    {
        $dragMenu = Post::find($request->dragId);
        if($request->dropId == 0){
            $max_order_id = Post::max('order_number');
            $midMenus = Post::query()->where("order_number", ">", $dragMenu->order_number)->get();
            foreach($midMenus as $item){
                $item->order_number = $item->order_number -1;
                $item->save();
            }
            $dragMenu->order_number = $max_order_id;
            $dragMenu->save();
            return;
        }
        $dropMenu = Post::find($request->dropId);
        if($dragMenu->order_number < $dropMenu->order_number){
            $midMenus = Post::query()->where("order_number", ">", $dragMenu->order_number)->where("order_number", "<", $dropMenu->order_number)->get();
            foreach($midMenus as $item){
                $item->order_number = $item->order_number -1;
                $item->save();
            }
            $dragMenu->order_number = $dropMenu->order_number - 1;
            $dragMenu->save();
            return;
        }
        if($dragMenu->order_number > $dropMenu->order_number){
            $midMenus = Post::query()->where("order_number", ">=", $dropMenu->order_number)->where("order_number", "<", $dragMenu->order_number)->get();
            foreach($midMenus as $item){
                $item->order_number = $item->order_number + 1;
                $item->save();
            }
            $dragMenu->order_number = $dropMenu->order_number;
            $dragMenu->save();
            return;
        }
    }

}
