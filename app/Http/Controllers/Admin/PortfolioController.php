<?php

namespace App\Http\Controllers\Admin;


use App\Models\Portfolio;
use App\Traits\ManagesModelsTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\PortfolioRequest;
use App\Http\Resources\Admin\PortfolioResource;

class PortfolioController extends Controller
{
    use ManagesModelsTrait;
    public function showAll()
    {
        $this->authorize('manage_users');

        $Portfolios = Portfolio::get();
        return response()->json([
            'data' => PortfolioResource::collection($Portfolios),
            'message' => "Show All Portfolios Successfully."
        ]);
    }




    public function create(PortfolioRequest $request)
    {
        $this->authorize('manage_users');

        $Portfolio = Portfolio::create([
            "name" => $request->name,
            "description" => $request->description,
            "programLang" => $request-> programLang,
            "startDate" => $request->startDate,
            "endDate" => $request->endDate,
            "url" => $request->url,
            "projectType" => $request-> projectType,
            "videoUrl" => $request->videoUrl,
            "status" => 'active',
        ]);
        if ($request->hasFile('mainImage')) {
            $mainImagePath = $request->file('mainImage')->store(Portfolio::storageFolder);
            $Portfolio->mainImage =  $mainImagePath;
        }

        if ($request->hasFile('images')) {
            $imagesPaths = [];

            foreach ($request->file('images') as $image) {
                $path = $image->store(Portfolio::storageFolder);
                $imagesPaths[] = $path;
            }

            $Portfolio->images = $imagesPaths;
        }
        // if ($request->hasFile('video')) {
        //     $videoPath = $request->file('video')->store(Portfolio::storageFolder);
        //     $Portfolio->video =  $videoPath;
        // }

        $Portfolio->save();

        return response()->json([
            'data' => new PortfolioResource($Portfolio),
            'message' => "Portfolio Created Successfully."
        ]);
    }


    public function edit(string $id)
    {
        $this->authorize('manage_users');
        $Portfolio = Portfolio::find($id);

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



    public function update(PortfolioRequest $request, string $id)
    {
        $this->authorize('manage_users');
       $Portfolio =Portfolio::findOrFail($id);

       if (!$Portfolio) {
        return response()->json([
            'message' => "Portfolio not found."
        ], 404);
    }
       $Portfolio->update([
            "name" => $request->name,
            "description" => $request->description,
            "programLang" => $request-> programLang,
            "startDate" => $request->startDate,
            "endDate" => $request->endDate,
            "url" => $request->url,
            "projectType" => $request-> projectType,
            "videoUrl" => $request->videoUrl,
            "status" => $request-> status,
        ]);

        if ($request->hasFile('mainImage')) {
            if ($Portfolio->mainImage) {
                Storage::disk('public')->delete($Portfolio->mainImage);
            }
            $mainImagePath = $request->file('mainImage')->store('Portfolio', 'public');
            $Portfolio->mainImage = $mainImagePath;
        }

        if ($request->hasFile('images')) {
            if ($Portfolio->images) {
                foreach ($Portfolio->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $imagesPaths = [];

            foreach ($request->file('images') as $image) {
                $path = $image->store('Portfolio', 'public');

                $imagesPaths[] = $path;
            }

            $Portfolio->images = $imagesPaths;
        }

        // if ($request->hasFile('video')) {
        //     if ($Portfolio->video) {
        //         Storage::disk('public')->delete($Portfolio->video);
        //     }
        //     $videoPath = $request->file('video')->store('Portfolio', 'public');
        //     $Portfolio->video = $videoPath;
        // }

       $Portfolio->save();
       return response()->json([
        'data' =>new PortfolioResource($Portfolio),
        'message' => " Update Portfolio By Id Successfully."
    ]);

  }

  public function destroy(string $id)
  {
      return $this->destroyModel(Portfolio::class, PortfolioResource::class, $id);
  }

  public function showDeleted()
  {
    $this->authorize('manage_users');
$Portfolios=Portfolio::onlyTrashed()->get();
return response()->json([
    'data' =>PortfolioResource::collection($Portfolios),
    'message' => "Show Deleted Portfolios Successfully."
]);

}

public function restore(string $id)
{
   $this->authorize('manage_users');
$Portfolio = Portfolio::withTrashed()->where('id', $id)->first();
if (!$Portfolio) {
    return response()->json([
        'message' => "Portfolio not found."
    ], 404);
}
$Portfolio->restore();
return response()->json([
    'data' =>new PortfolioResource($Portfolio),
    'message' => "Restore Portfolio By Id Successfully."
]);
}

  public function forceDelete(string $id)
  {
      return $this->forceDeleteModel(Portfolio::class, $id);
  }

  public function active(string $id)
  {
      $this->authorize('manage_users');
      $Portfolio =Portfolio::findOrFail($id);

      if (!$Portfolio) {
       return response()->json([
           'message' => "Portfolio not found."
       ], 404);
   }

      $Portfolio->update(['status' => 'active']);

      return response()->json([
          'data' => new PortfolioResource($Portfolio),
          'message' => 'Portfolio has been active.'
      ]);
  }

  public function notActive(string $id)
  {
      $this->authorize('manage_users');
      $Portfolio =Portfolio::findOrFail($id);

      if (!$Portfolio) {
       return response()->json([
           'message' => "Portfolio not found."
       ], 404);
   }

      $Portfolio->update(['status' => 'notActive']);

      return response()->json([
          'data' => new PortfolioResource($Portfolio),
          'message' => 'Portfolio has been notActive.'
      ]);
  }
}
