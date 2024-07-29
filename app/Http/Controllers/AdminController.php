<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoRequest;
use App\Models\Access;

class AdminController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')->get();
        $videos = Video::all();
        $requests = VideoRequest::with('customer', 'video')->get();
        return view('admin.dashboard', compact('customers', 'videos', 'requests'));
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

        return redirect()->route('admin.dashboard');
    }


    public function listCustomers()
    {
        $customers = User::where('role', 'customer')->get();
        return view('admin.dashboard', compact('customers'));
    }

    public function editCustomer($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function updateCustomer(Request $request, $id)
    {
        $customer = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'password' => 'nullable|min:8',
        ]);

        $customer->name = $validated['name'];
        $customer->email = $validated['email'];
        if ($request->filled('password')) {
            $customer->password = bcrypt($validated['password']);
        }
        $customer->save();

        return redirect()->route('admin.dashboard')->with('success', 'Customer updated successfully');
    }

    public function deleteCustomer($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Customer deleted successfully');
    }


    public function createVideo(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'required|url',
        ]);

        Video::create($validated);

        return redirect()->route('admin.dashboard');
    }

    public function updateVideo(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'required|url',
        ]);

        $video = Video::findOrFail($id);
        $video->update($validated);

        return redirect()->route('admin.dashboard');
    }

    public function deleteVideo($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();

        return redirect()->route('admin.dashboard');
    }

    public function manageRequest(Request $request, $id)
    {
        $videoRequest = VideoRequest::findOrFail($id);

        $videoRequest->update(['status' => $request->status]);

        if ($request->status == 'approved') {
            Access::create([
                'request_id' => $videoRequest->id,
                'access_start_time' => now(),
                'access_end_time' => now()->addHours(2), // Contoh: 2 jam
            ]);
        }

        return redirect()->route('admin.dashboard');
    }
}
