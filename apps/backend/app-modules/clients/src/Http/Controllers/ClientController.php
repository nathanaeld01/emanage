<?php

namespace Modules\Clients\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Clients\Models\Client;

class ClientController {
    public function store(Request $request): JsonResponse {
        DB::transaction(function () use ($request) {
            Client::create([
                'client_name' => $request->input('client_name'),
                'sales_agent_id' => $request->input('sales_agent_id'),
            ]);
        });

        return api()->success('Client created successfully');
    }
}
