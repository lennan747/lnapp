<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Transformers\V1\UserAddressTransformer;

class UserAddressesController extends Controller
{
    //
    public function index()
    {
        $userAddresses = $this->user()->addresses()->get();
        return $this->response->collection($userAddresses,new UserAddressTransformer())->setStatusCode(200);
    }
}
