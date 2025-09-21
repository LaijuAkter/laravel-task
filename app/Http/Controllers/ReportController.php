<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())->orderBy('report_date', 'desc')->get();
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'report_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reports', 'public');
        }

        Report::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'details' => $request->details,
            'report_date' => $request->report_date,
            'image' => $imagePath,
        ]);

        return redirect()->route('reports.index')->with('success', 'Report submitted successfully.');
    }

    public function edit($id)
    {
        $report = Report::findOrFail($id);

        if ($report->user_id !== Auth::id()) {
            abort(403);
        }

        return view('reports.edit', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        if ($report->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'report_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($report->image && Storage::disk('public')->exists($report->image)) {
                Storage::disk('public')->delete($report->image);
            }
            $report->image = $request->file('image')->store('reports', 'public');
        }

        $report->update([
            'title' => $request->title,
            'details' => $request->details,
            'report_date' => $request->report_date,
            'image' => $report->image,
        ]);

        return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        if ($report->user_id !== Auth::id()) {
            abort(403);
        }

        if ($report->image && Storage::disk('public')->exists($report->image)) {
            Storage::disk('public')->delete($report->image);
        }

        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }
}
