<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartyRequest;
use App\Party;
use App\Services\CommonService;
use App\Services\PartyService;

class PartyController extends Controller
{
    protected $partyService;
    protected $commonService;

    public function __construct(PartyService $partyService, CommonService $commonService)
    {
        $this->partyService = $partyService;
        $this->commonService = $commonService;
    }

    /*
     * Show page of list of parties.
     * */
    public function index(){
        $request = request()->all();
        $parties = $this->partyService->searchParty($request);
        return view('parties.index', compact('parties', 'request'));
    }

    /*
     * Show page of create party.
     * */
    public function create(){
        return view('parties.create');
    }

    /*
     * Save party into db.
     * @param: @request
     * */
    public function store(StorePartyRequest $request){
        $request = $request->except('_token', 'partyId');
        $this->commonService->findUpdateOrCreate(Party::class, ['id' => ''], $request);

        return redirect('party/parties-list')->with('message', PartyService::PARTY_SAVED);
    }

    /*
     * Show edit page.
     * */
    public function edit($id){
        $party = Party::find($id);
        if(empty($party)){
            abort(404);
        }
        return view('parties.create', compact('party'));
    }

    /*
     * update existing resource.
     * @param: $data
     * */
    public function update(StorePartyRequest $request){
        $request = $request->except('_token','partyId');
        $this->commonService->findUpdateOrCreate(Party::class, ['id' => request('partyId')], $request);
        return redirect('party/parties-list')->with('message', PartyService::PARTY_UPDATED);
    }

    /*
     * Delete existing resource.
     * @param: request()->id
     * */
    public function delete(){
        $deleted = Party::where('id', request()->id)->delete();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => PartyService::PARTY_DELETED]);
        } else {
            return response()->json(['status' => 'fail', 'message' => PartyService::SOME_THING_WENT_WRONG]);
        }
    }

    /*
     * View party detail.
     * @param: $id
     * */
    public function view($id){
        $party = Party::find($id);
        if(empty($party)){
            abort(404);
        }

        return view('parties.view', compact('party'));
    }
}
