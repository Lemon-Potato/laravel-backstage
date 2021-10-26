<?php

/**
 * 统一成功返回
 * @param $data
 * @param int $code
 * @param string $msg
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('responseSuccess')) {
    function responseSuccess($data, $code = 200, $msg = "")
    {
        return response()->json(['code' => $code, 'data' => $data, 'msg' => $msg], 200);
    }
}
/**
 * 统一失败返回
 * @param $data
 * @param int $code
 * @param string $msg
 * @return \Illuminate\Http\JsonResponse
 */
if (!function_exists('responseFailed')) {
    function responseFailed($msg = "", $code = 500, $data=[])
    {
        return response()->json(['code' => $code, 'data' => $data, 'error' => $msg], 401);
    }
}

/**
 * 验证表单规则
 * @param array $params
 * @param $rules
 * @param $messages
 * @return string|null
 * */
if (!function_exists('validateParams')) {
    function validateParams(array $params, array $rules, array $messages)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($params, $rules, $messages);
        if ($validator->fails()) {
            $bags = $validator->getMessageBag()->toArray();
            foreach ($bags as $bag) {
                foreach ($bag as $item) {
                    return $item;
                }
            }
        }
        return null;
    }
}
