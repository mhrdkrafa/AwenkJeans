<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with(['user', 'product', 'transaction'])
            ->latest()
            ->paginate(15);

        $totalOpen = Complaint::where('status', 'open')->count();
        $totalInProgress = Complaint::where('status', 'in_progress')->count();
        $totalResolved = Complaint::where('status', 'resolved')->count();

        return view('karyawan.complaints.index', compact('complaints', 'totalOpen', 'totalInProgress', 'totalResolved'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['user', 'product', 'transaction.details.product', 'messages.user']);
        return view('karyawan.complaints.show', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $complaint->update([
            'status' => $request->status,
        ]);

        return redirect()->route('karyawan.complaints.show', $complaint)->with('success', 'Status komplain berhasil diperbarui.');
    }

    public function reply(Request $request, Complaint $complaint)
    {
        $request->validate([
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi|max:20480',
        ]);

        // Handle file uploads
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('complaints/attachments', 'public');
                $attachmentPaths[] = $path;
            }
        }

        $complaint->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
            'attachments' => !empty($attachmentPaths) ? $attachmentPaths : null,
            'is_admin' => true,
        ]);

        // Auto update status to in_progress if it was open
        if ($complaint->status === 'open') {
            $complaint->update(['status' => 'in_progress']);
        }

        return redirect()->route('karyawan.complaints.show', $complaint)->with('success', 'Balasan berhasil dikirim.');
    }
}
