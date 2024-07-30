<?php
// app/Http/Controllers/CustomerController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\VideoRequest;
use App\Models\Access;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        // Hapus akses yang expired
        $expiredAccesses = Access::where('access_end_time', '<', now())->get();
        foreach ($expiredAccesses as $expiredAccess) {
            $expiredAccess->videoRequest->update(['status' => 'expired']);
            $expiredAccess->delete();
        }

        // Ambil semua video
        $videos = Video::all();


        // Ambil maksimal 3 video terbaru
        $latestVideos = Video::latest()->take(3)->get();

        // Ambil permintaan akses yang dibuat oleh customer saat ini
        $requests = VideoRequest::where('customer_id', Auth::id())->with('video')->get();

        // Ambil akses yang valid untuk customer saat ini
        $accesses = Access::whereHas('videoRequest', function ($query) {
            $query->where('customer_id', Auth::id());
        })->with('videoRequest.video')->get();

        return view('customer.dashboard', compact('videos','latestVideos', 'requests', 'accesses'));
    }

    public function requestAccess(Request $request, $videoId)
    {
        $customerId = Auth::id();

        // Cari permintaan akses yang sudah ada untuk video dan customer ini
        $existingRequest = VideoRequest::where('customer_id', $customerId)
            ->where('video_id', $videoId)
            ->first();

        if ($existingRequest) {
            // Jika permintaan sudah ada, perbarui statusnya jika statusnya tidak 'pending'
            if ($existingRequest->status !== 'pending') {
                $existingRequest->update(['status' => 'pending']);
            }
        } else {
            // Jika permintaan tidak ada, buat yang baru
            VideoRequest::create([
                'customer_id' => $customerId,
                'video_id' => $videoId,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('customer.dashboard');
    }

    public function watchVideo($accessId)
    {
        $access = Access::findOrFail($accessId);

        if (now()->between($access->access_start_time, $access->access_end_time)) {
            return view('customer.watch', ['video' => $access->videoRequest->video]);
        }

        return redirect()->route('customer.dashboard')->with('error', 'Access expired');
    }
}
