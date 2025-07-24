<?php

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\Requests\Mix\OrderRequest;

use App\Http\Resources\Mix\OrderResource;
use App\Models\Admin;
use App\Models\Order;
use App\Notifications\NewOrderNotification;


class OrderUserController extends Controller
{

    public function create(OrderRequest $request)
    {
           $order =Order::create ([
            'name'=> $request->name,
            'phoneNumber' => $request->phoneNumber,
            'creationDate' => now()->timezone('Africa/Cairo')->format('Y-m-d H:i:s'),
            'status' => 'pending',
            ]);

           $order->save();
           $superAdmin = Admin::where('role_id', 1)->where('status', 'active')->first();
           if ($superAdmin) {
               $superAdmin->notify(new NewOrderNotification($order));


           return response()->json([
            'data' =>new OrderResource($order),
            'message' => "Order Created Successfully."
        ]);

        }

    }

}
