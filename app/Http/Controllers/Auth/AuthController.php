<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Contacto;
use App\Empresa;
use App\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function create(Request $request)
    {

        $faker = Faker\Factory::create();

        $empresa = new Empresa();
        $empresa->designacao = $request->designacao ?? "DEFAULT";
        $empresa->nif = $request->nif ?? 'DEFAULT';
        $empresa->registo_comercial = '0000000000';
        $empresa->data_fundacao = $faker->dateTime();
        $empresa->csocial = "00000000";
        $empresa->representante = 'DEFAULT';
        $empresa->ndi_rep = '00000000';
        $empresa->descricao = '';
        $empresa->foto = 'null.png';
        $empresa->status = true;
        $empresa->save();

        DB::table('enderecos')->insert([
            [
                'empresa_id' => $empresa->id,
                'pais' => 'Angola',
                'cidade' => 'Luanda',
                'endereco' => $faker->country(),
            ],
        ]);

        DB::table('contactos')->insert([
            [
                'empresa_id' => $empresa->id,
                'telefone' => '911222333',
                'telemovel' => '911222333',
                'email' => $faker->email(),
            ],
        ]);

        $empresa->update(['id_endereco' => Endereco::where('empresa_id', $empresa->id)->first()->id, 'id_contacto' => Contacto::where('empresa_id', $empresa->id)->first()->id]);

        // DB::table('agts')->insert([
        //     [
        //         'private_key' => 'MIICXAIBAAKBgQC4dcYScJrnD1xCbBAlSwQN80TYmlMhC1q3fqyL0y2ygQOmtKKYJkDDp/bx0F7ZJ4psVDAmJ1PC2SlHfVPtSZrsVTIf/OlWMsrkLQ+bSf2vJuzUgDagZ/htowIn3io6myiY+Ehq9vDjCd65XV/Hq2sDZoksXMpQU8kQoIF4P2oJqwIDAQABAoGBAJdMauHXIQdjDv6gWoHsTPAQWKj9tC/He2pE6cxqs/HVZqRHR5Ja1gZl7+SaUCH4D88ZIsE4wrhwnS45OyzHkdzg6pe1CNhKi1Md3pCsDSzuyes0KpW6Gl1WeNWo4gLd0cxd0shLtq6aUPW17RMGq2qqEbfH4THB21/8OrHz+A25AkEA2sZTr+ea759PgO9W24uRx4NwPhfOObYzc4SVwNJlkxMmkUBIgKzTXykKyHRVI5V55mUf2c7Fmrbh7Q7eHMFeXQJBANfYuWkMspfSotDMMewIy6Vu5Z4WTAM3VqVlWU0YwsTOxJtuYbQejStDBz9mBCLGZpmJXlhRG9TYKxLt82cFt6cCQFoqFt+OcpqDa/7VpVSCZyh1EVNl+EZswzO+1wFLNTWyVNjUR41QrSSxA5Kt71DlEAJWdxQLVgF3khFjaUMsprkCQEmNzBkVP6LnH56hhv2VPbiBYvQNSxfperhgIh9Yqb6ha3RAGEFmC9tLOyQKoqwrCfmWSzUzZpWQmJUZy1E3LI8CQAWL67LsimFT8lsq+6RiwOSWHlMHFCtpqDLCbWA0PgDNYBmE5HBjyLHC/Fyv7LtSRAnsKJP71VOwQJJKw2PUbQA=',
        //         'public_key' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC4dcYScJrnD1xCbBAlSwQN80TYmlMhC1q3fqyL0y2ygQOmtKKYJkDDp/bx0F7ZJ4psVDAmJ1PC2SlHfVPtSZrsVTIf/OlWMsrkLQ+bSf2vJuzUgDagZ/htowIn3io6myiY+Ehq9vDjCd65XV/Hq2sDZoksXMpQU8kQoIF4P2oJqwIDAQAB',
        //     ],
        // ]);

        DB::table('permissions')
            ->insert([
                [
                    'empresa_id' => $empresa->id,
                    'name' => 'pos',
                    'guard_name' => 'web',
                ],
                [
                    'empresa_id' => $empresa->id,
                    'name' => 'painel',
                    'guard_name' => 'web',
                ],
                [
                    'empresa_id' => $empresa->id,
                    'name' => 'artigo',
                    'guard_name' => 'web',
                ],
                [
                    'empresa_id' => $empresa->id,
                    'name' => 'receita_despesa',
                    'guard_name' => 'web',
                ],
                [
                    'empresa_id' => $empresa->id,
                    'name' => 'cliente',
                    'guard_name' => 'web',
                ],
                [
                    'empresa_id' => $empresa->id,
                    'name' => 'documento',
                    'guard_name' => 'web',
                ],
                [
                    'empresa_id' => $empresa->id,
                    'name' => 'relatorio',
                    'guard_name' => 'web',
                ],
                [
                    'empresa_id' => $empresa->id,
                    'name' => 'configuracoes',
                    'guard_name' => 'web',
                ],
            ]);

        DB::table('roles')
            ->insert([
                [
                    'empresa_id' => $empresa->id,
                    'name' => 'Administrador',
                    'guard_name' => 'web',
                ],
                [
                    'empresa_id' => $empresa->id,
                    'name' => 'Gestor',
                    'guard_name' => 'web',
                ],
                [
                    'empresa_id' => $empresa->id,
                    'name' => 'Operador',
                    'guard_name' => 'web',
                ],
                [
                    'empresa_id' => $empresa->id,
                    'name' => 'Operador POS',
                    'guard_name' => 'web',
                ],
            ]);

        for ($i = 1; $i <= 8; $i++) {
            DB::table('role_has_permissions')
                ->insert([
                    [
                        'empresa_id' => $empresa->id,
                        'permission_id' => $i,
                        'role_id' => 1,
                    ],
                ]);
        }

        for ($i = 1; $i <= 7; $i++) {
            DB::table('role_has_permissions')
                ->insert([
                    [
                        'empresa_id' => $empresa->id,
                        'permission_id' => $i,
                        'role_id' => 2,
                    ],
                ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            DB::table('role_has_permissions')
                ->insert([
                    [
                        'empresa_id' => $empresa->id,
                        'permission_id' => $i,
                        'role_id' => 3,
                    ],
                ]);
        }

        for ($i = 1; $i <= 1; $i++) {
            DB::table('role_has_permissions')
                ->insert([
                    [
                        'empresa_id' => $empresa->id,
                        'permission_id' => $i,
                        'role_id' => 4,
                    ],
                ]);
        }

        DB::table('users')->insert([
            [
                'nome' => 'Administrador',
                'email' => 'admin@admin.com',
                'departamento_id' => 1,
                'password' => Hash::make(123),
                'empresa_id' => $empresa->id,
                'foto' => 'default.jpg',
                'status' => 1,
            ],
        ]);

        DB::table('model_has_roles')->insert([
            [
                'empresa_id' => $empresa->id,
                'role_id' => 1,
                'model_type' => 'App\User',
                'model_id' => 1,
            ],
        ]);

        DB::table('departamentos')->insert([
            ['codigo' => '0001', 'empresa_id' => $empresa->id, 'designacao' => 'Administração', 'descricao' => 'Administração', 'status' => true],
            ['codigo' => '0001', 'empresa_id' => $empresa->id, 'designacao' => 'Gestão', 'descricao' => 'Gestão', 'status' => true],
            ['codigo' => '0001', 'empresa_id' => $empresa->id, 'designacao' => 'Vendas', 'descricao' => 'Vendas', 'status' => true],
        ]);

        # /*********************** */

        DB::table('tax_tables')->insert([
            [
                'empresa_id' => $empresa->id,
                'tax_type' => 'IVA',
                'tax_code' => 'ISE',
                'description' => 'IVA - Isento',
                'tax_percentage' => '0.00',
            ],
        ]);

        DB::table('saft_audits')->insert([
            [
                'empresa_id' => $empresa->id,
                'audit_file_version' => '1.01_01',
                'company_id' => '000000000',
                'tax_registration_number' => '5000213438',
                'tax_accounting_basis' => 'F',
            ],
        ]);

        DB::table('pais')->insert([
            [
                'empresa_id' => $empresa->id,
                'designacao' => 'Angola',
                'sigla' => 'AO',
                'status' => true,
            ],
            [
                'empresa_id' => $empresa->id,
                'designacao' => 'Portugal',
                'sigla' => 'PT',
                'status' => true,
            ],
        ]);

        // DB::table('empresas')->insert([
        //     [
        //         'designacao' => "DEFAULT",
        //         'nif' => 'DEFAULT',
        //         'registo_comercial' => '5484084610',
        //         'data_fundacao' => $faker->dateTime(),
        //         'csocial' => '5484084610' /* $faker->randomNumber(8) */,
        //         'representante' => 'DEFAULT',
        //         'ndi_rep' => '5484084610',
        //         'descricao' => '',
        //         'foto' => 'null.png',
        //         'status' => true,
        //         'id_endereco' => 1,
        //         'id_contacto' => 1,
        //     ],
        // ]);

        DB::table('impostos')->insert([
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M00', 'designacao' => 'M00 - Regime Simplificado', 'taxa' => 0, 'motivo' => 'Regime Simplificado', 'status' => true],
            ['tipo' => 'IVA', 'empresa_id' => $empresa->id, 'codigo' => '', 'designacao' => 'IVA', 'taxa' => 14, 'motivo' => '', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M02', 'designacao' => 'M02 - Transmissão de bens e serviço não sujeita', 'taxa' => 0, 'motivo' => 'Regime Simplificado', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M04', 'designacao' => 'M04 - Regime de Exclusão', 'taxa' => 0, 'motivo' => 'Regime Simplificado', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M11', 'designacao' => 'M11 - Isento nos termos da alínea b) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea b) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M12', 'designacao' => 'M12 - Isento nos termos da alínea c) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea c) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M13', 'designacao' => 'M13 - Isento nos termos da alínea d) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea d) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M14', 'designacao' => 'M14 - Isento nos termos da alínea e) do nº1 do artigo 12. do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea e) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M15', 'designacao' => 'M15 - Isento nos termos da alínea f) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea f) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M16', 'designacao' => 'M16 - Isento nos termos da alínea g) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea g) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M17', 'designacao' => 'M17 - Isento nos termos da alínea h) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea h) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M18', 'designacao' => 'M18 - Isento nos termos da alínea i) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea i) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M19', 'designacao' => 'M19 - Isento nos termos da alínea j) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alnea j) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M20', 'designacao' => 'M20 - Isento nos termos da alínea k) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea k) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M21', 'designacao' => 'M21 - Isento nos termos da alínea l) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea l) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M22', 'designacao' => 'M22 - Isento nos termos da alínea m) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea m) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M23', 'designacao' => 'M23 - Isento nos termos da alínea n) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea n) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M24', 'designacao' => 'M24 - Isento nos termos da alínea o) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea o) do nº1 do artigo 12. do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M80', 'designacao' => 'M80 - Isento nos termos da alnea a) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea a) do nº1 do artigo 14.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M81', 'designacao' => 'M81 - Isento nos termos da alínea b) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea b) do nº1 do artigo 14.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M82', 'designacao' => 'M82 - Isento nos termos da alínea c) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea c) do nº1 do artigo 14.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M83', 'designacao' => 'M83 - Isento nos termos da alínea d) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea d) do nº1 do artigo 14.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M84', 'designacao' => 'M84 - Isento nos termos da alínea e) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea e) do nº1 do artigo 14.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M85', 'designacao' => 'M85 - Isento nos termos da alínea a) do nº2 do artigo 14. do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea a) do nº2 do artigo 14.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M86', 'designacao' => 'M86 - Isento nos termos da alínea b) do nº2 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea b) do nº2 do artigo 14.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M30', 'designacao' => 'M30 - Isento nos termos da alínea a) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea a) do artigo 15. do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M31', 'designacao' => 'M31 - Isento nos termos da alnea b) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea b) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M32', 'designacao' => 'M32 - Isento nos termos da alínea c) do artigo 15. do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea c) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M33', 'designacao' => 'M33 - Isento nos termos da alínea d) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea d) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M34', 'designacao' => 'M34 - Isento nos termos da alínea e) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea e) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M35', 'designacao' => 'M35 - Isento nos termos da alínea f) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea f) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M36', 'designacao' => 'M36 - Isento nos termos da alínea g) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea g) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M37', 'designacao' => 'M37 - Isento nos termos da alínea h) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea h) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M38', 'designacao' => 'M38 - Isento nos termos da alínea i) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea i) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M90', 'designacao' => 'M90 - Isento nos termos da alinea a) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea a) do nº1 do artigo 16.', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M91', 'designacao' => 'M91 - Isento nos termos da alinea b) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea b) do nº1 do artigo 16.º', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M92', 'designacao' => 'M92 - Isento nos termos da alinea c) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea c) do nº1 do artigo 16.º', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M93', 'designacao' => 'M93 - Isento nos termos da alinea d) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea d) do nº1 do artigo 16.º', 'status' => true],
            ['tipo' => 'ISENTO', 'empresa_id' => $empresa->id, 'codigo' => 'M93', 'designacao' => 'M94 - Isento nos termos da alinea e) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea e) do nº1 do artigo 16.', 'status' => true],
        ]);

        DB::table('retencaos')->insert([
            ['designacao' => 'Sem rentenção na fonte', 'empresa_id' => $empresa->id, 'taxa' => 0, 'status' => true],
            ['designacao' => 'Rentenção na fonte 6.5%', 'empresa_id' => $empresa->id, 'taxa' => 6.5, 'status' => true],
        ]);

        /*   DB::table('bancos')->insert([
        ['nome' => 'BFA', 'numero' => '062248130110', 'iban' => '000600000172248130110'],
        ['nome' => 'BAI', 'numero' => '402248130110', 'iban' => '004000000172248130110'],
        ]); */

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
            ['designacao' => 'Numerrio', 'empresa_id' => $empresa->id],
            ['designacao' => 'Transferência Bancária', 'empresa_id' => $empresa->id],
        ]);

        DB::table('series')->insert([
            ['codigo' => '0001', 'designacao' => 'PP ', 'empresa_id' => $empresa->id, 'tipo' => 'proforma', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0002', 'designacao' => 'FT ', 'empresa_id' => $empresa->id, 'tipo' => 'factura', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0003', 'designacao' => 'FR ', 'empresa_id' => $empresa->id, 'tipo' => 'factura-recibo', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0004', 'designacao' => 'RC ', 'empresa_id' => $empresa->id, 'tipo' => 'recibo', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0005', 'designacao' => 'NC ', 'empresa_id' => $empresa->id, 'tipo' => 'nota-credito', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0006', 'designacao' => 'ND ', 'empresa_id' => $empresa->id, 'tipo' => 'nota-debito', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0007', 'designacao' => 'GT ', 'empresa_id' => $empresa->id, 'tipo' => 'guia-transporte', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0008', 'designacao' => 'GR ', 'empresa_id' => $empresa->id, 'tipo' => 'guia-remessa', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0009', 'designacao' => 'RD ', 'empresa_id' => $empresa->id, 'tipo' => 'receita-despesa', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '00010', 'designacao' => 'SC ', 'empresa_id' => $empresa->id, 'tipo' => 'stock', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
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

    }
}
