<?php
namespace App\Services;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Collection;

class TourService
{
    public function create(array $data): Tour
    {
        return Tour::create($data);
    }
    public function getAll(): Collection
    {
        return Tour::all();
    }
}
