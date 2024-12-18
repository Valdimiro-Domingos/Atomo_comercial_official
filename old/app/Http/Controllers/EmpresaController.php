<?php

namespace App\Http\Controllers;

use App\Contacto;
use App\Empresa;
use App\Endereco;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;



class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $isCreate = false;
        $dados = Empresa::where('id', Auth::user()->empresa_id)->get();
        return view('empresa.index', compact('dados', 'isCreate'));
    }

    public function create()
    {
        return view('empresa.create');
    }

    public function store(Request $request)
    {
        $faker = Faker::create();
        
        $empresaCount = Empresa::where('nif', $request->nif)
        ->orWhere('designacao', $request->designacao)
        ->orWhere('registo_comercial', $request->registo_comercial)
        ->count();
        
        if($empresaCount > 0) {
           return redirect()->back()->withErrors(['Já existe uma empresa com estes dados']);
        }
        
        if(!$request->prazo_inicio || !$request->prazo_termino){
            return redirect()->back()->withErrors(['Prazo de pagamento invalido'])->withInput();
        }
        
        


        

        DB::beginTransaction();
        try {
            //Endereco
            $dados_endereco = new Endereco;
            $dados_endereco->pais = $request->input('pais');
            $dados_endereco->cidade = $request->input('cidade');
            $dados_endereco->endereco = $request->input('endereco');
            $dados_endereco->save();

            //Contacto
            $dados_contacto = new Contacto;
            $dados_contacto->telefone = $request->input('telefone');
            $dados_contacto->fax = $request->input('fax');
            $dados_contacto->telemovel = $request->input('telemovel');
            $dados_contacto->contacto = $request->input('contacto');
            $dados_contacto->email = $request->input('email');
            $dados_contacto->facebook = $request->input('facebook');
            $dados_contacto->whatsapp = $request->input('whatsapp');
            $dados_contacto->skype = $request->input('skype');
            $dados_contacto->twitter = $request->input('twitter');
            $dados_contacto->linkedin = $request->input('linkedin');
            $dados_contacto->website = $request->input('website');
            $dados_contacto->save();

            //Empresa
            $empresa = new Empresa;
            $empresa->designacao = $request->input('designacao');
            $empresa->nif = $request->input('nif') ?? "DEFAULT";
            $empresa->registo_comercial = $request->input('registo_comercial');
            $empresa->data_fundacao = $request->input('data_fundacao') ?? date('Y-m-d H:i:s');
            $empresa->csocial = $request->input('csocial');
            $empresa->representante = $request->input('representante') ?? 'DEFAULT';
            $empresa->ndi_rep = $request->input('ndi_rep');
            $empresa->descricao = $request->input('descricao');
            $empresa->id_endereco = $dados_endereco->id;
            $empresa->id_contacto = $dados_contacto->id;
            $empresa->operador = Auth::user()->nome;
            $empresa->prazo_inicio = $request->prazo_inicio ?? null;
            $empresa->prazo_termino = $request->prazo_termino ?? null;
            $empresa->data_criacao = date('Y-m-d H:i:s');
            
            $empresa->foto = ($request->file('file')) ? Helpers::uploadFile($request, 'file') : 'null.png';
            $empresa->status = ($request->input('status')) ? true : false;
            $empresa->save();

            // Atualizar a tabela 'enderecos' com o 'empresa_id'
            $dados_endereco->empresa_id = $empresa->id;
            $dados_endereco->save();

            // Atualizar a tabela 'contactos' com o 'empresa_id'
            $dados_contacto->empresa_id = $empresa->id;
            $dados_contacto->save();

            // Inserir permissões
            DB::table('permissions')->insert([
                ['empresa_id' => $empresa->id, 'name' => 'pos', 'guard_name' => 'web'],
                ['empresa_id' => $empresa->id, 'name' => 'painel', 'guard_name' => 'web'],
                ['empresa_id' => $empresa->id, 'name' => 'artigo', 'guard_name' => 'web'],
                ['empresa_id' => $empresa->id, 'name' => 'receita_despesa', 'guard_name' => 'web'],
                ['empresa_id' => $empresa->id, 'name' => 'cliente', 'guard_name' => 'web'],
                ['empresa_id' => $empresa->id, 'name' => 'documento', 'guard_name' => 'web'],
                ['empresa_id' => $empresa->id, 'name' => 'relatorio', 'guard_name' => 'web'],
                ['empresa_id' => $empresa->id, 'name' => 'configuracoes', 'guard_name' => 'web'],
            ]);

            // Inserir funções
            DB::table('roles')->insert([
                ['empresa_id' => $empresa->id, 'name' => 'Administrador', 'guard_name' => 'web'],
                ['empresa_id' => $empresa->id, 'name' => 'Gestor', 'guard_name' => 'web'],
                ['empresa_id' => $empresa->id, 'name' => 'Operador', 'guard_name' => 'web'],
                ['empresa_id' => $empresa->id, 'name' => 'Operador POS', 'guard_name' => 'web'],
            ]);

            $counts = DB::table('roles')->where('empresa_id', $empresa->id)->get();
            foreach ($counts as $key => $base) {
                switch ($key) {
                    case 0:
                        for ($i = 1; $i <= 8; $i++) {
                            DB::table('role_has_permissions')->insert(['empresa_id' => $empresa->id, 'permission_id' => $i, 'role_id' => $base->id]);
                        }
                    break;
                    case 1:
                        for ($i = 1; $i <= 7; $i++) {
                            DB::table('role_has_permissions')->insert(['empresa_id' => $empresa->id, 'permission_id' => $i, 'role_id' => $base->id]);
                        }
                    break;
                    case 2:
                        for ($i = 1; $i <= 6; $i++) {
                            DB::table('role_has_permissions')->insert(['empresa_id' => $empresa->id, 'permission_id' => $i, 'role_id' => $base->id]);
                        }
                    break;
                    case 3:
                        for ($i = 1; $i <= 1; $i++) {
                            DB::table('role_has_permissions')->insert(['empresa_id' => $empresa->id, 'permission_id' => $i, 'role_id' => $base->id]);
                        }
                    break;

                }
            }

            // Inserir departamentos
            DB::table('departamentos')->insert([
                ['codigo' => '0001', 'empresa_id' => $empresa->id, 'designacao' => 'Administração', 'descricao' => 'Administração', 'status' => true],
                ['codigo' => '0001', 'empresa_id' => $empresa->id, 'designacao' => 'Gestão', 'descricao' => 'Gestão', 'status' => true],
                ['codigo' => '0001', 'empresa_id' => $empresa->id, 'designacao' => 'Vendas', 'descricao' => 'Vendas', 'status' => true],
            ]);

            // Inserir usuário
            DB::table('users')->insert([
                [
                    'nome' => 'Administrador',
                    'email' => 'admin'. $empresa->id.date('y'). '@admin.com',
                    'departamento_id' => DB::table('departamentos')->where('empresa_id', $empresa->id)->first()->id,
                    'password' => Hash::make(123),
                    'empresa_id' => $empresa->id,
                    'foto' => 'default.jpg',
                    'status' => 1,
                ],
            ]);
        

            DB::table('model_has_roles')->insert([
                'empresa_id' => $empresa->id,
                'role_id' => DB::table('roles')->where('empresa_id', $empresa->id)->first()->id,
                'model_type' => 'App\User',
                'model_id' => DB::table('users')->where('empresa_id', $empresa->id)->first()->id,
            ]);


            // Inserir tabela de impostos
            DB::table('tax_tables')->insert([
                [
                    'empresa_id' => $empresa->id,
                    'tax_type' => 'IVA',
                    'tax_code' => 'ISE',
                    'description' => 'IVA - Isento',
                    'tax_percentage' => '0.00',
                ],
            ]);

            // Inserir auditoria SAFT
            DB::table('saft_audits')->insert([
                [
                    'empresa_id' => $empresa->id,
                    'audit_file_version' => '1.01_01',
                    'company_id' => $empresa->id,
                    'tax_registration_number' => $empresa->nif,
                    'tax_accounting_basis' => 'F',
                ],
            ]);

            // Inserir países
            DB::table('pais')->insert([
                ['empresa_id' => $empresa->id, 'designacao' => 'Angola', 'sigla' => 'AO', 'status' => true],
                ['empresa_id' => $empresa->id, 'designacao' => 'Portugal', 'sigla' => 'PT', 'status' => true],
            ]);

            // Inserir impostos

            DB::table('impostos')->insert([
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M00', 'designacao' => 'M00 - Regime Simplificado', 'taxa' => 0, 'motivo' => 'Regime Simplificado', 'status' => true],
                ['tipo' => 'IVA', 'empresa_id' => $empresa->id, 'codigo' => '', 'designacao' => 'IVA', 'taxa' => 14, 'motivo' => '', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M02', 'designacao' => 'M02 - Transmissão de bens e serviço não sujeita', 'taxa' => 0, 'motivo' => 'Regime Simplificado', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M04', 'designacao' => 'M04 - Regime de Exclusão', 'taxa' => 0, 'motivo' => 'Regime Simplificado', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M11', 'designacao' => 'M11 - Isento nos termos da alínea b) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea b) do nº1 do artigo 12.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M12', 'designacao' => 'M12 - Isento nos termos da alínea c) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea c) do nº1 do artigo 12.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M13', 'designacao' => 'M13 - Isento nos termos da alínea d) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea d) do nº1 do artigo 12.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M14', 'designacao' => 'M14 - Isento nos termos da alínea e) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea e) do nº1 do artigo 12.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M15', 'designacao' => 'M15 - Isento nos termos da alínea f) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea f) do nº1 do artigo 12.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M16', 'designacao' => 'M16 - Isento nos termos da alínea g) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea g) do nº1 do artigo 12.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M17', 'designacao' => 'M17 - Isento nos termos da alínea h) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea h) do nº1 do artigo 12.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M18', 'designacao' => 'M18 - Isento nos termos da alínea i) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea i) do nº1 do artigo 12.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M19', 'designacao' => 'M19 - Isento nos termos da alínea j) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea j) do nº1 do artigo 12.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M20', 'designacao' => 'M20 - Isento nos termos da alínea k) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea k) do nº1 do artigo 12.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M21', 'designacao' => 'M21 - Isento nos termos da alínea l) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea l) do nº1 do artigo 12.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M22', 'designacao' => 'M22 - Isento nos termos da alínea m) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea m) do nº1 do artigo 12.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M23', 'designacao' => 'M23 - Isento nos termos da alínea n) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea n) do nº1 do artigo 12.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M24', 'designacao' => 'M24 - Isento nos termos da alínea o) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea o) do nº1 do artigo 12.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M80', 'designacao' => 'M80 - Isento nos termos da alínea a) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea a) do nº1 do artigo 14.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M81', 'designacao' => 'M81 - Isento nos termos da alínea b) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea b) do nº1 do artigo 14.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M82', 'designacao' => 'M82 - Isento nos termos da alínea c) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea c) do nº1 do artigo 14.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M83', 'designacao' => 'M83 - Isento nos termos da alínea d) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea d) do nº1 do artigo 14.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M84', 'designacao' => 'M84 - Isento nos termos da alínea e) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea e) do nº1 do artigo 14.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M85', 'designacao' => 'M85 - Isento nos termos da alínea a) do nº2 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea a) do nº2 do artigo 14.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M86', 'designacao' => 'M86 - Isento nos termos da alínea b) do nº2 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea b) do nº2 do artigo 14.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M30', 'designacao' => 'M30 - Isento nos termos da alínea a) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea a) do artigo 15.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M31', 'designacao' => 'M31 - Isento nos termos da alínea b) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea b) do artigo 15.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M32', 'designacao' => 'M32 - Isento nos termos da alínea c) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea c) do artigo 15.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M33', 'designacao' => 'M33 - Isento nos termos da alínea d) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea d) do artigo 15.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M34', 'designacao' => 'M34 - Isento nos termos da alínea e) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea e) do artigo 15.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M35', 'designacao' => 'M35 - Isento nos termos da alínea f) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea f) do artigo 15.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M36', 'designacao' => 'M36 - Isento nos termos da alínea g) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea g) do artigo 15.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M37', 'designacao' => 'M37 - Isento nos termos da alínea h) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea h) do artigo 15.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M38', 'designacao' => 'M38 - Isento nos termos da alínea i) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea i) do artigo 15.º do CIVA', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M90', 'designacao' => 'M90 - Isento nos termos da alinea a) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea a) do nº1 do artigo 16.º', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M91', 'designacao' => 'M91 - Isento nos termos da alinea b) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea b) do nº1 do artigo 16.º', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M92', 'designacao' => 'M92 - Isento nos termos da alinea c) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea c) do nº1 do artigo 16.º', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M93', 'designacao' => 'M93 - Isento nos termos da alinea d) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea d) do nº1 do artigo 16.º', 'status' => true],
                ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M93', 'designacao' => 'M94 - Isento nos termos da alinea e) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea e) do nº1 do artigo 16.º', 'status' => true],
            ]);

            DB::table('retencaos')->insert([
                ['designacao' => 'Sem rentenção na fonte', 'empresa_id' => $empresa->id, 'taxa' => 0, 'status' => true],
                ['designacao' => 'Rentenção na fonte 6.5%', 'empresa_id' => $empresa->id, 'taxa' => 6.5, 'status' => true],
            ]);

            DB::table('moedas')->insert([
                ['designacao' => 'Kwanza', 'empresa_id' => $empresa->id],
                ['designacao' => 'Dollar', 'empresa_id' => $empresa->id],
            ]);

            DB::table('condicoes_pagamentos')->insert([
                ['designacao' => 'Pronto Pagemento', 'empresa_id' => $empresa->id],
                ['designacao' => '30 Dias', 'empresa_id' => $empresa->id],
                ['designacao' => '60 Dias', 'empresa_id' => $empresa->id],
                ['designacao' => '90 Dias', 'empresa_id' => $empresa->id],
                ['designacao' => '120 Dias', 'empresa_id' => $empresa->id],
            ]);

            DB::table('modo_pagamentos')->insert([
                ['designacao' => 'Cheque', 'empresa_id' => $empresa->id],
                ['designacao' => 'Numerário', 'empresa_id' => $empresa->id],
                ['designacao' => 'Transferência Bancária', 'empresa_id' => $empresa->id],
            ]);

            DB::table('series')->insert([
                ['codigo' => '0001', 'designacao' => 'PP ' . date('Y'), 'empresa_id' => $empresa->id, 'tipo' => 'proforma', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
                ['codigo' => '0002', 'designacao' => 'FT ' . date('Y'), 'empresa_id' => $empresa->id, 'tipo' => 'factura', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
                ['codigo' => '0003', 'designacao' => 'FR ' . date('Y'), 'empresa_id' => $empresa->id, 'tipo' => 'factura-recibo', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
                ['codigo' => '0004', 'designacao' => 'RC ' . date('Y'), 'empresa_id' => $empresa->id, 'tipo' => 'recibo', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
                ['codigo' => '0005', 'designacao' => 'NC ' . date('Y'), 'empresa_id' => $empresa->id, 'tipo' => 'nota-credito', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
                ['codigo' => '0006', 'designacao' => 'ND ' . date('Y'), 'empresa_id' => $empresa->id, 'tipo' => 'nota-debito', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
                ['codigo' => '0007', 'designacao' => 'GT ' . date('Y'), 'empresa_id' => $empresa->id, 'tipo' => 'guia-transporte', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
                ['codigo' => '0008', 'designacao' => 'GR ' . date('Y'), 'empresa_id' => $empresa->id, 'tipo' => 'guia-remessa', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
                ['codigo' => '0009', 'designacao' => 'RD ' . date('Y'), 'empresa_id' => $empresa->id, 'tipo' => 'receita-despesa', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
                ['codigo' => '00010', 'designacao' => 'SC ' . date('Y'), 'empresa_id' => $empresa->id, 'tipo' => 'stock', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ]);

            DB::table('motivo_anulacaos')->insert([
                ['codigo' => '0001', 'designacao' => 'Anulação', 'descricao' => '', 'empresa_id' => $empresa->id, 'status' => true],
                ['codigo' => '0002', 'designacao' => 'Rectificação', 'descricao' => '', 'empresa_id' => $empresa->id, 'status' => true],

            ]);

            DB::table('tipo_motivo_anulacaos')->insert([
                ['codigo' => '0001', 'designacao' => 'Ausência de desconto na fatura', 'descricao' => '', 'empresa_id' => $empresa->id, 'status' => true],
                ['codigo' => '0002', 'designacao' => 'Devolução dos artigos', 'descricao' => '', 'empresa_id' => $empresa->id, 'status' => true],
                ['codigo' => '0003', 'designacao' => 'Erro na entidade', 'descricao' => '', 'empresa_id' => $empresa->id, 'status' => true],
                ['codigo' => '0004', 'designacao' => 'Erros nas quantidades / preços', 'descricao' => '', 'empresa_id' => $empresa->id, 'status' => true],
                ['codigo' => '0005', 'designacao' => 'Erro no (s) preço (s)', 'descricao' => '', 'empresa_id' => $empresa->id, 'status' => true],
                ['codigo' => '0006', 'designacao' => 'Produto / serviço rejeitado', 'descricao' => '', 'empresa_id' => $empresa->id, 'status' => true],
                ['codigo' => '0007', 'designacao' => 'Rutura de stock', 'descricao' => '', 'empresa_id' => $empresa->id, 'status' => true],

            ]);

            DB::table('armazems')->insert([
                ['codigo' => '0001', 'designacao' => 'Sede', 'empresa_id' => $empresa->id, 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ]);

            DB::table('fabricantes')->insert([
                ['codigo' => '0001', 'designacao' => 'Diverso', 'empresa_id' => $empresa->id, 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ]);

            DB::table('categorias')->insert([
                ['codigo' => '0001', 'designacao' => 'Diverso', 'empresa_id' => $empresa->id, 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ]);

            DB::table('tipos')->insert([
                ['codigo' => 'P', 'designacao' => 'Produto', 'empresa_id' => $empresa->id, 'descricao' => 'Produtos', 'status' => true],
                ['codigo' => 'S', 'designacao' => 'Serviços', 'empresa_id' => $empresa->id, 'descricao' => 'Serviços', 'status' => true],
            ]);

            DB::table('formas_pagamentos')->insert([
                ['codigo' => '0001', 'designacao' => 'Dinheiro', 'empresa_id' => $empresa->id, 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
                ['codigo' => '0002', 'designacao' => 'Transferência', 'empresa_id' => $empresa->id, 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ]);

            DB::table('clientes')->insert([
                [
                    'codigo' => date('Y-0001'),
                    'designacao' => 'Consumidor Final',
                    'contribuinte' => 'Consumidor Final',
                    'id_endereco' => Endereco::where('empresa_id', $empresa->id)->first()->id,
                    'id_contacto' => Contacto::where('empresa_id', $empresa->id)->first()->id,
                    'imagem' => 'null.png',
                    'status' => true,
                    'empresa_id' => $empresa->id,
                ],
            ]);

            DB::table('fornecedors')->insert([
                [
                    'codigo' => date('Y-0001'),
                    'designacao' => 'Diverso',
                    'contribuinte' => '999999999',
                    'id_endereco' => Endereco::where('empresa_id', $empresa->id)->first()->id,
                    'id_contacto' => Contacto::where('empresa_id', $empresa->id)->first()->id,
                    'imagem' => 'null.png',
                    'empresa_id' => $empresa->id,
                    'status' => true,
                ],
            ]);

            DB::commit();
            return redirect('empresa/utilizadores');

        } catch (\Throwable $th) {
            //throw $th;
            // return response()->json([$th->getMessage(),  'line' => $th->getLine()]);
            // DB::rollback();
            return redirect()->back()->withErrors(['Ocorreu um erro ao tentar gerar os dados. Por favor, tente novamente.'])->withInput();

        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function default()
    {
        // Verifica se o id da empresa do usuário não é 1
        if (Auth::user()->empresa_id != 1) {
            return redirect('/empresa'); // Redireciona para /empresa se não for a empresa com id 1
        }
        
        // Lista todas as empresas onde o id não é igual a 1
        $dados = Empresa::where('id', '!=', Auth::user()->empresa_id)->get();
        
        // Define uma variável para indicar que é uma operação de criação (isCreate)
        $isCreate = true;
        
        // Retorna a view 'empresa.index' passando os dados das empresas e a variável isCreate
        return view('empresa.index', compact('dados', 'isCreate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $isCreate = Auth::user()->empresa_id == 1? true: false;
        $dados = Endereco::getEntityEnderecoContacto($id, 'empresas');
        return view('empresa.edit', compact('dados', 'isCreate'));
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
        $dados = Empresa::find($id);
        $dados->designacao = $request->input('designacao');
        $dados->nif = $request->input('nif');
        $dados->registo_comercial = $request->input('registo_comercial');
        $dados->data_fundacao = $request->input('data_fundacao');
        $dados->csocial = $request->input('csocial');
        $dados->representante = $request->input('representante');
        $dados->ndi_rep = $request->input('ndi_rep');
        $dados->descricao = $request->input('descricao');
        $dados->foto = ($request->file('file')) ? Helpers::uploadFile($request, 'file') : $dados->foto;
        $dados->status = ($request->input('status')) ? true : false;
        $dados->prazo_inicio = $request->prazo_inicio ?? null;
        $dados->prazo_termino = $request->prazo_termino ?? null;
        $dados->save();

        //Endereco
        $dados_endereco = Endereco::find($dados->id_endereco);
        $dados_endereco->pais = $request->input('pais');
        $dados_endereco->cidade = $request->input('cidade');
        $dados_endereco->endereco = $request->input('endereco');

        $dados_endereco->save();

        //Contacto
        $dados_contacto = Contacto::find($dados->id_contacto);
        $dados_contacto->telefone = $request->input('telefone');
        $dados_contacto->fax = $request->input('fax');
        $dados_contacto->telemovel = $request->input('telemovel');
        $dados_contacto->contacto = $request->input('contacto');
        $dados_contacto->email = $request->input('email');
        $dados_contacto->facebook = $request->input('facebook');
        $dados_contacto->whatsapp = $request->input('whatsapp');
        $dados_contacto->skype = $request->input('skype');
        $dados_contacto->twitter = $request->input('twitter');
        $dados_contacto->linkedin = $request->input('linkedin');
        $dados_contacto->website = $request->input('website');
        

        $dados_contacto->save();

        return redirect('/empresa')->with('success', 'Sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $dados = Empresa::find($id);
        $dados->delete();
        return redirect('/empresa')->with('success', 'Sucesso');
    }
}
