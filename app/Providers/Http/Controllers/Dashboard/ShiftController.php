<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utilities\HelperControler;
use App\Models\GroupEmployees;
use App\Models\GroupOfSets;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        [$filter, $hasFilter] = HelperControler::getFiltersFromRequest();
        $groups = GroupOfSets::query();

        if ($hasFilter) {
            $groups
                ->when($filter['day'], fn ($q, $r) => $q->whereRelation('shifts', 'day', $r))
                ->when($filter['from_date'], fn ($q, $r) => $q->whereIn('id', GroupEmployees::whereDate('start', '<=', $r)->pluck('group_of_sets_id')))
                ->when($filter['to_date'], fn ($q, $r) => $q->whereIn('id', GroupEmployees::whereDate('end', '<=', $r)->pluck('group_of_sets_id')))
                ->when($filter['group'], fn ($q, $r) => $q->where('id', $r));
        }

        return inertia()->render('Dashboard/Shift/Index', [
            'groupProp' => $groups->get()->map(function ($group) {
                return [
                    'id' => $group->id,
                    'name' => $group->name,
                    'sanctions_count' => $group->employees()->get()->sum(fn ($emp) => $emp->sanctions()->count())
                ];
            }),
            // 'filter' => $filter
        ]);
    }
}
