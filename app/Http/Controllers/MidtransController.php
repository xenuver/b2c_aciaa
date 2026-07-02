<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function notification(Request $request, MidtransService $midtransService)
    {
        try {
            $rawPayload = $request->getContent();

            if ($rawPayload === '' && $request->all()) {
                $rawPayload = json_encode($request->all());
            }

            $midtransService->handleNotification($rawPayload);

            return response()->json(['message' => 'OK'], 200);
        } catch (\Throwable $e) {
            Log::error('Midtrans notification error: ' . $e->getMessage(), [
                'body' => $request->getContent(),
                'exception' => $e,
            ]);

            return response()->json(['message' => 'Error'], 500);
        }
    }
}
