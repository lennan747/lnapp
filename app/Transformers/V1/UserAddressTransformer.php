<?php
/**
 * Created by PhpStorm.
 * User: leona
 * Date: 2019/10/22
 * Time: 22:05
 */

namespace App\Transformers\V1;

use App\Models\UserAddress;
use League\Fractal\TransformerAbstract;

class UserAddressTransformer extends TransformerAbstract
{
    public function transform(UserAddress $address){
        return [
            'id'                => $address->id,
            'province'          => $address->province,
            'city'              => $address->city,
            'district'          => $address->district,
            'address'           => $address->address,
            'zip'               => $address->zip,
            'contact_name'      => $address->contact_name,
            'contact_phone'     => $address->contact_phone,
            'last_used_at'      => $address->last_used_at,
        ];
    }
}