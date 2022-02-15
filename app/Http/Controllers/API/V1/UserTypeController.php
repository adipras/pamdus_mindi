<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\UserType;
use Illuminate\Http\Request;

class UserTypeController extends BaseController
{
    protected $userType = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserType $userType)
    {
        $this->middleware('auth:api');
        $this->userType = $userType;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userTypes = $this->userType->latest()->paginate(10);

        return $this->sendResponse($userTypes, 'User type list.');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $userTypes = $this->userType->pluck('name', 'id');

        return $this->sendResponse($userTypes, 'User type list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag = $this->userType->create([
            'name' => $request->get('name'),
        ]);

        return $this->sendResponse($tag, 'User type Created Successfully');
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
        $tag = $this->userType->findOrFail($id);

        $tag->update($request->all());

        return $this->sendResponse($tag, 'User type Information has been updated');
    }
}
