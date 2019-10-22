<?php

namespace App\Transformers\V1;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'               => $user->id,
            'name'             => $user->name,
            'email'            => $user->email,
            'avatar'           => $user->avatar,
            'introduction'     => $user->introduction,
            'bound_phone'      => $user->phone ? true : false,
            'bound_wechat'     => ($user->weixin_unionid || $user->weixin_openid) ? true : false,
            'created_at'       => (string) $user->created_at,
            'updated_at'       => (string) $user->updated_at,
        ];
    }
}
