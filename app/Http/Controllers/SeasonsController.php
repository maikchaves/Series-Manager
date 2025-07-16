<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Series;
use Illuminate\Http\Request;

class SeasonsController extends Controller
{
    public function index(Series $series)
    {
        //sem o () traz a collection seasons
        //$seasons = $series->seasons;

        //com () traz o relacionamento. Quero trazer na query os episódios relacionados juntos, então
        $seasons = $series->seasons()->with('episodes')->get();

        return view('seasons.index')->with('seasons', $seasons)->with('series', $series);
    }

}
