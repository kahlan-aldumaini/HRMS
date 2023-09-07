<?php

namespace App\Console\Commands;

use App\Models\GroupEmployees;
use App\Models\GroupOfSets;
use App\Models\Period;
use App\Models\Sanction;
use App\Models\Shift;
use App\Models\TaskEmployee;
use App\Models\VacationEmployee;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ArchiveFingerPrint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:archive-finger-print';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive Fingerprint';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //TODO: archive fingerprint
        $now = Carbon::now();
        $time = $time = $now->hour . ':' . $now->minute . ':' . $now->second;
        Shift::whereTime('secondary_exit', '>', $time)->each(function ($shift) {
            GroupOfSets::withTrashed()
                ->whereRelation('shifts', 'id', $shift->id)
                ->each(function ($group) use ($shift) {

                    $group->employees()
                        ->whereDoesntHave('fingerprints', fn ($fing) => $fing
                            ->whereNotIn('employee_id', $group->employees->pluck('id'))
                            ->where('shift_id', $shift->id))
                        ->each(function ($emp) use ($group, $shift) {
                            if (
                                VacationEmployee::query()
                                ->whereDate('start', '<=', Carbon::now())
                                ->whereDate('end', '>=', Carbon::now())
                                ->where('shift_id', $shift->id)->exists()
                            ) {
                                VacationEmployee::query()
                                    ->whereDate('start', '<=', Carbon::now())
                                    ->whereDate('end', '>=', Carbon::now())
                                    ->where('shift_id', $shift->id)->delete();
                                return;
                            }

                            if (
                                TaskEmployee::query()
                                ->whereDate('start', '<=', Carbon::now())
                                ->whereDate('end', '>=', Carbon::now())
                                ->where('shift_id', $shift->id)->exists()
                            ) {
                                TaskEmployee::query()
                                    ->whereDate('start', '<=', Carbon::now())
                                    ->whereDate('end', '>=', Carbon::now())
                                    ->where('shift_id', $shift->id)->delete();
                                return;
                            }
                            $empSalary = $emp->salary()->orderByDesc('created_at')->first();;
                            $groupShift = $group->shifts->unique('day');
                            $numberOfWeek = Carbon::now()->weekNumberInMonth;
                            $daySalary = $empSalary?->salary / ($numberOfWeek * count($groupShift));
                            $emp->fingerprints()->each(function ($finger) use ($daySalary, $emp) {
                                $finger->sanctions()->create([
                                    'name' => 'غياب',
                                    'value' => number_format($daySalary * 2, 2),
                                    'isDone' => false,
                                    'employee_id' => $emp->id
                                ]);
                            });
                        });
                });

            $shift->fingerprints()
                ->with(['employee', 'employee.salary'])
                ->whereNull('exit')
                ->each(function ($finger) use ($shift) {
                    $daySalary = $this->daySalary($finger->employee, $shift);
                    $finger->sanctions()->create([
                        'name' => 'لم يتم تسجيل بصمة خروج',
                        'value' => number_format($daySalary / 2, 2),
                        'isDone' => false,
                        'employee_id' => $finger->employee->id
                    ]);
                });

            $shift->fingerprints()
                ->whereNull('login')
                ->each(function ($finger) use ($shift) {
                    $daySalary = $this->daySalary($finger->employee, $shift);
                    $finger->sanctions()->create([
                        'name' => 'لم يتم تسجيل بصمة دخول',
                        'value' => number_format($daySalary / 2, 2),
                        'isDone' => false,
                        'employee_id' => $finger->employee->id
                    ]);
                });

            $shift->fingerprints()
                ->whereTime('login', '<', $shift->secondary_enter)
                ->each(function ($finger) use ($shift) {
                    $daySalary = $this->daySalary($finger->employee, $shift);
                    $shiftHourForLogin = Carbon::parse($shift->primary_enter)->diffInHours($finger->login) * 2;
                    if ($shiftHourForLogin > 0) {
                        $finger->sanctions()->create([
                            'name' => 'تأخر في بصمة الدخول',
                            'value' => number_format($daySalary / $shiftHourForLogin, 2),
                            'isDone' => false,
                            'employee_id' => $finger->employee->id
                        ]);
                    }
                    $shiftHourForExit = Carbon::parse($finger->exit)->diffInHours($shift->primary_exit) * 2;
                    if ($shiftHourForLogin > 0) {
                        $finger->sanctions()->create([
                            'name' => 'تأخر في بصمة الخروج',
                            'value' => $shiftHourForExit != 0 ? number_format($daySalary / $shiftHourForExit, 2) : 0,
                            'isDone' => false,
                            'employee_id' => $finger->employee->id
                        ]);
                    }
                });

            $shift->fingerprints()->update([
                'deleted_at' => Carbon::now()
            ]);
        });

        GroupEmployees::whereDate('end', '<', Carbon::now())->delete();
    }

    public function daySalary($emp, $shift)
    {
        $group = GroupOfSets::withTrashed()->with('shifts')
            ->whereRelation('shifts', 'id', $shift->id)
            ->whereIn('id', GroupEmployees::where('employee_id', $emp->id)->pluck('group_of_sets_id'))
            ->first();
        $empSalary = $emp?->salary()->orderByDesc('created_at')->first();
        if (!$empSalary) return 0;
        $groupShift = $group?->shifts->unique('day');
        $numberOfWeek = Carbon::now()->weekNumberInMonth;
        return  $empSalary?->salary / ($numberOfWeek * count($groupShift ?? [1]));
    }
}
