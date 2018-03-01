<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user_id = Auth::user()->id;
        $companies = Company::where('user_id',$user_id)->get();
        return view('companies.index', ['companies'=>$companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $name = $request->input('name');
        $description = $request->input('description');
        $user_id = Auth::user()->id;

        $company = new Company;
        $company->name = $name;
        $company->description = $description;
        $company->user_id = $user_id;

        $companySave = $company->save();

        if($companySave){
            $user_id = Auth::user()->id;
            $companies = Company::where('user_id', $user_id)->get();

            return redirect()->route('companies.index')->with('success', 'Company created successfully');
        }

        return back()->withInput()->with('errors', 'Save company error!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
        //$company = Company::where('id', $company->id);
        $company = Company::find($company->id);
        return view('companies.show', ['company'=>$company]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
        $company = Company::find($company->id);
        return view('companies.edit', ['company'=>$company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
        $company = Company::find($company->id);
        $company->name = $request->input('name');
        $company->description = $request->input('description');

        $companyUpdate = $company->update();

        if($companyUpdate){

            return redirect()->route('companies.show', ['company' => $company->id])->with('success', 'Company updated successfully!');
        }

        return back()->withInput()->with('errors', 'Update company error!');

        // return view('companies.index', ['companies' => $companies]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
        $deleteCompany = Company::where('id', $company->id)->delete();

        if($deleteCompany){
            $user_id = Auth::user()->id;
            $companies = Company::where('user_id', $user_id)->get();
            return redirect()->route('companies.index')->with('success', 'Company deleted successfully!');
        }

        return back()->with('errors', 'Company could not be deleted!');
    }
}
