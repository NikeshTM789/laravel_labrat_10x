<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class BaseApiController extends Controller {

	public function sendResponse($data, $message = 'OK') {
		$response = [
			'success' => true,
			'data' => $data,
			'message' => $message,
		];
		return response()->json($response, 200);
	}

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
