<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EducationHistory;
use Illuminate\Support\Facades\Storage;

class EducationHistoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'school' => 'required|max:255',
            'major' => 'required|max:255',
            'degree' => 'required|max:255',
            'year' => 'required|numeric|min:1950|max:' . (date('Y') + 1),
            'transcript_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('transcript_image')) {
            $path = $request->file('transcript_image')->store('transcripts', 'public');
            $validated['transcript_image'] = $path;
        }

        EducationHistory::create($validated);

        return redirect()->back()->with('success', 'Đã thêm hồ sơ học vấn mới!');
    }

    public function update(Request $request, EducationHistory $education_history)
    {
        $validated = $request->validate([
            'school' => 'required|max:255',
            'major' => 'required|max:255',
            'degree' => 'required|max:255',
            'year' => 'required|numeric|min:1950|max:' . (date('Y') + 1),
            'transcript_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($request->hasFile('transcript_image')) {
            // Delete old image
            if ($education_history->transcript_image) {
                Storage::disk('public')->delete($education_history->transcript_image);
            }
            $path = $request->file('transcript_image')->store('transcripts', 'public');
            $validated['transcript_image'] = $path;
        }

        $education_history->update($validated);

        return redirect()->back()->with('success', 'Đã cập nhật hồ sơ học vấn!');
    }

    public function destroy(EducationHistory $education_history)
    {
        if ($education_history->transcript_image) {
            Storage::disk('public')->delete($education_history->transcript_image);
        }
        $education_history->delete();
        return redirect()->back()->with('success', 'Đã xóa hồ sơ học vấn.');
    }
}
