<?php

namespace Modules\Clients\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Clients\Data\ContactStoreData;
use Modules\Clients\Models\Contact;

class ContactController {
    /**
     * Store a newly created contact along with an associated user.
     *
     * @param ContactStoreData $data
     * @return JsonResponse
     */
    public function store(ContactStoreData $data): JsonResponse {
        DB::transaction(function () use ($data) {
            $contact = Contact::create([
                'contact_name' => $data->contact_name,
                'client_id' => $data->client_id,
                'email' => $data->email,
                'phone' => $data->phone,
            ]);

            $contact->user()->create([
                'name' => $data->contact_name,
                'email' => $data->email,
                'password' => bcrypt('defaultpassword'), // Ensure to set a proper password or send a password setup link
            ]);

            DB::afterCommit(function () use ($contact) {
                // Dispatch any events or notifications here
                // event(new ContactCreated($contact));
            });

            DB::afterRollBack(function () use ($contact) {
                // Handle rollback actions if necessary
                // For example, log the rollback event
                // Log::info('Transaction rolled back for contact: ' . $contact->id);
            });
        });

        return api()->success(
            message: 'Contact created successfully',
            status: 201
        );
    }
}
