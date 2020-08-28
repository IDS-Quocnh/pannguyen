<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Redirect;
use DB;
use Auth;
use Session;
use File;
use App\Model\Menu;
use App\Model\Catagory;

class MenuManagementController extends Controller
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
        $list = Menu::orderBy('created_at', 'desc')->get();
        return view('MenuManagement.list')->with('list', $list);
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post')) {
            $item = Menu::find($request->id);
            if ($request->name == $item->name) {
                $keyUnikey = "required|min:3|max:256";
            } else {
                $keyUnikey = "required|unique:menu|min:3|max:256";
            }
            $request->validate([
                'name' => $keyUnikey,
            ]);

            $item = Menu::find($request->id);
            $name = $item->name;
            $item->setAttributeMap($request->all());
            $item->save();
            $list = Menu::orderBy('created_at', 'desc')->get();
            return view('MenuManagement.list')->with('susscessMessage', 'Menu name "' . $name . '" edit successfully')
                ->with('list', $list);
        } else {
            if (!isset($request->id)) {
                return redirect()->route('home');
            }
            $item = Menu::find($request->id);
            return view('MenuManagement.main')->with('item', $item);
        }
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|unique:menu|min:3',
            ]);

            $item = new Menu;
            $item->setAttributeMap($request->all());
            $item->order_number = Menu::max("order_number") + 1;
            $item->save();
            return view('MenuManagement.main')->with('susscessMessage', 'Add menu successfully');
        } else {
            return view('MenuManagement.main');
        }
    }

    public function delete(Request $request)
    {
        $item = Menu::find($request->id);
        $name = $item->name;
        $item->delete();
        $list = Menu::orderBy('created_at', 'desc')->get();
        return view('MenuManagement.list')->with('susscessMessage', 'Menu name "' . $name . '" deleted successfully')->with('list', $list);
    } 
    
    public function show(Request $request)
    {
        $list = Catagory::query()->where('menu_id', '=', $request->id)->orderBy('order_number', 'asc')->get();
        $itemMenu = Menu::find($request->id);
        return view('MenuManagement.show')->with('list', $list)->with('itemMenu', $itemMenu);
    } 
    
    public function move(Request $request)
    {
        $dragMenu = Menu::find($request->dragId);
        if($request->dropId == 0){
            $max_order_id = Menu::max('order_number');
            $midMenus = Menu::query()->where("order_number", ">", $dragMenu->order_number)->get();
            foreach($midMenus as $item){
                $item->order_number = $item->order_number -1;
                $item->save();
            }
            $dragMenu->order_number = $max_order_id;
            $dragMenu->save();
            return;
        }
        $dropMenu = Menu::find($request->dropId);
        if($dragMenu->order_number < $dropMenu->order_number){
            $midMenus = Menu::query()->where("order_number", ">", $dragMenu->order_number)->where("order_number", "<", $dropMenu->order_number)->get();
            foreach($midMenus as $item){
                $item->order_number = $item->order_number -1;
                $item->save();
            }
            $dragMenu->order_number = $dropMenu->order_number - 1;
            $dragMenu->save();
            return;
        }
        if($dragMenu->order_number > $dropMenu->order_number){
            $midMenus = Menu::query()->where("order_number", ">=", $dropMenu->order_number)->where("order_number", "<", $dragMenu->order_number)->get();
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
