<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GroupOfSets;
use App\Models\Sanction;
use Illuminate\Http\Request;

class SanctionController extends Controller
{
    public function getSanction(GroupOfSets $group = null)
    {
        if (is_null($group)) {
            return Sanction::all()->toJson();
        }

        // get all employees then get all
        $sanctions = collect();
        $group->employees()->each(function ($emp) use ($sanctions) {
            $emp->sanctions()->each(function ($sanction) use ($emp, $sanctions) {
                $sanctions->add([
                    'id' => $sanction->id,
                    'name' => $sanction->name,
                    'value' => $sanction->value,
                    'isDone' => $sanction->isDone,
                    'employee_name' => $emp->name
                ]);
            });
        });

        return $sanctions->toJson();
    }

    public function closeSanction(Sanction $sanction)
    {
        $sanction->update([
            'isDone' => true,
        ]);
        return response()->json(true);
    }
}
