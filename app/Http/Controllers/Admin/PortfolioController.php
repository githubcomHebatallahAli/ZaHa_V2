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
            'data' => $Portfolios->map(function ($Portfolio) {
                return [
                    'id' => $Portfolio->id,
                    'name' => $Portfolio->name,
                    'description' => $Portfolio->description,
                    'mainImage' => $Portfolio->mainImage,
                    'projectType' => $Portfolio->projectType,
                    'endDate' => $Portfolio->endDate,
                    'status' => $Portfolio->status,
                ];
            }),
            'message' => "Show All Portfolios Successfully."
        ]);
    }


    public function create(PortfolioRequest $request)
    {
        $this->authorize('manage_users');

        $Portfolio = Portfolio::create([
            "name" => $request->name,
            // "slug" => $request->slug,
            "description" => $request->description,
            "programLang" => $request-> programLang,
            "startDate" => $request->startDate,
            "endDate" => $request->endDate,
            "url" => $request->url,
            "projectType" => $request-> projectType,
            "videoUrl" => $request->videoUrl,
            "status" => 'active',
        ]);

        $slug = $this->generateSlug($Portfolio->name, $Portfolio->id);
        $Portfolio->slug = $slug;

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

        $Portfolio->save();

        return response()->json([
            'data' => new PortfolioResource($Portfolio),
            'message' => "Portfolio Created Successfully."
        ]);
    }

    private function generateSlug($name, $id)
    {
        $slug = strtolower(str_replace(' ', '-', $name));

        $slug = $slug . '-' . $id;

        return $slug;
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

     if ($request->filled('name')) {
        $Portfolio->name = $request->name;
    }

     if ($request->filled('description')) {
        $Portfolio->description = $request->description;
    }

     if ($request->filled('programLang')) {
        $Portfolio->programLang = $request->programLang;
    }

     if ($request->filled('url')) {
        $Portfolio->url = $request->url;
    }

    if ($request->filled('startDate')) {
        $Portfolio->startDate = $request->startDate;
    }

     if ($request->filled('endDate')) {
        $Portfolio->endDate = $request->endDate;
    }
     if ($request->filled('projectType')) {
        $Portfolio->projectType = $request->projectType;
    }
     if ($request->filled('videoUrl')) {
        $Portfolio->videoUrl = $request->videoUrl;
    }
     if ($request->filled('status')) {
        $Portfolio->status = $request->status;
    }

    $slug = $this->generateSlug($Portfolio->name, $Portfolio->id);
    $Portfolio->slug = $slug;


        if ($request->hasFile('mainImage')) {
            if ($Portfolio->mainImage) {
                Storage::disk('public')->delete($Portfolio->mainImage);
            }
            $mainImagePath = $request->file('mainImage')->store('Portfolio', 'public');
            $Portfolio->mainImage = $mainImagePath;
        } else {
            $mainImagePath = $Portfolio->mainImage;
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
        } else {
            $imagesPaths = $Portfolio->images;
        }

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
