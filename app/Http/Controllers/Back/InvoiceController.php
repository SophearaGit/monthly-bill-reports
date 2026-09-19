<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // public function index()
    // {
    //     $data = [
    //         'pageTitle' => 'Admin | Invoices',
    //         'invoices' => Invoices::with(['room', 'tenant'])->paginate(20),
    //     ];
    //     return view('backend.pages.invoices.index', $data);
    // }

    public function index(Request $request)
    {
        $month = $request->filled('month') ? $request->month : now()->format('Y-m');

        $query = Invoices::with(['room', 'tenant'])->where('month', $month);

        return view('backend.pages.invoices.index', [
            'pageTitle' => 'Admin | Invoices',
            'invoices' => $query->paginate(40),
            'selectedMonth' => $month,
        ]);
    }

    public function show(Invoices $invoice)
    {
        $exchangeRate = 4150;

        $data = [
            'invoice' => $invoice,
            'exchangeRate' => $exchangeRate,
        ];

        return view('backend.pages.invoices.show', $data);
    }
}
