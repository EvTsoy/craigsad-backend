<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Ad;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ad\StoreAdRequest;
use App\Http\Requests\Ad\UpdateAdRequest;
use App\Http\Resources\AdResource;
use App\Services\AdService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

/**
 * Class AdController
 * @package App\Http\Controllers\Api
 */
class AdController extends Controller
{
    /**
     * @param AdService $adService
     * @return AnonymousResourceCollection
     */
    public function index(AdService $adService): AnonymousResourceCollection
    {
        return AdResource::collection($adService->getAllAds());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAdRequest $request
     * @return Response
     */
    public function store(StoreAdRequest $request): Response
    {
        $ad = $request->user()->ads()
            ->create($request->validated());

        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $file) {
                $path = Storage::putFile('/public/images', $file);
                $url = Storage::url($path);
                $ad->images()->create([
                    'image_path' => substr($url, 1)
                ]);
            }
        }

        return response(new AdResource($ad), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Ad $ad
     * @return AdResource
     */
    public function show(Ad $ad): AdResource
    {
        return new AdResource($ad);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAdRequest $request
     * @param Ad $ad
     * @return Response
     */
    public function update(UpdateAdRequest $request, Ad $ad): Response
    {
        if (!Gate::allows('update-delete-ad', $ad)) {
            abort(403);
        }
        $ad->update($request->validated());

        return response(new AdResource($ad), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Ad $ad
     * @return Response
     */
    public function destroy(Ad $ad): Response
    {
        if (!Gate::allows('update-delete-ad', $ad)) {
            abort(403);
        }

        $ad->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
