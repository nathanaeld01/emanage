<?php

namespace Modules\Employees\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Employees\Data\EmployeeStoreData;
use Modules\Employees\Models\Employee;
use Str;

class EmployeeController {
    public function store(EmployeeStoreData $data): JsonResponse {
        DB::transaction(function () use ($data) {
            $employee = Employee::create($data->toArray());

            $password = Str::random(16); // Generate a secure random password

            $employee->user()->create([
                'name' => $employee->full_name,
                'email' => $data->email,
                'password' => Hash::make($password), // secure random password
            ]);
        });

        return api()->success(
            message: 'Employee created successfully',
            status: 201
        );
    }
}
