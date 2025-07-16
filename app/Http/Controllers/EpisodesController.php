<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EpisodesController extends Controller
{

    public function index(Season $season)
    {

        $mensagem = session('mensagem.sucesso');

        return view('episodes.index', ['episodes' => $season->episodes])
            ->with('mensagemSucesso', $mensagem);;
    }

    public function update(Request $request, Season $season)
    {
        $watched = implode(', ', $request->episodes ?? []);
        if (empty($watched)) {
            DB::transaction(function () use ($season) {
                $season->episodes()->update(['watched' => 0]);
            });
            return redirect()->route('episodes.index', $season->id)->with('mensagem.sucesso', "Episódios assistidos foram atualizados");
        }

        DB::transaction(function () use ($watched, $season) {
            $season->episodes()->update(['watched' => DB::raw("case when id in ($watched) then 1 else 0 end")]);
        });

        //$watched = $request->episodes;

        // $season->episodes->each(function (Episode $episode) use ($watched) {
        //     $episode->watched = in_array($episode->id, $watched);
        // });

        // $season->push(); //está salvando o estado atual dos atributos do season

        return to_route('episodes.index', $season->id)->with('mensagem.sucesso', "Episódios assistidos foram atualizados");
    }
}
