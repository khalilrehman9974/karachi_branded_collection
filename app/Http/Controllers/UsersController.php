<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Services\CommonService;
use App\Services\UserService;
use App\User;

class UsersController extends Controller
{
    protected $userService;
    protected $commonService;

    public function __construct(UserService $userService, CommonService $commonService)
    {
        $this->userService = $userService;
        $this->commonService = $commonService;
    }

    /*
     * Show page of list of users.
     * */
    public function index(){
        $request = request()->all();
        $users = $this->userService->searchUser($request);
        return view('users.index', compact('users', 'request'));
    }

    /*
     * Show page of create user.
     * */
    public function create(){
        return view('users.create');
    }

    /*
     * Save user into db.
     * @param: @request
     * */
    public function store(StoreUserRequest $request){
        $request = $request->except('_token', 'userId');
        $this->commonService->findUpdateOrCreate(User::class, ['id' => ''], $this->userService->dataArray($request));

        return redirect('user/users')->with('message', UserService::USER_SAVED);
    }

    /*
     * Show edit page.
     * */
    public function edit($id){
        $user = User::find($id);
        if(empty($user)){
            abort(404);
        }
        return view('users.create', compact('user'));
    }

    /*
     * update existing resource.
     * @param: $data
     * */
    public function update(StoreUserRequest $request){
        $request = $request->except('_token','userId');
        $this->commonService->findUpdateOrCreate(User::class, ['id' => request('userId')], $request);
        return redirect('user/users-list')->with('message', UserService::USER_UPDATED);
    }

    /*
     * Delete existing resource.
     * @param: request()->id
     * */
    public function delete(){
        $deleted = User::where('id', request()->id)->delete();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => UserService::USER_DELETED]);
        } else {
            return response()->json(['status' => 'fail', 'message' => UserService::SOME_THING_WENT_WRONG]);
        }
    }

    /*
     * View User detail.
     * @param: $id
     * */
    public function view($id){
        $user = User::find($id);
        if(empty($user)){
            abort(404);
        }

        return view('users.view', compact('user'));
    }
}
