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
        $videos = Video::all();
        $requests = VideoRequest::where('customer_id', Auth::id())->with('video')->get();
        $accesses = Access::whereHas('videoRequest', function($query) {
            $query->where('customer_id', Auth::id());
        })->with('videoRequest.video')->get();

        return view('customer.dashboard', compact('videos', 'requests', 'accesses'));
    }

    public function requestAccess(Request $request, $videoId)
    {
        VideoRequest::create([
            'customer_id' => Auth::id(),
            'video_id' => $videoId,
            'status' => 'pending',
        ]);

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

