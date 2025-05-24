<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseAPI
{
    /**
     * Core of response
     *
     * @param   string          $message
     * @param   array|object    $data
     * @param   integer         $statusCode
     * @param   boolean         $isSuccess
     */

    private function coreResponse(array $data, int $code = 200): JsonResponse
    {
        return response()->json($data, $code);
    }

    public function success($contents, $is_data = true, $meta = false)
    {
        $data = ['status' => true];
        if ($is_data) {
            $data['data'] = $contents;
        } else {
            $data = array_merge($data, $contents);
        }
        if ($meta) {
            $data['meta'] = $meta;
        }
        return $this->coreResponse($data);
    }

    public function error($message, $code = 422): JsonResponse
    {
        return $this->coreResponse(
            ['status' => false, 'message' => $message],
            $code
        );
    }

}
