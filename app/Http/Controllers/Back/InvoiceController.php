<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Admin | Invoices',
            'invoices' => Invoices::with(['room', 'tenant'])->paginate(20),
        ];
        return view('backend.pages.invoices.index', $data);
    }

    public function show(Invoices $invoice)
    {
        $exchangeRate = 4150;

        return view('invoices.show', [
            'invoice' => $invoice,
            'exchangeRate' => $exchangeRate,
        ]);
    }

    public function download(Invoices $invoice)
    {
        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'exchangeRate' => 4150,
        ]);

        return $pdf->download("invoice_{$invoice->id}.pdf");
    }

}
