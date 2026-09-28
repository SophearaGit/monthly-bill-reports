<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Invoices;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

    /**
     * Mark a batch of invoices as paid/unpaid from the list's bulk toolbar.
     */
    /**
     * Stream a single invoice as a PDF, used by the invoice list's per-row
     * "download" flow and by the bulk ZIP download (fetched once per invoice
     * and packed client-side with JSZip).
     */
    public function downloadPdf(Invoices $invoice)
    {
        $invoice->load(['room', 'tenant']);

        $exchangeRate = 4150;
        $totalRiel = $invoice->total_amount * $exchangeRate;
        $monthParsed = \Carbon\Carbon::parse($invoice->month . '-01');

        $fontDir = storage_path('fonts');
        $khmerFont = $fontDir . '/NotoSansKhmer-Regular.ttf';

        $pdf = Pdf::loadView('backend.pages.invoices.pdf', [
            'invoice' => $invoice,
            'monthParsed' => $monthParsed,
            'totalRiel' => $totalRiel,
        ]);

        if (is_file($khmerFont)) {
            $pdf->getDomPDF()->getFontMetrics()->registerFont(
                ['family' => 'NotoSansKhmer', 'style' => 'normal', 'weight' => 'normal'],
                $khmerFont
            );
        }

        $fileName = 'INV-' . str_pad($invoice->id, 4, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->stream($fileName);
    }

    public function bulkUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:invoices,id',
            'status' => 'required|in:paid,unpaid',
        ]);

        $updated = Invoices::whereIn('id', $validated['ids'])
            ->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'status' => $validated['status'],
            'updated' => $updated,
        ]);
    }

    /**
     * Toggle an invoice between paid/unpaid from the list's inline switch.
     */
    public function updateStatus(Request $request, Invoices $invoice)
    {
        $validated = $request->validate([
            'status' => 'required|in:paid,unpaid',
        ]);

        $invoice->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'status' => $invoice->status,
        ]);
    }
}
