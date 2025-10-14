<?php

namespace Modules\Employees\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class EmployeeStoreData extends Data {
    public function __construct(
        public string $employee_code,
        public string $first_name,
        public ?string $middle_name,
        public string $last_name,
        public string $email,
        public ?string $personal_email,
        public ?string $profile_photo,
        public ?int $department_id,
        public ?int $designation_id,
    ) {
        //
    }

    public static function rules(?ValidationContext $context = null): array {
        return [
            'employee_code' => ['required', 'string', 'max:50', 'unique:employees,employee_code'],
            'first_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:employees,email'],
            'personal_email' => ['nullable', 'email', 'max:150'],
            'profile_photo' => ['nullable', 'string', 'max:255'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'designation_id' => ['nullable', 'integer', 'exists:designations,id'],
        ];
    }

    public static function messages(...$args): array {
        return [
            'employee_code.required' => 'Employee code is required',
            'employee_code.string' => 'Employee code must be a string',
            'employee_code.max' => 'Employee code must not exceed 50 characters',
            'employee_code.unique' => 'Employee code must be unique',

            'first_name.required' => 'First name is required',
            'first_name.string' => 'First name must be a string',
            'first_name.max' => 'First name must not exceed 100 characters',

            'middle_name.string' => 'Middle name must be a string',
            'middle_name.max' => 'Middle name must not exceed 100 characters',

            'last_name.required' => 'Last name is required',
            'last_name.string' => 'Last name must be a string',
            'last_name.max' => 'Last name must not exceed 100 characters',

            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.max' => 'Email must not exceed 150 characters',
            'email.unique' => 'Email must be unique',

            'personal_email.email' => 'Personal email must be a valid email address',
            'personal_email.max' => 'Personal email must not exceed 150 characters',

            'profile_photo.string' => 'Profile photo must be a string',
            'profile_photo.max' => 'Profile photo must not exceed 255 characters',

            // 'department_id.required' => 'Department ID is required',
            'department_id.integer' => 'Department ID must be an integer',
            'department_id.exists' => 'Department ID must exist in departments table',

            // 'designation_id.required' => 'Designation ID is required',
            'designation_id.integer' => 'Designation ID must be an integer',
            'designation_id.exists' => 'Designation ID must exist in designations table',
        ];
    }
}
