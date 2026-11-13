<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessRecord;
use App\Models\WaterSource;
use App\Models\AccessRequest;
use App\Models\Schedule;
use App\Models\ManagedUser;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingApprovalsCount = AccessRequest::where('status', 'Pending')->count();

        $activeSourcesCount = WaterSource::where('status', 'Active')->count();

        $accessRecordsCount = AccessRecord::count();

        $activityLogs = AccessRequest::latest()->take(4)->get();

        $pendingRequests = AccessRequest::where('status', 'Pending')
            ->latest()
            ->take(2)
            ->get();

        return view('admin.dashboard', compact(
            'pendingApprovalsCount',
            'activeSourcesCount',
            'accessRecordsCount',
            'activityLogs',
            'pendingRequests'
        ));
    }

    public function waterSources()
    {
        $waterSources = WaterSource::latest()->get();

        return view('admin.water-sources', compact('waterSources'));
    }

    public function storeWaterSource(Request $request)
    {
        $validated = $request->validate([
            'source_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|string|max:255',
            'status' => 'required|in:Active,Maintenance',
        ]);

        $lastSource = WaterSource::withTrashed()
            ->where('source_id', 'like', '#SRC-%')
            ->orderByRaw(
                'CAST(SUBSTRING(source_id, 6) AS UNSIGNED) DESC'
            )
            ->first();

        $nextNumber = $lastSource
            ? ((int) substr($lastSource->source_id, 5)) + 1
            : 1;

        $validated['source_id'] = '#SRC-' . str_pad(
            (string) $nextNumber,
            3,
            '0',
            STR_PAD_LEFT
        );

        WaterSource::create($validated);

        return redirect()
            ->route('admin.water-sources')
            ->with('success', 'Water source added successfully.');
    }

    public function updateWaterSource(
        Request $request,
        WaterSource $waterSource
    ) {
        $validated = $request->validate([
            'source_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|string|max:255',
            'status' => 'required|in:Active,Maintenance',
        ]);

        $waterSource->update($validated);

        return redirect()
            ->route('admin.water-sources')
            ->with('success', 'Water source updated successfully.');
    }

    public function deleteWaterSource(WaterSource $waterSource)
    {
        $waterSource->delete();

        return redirect()
            ->route('admin.water-sources')
            ->with(
                'success',
                'Water source moved to trash (soft deleted) successfully.'
            );
    }

    public function restoreWaterSource(int $id)
    {
        $waterSource = WaterSource::withTrashed()->findOrFail($id);

        $waterSource->restore();

        return redirect()
            ->route('admin.water-sources')
            ->with('success', 'Water source restored successfully.');
    }

    public function accessRequests()
    {
        $requests = AccessRequest::latest()->get();

        return view('admin.access-requests', compact('requests'));
    }

    public function accessRecords(Request $request)
    {
        $query = AccessRequest::query()->with('schedule');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('source') && $request->source !== 'all') {
            $query->where('requested_source', $request->source);
        }

        $records = $query->latest('submitted_at')->get();

        return view('admin.access-records', compact('records'));
    }

    public function updateAccessRequestStatus(
        Request $request,
        AccessRequest $accessRequest
    ) {
        $validated = $request->validate([
            'status' => 'required|in:Approved,Declined',
        ]);

        if ($accessRequest->status !== 'Pending') {
            return redirect()
                ->route('admin.access-requests')
                ->with(
                    'success',
                    'This request has already been processed.'
                );
        }

        $accessRequest->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.access-requests')
            ->with(
                'success',
                'Access request status updated successfully.'
            );
    }

    public function requestApprovals()
    {
        return view('admin.request-approvals');
    }

    public function scheduleManagement()
    {
        $requests = AccessRequest::with('schedule')
            ->where('status', 'Approved')
            ->latest()
            ->get();

        return view('admin.schedule-management', compact('requests'));
    }

    public function saveSchedule(
        Request $request,
        AccessRequest $accessRequest
    ) {
        abort_unless(
            $accessRequest->status === 'Approved',
            422,
            'Only approved requests can be scheduled.'
        );

        $validated = $request->validate([
            'schedule_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        $formattedStartTime = Carbon::createFromFormat('H:i', $validated['start_time'])->format('h:i A');
        $formattedEndTime = Carbon::createFromFormat('H:i', $validated['end_time'])->format('h:i A');
        $timeSlot = $formattedStartTime . ' - ' . $formattedEndTime;

        $existingScheduleId = Schedule::where(
            'access_request_id',
            $accessRequest->id
        )->value('id');

        $slotTaken = Schedule::where(
            'schedule_date',
            $validated['schedule_date']
        )
            ->where('time_slot', $timeSlot)
            ->where('status', 'Scheduled')
            ->when(
                $existingScheduleId,
                fn ($query) => $query->where(
                    'id',
                    '!=',
                    $existingScheduleId
                )
            )
            ->exists();

        if ($slotTaken) {
            return back()
                ->withInput()
                ->withErrors([
                    'end_time' => 'This time slot is already assigned on that date.',
                ]);
        }

        DB::transaction(function () use ($accessRequest, $validated, $timeSlot) {
            Schedule::updateOrCreate(
                ['access_request_id' => $accessRequest->id],
                [
                    'schedule_date' => $validated['schedule_date'],
                    'time_slot' => $timeSlot,
                    'status' => 'Scheduled',
                ]
            );
        });

        return redirect()
            ->route('admin.schedule-management')
            ->with('success', 'Schedule saved successfully.');
    }

    public function deleteSchedule(AccessRequest $accessRequest)
    {
        $accessRequest->schedule()->delete();

        return redirect()
            ->route('admin.schedule-management')
            ->with('success', 'Schedule removed successfully.');
    }

    public function userManagement()
    {
        $users = ManagedUser::latest()->get();

        $totalUsers = $users->count();

        $activeUsers = $users->where('status', 'Active')->count();

        $inactiveUsers = $users->where('status', 'Inactive')->count();

        return view('admin.user-management', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'inactiveUsers'
        ));
    }

    public function storeManagedUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:managed_users,email',
            'role' => 'required|in:Water Seeker,Administrator',
            'status' => 'required|in:Active,Inactive',
        ]);

        ManagedUser::create($validated);

        return redirect()
            ->route('admin.user-management')
            ->with('success', 'User account added successfully.');
    }

    public function updateManagedUser(
        Request $request,
        ManagedUser $managedUser
    ) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('managed_users', 'email')
                    ->ignore($managedUser->id),
            ],
            'role' => 'required|in:Water Seeker,Administrator',
            'status' => 'required|in:Active,Inactive',
        ]);

        $managedUser->update($validated);

        return redirect()
            ->route('admin.user-management')
            ->with('success', 'User account updated successfully.');
    }

    public function reports(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));

        if (
            !preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $month)
        ) {
            $month = now()->format('Y-m');
        }

        $parsedMonth = Carbon::createFromFormat('!Y-m', $month);

        $startDate = $parsedMonth->copy()->startOfMonth();

        $endDate = $parsedMonth->copy()->endOfMonth();

        $baseQuery = AccessRequest::query()
            ->whereBetween('submitted_at', [$startDate, $endDate]);

        if ($request->filled('search')) {
            $search = $request->search;

            $baseQuery->where(function ($query) use ($search) {
                $query->where('request_code', 'like', "%{$search}%")
                    ->orWhere('user_name', 'like', "%{$search}%")
                    ->orWhere(
                        'requested_source',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        $totalRequests = (clone $baseQuery)->count();

        $approvedCount = (clone $baseQuery)
            ->where('status', 'Approved')
            ->count();

        $pendingCount = (clone $baseQuery)
            ->where('status', 'Pending')
            ->count();

        $rejectedCount = (clone $baseQuery)
            ->whereIn('status', ['Rejected', 'Declined'])
            ->count();

        $sourceSummary = (clone $baseQuery)
            ->get()
            ->groupBy('requested_source')
            ->map(function ($items, $source) {
                return [
                    'source' => $source ?: 'Unknown Source',
                    'total' => $items->count(),
                    'approved' => $items
                        ->where('status', 'Approved')
                        ->count(),
                    'pending' => $items
                        ->where('status', 'Pending')
                        ->count(),
                    'rejected' => $items
                        ->whereIn('status', ['Rejected', 'Declined'])
                        ->count(),
                ];
            })
            ->values();

        $query = clone $baseQuery;

        $query->with('schedule');

        if ($request->filled('status') && $request->status !== 'all') {
            if ($request->status === 'Rejected') {
                $query->whereIn('status', ['Rejected', 'Declined']);
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->filled('source') && $request->source !== 'all') {
            $query->where('requested_source', $request->source);
        }

        $requests = $query->orderByDesc('submitted_at')->get();

        $monthName = $parsedMonth->format('F Y');

        return view('admin.reports', compact(
            'requests',
            'totalRequests',
            'approvedCount',
            'pendingCount',
            'rejectedCount',
            'sourceSummary',
            'month',
            'monthName'
        ));
    }

    public function exportReportsPdf(Request $request)
    {
        $query = AccessRequest::query()->with('schedule');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->where('request_code', 'like', "%{$search}%")
                    ->orWhere('user_name', 'like', "%{$search}%")
                    ->orWhere(
                        'requested_source',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            if ($request->status === 'Rejected') {
                $query->whereIn('status', ['Rejected', 'Declined']);
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->filled('source') && $request->source !== 'all') {
            $query->where('requested_source', $request->source);
        }

        if ($request->filled('month')) {
            $query->whereMonth(
                'submitted_at',
                Carbon::parse($request->month)->month
            )->whereYear(
                'submitted_at',
                Carbon::parse($request->month)->year
            );
        }

        $reports = $query->orderByDesc('submitted_at')->get();

        $pdf = app('dompdf.wrapper');

        $pdf->loadView('admin.reports-pdf', compact('reports'));

        return $pdf->download(
            'water-access-reports-' . date('Y-m-d') . '.pdf'
        );
    }

    public function exportReportsExcel(Request $request)
    {
        $query = AccessRequest::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->where('request_code', 'like', "%{$search}%")
                    ->orWhere('user_name', 'like', "%{$search}%")
                    ->orWhere(
                        'requested_source',
                        'like',
                        "%{$search}%"
                    );
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            if ($request->status === 'Rejected') {
                $query->whereIn('status', ['Rejected', 'Declined']);
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->filled('source') && $request->source !== 'all') {
            $query->where('requested_source', $request->source);
        }

        if ($request->filled('month')) {
            $query->whereMonth(
                'submitted_at',
                Carbon::parse($request->month)->month
            )->whereYear(
                'submitted_at',
                Carbon::parse($request->month)->year
            );
        }

        $reports = $query->get();

        $filename = 'water-access-reports-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($reports) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Request Code',
                'User Name',
                'Water Source',
                'Date Submitted',
                'Status',
            ]);

            foreach ($reports as $item) {
                fputcsv($file, [
                    $item->request_code ?? 'N/A',
                    $item->user_name ?? 'N/A',
                    $item->requested_source ?? 'N/A',
                    $item->submitted_at ?? 'N/A',
                    $item->status ?? 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}