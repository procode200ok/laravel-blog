<?php

namespace App\Http\Controllers\Ai;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class OpenApi extends Controller
{
    /**
     * get openApi token
     */
    public function getOpenAiData(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer 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',
            'Content-Type' => 'application/json'
        ])->post('https://api.openai.com/v1/moderations',[
            'input' => $request->input
        ]);

        return $response;
    }
}
