<?php


namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    /**
     * 登录方法
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $params = $request->all();

        // 请求参数校验
        if ($message = validateParams(
            $params,
            ['uname' => 'required', 'upwd' =>'required|min:6'],
            ['uname.required'=>'请输入常用用户名', 'upwd.required'=>'请输入密码', 'upwd.min'=>'请输入至少6位的常用密码']
        )) {
            return responseFailed($message);
        }

        $password = md5($params['upwd'] . config('auth.password_key'));

        $user = User::query()
            ->where('uname', $params['uname'])
            ->where('upwd', $password)
            ->where('is_del', 1)
            ->first();

        if (empty($user)) {
            return responseFailed("无对应用户信息");
        }

        $token = $user->createToken('api')->accessToken;
        return responseSuccess(['token' => $token]);
    }

}
