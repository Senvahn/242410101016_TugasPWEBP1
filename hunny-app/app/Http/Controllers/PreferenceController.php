<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    public function index(Request $request)
    {
        $theme = $request->cookie('hunny_theme', 'system');
        $fontSize = $request->cookie('hunny_font_size', 'medium');

        $visitCount = $request->session()->get('preferensi.visit_count', 0) + 1;
        $firstVisit = $request->session()->get('preferensi.first_visit');
        $lastVisit = now()->format('d M Y H:i:s');

        if (!$firstVisit) {
            $firstVisit = $lastVisit;
        }

        $request->session()->put('preferensi.visit_count', $visitCount);
        $request->session()->put('preferensi.first_visit', $firstVisit);
        $request->session()->put('preferensi.last_visit', $lastVisit);

        return view('preferensi', compact('theme', 'fontSize', 'visitCount', 'firstVisit', 'lastVisit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|in:light,dark,system',
            'font_size' => 'required|in:small,medium,large',
        ]);

        $response = response()->json([
            'success' => true,
            'message' => 'Preferensi tersimpan.',
            'theme' => $validated['theme'],
            'font_size' => $validated['font_size'],
        ]);

        $response->cookie('hunny_theme', $validated['theme'], 525600);
        $response->cookie('hunny_font_size', $validated['font_size'], 525600);

        return $response;
    }

    public function reset(Request $request)
    {
        $request->session()->forget([
            'preferensi.visit_count',
            'preferensi.first_visit',
            'preferensi.last_visit',
        ]);

        return redirect()->route('preferensi.index');
    }
}
