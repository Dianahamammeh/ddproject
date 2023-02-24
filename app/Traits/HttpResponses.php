<?php

namespace App\Traits;

trait HttpResponses
{
    protected function success($data = null, $message = null, $code = 200)
    {
        $res = ['status' => 'Request was successful.'];
        if ($message != null)
            $res['message'] = $message;
        if ($data != null)
            $res['data'] = $data;

        return response()->json($res, $code);
    }

    protected function error($data = null, $message = null, $code = 403)
    {
        $res = $data == null ? [] : $data;
        $res  ['status'] = 'Error has occurred.';

        if ($message != null)
            $res['message'] = $message;

        return response()->json($res, $code);
    }
}
