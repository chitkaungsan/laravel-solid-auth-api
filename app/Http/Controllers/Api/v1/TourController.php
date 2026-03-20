<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Tour\TourStoreRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Services\TourService;

class TourController extends Controller
{
    protected $tourService;

    public function __construct(TourService $tourService)
    {
        $this->tourService = $tourService;
    }
    public function index(){
        $tours = $this->tourService->getAll();
        return TourResource::collection($tours);
    }

    public function store(TourStoreRequest $request){
        $tour = Tour::create($request->validated());
        return new TourResource($tour);
    }
}
