<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utilities\HelperControler;
use App\Models\GroupOfSets;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function getAll()
    {
        $props = GroupOfSets::all()->map(function ($group) {
            return [
                'id' => $group->id,
                'name' => $group->name,
                'sanctions_count' => $group->employees()->get()->sum(fn ($emp) => $emp->sanctions()->count())
            ];
        });
        return response()->json($props->toArray());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);
        GroupOfSets::create($request->all());
        return back();
    }

    public function delete(GroupOfSets $group)
    {
        $group->delete();
        return back();
    }

    public function edit(Request $request, GroupOfSets $group)
    {
        $group->update($request->all());
        return back();
    }
    public function getDays(GroupOfSets $group)
    {
        $data = $group->shifts->map(fn ($item) => [
            'id' => $item->id,
            'day' => $item->day,
            'name' => $item->name,
            'primary_enter' => HelperControler::ampm2arabic($item->primary_enter),
            'primary_exit' => HelperControler::ampm2arabic($item->primary_exit),
            'secondary_enter' => HelperControler::ampm2arabic($item->secondary_enter),
            'secondary_exit' => HelperControler::ampm2arabic($item->secondary_exit)
        ]);
        return response()->json($data);
    }

    public function storeDay(Request $request, GroupOfSets $group)
    {
        $request->validate([
            'day' => 'required',
            'periods' => 'required|array',
            'periods.*.name' => 'required|string',
            'periods.*.primary_enter' => 'required|string',
            'periods.*.primary_exit' => 'required|string',
            'periods.*.secondary_enter' => 'required|string|after:primary_enter',
            'periods.*.secondary_exit' => 'required|string|after:primary_exit',
        ]);

        foreach ($request->periods as $day) {
            $day['day'] = $request->day;
            $group->shifts()->create($day);
        }

        return back();
    }

    private function validateTime(string $first, string $second)
    {
        return Carbon::parse($first)->greaterThan(Carbon::parse($second));
    }

    public function deleteDay(Shift $shift)
    {
        $shift->delete();
        return back();
    }

    public function editDay(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:shifts,id',
            'day' => 'required',
            'name' => 'required|string',
            'primary_enter' => 'required|string',
            'primary_exit' => 'required|string',
            'secondary_enter' => 'required|string',
            'secondary_exit' => 'required|string',
        ]);

        $shift = Shift::find($request->id);
        $shift->update($request->except('id'));
        return back();
    }
}
