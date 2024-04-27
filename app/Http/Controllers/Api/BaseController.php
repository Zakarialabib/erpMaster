<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

/**
 *
 * @author yois
 *
 */
class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return Response
     */
    public function sendResponse($result, $message, $count = null)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
            'meta'    => ['count' => $count ?? 0],
        ];

        return response()->json($response);
    }

    /**
     * return error response.
     *
     * @return Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
            'code'    => $code,
        ];

        if ( ! empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
