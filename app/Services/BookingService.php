<?php

namespace App\Services;

use App\Models\Booking;

class BookingService
{
    public function create(array $data): Booking
    {
        return Booking::create($data);
    }

    public function update($id, array $data): Booking
    {
        $booking = Booking::findOrFail($id);
        $booking->update($data);

        return $booking;
    }
}
