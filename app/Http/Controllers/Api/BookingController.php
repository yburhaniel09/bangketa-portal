<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Consignee;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends BaseController {

    public function consignee_details(Request $request, $id) {
        $consignee = Consignee::find($id);
        return $this->sendResponse($consignee, 'Success.');
    }

    public function consigner_details(Request $request, $id) {
        $consigner = User::find($id);
        return $this->sendResponse($consigner, 'Success.');
    }
}
