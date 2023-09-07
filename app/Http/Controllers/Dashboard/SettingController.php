<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CareerCategory;
use App\Models\CareerDegree;
use App\Models\Task;
use App\Models\Vacation;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $props = [];
        return inertia()->render('Dashboard/Setting/index', $props);
    }

    public function storeCareer(Request $request, string $type)
    {
        $request->validate([
            'name' => 'required|string',
            'balance' => 'nullable'
        ]);
        $types = ['category', 'degree', 'vacation', 'task'];

        if (!in_array($type, $types)) return back()->withErrors([
            'message' => 'يرجى التأكد من اليانات المرسلة'
        ]);

        switch ($type) {
            case $types[0]:
                $request->validate(['id' => 'nullable|exists:career_categories,id']);
                CareerCategory::query()->updateOrCreate($request->only(['id']), $request->only(['name']));
                break;
            case $types[1]:
                $request->validate(['id' => 'nullable|exists:career_degrees,id']);
                CareerDegree::query()->updateOrCreate($request->only(['id']), $request->only(['name']));
                break;
            case $types[2]:
                $request->validate(['id' => 'nullable|exists:vacations,id']);
                Vacation::query()->updateOrCreate(
                    $request->only(['id']),
                    $request->only(['name', 'balance'])
                );
                break;
            default:
                $request->validate(['id' => 'nullable|exists:tasks,id']);
                Task::query()->updateOrCreate(
                    $request->only(['id']),
                    $request->only(['name', 'balance'])
                );
                break;
        }
        return back();
    }

    public function destroySetting(int $id, string $type)
    {
        $types = ['category', 'degree', 'vacation', 'task'];
        if (!in_array($type, $types)) {
            return back()->withErrors([
                'message' => 'يرجى التأكد من اليانات المرسلة'
            ]);
        }
        switch ($type) {
            case $types[0]:
                $model = CareerCategory::find($id);
                if ($model) {
                    $model->delete();
                }
                break;
            case $types[1]:
                $model = CareerDegree::find($id);
                if ($model) {
                    $model->delete();
                }
                break;
            case $types[2]:
                $model = Vacation::find($id);
                if ($model) {
                    $model->delete();
                }
                break;
            default:
                $model = Task::find($id);
                if ($model) {
                    $model->delete();
                }
                break;
        }
    }
}
