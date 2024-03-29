<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\V1\UserRequest;
use App\Models\User;
use App\Transformers\V1\UserTransformer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    // $request->verification_key 验证码key
    // $request->verification_code 验证码
    public function store(UserRequest $request)
    {
        $verifyData = Cache::get($request->verification_key);

        // 422用来表示校验错误
        if (!$verifyData) {
            return $this->response->error('验证码已失效', 422);
        }

        // 401  没有进行认证或者认证非法
        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            return $this->response->errorUnauthorized('验证码错误');
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
        ]);

        // 清除验证码缓存
        Cache::forget($request->verification_key);

        return $this->response->item($user, new UserTransformer())
            ->setMeta([
                'access_token' => Auth::guard('api')->fromUser($user),
                'token_type' => 'Bearer',
                'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
            ])
            ->setStatusCode(201);
    }

    public function me()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }
}
