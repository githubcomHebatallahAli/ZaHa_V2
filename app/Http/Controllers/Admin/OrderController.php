<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Mix\OrderResource;



class OrderController extends Controller
{
    use ManagesModelsTrait;

public function showAll()
{
    $this->authorize('manage_users');

    $Orders = Order::get();
    return response()->json([
        'data' => OrderResource::collection($Orders),
        'message' => "Show All Orders Successfully."
    ]);
}


    public function edit(string $id)
    {
        $this->authorize('manage_users');
        $Order = Order::find($id);
        if (!$Order) {
            return response()->json([
                'message' => "Order not found."
            ], 404);
        }
        return response()->json([
            'data' =>new OrderResource($Order),
            'message' => "Edit Order for User Successfully."
        ]);

    }

    public function destroy(string $id)
    {
        return $this->destroyModel(Order::class, OrderResource::class, $id);
    }

    public function showDeleted()
    {
      $this->authorize('manage_users');
  $Orders=Order::onlyTrashed()->get();
  return response()->json([
      'data' =>OrderResource::collection($Orders),
      'message' => "Show Deleted Orders Successfully."
  ]);

  }

  public function restore(string $id)
  {
     $this->authorize('manage_users');
  $Order = Order::withTrashed()->where('id', $id)->first();
  if (!$Order) {
      return response()->json([
          'message' => "Order not found."
      ], 404);
  }
  $Order->restore();
  return response()->json([
      'data' =>new OrderResource($Order),
      'message' => "Restore Order By Id Successfully."
  ]);
  }

    public function forceDelete(string $id)
    {
        return $this->forceDeleteModel(Order::class, $id);
    }

}



