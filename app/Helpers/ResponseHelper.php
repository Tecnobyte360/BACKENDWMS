<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($data = [], string $message = 'Operación exitosa.', int $code = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error(string $message = 'Ocurrió un error.', $errors = null, int $code = 400)
    {
        $response = ['message' => $message];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
