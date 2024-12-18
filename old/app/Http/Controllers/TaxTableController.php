<?php

namespace App\Http\Controllers;

use App\TaxTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class TaxTableController extends Controller
{
    /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function index()
     {
         $dados = TaxTable::where('empresa_id', Auth::user()->empresa_id)->get();
         return view('taxtable.index', compact('dados'));
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
         $dados = TaxTable::where('empresa_id', Auth::user()->empresa_id)->get();
         return view('taxtable.create', compact('dados'));
     }
 
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
         $dados = new TaxTable;
         $dados->empresa_id = Auth::user()->empresa_id;
         $dados->tax_type = $request->input('tax_type');
         $dados->tax_code = $request->input('tax_code');
         $dados->description = $request->input('description');
         $dados->tax_percentage = $request->input('tax_percentage');
         $dados->save();
         return redirect('/taxtable')->with('success', 'Sucesso');
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
         $dados =  TaxTable::where('empresa_id', Auth::user()->empresa_id)->find($id);
         return view('taxtable.edit', compact('dados'));
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
         $dados = TaxTable::where('empresa_id', Auth::user()->empresa_id)->find($id);
         $dados->tax_type = $request->input('tax_type');
         $dados->tax_code = $request->input('tax_code');
         $dados->description = $request->input('description');
         $dados->tax_percentage = $request->input('tax_percentage');
         $dados->save();
         $request->session()->flash('alt_success', 'Succeso');
         return redirect('/taxtable')->with('success', 'Sucesso');
     }
 
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy($id)
     {
         $dados = TaxTable::where('empresa_id', Auth::user()->empresa_id)->find($id);
         $dados->delete();
         session()->flash('alt_success', 'Succeso');
         return redirect('/taxtable')->with('success', 'Sucesso');
     }
 }
