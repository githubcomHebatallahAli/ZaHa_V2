<?php

namespace App\Http\Controllers\User;


use App\Models\Order;
use App\Http\Controllers\Controller;

use App\Http\Requests\Mix\OrderRequest;
use App\Http\Resources\Mix\OrderResource;


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

            // $admins = User::where('isAdmin', 1)->get();
            // foreach ($admins as $admin) {
            //     $admin->notify(new NewOrderNotification($order));
            //     Mail::to($admin->email)->send(new NewOrderMail($order));
            // }
            //     Mail::to($order->user->email)->send(new OrderWelcomeMail($order));
           $order->save();
           return response()->json([
            'data' =>new OrderResource($order),
            'message' => "Order Created Successfully."
        ]);

        }

    }

