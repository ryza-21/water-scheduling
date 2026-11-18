<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessRequest;
use App\Models\WaterSource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommunityUserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $pendingRequests = AccessRequest::where('user_id', $user->id)
            ->where('status', 'Pending')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($req) {
                return [
                    'id' => $req->request_code,
                    'source' => $req->requested_source,
                    'date' => $req->preferred_date
                        ? $req->preferred_date->format('Y-m-d')
                        : '-',
                    'status' => $req->status,
                ];
            })->toArray();

        $upcomingSchedules = AccessRequest::where('user_id', $user->id)
            ->where('status', 'Approved')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($sch) {
                return [
                    'source' => $sch->requested_source,
                    'schedule' => $sch->preferred_date
                        ? $sch->preferred_date->format('F d, Y') . ' (Approved Slot)'
                        : 'Scheduled',
                    'status' => 'Scheduled',
                ];
            })->toArray();

        return view('user.dashboard', [
            'pendingRequests' => $pendingRequests,
            'upcomingSchedules' => $upcomingSchedules,
            'userName' => $user->name,
        ]);
    }

    // REQUEST WATER ACCESS PAGE
    public function createRequest(Request $request)
    {
        $waterSources = WaterSource::query()
            ->select([
                'id',
                'source_name',
                'location'
            ])
            ->where('status', 'Active')
            ->orderBy('source_name')
            ->get();

        // Automatically select source when coming from Water Sources page
        $selectedSourceId = $request->query('source');

        return view('user.request-access', compact(
            'waterSources',
            'selectedSourceId'
        ));
    }

    // WATER SOURCES PAGE
    public function waterSources()
    {
        $waterSources = WaterSource::query()
            ->select([
                'id',
                'source_id',
                'source_name',
                'location',
                'capacity',
                'status'
            ])
            ->orderBy('source_name')
            ->get();

        return view('user.water-sources', compact('waterSources'));
    }

    // SAVE WATER ACCESS REQUEST
    public function storeWaterAccess(Request $request)
    {
        $validated = $request->validate([
            'water_source_id' => [
                'required',
                'integer',
                'exists:water_sources,id',
            ],

            'preferred_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'purpose' => [
                'required',
                'string',
                'max:2000',
            ],

            'estimated_volume' => [
                'nullable',
                'numeric',
                'min:0.01',
                'max:1000000',
            ],
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($validated, $user) {

            $waterSource = WaterSource::findOrFail(
                $validated['water_source_id']
            );

            if ($waterSource->status !== 'Active') {
                abort(403, 'This water source is currently unavailable.');
            }

            AccessRequest::create([
                'request_code' => 'REQ-' . strtoupper(
                    (string) Str::uuid()
                ),

                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,

                'water_source_id' => $waterSource->id,
                'requested_source' => $waterSource->source_name,

                'preferred_date' => $validated['preferred_date'],
                'purpose' => $validated['purpose'],

                'estimated_volume' => $validated['estimated_volume'] ?? null,

                'status' => 'Pending',

                'submitted_at' => now(),
            ]);
        });

        return redirect()
            ->route('user.request-access')
            ->with('success', 'Your water access request has been submitted successfully.');
    }

    // MY REQUESTS
    public function myRequests()
    {
        $requests = AccessRequest::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.my-requests', compact('requests'));
    }

    // MY SCHEDULE
    public function mySchedule()
    {
        $requests = AccessRequest::where('user_id', Auth::id())
            ->where('status', 'Approved')
            ->latest()
            ->paginate(10);

        return view('user.my-schedule', compact('requests'));
    }

    // ACCESS HISTORY
    public function accessHistory()
    {
        $requests = AccessRequest::where('user_id', Auth::id())
            ->whereIn('status', [
                'Completed',
                'Rejected',
                'Declined',
                'Cancelled',
                'Approved',
            ])
            ->latest()
            ->paginate(10);

        return view('user.access-history', compact('requests'));
    }
}
