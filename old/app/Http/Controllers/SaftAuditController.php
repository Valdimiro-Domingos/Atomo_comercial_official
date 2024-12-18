<?php

namespace App\Http\Controllers;

use App\SaftAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SaftAuditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = SaftAudit::all();
        return view('saftaudit.index', compact('dados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dados = SaftAudit::all();
        return view('saftaudit.create', compact('dados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = new SaftAudit;
        $dados->empresa_id = Auth::user()->empresa_id;
        $dados->audit_file_version = $request->input('audit_file_version');
        $dados->company_id = $request->input('company_id');
        $dados->tax_registration_number = $request->input('tax_registration_number');
        $dados->tax_accounting_basis = $request->input('tax_accounting_basis');
        $dados->save();
        return redirect('/saftaudit')->with('success', 'Sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dados =  SaftAudit::where('empresa_id', Auth::user()->empresa_id)->find($id);
        return view('saftaudit.edit', compact('dados'));
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
        $dados = SaftAudit::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->audit_file_version = $request->input('audit_file_version');
        $dados->company_id = $request->input('company_id');
        $dados->tax_registration_number = $request->input('tax_registration_number');
        $dados->tax_accounting_basis = $request->input('tax_accounting_basis');
        $dados->save();
        $request->session()->flash('alt_success', 'Succeso');
        return redirect('/saftaudit')->with('success', 'Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dados = SaftAudit::where('empresa_id', Auth::user()->empresa_id)->find($id);
        $dados->delete();
        session()->flash('alt_success', 'Succeso');
        return redirect('/saftaudit')->with('success', 'Sucesso');
    }
}
