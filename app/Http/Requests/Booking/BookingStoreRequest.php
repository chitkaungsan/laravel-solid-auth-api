<?php

namespace App\Http\Requests\Booking;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BookingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'service_name' => 'required|string|max:255',
            'booking_date' => 'required|date',
            'booking_time' => 'nullable',
            'people_count' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric',
            'status' => 'nullable|in:pending,confirmed,completed,cancelled',
            'note' => 'nullable|string',
        ];
    }
}
