<?php


namespace App\Services;


use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserService
{
    const PER_PAGE = 10;
    const USER_SAVED = 'User saved successfully';
    const USER_UPDATED = 'User updated successfully';
    const USER_DELETED = 'User is deleted successfully';
    const SOME_THING_WENT_WRONG = 'Oops!Something went wrong';

    protected $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    /*
     * Advance Search data on issuance records.
     * @queries: $queries
     * @return: object
     * */
    public function searchUser($request)
    {
        $users = [];
        $query = User::get();
        if (!empty($request)) {
            if(!empty($request['param'])){
                $query = Customer::where('name', 'like', '%' . $request['param'] . '%')
                    ->orwhere('email', 'like', '%' . $request['param'] . '%');
            }
        }

        if(!empty($request['param'])){
            $users = $query->get();
        }else{
            $users = $query;
        }

        return $this->commonService->paginate($users, Self::PER_PAGE);
    }

    public function dataArray($request)
    {
        $data['name'] = $request['name'];
        $data['email'] = $request['email'];
        $data['password'] = Hash::make($request['password']);
        $data['role'] = $request['role'];

        return $data;
    }

}
