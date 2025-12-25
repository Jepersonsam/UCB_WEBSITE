<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JoinApplication;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JoinApplicationsExport;

class JoinApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JoinApplication::latest();

        // Filter by read status
        if ($request->has('filter')) {
            if ($request->filter === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->filter === 'read') {
                $query->where('is_read', true);
            }
        }

        $applications = $query->paginate(20);
        return response()->json($applications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'voice_part' => 'nullable|string|max:50',
            'experience' => 'nullable|string',
            'reason' => 'nullable|string',
        ]);

        $application = JoinApplication::create($validated);

        return response()->json([
            'message' => 'Aplikasi bergabung berhasil dikirim',
            'data' => $application,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application = JoinApplication::findOrFail($id);
        
        // Mark as read when viewing
        if (!$application->is_read) {
            $application->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        return response()->json($application);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application = JoinApplication::findOrFail($id);

        $validated = $request->validate([
            'is_read' => 'sometimes|boolean',
        ]);

        if (isset($validated['is_read']) && $validated['is_read'] && !$application->is_read) {
            $validated['read_at'] = now();
        } elseif (isset($validated['is_read']) && !$validated['is_read']) {
            $validated['read_at'] = null;
        }

        $application->update($validated);

        return response()->json($application);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $application = JoinApplication::findOrFail($id);
        $application->delete();

        return response()->json(['message' => 'Aplikasi bergabung berhasil dihapus']);
    }

    /**
     * Export join applications to PDF
     */
    public function exportPDF(Request $request)
    {
        $query = JoinApplication::latest();

        // Filter by read status
        if ($request->has('filter')) {
            if ($request->filter === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->filter === 'read') {
                $query->where('is_read', true);
            }
        }

        $applications = $query->get();

        $pdf = Pdf::loadView('exports.join-applications-pdf', [
            'applications' => $applications,
            'filter' => $request->get('filter', 'all'),
        ]);

        return $pdf->download('aplikasi-bergabung-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export join applications to Excel
     */
    public function exportExcel(Request $request)
    {
        $filter = $request->get('filter', 'all');
        
        return Excel::download(new JoinApplicationsExport($filter), 'aplikasi-bergabung-' . date('Y-m-d') . '.xlsx');
    }
}
