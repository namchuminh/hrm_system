<?php
namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $query = Position::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $positions = $query->latest()->paginate(10)->withQueryString();

        return view('positions.index', compact('positions'));
    }

    public function create()
    {
        return view('positions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:positions|max:255',
            'basic_salary' => 'required|numeric',
            'allowance' => 'required|numeric',
        ], [
            'name.required' => 'Vui lòng nhập tên chức vụ.',
            'name.unique' => 'Tên chức vụ này đã tồn tại.',
            'basic_salary.required' => 'Vui lòng nhập lương cơ bản.',
            'basic_salary.numeric' => 'Lương cơ bản phải là một con số.',
            'allowance.required' => 'Vui lòng nhập phụ cấp.',
            'allowance.numeric' => 'Phụ cấp phải là một con số.',
        ]);

        Position::create($validated);
        return redirect()->route('positions.index')->with('success', 'Đã tạo chức vụ mới!');
    }

    public function edit(Position $position)
    {
        return view('positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:positions,name,' . $position->id,
            'basic_salary' => 'required|numeric',
            'allowance' => 'required|numeric',
        ], [
            'name.required' => 'Vui lòng nhập tên chức vụ.',
            'name.unique' => 'Tên chức vụ này đã tồn tại.',
            'basic_salary.required' => 'Vui lòng nhập lương cơ bản.',
            'basic_salary.numeric' => 'Lương cơ bản phải là một con số.',
            'allowance.required' => 'Vui lòng nhập phụ cấp.',
            'allowance.numeric' => 'Phụ cấp phải là một con số.',
        ]);

        $position->update($validated);
        return redirect()->route('positions.index')->with('success', 'Cập nhật chức vụ thành công!');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('positions.index')->with('success', 'Đã xóa chức vụ.');
    }
}
