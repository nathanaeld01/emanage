<?php

namespace Modules\Employees\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Modules\Employees\Data\EmployeeStoreData;
use Modules\Employees\Models\Employee;
use Str;

class EmployeeController {
    public function store(EmployeeStoreData $data): JsonResponse {
        DB::transaction(function () use ($data) {
            $employee = Employee::create($data->toArray());

            $employee->user()->create([
                'name' => $employee->full_name,
                'email' => $data->email,
                'password' => bcrypt(Str::random(16)),
            ]);
        });

        return api()->success(
            message: 'Employee created successfully',
            status: 201,
        );
    }
}
