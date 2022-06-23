<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends BaseController
{

    public function __construct(Company $company)
    {
        $this->middleware('auth:api');
        $this->company = $company;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = $this->company
        ->paginate(10);

        return $this->sendResponse($companies, 'Company list');
    }

    public function list()
    {
        $companies = $this->company->pluck('name', 'id');

        return $this->sendResponse($companies, 'Company list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = $this->company->create([
            'name' => $request->get('name'),
        ]);

        

        return $this->sendResponse($company, 'Company Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = $this->company->findOrFail($id);

        return $this->sendResponse($company, 'Company Details');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $company = $this->company->findOrFail($id);

        $company->update($request->all());

        return $this->sendResponse($company, 'Company Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $company = $this->company->findOrFail($id);

        $company->delete();

        return $this->sendResponse($company, 'Company has been Deleted');
    }
}
