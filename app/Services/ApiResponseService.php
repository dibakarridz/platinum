<?php

namespace App\Services;

use Illuminate\Http\Request;
use Auth;

class ApiResponseService
{
	public function __construct()
	{
		//
	}

	public function sendSuccessResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public function sendNotFoundResponse($result, $message)
    {
        $response = [
            'success' => false,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 404);
    }

    public function sendValidationErrorResponse($result, $message)
    {
        $response = [
            'success' => false,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 400);
    }
}
