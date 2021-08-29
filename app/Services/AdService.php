<?php

namespace App\Services;

use App\Models\Ad;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class AdService
 * @package App\Services
 */
class AdService
{
    /**
     * @return LengthAwarePaginator
     */
    public function getAllAds(): LengthAwarePaginator
    {
        $sortField = request('sort_field', 'created_at');
        if (!in_array($sortField, ['title', 'created_at'])) {
            $sortField = 'created_at';
        }

        $sortDirection = request('sort_by', 'desc');
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        return Ad::orderBy($sortField, $sortDirection)->paginate(10);
    }
}
