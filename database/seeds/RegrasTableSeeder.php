<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegrasTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker\Factory::create();

        DB::table('agts')->insert([
            [
                'private_key' => 'MIICXAIBAAKBgQC4dcYScJrnD1xCbBAlSwQN80TYmlMhC1q3fqyL0y2ygQOmtKKYJkDDp/bx0F7ZJ4psVDAmJ1PC2SlHfVPtSZrsVTIf/OlWMsrkLQ+bSf2vJuzUgDagZ/htowIn3io6myiY+Ehq9vDjCd65XV/Hq2sDZoksXMpQU8kQoIF4P2oJqwIDAQABAoGBAJdMauHXIQdjDv6gWoHsTPAQWKj9tC/He2pE6cxqs/HVZqRHR5Ja1gZl7+SaUCH4D88ZIsE4wrhwnS45OyzHkdzg6pe1CNhKi1Md3pCsDSzuyes0KpW6Gl1WeNWo4gLd0cxd0shLtq6aUPW17RMGq2qqEbfH4THB21/8OrHz+A25AkEA2sZTr+ea759PgO9W24uRx4NwPhfOObYzc4SVwNJlkxMmkUBIgKzTXykKyHRVI5V55mUf2c7Fmrbh7Q7eHMFeXQJBANfYuWkMspfSotDMMewIy6Vu5Z4WTAM3VqVlWU0YwsTOxJtuYbQejStDBz9mBCLGZpmJXlhRG9TYKxLt82cFt6cCQFoqFt+OcpqDa/7VpVSCZyh1EVNl+EZswzO+1wFLNTWyVNjUR41QrSSxA5Kt71DlEAJWdxQLVgF3khFjaUMsprkCQEmNzBkVP6LnH56hhv2VPbiBYvQNSxfperhgIh9Yqb6ha3RAGEFmC9tLOyQKoqwrCfmWSzUzZpWQmJUZy1E3LI8CQAWL67LsimFT8lsq+6RiwOSWHlMHFCtpqDLCbWA0PgDNYBmE5HBjyLHC/Fyv7LtSRAnsKJP71VOwQJJKw2PUbQA=',
                'public_key' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC4dcYScJrnD1xCbBAlSwQN80TYmlMhC1q3fqyL0y2ygQOmtKKYJkDDp/bx0F7ZJ4psVDAmJ1PC2SlHfVPtSZrsVTIf/OlWMsrkLQ+bSf2vJuzUgDagZ/htowIn3io6myiY+Ehq9vDjCd65XV/Hq2sDZoksXMpQU8kQoIF4P2oJqwIDAQAB',
            ]
        ]);


        DB::table('tax_tables')->insert([
            [
                'tax_type' => 'IVA',
                'tax_code' => 'ISE',
                'description' => 'IVA - Isento',
                'tax_percentage' => '0.00',
            ]
        ]);

        DB::table('saft_audits')->insert([
            [
                'audit_file_version' => '1.01_01',
                'company_id' => '000000000',
                'tax_registration_number' => '5000213438',
                'tax_accounting_basis' => 'F',
            ]
        ]);

        DB::table('pais')->insert([
            [
                'designacao' => 'Angola',
                'sigla' => 'AO',
                'status' => true,
            ],
            [
                'designacao' => 'Portugal',
                'sigla' => 'PT',
                'status' => true,
            ]
        ]);

        DB::table('enderecos')->insert([
            [
                'pais' => 'Angola',
                'cidade' => 'Luanda',
                'endereco' => $faker->country(),

            ]
        ]);


        DB::table('contactos')->insert([
            [
                'telefone' => '911222333',
                'telemovel' => '911222333',
                'email' => $faker->email(),
            ]
        ]);

        DB::table('empresas')->insert([
            [
                'designacao' => "DEFAULT",
                'nif' => 'DEFAULT',
                'registo_comercial' => '5484084610',
                'data_fundacao' => $faker->dateTime(),
                'csocial' => '5484084610' /* $faker->randomNumber(8) */,
                'representante' => 'DEFAULT',
                'ndi_rep' => '5484084610',
                'descricao' => '',
                'foto' => 'null.png',
                'status' => true,
                'id_endereco' => 1,
                'id_contacto' => 1,
            ]
        ]);

        DB::table('impostos')->insert([
            ['tipo' => 'ISENTO', 'codigo' => 'M00', 'designacao' => 'M00 - Regime Simplificado', 'taxa' => 0, 'motivo' => 'Regime Simplificado', 'status' => true],
            ['tipo' => 'IVA', 'codigo' => '', 'designacao' => 'IVA', 'taxa' => 14, 'motivo' => '', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M02', 'designacao' => 'M02 - Transmissão de bens e serviço não sujeita', 'taxa' => 0, 'motivo' => 'Regime Simplificado', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M04', 'designacao' => 'M04 - Regime de Exclusão', 'taxa' => 0, 'motivo' => 'Regime Simplificado', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M11', 'designacao' => 'M11 - Isento nos termos da alínea b) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea b) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M12', 'designacao' => 'M12 - Isento nos termos da alínea c) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea c) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M13', 'designacao' => 'M13 - Isento nos termos da alínea d) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea d) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M14', 'designacao' => 'M14 - Isento nos termos da alínea e) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea e) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M15', 'designacao' => 'M15 - Isento nos termos da alínea f) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea f) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M16', 'designacao' => 'M16 - Isento nos termos da alínea g) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea g) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M17', 'designacao' => 'M17 - Isento nos termos da alínea h) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea h) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M18', 'designacao' => 'M18 - Isento nos termos da alínea i) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea i) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M19', 'designacao' => 'M19 - Isento nos termos da alínea j) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea j) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M20', 'designacao' => 'M20 - Isento nos termos da alínea k) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea k) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M21', 'designacao' => 'M21 - Isento nos termos da alínea l) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea l) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M22', 'designacao' => 'M22 - Isento nos termos da alínea m) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea m) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M23', 'designacao' => 'M23 - Isento nos termos da alínea n) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea n) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M24', 'designacao' => 'M24 - Isento nos termos da alínea o) do nº1 do artigo 12.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea o) do nº1 do artigo 12.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M80', 'designacao' => 'M80 - Isento nos termos da alínea a) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea a) do nº1 do artigo 14.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M81', 'designacao' => 'M81 - Isento nos termos da alínea b) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea b) do nº1 do artigo 14.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M82', 'designacao' => 'M82 - Isento nos termos da alínea c) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea c) do nº1 do artigo 14.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M83', 'designacao' => 'M83 - Isento nos termos da alínea d) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea d) do nº1 do artigo 14.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M84', 'designacao' => 'M84 - Isento nos termos da alínea e) do nº1 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea e) do nº1 do artigo 14.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M85', 'designacao' => 'M85 - Isento nos termos da alínea a) do nº2 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea a) do nº2 do artigo 14.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M86', 'designacao' => 'M86 - Isento nos termos da alínea b) do nº2 do artigo 14.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea b) do nº2 do artigo 14.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M30', 'designacao' => 'M30 - Isento nos termos da alínea a) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea a) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M31', 'designacao' => 'M31 - Isento nos termos da alínea b) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea b) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M32', 'designacao' => 'M32 - Isento nos termos da alínea c) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea c) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M33', 'designacao' => 'M33 - Isento nos termos da alínea d) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea d) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M34', 'designacao' => 'M34 - Isento nos termos da alínea e) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea e) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M35', 'designacao' => 'M35 - Isento nos termos da alínea f) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea f) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M36', 'designacao' => 'M36 - Isento nos termos da alínea g) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea g) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M37', 'designacao' => 'M37 - Isento nos termos da alínea h) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea h) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M38', 'designacao' => 'M38 - Isento nos termos da alínea i) do artigo 15.º do CIVA', 'taxa' => 0, 'motivo' => 'Isento nos termos da alínea i) do artigo 15.º do CIVA', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M90', 'designacao' => 'M90 - Isento nos termos da alinea a) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea a) do nº1 do artigo 16.º', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M91', 'designacao' => 'M91 - Isento nos termos da alinea b) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea b) do nº1 do artigo 16.º', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M92', 'designacao' => 'M92 - Isento nos termos da alinea c) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea c) do nº1 do artigo 16.º', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M93', 'designacao' => 'M93 - Isento nos termos da alinea d) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea d) do nº1 do artigo 16.º', 'status' => true],
            ['tipo' => 'ISENTO', 'codigo' => 'M93', 'designacao' => 'M94 - Isento nos termos da alinea e) do nº1 do artigo 16.º', 'taxa' => 0, 'motivo' => 'Isento nos termos da alinea e) do nº1 do artigo 16.º', 'status' => true],
        ]);

        DB::table('retencaos')->insert([
            ['designacao' => 'Sem rentenção na fonte', 'taxa' => 0, 'status' => true],
            ['designacao' => 'Rentenção na fonte 6.5%', 'taxa' => 6.5, 'status' => true],
        ]);

      /*   DB::table('bancos')->insert([
            ['nome' => 'BFA', 'numero' => '062248130110', 'iban' => '000600000172248130110'],
            ['nome' => 'BAI', 'numero' => '402248130110', 'iban' => '004000000172248130110'],
        ]); */


        DB::table('moedas')->insert([
            ['designacao' => 'Kwanza'],
            ['designacao' => 'Dollar'],
        ]);

        DB::table('condicoes_pagamentos')->insert([
            ['designacao' => 'Pronto Pagemento'],
            ['designacao' => '30 Dias'],
            ['designacao' => '60 Dias'],
            ['designacao' => '90 Dias'],
            ['designacao' => '120 Dias'],
        ]);

        DB::table('modo_pagamentos')->insert([
            ['designacao' => 'Cheque'],
            ['designacao' => 'Numerário'],
            ['designacao' => 'Transferência Bancária'],
        ]);

        DB::table('series')->insert([
            ['codigo' => '0001', 'designacao' => 'PP ' . date('Y'), 'tipo' => 'proforma', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0002', 'designacao' => 'FT ' . date('Y'), 'tipo' => 'factura', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0003', 'designacao' => 'FR ' . date('Y'), 'tipo' => 'factura-recibo', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0004', 'designacao' => 'RC ' . date('Y'), 'tipo' => 'recibo', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0005', 'designacao' => 'NC ' . date('Y'), 'tipo' => 'nota-credito', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0006', 'designacao' => 'ND ' . date('Y'), 'tipo' => 'nota-debito', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0007', 'designacao' => 'GT ' . date('Y'), 'tipo' => 'guia-transporte', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0008', 'designacao' => 'GR ' . date('Y'), 'tipo' => 'guia-remessa', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0009', 'designacao' => 'RD ' . date('Y'), 'tipo' => 'receita-despesa', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '00010', 'designacao' => 'SC ' . date('Y'), 'tipo' => 'stock', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
        ]);


        DB::table('motivo_anulacaos')->insert([
            ['codigo' => '0001', 'designacao' => 'Anulação', 'descricao' => '', 'status' => true],
            ['codigo' => '0002', 'designacao' => 'Rectificação', 'descricao' => '', 'status' => true],

        ]);

        DB::table('tipo_motivo_anulacaos')->insert([
            ['codigo' => '0001', 'designacao' => 'Ausência de desconto na fatura', 'descricao' => '', 'status' => true],
            ['codigo' => '0002', 'designacao' => 'Devolução dos artigos', 'descricao' => '', 'status' => true],
            ['codigo' => '0003', 'designacao' => 'Erro na entidade', 'descricao' => '', 'status' => true],
            ['codigo' => '0004', 'designacao' => 'Erros nas quantidades / preços', 'descricao' => '', 'status' => true],
            ['codigo' => '0005', 'designacao' => 'Erro no (s) preço (s)', 'descricao' => '', 'status' => true],
            ['codigo' => '0006', 'designacao' => 'Produto / serviço rejeitado', 'descricao' => '', 'status' => true],
            ['codigo' => '0007', 'designacao' => 'Rutura de stock', 'descricao' => '', 'status' => true],

        ]);



        DB::table('armazems')->insert([
            ['codigo' => '0001', 'designacao' => 'Sede', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
        ]);

        DB::table('fabricantes')->insert([
            ['codigo' => '0001', 'designacao' => 'Diverso', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
        ]);

        DB::table('categorias')->insert([
            ['codigo' => '0001', 'designacao' => 'Diverso', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
        ]);

        DB::table('tipos')->insert([
            ['codigo' => 'P', 'designacao' => 'Produto', 'descricao' => 'Produtos', 'status' => true],
            ['codigo' => 'S', 'designacao' => 'Serviços', 'descricao' => 'Serviços', 'status' => true],
        ]);


        DB::table('formas_pagamentos')->insert([
            ['codigo' => '0001', 'designacao' => 'Dinheiro', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0002', 'designacao' => 'Transferência', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
        ]);



        DB::table('clientes')->insert([
          [
              'codigo' => date('Y-0001'),
              'designacao' => 'Consumidor Final',
              'contribuinte' => 'Consumidor Final',
              'id_endereco' => 1,
              'id_contacto' => 1,
              'imagem' => 'null.png',
              'status' => true,
          ]
      ]);

        DB::table('fornecedors')->insert([
          [
              'codigo' => date('Y-0001'),
              'designacao' => 'Diverso',
              'contribuinte' => '999999999',
              'id_endereco' => 1,
              'id_contacto' => 1,
              'imagem' => 'null.png',
              'status' => true,
          ]
      ]);

     /*    DB::table('condicoes_pagamentos')->insert([
            ['codigo' => '0001', 'designacao' => 'Condição-1', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
            ['codigo' => '0002', 'designacao' => 'Condição-2', 'descricao' => $faker->realText(rand(10, 20)), 'status' => true],
        ]);
 */


/*         DB::table('clientes')->insert([
            [
                'codigo' => date('Y-0001'),
                'designacao' => 'Polo De Desenvolvimento Industrial De Viana',
                'contribuinte' => '5401052367',
                'id_endereco' => 1,
                'id_contacto' => 1,
                'imagem' => 'null.png',
                'status' => true,
            ]
        ]);

        for ($i = 1; $i < 4; $i++) {
            DB::table('clientes')->insert([
                [
                    'codigo' => date('Y-000') . ($i + 1),
                    'designacao' => 'Cliente-' . ($i + 1),
                    'contribuinte' => '999999999',
                    'id_endereco' => 1,
                    'id_contacto' => 1,
                    'imagem' => 'null.png',
                    'status' => true,
                ]
            ]);

            DB::table('fornecedors')->insert([
                [
                    'codigo' => date('Y-000') . ($i),
                    'designacao' => 'Fornecedor-' . ($i),
                    'contribuinte' => '999999999',
                    'id_endereco' => 1,
                    'id_contacto' => 1,
                    'imagem' => 'null.png',
                    'status' => true,
                ]
            ]);

            DB::table('artigos')->insert([
                [
                    'codigo' => date('Y-000') . ($i),
                    'designacao' => 'Artigo-' . ($i),
                    'tipo_id' => 1,
                    'categoria_id' => 1,
                    'imposto_id' => 1,
                    'retencao_id' => 1,
                    'preco' => 100,
                    'imagem_1' => 'img-' . $i . '.png',
                    'imagem_2' => 'null.png',
                    'imagem_3' => 'null.png',
                    'fornecedor_id' => 1,
                    'codigo_barra' => '000' . ($i),
                    'is_stock' => ($i % 2 == 0) ? true : false,
                    'stock_minimo' => 0,
                    'stock_maximo' => 10,
                    'observacao' => '',
                    'status' => true,
                ]
            ]);
        } */



    }
}