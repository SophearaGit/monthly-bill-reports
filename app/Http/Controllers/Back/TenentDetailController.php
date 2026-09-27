<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Tenent;
use App\Models\TenantDocument;
use App\Models\TenantSocialLink;
use App\Models\TenantTransportation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenentDetailController extends Controller
{
    /**
     * Show the dedicated details page for a single tenant: social links,
     * transportation, and documents.
     */
    public function show(Tenent $tenent)
    {
        $data = [
            'pageTitle' => 'Admin | Tenant Details',
            'tenant' => $tenent->load(['room', 'socialLinks', 'transportations', 'documents']),
        ];

        return view('backend.pages.tenents.details', $data);
    }

    /**
     * Store a new social link for the tenant.
     */
    public function storeSocialLink(Request $request, Tenent $tenent)
    {
        $validated = $request->validate([
            'platform' => 'required|in:facebook,telegram,whatsapp,instagram,tiktok,other',
            'url' => 'required|string|max:500',
        ]);

        $tenent->socialLinks()->create($validated);

        return redirect()->back()->with('success', 'Social link added.');
    }

    /**
     * Remove a social link.
     */
    public function destroySocialLink(Tenent $tenent, TenantSocialLink $socialLink)
    {
        abort_unless($socialLink->tenant_id === $tenent->id, 404);

        $socialLink->delete();

        return redirect()->back()->with('success', 'Social link removed.');
    }

    /**
     * Store a new transportation record for the tenant.
     */
    public function storeTransportation(Request $request, Tenent $tenent)
    {
        $validated = $request->validate([
            'type' => 'required|in:motorbike,car,bicycle,other',
            'brand' => 'nullable|string|max:100',
            'license_plate' => 'required|string|max:50',
        ]);

        $tenent->transportations()->create($validated);

        return redirect()->back()->with('success', 'Transportation added.');
    }

    /**
     * Remove a transportation record.
     */
    public function destroyTransportation(Tenent $tenent, TenantTransportation $transportation)
    {
        abort_unless($transportation->tenant_id === $tenent->id, 404);

        $transportation->delete();

        return redirect()->back()->with('success', 'Transportation removed.');
    }

    /**
     * Upload a new document for the tenant.
     */
    public function storeDocument(Request $request, Tenent $tenent)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $file = $request->file('file');
        $path = $file->store('tenant-documents/' . $tenent->id, 'uploads');

        $tenent->documents()->create([
            'label' => $validated['label'],
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
        ]);

        return redirect()->back()->with('success', 'Document uploaded.');
    }

    /**
     * Delete a document, removing the stored file as well.
     */
    public function destroyDocument(Tenent $tenent, TenantDocument $document)
    {
        abort_unless($document->tenant_id === $tenent->id, 404);

        if ($document->file_path && Storage::disk('uploads')->exists($document->file_path)) {
            Storage::disk('uploads')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->back()->with('success', 'Document removed.');
    }
}
