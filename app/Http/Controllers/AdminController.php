<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoRequest;
use App\Models\Access;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        // Update status video requests yang memiliki akses habis
        $expiredAccesses = Access::where('access_end_time', '<', now())->get();
        foreach ($expiredAccesses as $expiredAccess) {
            $expiredAccess->videoRequest->update(['status' => 'expired']);
            $expiredAccess->delete();
        }

        $customerCount = User::where('role', 'customer')->count();
        $videoCount = Video::count();
        $requestCount = VideoRequest::where('status', 'pending')->count();

        return view('admin.dashboard', compact('customerCount', 'videoCount', 'requestCount'));
    }

    public function createCustomer(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'customer',
        ]);

        return redirect()->route('admin.customers')->with('success', 'Customer added successfully.');
    }

    public function listCustomers()
    {
        $customers = User::where('role', 'customer')->get();
        return view('admin.customers.index', compact('customers'));
    }

    public function editCustomer($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function updateCustomer(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'password' => 'nullable|string|min:8',
        ]);

        $customer->name = $request->name;
        $customer->email = $request->email;
        if ($request->filled('password')) {
            $customer->password = Hash::make($request->password);
        }
        $customer->save();

        return redirect()->route('admin.customers')->with('success', 'Customer updated successfully.');
    }

    public function deleteCustomer($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers')->with('success', 'Customer deleted successfully.');
    }

    // Fungsi untuk mengubah URL YouTube menjadi format embed
    private function convertToEmbedUrl($url)
    {
        // Ekstrak video ID dari URL
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $matches);
        $videoId = $matches[1] ?? null;

        // Jika tidak ditemukan video ID, kembalikan URL asli
        if (!$videoId) {
            return $url;
        }

        // Kembalikan URL embed
        return 'https://www.youtube.com/embed/' . $videoId;
    }

    // Fungsi untuk mendapatkan URL thumbnail YouTube
    private function getThumbnailUrl($url)
    {
        // Ekstrak video ID dari URL
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $matches);
        $videoId = $matches[1] ?? null;

        // Jika tidak ditemukan video ID, kembalikan null
        if (!$videoId) {
            return null;
        }

        // Kembalikan URL thumbnail
        return 'https://img.youtube.com/vi/' . $videoId . '/maxresdefault.jpg';
    }

    public function listVideos()
    {
        $videos = Video::all();
        return view('admin.videos.index', compact('videos'));
    }

    public function createVideo(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'required|url',
        ]);

        // Ubah URL menjadi format embed
        $validated['url'] = $this->convertToEmbedUrl($validated['url']);

        // Dapatkan URL thumbnail
        $validated['thumbnail'] = $this->getThumbnailUrl($request->url);

        Video::create($validated);

        return redirect()->route('admin.videos');
    }

    public function updateVideo(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'required|url',
        ]);

        $video = Video::findOrFail($id);

        // Ubah URL menjadi format embed
        $validated['url'] = $this->convertToEmbedUrl($validated['url']);

        // Dapatkan URL thumbnail
        $validated['thumbnail'] = $this->getThumbnailUrl($request->url);

        $video->update($validated);

        return redirect()->route('admin.videos');
    }

    public function deleteVideo($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();

        return redirect()->route('admin.videos');
    }

    public function listRequests()
    {
        $requests = VideoRequest::with('customer', 'video')->get();
        return view('admin.requests.index', compact('requests'));
    }

    public function manageRequest(Request $request, $id)
    {
        $videoRequest = VideoRequest::findOrFail($id);

        $videoRequest->update(['status' => $request->status]);

        if ($request->status == 'approved') {
            // Mengubah durasi akses berdasarkan input dari form
            $duration = $request->input('duration', 2); // Default 2 jam jika tidak ada input

            Access::create([
                'request_id' => $videoRequest->id,
                'access_start_time' => now(),
                'access_end_time' => now()->addHours($duration), // Durasi akses berdasarkan input
            ]);
        }

        return redirect()->route('admin.requests');
    }
}
