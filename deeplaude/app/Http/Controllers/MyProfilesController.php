<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Redirect;
use DB;
use Auth;
use Session;
use App\Model\Company;

class MyProfilesController extends Controller
{
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
       /* $list = Poll::orderBy('created_at', 'desc')->get();
        foreach ($list as $item) {
            $item->total = $item->poll1_count + $item->poll2_count + $item->poll3_count + $item->poll4_count + $item->poll5_count + $item->poll6_count;
        }
        if (isset($request->addPoll)) {
            return view('PollManagementController.list')->with('susscessMessage', 'poll registered successfully')->with('list', $list);
        }*/
        //return view('PollManagementController.list')->with('list', $list);
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|min:3'
            ], [
                'required'  => ':attribute is required.',
                'unique'    => ':attribute has been taken.',
            ]);

            $user = User::find(auth()->user()->id);
            $item = Company::find(1);
            if($item == null){
                $item = new Company;
            }
            $item->setAttributeMapWith($request->all(),["company_logo", "company_address", "company_email", "company_vat_number", "company_description"]);
            $file = $request->file('company_logo');
            if($file != null) {
                $item->company_logo = $this->uploadImage($file);
            }
            $item->save();


            $user = User::find(auth()->user()->id);
            $user->name = $request->name;
            $user->surname = $request->surname;
            $user->save();
            Auth::user()->name =$request->name;
            Auth::user()->surname =$request->surname;
            return view('my_profiles.main')->with('susscessMessage', 'Your profiles edit successfully')
                ->with('item', $item);
        } else {
            $user = User::find(auth()->user()->id);
            $item = Company::find(1);
            if($item == null) {
                $item = new Company;
                $item->save();
                $item->company_name = "Company Name";
                $item->save();
                $user->company_id = $item->id;
                $user->save();
            }

           return view('my_profiles.main')->with('item', $item)->with('user', $user);
        }
    }

    public function uploadImage($file){
        $destinationPath = 'uploads';
        $fileId=uniqid();
        $fileName=$file->getClientOriginalName();
        $parts = explode('.', $fileName);
        $fileName= uniqid();
        $extent = $parts[count($parts) - 1];
        $file->move($destinationPath . "/" . $fileId ,$fileName . "." . $extent);
        $filePath = $destinationPath . "/" . $fileId  .'/'.$fileName . "." . $extent;
        return $filePath;
    }

    public function add(Request $request)
    {
        /*if ($request->isMethod('post')) {

            $request->validate([
                'name' => 'required|unique:poll|min:3',
            ]);

            $item = new Poll;
            $item->setAttributeMap($request->all());
            $item->save();
            return view('PollManagementController.main')->with('susscessMessage', 'Add poll successfully');
        } else {
            return view('PollManagementController.main');
        }*/
    }

    public function delete(Request $request)
    {
       /* $item = Poll::find($request->id);
        $name = $item->name;
        $item->delete();
        $list = Poll::orderBy('created_at', 'desc')->get();
        return view('PollManagementController.list')->with('susscessMessage', 'Poll name "' . $name . '" deleted successfully')->with('list', $list);
       */
    }

}


