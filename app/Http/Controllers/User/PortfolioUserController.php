<?php

namespace App\Http\Controllers\User;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PortfolioResource;

class PortfolioUserController extends Controller
{
    public function showAll()
    {
        $Portfolios = Portfolio::where('status', 'active')
        ->get();
        return response()->json([
            'data' => PortfolioResource::collection($Portfolios),
            'message' => "Show All Portfolios Successfully."
        ]);
    }

    public function edit(string $id)
    {
        $Portfolio = Portfolio::where('status', 'active')
        ->find($id);

        if (!$Portfolio) {
            return response()->json([
                'message' => "Portfolio not found."
            ], 404);
        }

        return response()->json([
            'data' =>new PortfolioResource($Portfolio),
            'message' => "Edit Portfolio By ID Successfully."
        ]);
    }

}
