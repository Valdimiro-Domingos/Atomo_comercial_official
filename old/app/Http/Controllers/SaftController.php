<?php

namespace App\Http\Controllers;

use App\Artigo;
use App\Categoria;
use App\Endereco;
use App\Factura;
use App\Fornecedor;
use App\FacturaRecibo;
use App\NotaCredito;
use App\Proforma;
use App\Recibo;
use App\Saft;
use App\SaftAudit;
use App\TaxTable;
use App\Tipo;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class SaftController extends Controller
{
  public function index()
  {
    $dados = Saft::where('empresa_id', Auth::user()->empresa_id)->orderBy('id', 'DESC')->get();
    return view('agt.saft', compact('dados'));
  }

  public function generate(Request $request)
  {

    $document = '<?xml version="1.0" encoding="UTF-8"?>';
    $document .= '<AuditFile xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="urn:OECD:StandardAuditFile-Tax:PT_1.04_01">';
    $document .= $this->header($request);
    $document .= $this->masterFiles($request);
    $document .= $this->sourceDocuments($request);
    $document .= '</AuditFile>';
    $data = simplexml_load_string($document);

    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($data->saveXML());
    $filename = 'SAFT_AO_' . date('YmdHis') . '.xml';

    // return response()->json($data);

    $dom->save("public/agt/files/$filename");
    $dados = new Saft();
    $dados->filename = $filename;
    $dados->empresa_id = Auth::user()->empresa_id;



    $dados->save();

    return redirect('/saft');
  }


  public function header(Request $request)
  {
    $saftAudit = SaftAudit::first();
    $company = Endereco::getEntityEnderecoContacto(Auth::user()->empresa_id, 'empresas');

    $header = '<Header>
    <AuditFileVersion>1.01_01</AuditFileVersion>
    <CompanyID>' . $company[0]->nif . '</CompanyID>
    <TaxRegistrationNumber>' . $company[0]->nif . '</TaxRegistrationNumber>
    <TaxAccountingBasis>F</TaxAccountingBasis>
    <CompanyName>' . $company[0]->designacao . '</CompanyName>
    <CompanyAddress>
      <AddressDetail>' . $company[0]->endereco . '</AddressDetail>
      <City>' . ($company[0]->cidade ?? 'Luanda') . '</City>
      <Province>' . $company[0]->cidade . '</Province>
      <Country>AO</Country>
    </CompanyAddress>
    <FiscalYear>' . date('Y') . '</FiscalYear>
    <StartDate>' . $request->input('data1') . '</StartDate>
    <EndDate>' . $request->input('data2') . '</EndDate>
    <CurrencyCode>AOA</CurrencyCode>
    <DateCreated>' . date('Y-m-d') . '</DateCreated>
    <TaxEntity>Global</TaxEntity>
    <ProductCompanyTaxID>5484084610</ProductCompanyTaxID>
    <SoftwareValidationNumber>474</SoftwareValidationNumber>
    <ProductID>ATOMO / ATOMO TECNOLOGIA SISTEMA - PRESTAÇAO DE SERVIÇOS, LDA</ProductID>
    <ProductVersion>1.0.0</ProductVersion>
    <Telephone>' . $company[0]->telefone . '</Telephone>
    <Email>' . $company[0]->email . '</Email>
    <Website></Website>
  </Header>';
    return $header;
  }

  public function masterFiles(Request $request)
  {
    $masterFiles = '<MasterFiles>';
    $customer = '';
    foreach (Endereco::where('empresa_id', Auth::user()->empresa_id)->getClientes('clientes') as $key => $value) {

      $customer .= '<Customer>
      <CustomerID>' . $value->id . '</CustomerID>
      <AccountID>Desconhecido</AccountID>
      <CustomerTaxID>' . (($value->contribuinte == 'Consumidor Final') ? '999999999' : $value->contribuinte) . '</CustomerTaxID>
      <CompanyName>' . $value->designacao . '</CompanyName>
      <BillingAddress>
        <AddressDetail>' . $value->endereco . '</AddressDetail>
        <City>' . ($value->cidade ?? 'Luanda') . '</City>
        <Country>AO</Country>
      </BillingAddress>
      <SelfBillingIndicator>0</SelfBillingIndicator>
    </Customer>';
    }
    $masterFiles .= $customer;


    $supplier = '';
    foreach (Endereco::getEntityEnderecoContacto(Fornecedor::where('empresa_id', Auth::user()->empresa_id)->first()->id, 'fornecedors') as $key => $value) {
      $supplier .= '<Supplier>
      <SupplierID>' . $value->id . '</SupplierID>
      <AccountID>Desconhecido</AccountID>
      <SupplierTaxID>' . $value->contribuinte . '</SupplierTaxID>
      <CompanyName>' . $value->designacao . '</CompanyName>
      <BillingAddress>
        <AddressDetail>' . $value->endereco . '</AddressDetail>
        <City>' . $value->cidade . '</City>
        <Country>AO</Country>
      </BillingAddress>
      <SelfBillingIndicator>0</SelfBillingIndicator>
    </Supplier>';
    }
    $masterFiles .= $supplier;


    $product = '';
    foreach (Artigo::all() as $key => $value) {

      $product .= '<Product>
      <ProductType>' . Tipo::where('empresa_id', Auth::user()->empresa_id)->find($value->tipo_id)->codigo . '</ProductType>
      <ProductCode>' . $value->id . '</ProductCode>
      <ProductGroup>' . Categoria::where('empresa_id', Auth::user()->empresa_id)->find($value->categoria_id)->designacao . '</ProductGroup>
      <ProductDescription>' . $value->designacao . '</ProductDescription>
      <ProductNumberCode>' . ($value->codigo_barra ?? $value->id) . '</ProductNumberCode>
    </Product>';
    }

    $masterFiles .= $product;

    $taxTableData = TaxTable::where('empresa_id', Auth::user()->empresa_id)->first();

    $taxTable = '<TaxTable>
    <TaxTableEntry>
      <TaxType>IVA</TaxType>
      <TaxCode>NOR</TaxCode>
      <Description>Normal</Description>
      <TaxPercentage>14.0000</TaxPercentage>
    </TaxTableEntry>
    <TaxTableEntry>
      <TaxType>IVA</TaxType>
      <TaxCode>OUT</TaxCode>
      <Description>IVA - Regime de Exclusão</Description>
      <TaxPercentage>0.0000</TaxPercentage>
    </TaxTableEntry>
    <TaxTableEntry>
      <TaxType>IVA</TaxType>
      <TaxCode>ISE</TaxCode>
      <Description>Transmissão de bens e serviços não sujeita</Description>
      <TaxPercentage>0</TaxPercentage>
    </TaxTableEntry>
  </TaxTable>';
    $masterFiles .= $taxTable;

    $masterFiles .= '</MasterFiles>';
    return $masterFiles;
  }

  public function sourceDocuments(Request $request)
  {


    $sourceDocuments = '<SourceDocuments>';

    // Paulo alteração
    $FT_qty = Factura::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
      ->whereDate('data', '<=', $request->input('data2'))
      ->get()->count();
    $FR_qty = FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
      ->whereDate('data', '<=', $request->input('data2'))
      ->get()->count();
    $NC_qty = NotaCredito::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
      ->whereDate('data', '<=', $request->input('data2'))
      ->get()->count();

    $invoiceData = $this->invoices($request);

    if ($invoiceData) {

      //SalesInvoices
      $salesInvoices = '<SalesInvoices>';
      $numberOfEntries = intval($FT_qty + $FR_qty + $NC_qty);

      $totalCredit = floatval(
        Factura::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
          ->whereDate('data', '<=', $request->input('data2'))
          ->get()->sum('subtotal')
          +
          FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
          ->whereDate('data', '<=', $request->input('data2'))
          ->get()->sum('subtotal')
      );
      $totalDebit = floatval(
        NotaCredito::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
          ->whereDate('data', '<=', $request->input('data2'))
          ->get()->sum('subtotal')
      );
      $salesInvoices .= '<NumberOfEntries>' . $numberOfEntries . '</NumberOfEntries>
      <TotalDebit>' . str_replace(',', '', number_format($totalDebit, 2)) . '</TotalDebit>
      <TotalCredit>' . str_replace(',', '', number_format($totalCredit, 2)) . '</TotalCredit>';

      $salesInvoices .= $invoiceData;
      $salesInvoices .= '</SalesInvoices>';

      $sourceDocuments .= $salesInvoices;
    }
    //WorkingDocuments
    $workingDocuments = '<WorkingDocuments>';
    $numberOfEntries = intval(
      Proforma::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
        ->whereDate('data', '<=', $request->input('data2'))
        ->get()->count()
    );
    $totalCredit = floatval(
      Proforma::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
        ->whereDate('data', '<=', $request->input('data2'))
        ->get()->sum('subtotal')
    );
    $totalDebit = floatval(0);
    $workingDocuments .= '<NumberOfEntries>' . $numberOfEntries . '</NumberOfEntries>
    <TotalDebit>' . str_replace(',', '', number_format($totalDebit, 2)) . '</TotalDebit>
    <TotalCredit>' . str_replace(',', '', number_format($totalCredit, 2)) . '</TotalCredit>';
    $workDocuments = $this->workDocuments($request);
    $workingDocuments .= $workDocuments;
    $workingDocuments .= '</WorkingDocuments>';
    $sourceDocuments .= $workingDocuments;

    //Payments
    $payments = '<Payments>';
    $numberOfEntries = intval(
      Recibo::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
        ->whereDate('data', '<=', $request->input('data2'))
        ->get()->count()
    );
    $totalCredit = floatval(
      Recibo::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
        ->whereDate('data', '<=', $request->input('data2'))
        ->get()->sum('subtotal')
    );
    $totalDebit = floatval(0);
    $payments .= '<NumberOfEntries>' . $numberOfEntries . '</NumberOfEntries>
      <TotalDebit>' . str_replace(',', '', number_format($totalDebit, 2)) . '</TotalDebit>
      <TotalCredit>' . str_replace(',', '', number_format($totalCredit, 2)) . '</TotalCredit>';

    $payment = $this->payment($request);

    $payments .= $payment;
    $payments .= '</Payments>';

    $sourceDocuments .= $payments;

    $sourceDocuments .= '</SourceDocuments>';

    return $sourceDocuments;
  }

  //Geração das Fatura, Fatura Recibo, Nota Debito
  public function invoices(Request $request)
  {
    $invoices = '';


    foreach (Factura::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
      ->whereDate('data', '<=', $request->input('data2'))
      ->get() as $key => $value) {
      $invoices .= $this->invoice($value, 'factura');
    }

    foreach (FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
      ->whereDate('data', '<=', $request->input('data2'))
      ->get() as $key => $value) {
      $invoices .= $this->invoice($value, 'factura-recibo');
    }

    foreach (NotaCredito::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
      ->whereDate('data', '<=', $request->input('data2'))
      ->get() as $key => $value) {
      $invoices .= $this->invoice($value, 'nota-credito');
    }

    return $invoices;
  }

  public function invoice($value, $tipo)
  {

    $invoice = '';
    $invoice .= '<Invoice>
          <InvoiceNo>' . $value->numero . '</InvoiceNo>
          <DocumentStatus>
            <InvoiceStatus>N</InvoiceStatus>
            <InvoiceStatusDate>' . str_replace(" ", "T", date('Y-m-d H:i:s', strtotime($value->created_at))) . '</InvoiceStatusDate>
            <SourceID>' . $value->id . '</SourceID>
            <SourceBilling>P</SourceBilling>
          </DocumentStatus>
          <Hash>' . $value->hash . '</Hash>
          <HashControl>1</HashControl>
          <Period>' . date('m', strtotime($value->created_at)) . '</Period>
          <InvoiceDate>' . date('Y-m-d', strtotime($value->created_at)) . '</InvoiceDate>
          <InvoiceType>' . explode(" ", $value->numero)[0] . '</InvoiceType>
          <SpecialRegimes>
            <SelfBillingIndicator>0</SelfBillingIndicator>
            <CashVATSchemeIndicator>0</CashVATSchemeIndicator>
            <ThirdPartiesBillingIndicator>0</ThirdPartiesBillingIndicator>
          </SpecialRegimes>
          <SourceID>' . $value->id . '</SourceID>
          <SystemEntryDate>' . str_replace(" ", "T", date('Y-m-d H:i:s', strtotime($value->created_at))) . '</SystemEntryDate>
          <CustomerID>' . $value->cliente_id . '</CustomerID>';
      
      $lines = '';
      switch ($tipo) {
        case 'factura':
        foreach (Factura::where('empresa_id', Auth::user()->empresa_id)->find($value->id)->itens as $keyLine => $line) {
          $CreditAmount = $line->preco * $line->qtd;

          $lines .= '<Line>
                              <LineNumber>' . ($keyLine + 1) . '</LineNumber>
                              <ProductCode>' . $line->artigo_id . '</ProductCode>
                              <ProductDescription>' . $line->designacao . '</ProductDescription>
                              <Quantity>' . number_format($line->qtd, 2) . '</Quantity>
                              <UnitOfMeasure>UN</UnitOfMeasure>
                              <UnitPrice>' . str_replace(',', '', number_format($line->preco, 2)) . '</UnitPrice>
                              <TaxPointDate>' . date('Y-m-d', strtotime($value->created_at)) . '</TaxPointDate>
                              <Description>' . $line->designacao . '</Description>
                              <CreditAmount>' . str_replace(',', '', number_format($CreditAmount, 2)) . '</CreditAmount>
                              <Tax>
                                <TaxType>IVA</TaxType>
                                <TaxCountryRegion>AO</TaxCountryRegion>
                                <TaxCode>' . (($line->imposto_taxa == 14) ? 'NOR' : 'ISE') . '</TaxCode>
                                <TaxPercentage>' . $line->imposto_taxa . '</TaxPercentage>
                              </Tax>
                              ' . (($line->imposto_taxa != 14)
            ? '<TaxExemptionReason>' . $line->imposto_motivo . '</TaxExemptionReason>
                              <TaxExemptionCode>' . $line->imposto_codigo . '</TaxExemptionCode>
                              <SettlementAmount>' . str_replace(',', '', number_format($line->imposto_taxa, 2)) . '</SettlementAmount>' : '') . '
                            </Line>';
        }
        break;
      case 'factura-recibo':
        foreach (FacturaRecibo::where('empresa_id', Auth::user()->empresa_id)->find($value->id)->itens as $keyLine => $line) {
          $CreditAmount = $line->preco * $line->qtd;

          $lines .= '<Line>
                                <LineNumber>' . ($keyLine + 1) . '</LineNumber>
                                <ProductCode>' . $line->artigo_id . '</ProductCode>
                                <ProductDescription>' . $line->designacao . '</ProductDescription>
                                <Quantity>' . number_format($line->qtd, 2) . '</Quantity>
                                <UnitOfMeasure>UN</UnitOfMeasure>
                                <UnitPrice>' . str_replace(',', '', number_format($line->preco, 2)) . '</UnitPrice>
                                <TaxPointDate>' . date('Y-m-d', strtotime($value->created_at)) . '</TaxPointDate>
                                <Description>' . $line->designacao . '</Description>
                                <CreditAmount>' . str_replace(',', '', number_format($CreditAmount, 2)) . '</CreditAmount>
                                <Tax>
                                  <TaxType>IVA</TaxType>
                                  <TaxCountryRegion>AO</TaxCountryRegion>
                                  <TaxCode>' . (($line->imposto_taxa == 14) ? 'NOR' : 'ISE') . '</TaxCode>
                                  <TaxPercentage>' . $line->imposto_taxa . '</TaxPercentage>
                                </Tax>
                                ' . (($line->imposto_taxa != 14)
            ? '<TaxExemptionReason>' . $line->imposto_motivo . '</TaxExemptionReason>
                                <TaxExemptionCode>' . $line->imposto_codigo . '</TaxExemptionCode>
                                <SettlementAmount>' . str_replace(',', '', number_format($line->imposto_taxa, 2)) . '</SettlementAmount>' : '') . '
                              </Line>';
        }
        break;
      case 'nota-credito':
        $notaCredito = NotaCredito::where('empresa_id', Auth::user()->empresa_id)->find($value->id);
        foreach ($notaCredito->itens as $keyLine => $line) {

          $CreditAmount = $line->preco * $line->qtd;
          $lines .= '<Line>
                                  <LineNumber>' . ($keyLine + 1) . '</LineNumber>
                                  <ProductCode>' . $line->artigo_id . '</ProductCode>
                                  <ProductDescription>' . $line->designacao . '</ProductDescription>
                                  <Quantity>' . number_format($line->qtd, 2) . '</Quantity>
                                  <UnitOfMeasure>UN</UnitOfMeasure>
                                  <UnitPrice>' . str_replace(',', '', number_format($line->preco, 2)) . '</UnitPrice>
                                  <TaxPointDate>' . date('Y-m-d', strtotime($value->created_at)) . '</TaxPointDate>
                                  <References>
                                      <Reference>' . $notaCredito->documento_numero . '</Reference>
                                      <Reason>' . $notaCredito->tipo_motivo_anulacao_designacao . '</Reason>
                                  </References>
                                  <Description>' . $line->designacao . '</Description>
                                  <DebitAmount>' . str_replace(',', '', number_format($CreditAmount, 2)) . '</DebitAmount>
                                  <Tax>
                                    <TaxType>IVA</TaxType>
                                    <TaxCountryRegion>AO</TaxCountryRegion>
                                    <TaxCode>' . (($line->imposto_taxa == 14) ? 'NOR' : 'ISE') . '</TaxCode>
                                    <TaxPercentage>' . $line->imposto_taxa . '</TaxPercentage>
                                  </Tax>
                                  ' . (($line->imposto_taxa != 14)
            ? '<TaxExemptionReason>' . $line->imposto_motivo . '</TaxExemptionReason>
                                  <TaxExemptionCode>' . $line->imposto_codigo . '</TaxExemptionCode>
                                  <SettlementAmount>' . str_replace(',', '', number_format($line->imposto_taxa, 2)) . '</SettlementAmount>' : '') . '
                                </Line>';
        }
        break;
    }


    $invoice .= $lines;

    $invoice .= '<DocumentTotals>
            <TaxPayable>' . str_replace(',', '', number_format($value->imposto, 2)) . '</TaxPayable>
            <NetTotal>' . str_replace(',', '', number_format($value->subtotal, 2)) . '</NetTotal>
            <GrossTotal>' . str_replace(',', '', number_format($value->subtotal + $value->imposto, 2)) . '</GrossTotal>
          </DocumentTotals>
        </Invoice>';

    return $invoice;
  }

  //Geração das Proforma
  public function workDocuments(Request $request)
  {
    $workDocuments = '';
    foreach (Proforma::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
      ->whereDate('data', '<=', $request->input('data2'))
      ->get() as $key => $value) {
      $workDocuments .= $this->workDocument($value, 'proforma');
    }
    return $workDocuments;
  }

  public function workDocument($value, $tipo)
  {
    $workDocument = '';
    $workDocument .= '<WorkDocument>
          <DocumentNumber>' . $value->numero . '</DocumentNumber>
          <DocumentStatus>
            <WorkStatus>N</WorkStatus>
            <WorkStatusDate>' . str_replace(" ", "T", date('Y-m-d H:i:s', strtotime($value->created_at))) . '</WorkStatusDate>
            <SourceID>' . $value->utilizador_id . '</SourceID>
            <SourceBilling>P</SourceBilling>
          </DocumentStatus>
          <Hash>' . $value->hash . '</Hash>
          <HashControl>1</HashControl>
          <Period>' . date('m', strtotime($value->created_at)) . '</Period>
          <WorkDate>' . date('Y-m-d', strtotime($value->created_at)) . '</WorkDate>
          <WorkType>' . explode(" ", $value->numero)[0] . '</WorkType>

          <SourceID>' . $value->utilizador_id . '</SourceID>
          <SystemEntryDate>' . str_replace(" ", "T", date('Y-m-d H:i:s', strtotime($value->created_at))) . '</SystemEntryDate>
          <TransactionID>' . ' ' . '</TransactionID>
          <CustomerID>' . $value->cliente_id . '</CustomerID>';
    $lines = '';
    switch ($tipo) {
      case 'proforma':
        foreach (Proforma::find($value->id)->itens as $keyLine => $line) {
          $lines .= '<Line>
                              <LineNumber>' . ($keyLine + 1) . '</LineNumber>
                              <ProductCode>' . $line->artigo_id . '</ProductCode>
                              <ProductDescription>' . $line->designacao . '</ProductDescription>
                              <Quantity>' . number_format($line->qtd, 2) . '</Quantity>
                              <UnitOfMeasure>UND</UnitOfMeasure>
                              <UnitPrice>' . str_replace(',', '', number_format($line->preco, 2)) . '</UnitPrice>
                              <TaxPointDate>' . date('Y-m-d', strtotime($value->created_at)) . '</TaxPointDate>
                              <Description>' . $line->designacao . '</Description>
                              <CreditAmount>' . str_replace(',', '', number_format($line->preco * $line->qtd, 2)) . '</CreditAmount>
                              <Tax>
                                <TaxType>IVA</TaxType>
                                <TaxCountryRegion>AO</TaxCountryRegion>
                                <TaxCode>' . (($line->imposto_taxa == 14) ? 'NOR' : 'ISE') . '</TaxCode>
                                <TaxPercentage>' . number_format($line->imposto_taxa, 1) . '</TaxPercentage>
                              </Tax>
                              ' . (($line->imposto_taxa != 14)
            ? '<TaxExemptionReason>' . $line->imposto_motivo . '</TaxExemptionReason>
                              <TaxExemptionCode>' . $line->imposto_codigo . '</TaxExemptionCode>
                              <SettlementAmount>' . str_replace(',', '', number_format($line->imposto_taxa, 2)) . '</SettlementAmount>' : '') . '
                            </Line>';
        }
        break;
    }


    $workDocument .= $lines;

    $workDocument .= '<DocumentTotals>
            <TaxPayable>' . str_replace(',', '', number_format($value->imposto, 2)) . '</TaxPayable>
            <NetTotal>' . str_replace(',', '', number_format($value->subtotal, 2)) . '</NetTotal>
            <GrossTotal>' . str_replace(',', '', number_format($value->subtotal + $value->imposto, 2)) . '</GrossTotal>
          </DocumentTotals>
        </WorkDocument>';

    return $workDocument;
  }

  //Geração dos Recibos
  public function payment(Request $request)
  {
    $payment = '';
    foreach (Recibo::where('empresa_id', Auth::user()->empresa_id)->whereDate('data', '>=', $request->input('data1'))
      ->whereDate('data', '<=', $request->input('data2'))
      ->get() as $key => $value) {
      $payment .= '<Payment>
      <PaymentRefNo>' . $value->numero . '</PaymentRefNo>
      <Period>' . date('m', strtotime($value->created_at)) . '</Period>
      <TransactionDate>' . date('Y-m-d', strtotime($value->created_at)) . '</TransactionDate>
      <PaymentType>' . explode(" ", $value->numero)[0] . '</PaymentType>
      <SystemID>' . $value->id . '</SystemID>
      <DocumentStatus>
        <PaymentStatus>N</PaymentStatus>
        <PaymentStatusDate>' . str_replace(" ", "T", date('Y-m-d H:i:s', strtotime($value->created_at))) . '</PaymentStatusDate>
        <SourceID>' . $value->id . '</SourceID>
        <SourcePayment>P</SourcePayment>
      </DocumentStatus>
      <PaymentMethod>
        <PaymentAmount>' . str_replace(',', '', number_format($value->total, 2)) . '</PaymentAmount>
        <PaymentDate>' . date('Y-m-d', strtotime($value->created_at)) . '</PaymentDate>
      </PaymentMethod>
      <SourceID>' . $value->id . '</SourceID>
      <SystemEntryDate>' . str_replace(" ", "T", date('Y-m-d H:i:s', strtotime($value->created_at))) . '</SystemEntryDate>
      <CustomerID>' . $value->cliente_id . '</CustomerID>
      <Line>
        <LineNumber>1</LineNumber>
        <SourceDocumentID>
          <OriginatingON>' . $value->numero_documento . '</OriginatingON>
          <InvoiceDate>' . date('Y-m-d', strtotime($value->created_at)) . '</InvoiceDate>
        </SourceDocumentID>
        <SettlementAmount>0</SettlementAmount>
        <CreditAmount>' . str_replace(',', '', number_format($value->subtotal, 2)) . '</CreditAmount>
      </Line>
      <DocumentTotals>
        <TaxPayable>' . str_replace(',', '', number_format($value->imposto, 2)) . '</TaxPayable>
        <NetTotal>' . str_replace(',', '', number_format($value->subtotal, 2)) . '</NetTotal>
        <GrossTotal>' . str_replace(',', '', number_format($value->subtotal + $value->imposto, 2)) . '</GrossTotal>
      </DocumentTotals>
    </Payment>';
    }
    return $payment;
  }
}
