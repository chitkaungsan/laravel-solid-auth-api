<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\BookingStoreRequest;
use App\Http\Requests\Booking\BookingUpdateRequest;
use App\Models\Booking;
use App\Services\BookingService;
use App\Http\Resources\BookingResource;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $bookings = Booking::with('customer')->latest()->get();

        return BookingResource::collection($bookings);
    }

    public function store(BookingStoreRequest $request)
    {
        $booking = $this->bookingService->create($request->validated());

        return new BookingResource($booking);
    }

    public function show($id)
    {
        $booking = Booking::with('customer')->findOrFail($id);

        return new BookingResource($booking);
    }

    public function update(BookingUpdateRequest $request, $id)
    {
        $booking = $this->bookingService->update($id, $request->validated());

        return new BookingResource($booking);
    }

    public function destroy($id)
    {
        Booking::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
