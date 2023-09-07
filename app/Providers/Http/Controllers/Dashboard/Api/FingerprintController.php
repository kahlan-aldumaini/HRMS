<?php

namespace App\Http\Controllers\Dashboard\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\GroupEmployees;
use App\Models\Shift;
use App\Models\VacationEmployee;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FingerprintController extends Controller
{
    public function reciveFingerprint(Request $request)
    {
        $emp = Employee::with(['groups', 'groups.shifts']); // initial emplyee

        $time = $request->time; // initial time
        $now = Carbon::now();

        if (!$time)
            $time = $now->hour . ':' . $now->minute . ':' . $now->second;

        $month = $now->month < 10 ? "0$now->month" : $now->month;
        $day = $now->day < 10 ? "0$now->day" : $now->day;
        $today = "$now->year-$month-$day";

        $shifts = Shift::query()
            ->where('day', Carbon::now()->dayName)
            ->where('primary_enter', '<=', $time)
            ->where('secondary_exit', '>=', $time);

        if (!$shifts->exists()) {
            return response()->json(['message' => 'لا يوجد شفت في هذا الوقت او اليوم'], 422);
        }

        $groupEmp = GroupEmployees::query()
            ->where('employee_id', $request->id)
            ->whereIn('group_of_sets_id', $shifts->pluck('group_of_sets_id'))
            ->where('end', '>=', $today)
            ->where('start', '<=', $today);

        // chick if has any time for work in any group
        if (!$groupEmp->exists()) {
            return response()->json(['message' => 'الموظف غير مشترك في اي مجموعة.'], 422);
        }

        $empModel = $emp->find($request->id); // get employee model

        // chick if has any time for work in any group
        if (!$empModel) {
            return response()->json(['message' => 'الموظف غير موجود.'], 422);
        }

        if (!is_numeric($request->device_number)) {
            return response()->json(['message' => 'يجب ان يكون رقم الجهاز رقما.'], 422);
        }

        $has = $empModel->fingerprints()
            ->whereIn('shift_id', $shifts->pluck('id'))
            ->whereDate('created_at', $now); // create if has any fingerprint today
        try {
            DB::beginTransaction();
            if ($has->exists()) {
                /**
                 * if has any fingerprint today
                 * update exit if has login
                 */
                $has->each(function ($finger) use ($time, $shifts) {
                    if ($finger->login and $finger->exit == null)
                        $finger->update([
                            'exit' => $time,
                            'movement' =>  '---'
                        ]);
                    else {
                        DB::rollBack();
                        throw new Exception('لقد تمت اضافة جميع البصمات للشفت الحالي');
                    }
                });
                DB::commit();
                return response()->json([
                    'message' => 'تمت تعديل البصمة بنجاح.'
                ]);
            } else {
                $isOut = Shift::query()
                    ->where('day', Carbon::now()->dayName)
                    ->whereIn('group_of_sets_id', $groupEmp->pluck('group_of_sets_id'))
                    ->where('primary_exit', '<=', $time)
                    ->where('secondary_exit', '>=', $time);

                $isOut->each(fn ($q) => $empModel->fingerprints()->create([
                    'exit' => $time,
                    'device_number' => $request->device_number,
                    'shift_id' => $q->id,
                    'movement' => '---'
                ]));

                VacationEmployee::query()->where('employee_id', $request->id)
                    ->whereIn('shift_id', $shifts->pluck('id'))
                    ->where('start', '<=', $today)
                    ->where('end', '>=', $today)
                    ->each(function ($v) {
                        $v->update([
                            'last_balance' => Carbon::parse($v->end)->diffInDays(Carbon::now()),
                            'end' => Carbon::today()
                        ]);
                        $v->delete();
                    });

                if (!$shifts->exists() && !$isOut->exists()) {
                    DB::rollBack();
                    throw new Exception('لم تتم اضافة البصمة بسبب عدم وجود اي شفت في هذا الوقت');
                }


                $shifts->whereNotIn('id', $isOut->pluck('id'))
                    ->each(fn ($q) => $empModel->fingerprints()->create([
                        'login' =>  $time,
                        'device_number' => $request->device_number,
                        'shift_id' => $q->id,
                        'movement' => '---'
                    ]));


                DB::commit();
                return response()->json([
                    'message' => 'تمت اضافة البصمة بنجاح.'
                ]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e, 422);
        }
    }
}

enum FingerType: string
{
    case IN = 'in';
    case OUT = 'out';

    public static function get(string $type)
    {
        return match (str($type)->lower()) {
            'in' => self::IN,
            'out' => self::OUT,
            default => null
        };
    }
}
