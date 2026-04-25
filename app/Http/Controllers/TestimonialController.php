<?php


namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller {
    public function index() {
        $testimonials = Testimonial::with('user')->latest()->get();
        // Cek apakah user yang login sudah punya testimoni
        $myTestimony = Auth::check() ? Testimonial::where('user_id', Auth::id())->first() : null;
        return view('user.testimoni', compact('testimonials', 'myTestimony'));
    }

    public function store(Request $request) {
        $request->validate(['message' => 'required|max:500']);
        Testimonial::create(['user_id' => Auth::id(), 'message' => $request->message]);
        return back()->with('success', 'Terima kasih atas testimoni Anda!');
    }

    public function update(Request $request, $id) {
        $t = Testimonial::findOrFail($id);
        if($t->user_id !== Auth::id()) abort(403);
        $t->update(['message' => $request->message]);
        return back()->with('success', 'Testimoni diperbarui!');
    }

    public function destroy($id) {
        $t = Testimonial::findOrFail($id);
        if($t->user_id !== Auth::id()) abort(403);
        $t->delete();
        return back()->with('success', 'Testimoni dihapus.');
    }
}