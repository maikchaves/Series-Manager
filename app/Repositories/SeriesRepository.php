<?php

namespace App\Repositories;

use App\Models\Series;
use App\Http\Requests\SeriesFormRequest;

interface SeriesRepository
{

    public function add(array $data): Series;
}
