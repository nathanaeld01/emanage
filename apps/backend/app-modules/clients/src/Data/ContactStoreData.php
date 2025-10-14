<?php

namespace Modules\Clients\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ContactStoreData extends Data {
    public function __construct(
        public string $contact_name,
        public string $client_id,
        public string $email,
        public string $phone,
    ) {
        //
    }

    public static function rules(?ValidationContext $context = null): array {
        return [
            'contact_name' => ['required', 'string', 'max:255'],
            'client_id' => ['required', 'exists:clients,id'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
        ];
    }

    public static function messages(...$args): array {
        return [
            'contact_name.required' => 'The contact name is required.',
            'contact_name.string' => 'The contact name must be a string.',
            'contact_name.max' => 'The contact name may not be greater than 255 characters.',

            'client_id.required' => 'The client ID is required.',
            'client_id.exists' => 'The selected client ID is invalid.',

            'email.required' => 'The email address is required.',
            'email.email' => 'The email address must be a valid email.',
            'email.max' => 'The email address may not be greater than 255 characters.',

            'phone.required' => 'The phone number is required.',
            'phone.string' => 'The phone number must be a string.',
            'phone.max' => 'The phone number may not be greater than 20 characters.',
        ];
    }
}
