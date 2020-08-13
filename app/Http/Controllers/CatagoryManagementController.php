<?php

namespace App\Http\Controllers;
use App\Model\Post;
use Illuminate\Http\Request;
use Redirect;
use DB;
use Auth;
use Session;
use File;
use App\Model\Catagory;
class CatagoryManagementController extends Controller
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
    
    public function index(Request $request)
    {
        $list = Catagory::query()
                        ->join('menu', 'catagory.menu_id', "=", "menu.id")
                        ->orderBy('catagory.order_number', 'asc')
                        ->get(['catagory.id as id', 'catagory.name as name', 'menu.name as menu_name']);
        return view('CatagoryManagement.list')->with('list', $list);
    }
    
    public function edit(Request $request)
    {
        if ($request->isMethod('post')) {
            $item = Catagory::find($request->id);
            if ($request->name == $item->name) {
                $keyUnikey = "required|min:3|max:256";
            } else {
                $keyUnikey = "required|unique:catagory|min:3|max:256";
            }
            $request->validate([
                'name' => $keyUnikey,
            ]);
            
            $item = Catagory::find($request->id);
            $name = $item->name;
            $item->setAttributeMap($request->all());
            $item->save();
            $list = Catagory::query()
            ->join('menu', 'catagory.menu_id', "=", "menu.id")
            ->orderBy('order_number', 'asc')
            ->get(['catagory.catagory.id as id', 'catagory.name as name', 'menu.name as menu_name']);
            return view('CatagoryManagement.list')->with('susscessMessage', 'Catagory name "' . $name . '" edit successfully')
            ->with('list', $list)->with('popupMode', $request->popupMode);
        } else {
            if (!isset($request->id)) {
                return redirect()->route('home');
            }
            $item = Catagory::find($request->id);
            return view('CatagoryManagement.main')->with('item', $item)->with('popupMode', $request->popupMode);
        }
    }
    
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|unique:catagory|min:3',
            ]);
            
            $item = new Catagory;
            $item->setAttributeMap($request->all());
            $item->order_number = Catagory::where("menu_id" , "=" , $item->menu_id)->max("order_number") + 1;
            $item->save();
            return view('CatagoryManagement.main')->with('susscessMessage', 'Add Catagory successfully');
        } else {
            return view('CatagoryManagement.main')->with('menu_id', $request->menu_id)->with('popupMode', $request->popupMode);
        }
    }
    
    public function delete(Request $request)
    {
        $item = Catagory::find($request->id);
        $name = $item->name;
        $item->delete();
        $list = Catagory::orderBy('order_number', 'asc')->get();
        return view('CatagoryManagement.list')->with('susscessMessage', 'Catagory name "' . $name . '" deleted successfully')->with('list', $list);
    } 
    
    public function getCatagoryByMenuId(Request $request)
    {
        $list = Catagory::where('menu_id', $request->id)->get();
        $resultString = "";
        foreach($list as $item){
            $resultString = $resultString . $item->id . ";" . $item->name . "||";
        }
        return $resultString;
    }

    public function show(Request $request)
    {
        $list = Post::query()->where('catagory_id', '=', $request->id)->orderBy('order_number', 'asc')->get();
        $itemCatagory = Catagory::find($request->id);
        return view('CatagoryManagement.show')->with('list', $list)->with('itemCatagory', $itemCatagory)->with('menu_id', $itemCatagory->menu_id);
    }
    
    public function move(Request $request)
    {

        $dragMenu = Catagory::find($request->dragId);
        if($request->dropId == 0){
            $max_order_id = Catagory::max('order_number');
            $midMenus = Catagory::query()->where("order_number", ">", $dragMenu->order_number)->get();
            foreach($midMenus as $item){
                $item->order_number = $item->order_number -1;
                $item->save();
            }
            $dragMenu->order_number = $max_order_id;
            $dragMenu->save();
            return;
        }
        $dropMenu = Catagory::find($request->dropId);
        if($dragMenu->order_number < $dropMenu->order_number){
            $midMenus = Catagory::query()->where("order_number", ">", $dragMenu->order_number)->where("order_number", "<", $dropMenu->order_number)->get();
            foreach($midMenus as $item){
                $item->order_number = $item->order_number -1;
                $item->save();
            }
            $dragMenu->order_number = $dropMenu->order_number - 1;
            $dragMenu->save();
            return;
        }
        if($dragMenu->order_number > $dropMenu->order_number){
            $midMenus = Catagory::query()->where("order_number", ">=", $dropMenu->order_number)->where("order_number", "<", $dragMenu->order_number)->get();
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
