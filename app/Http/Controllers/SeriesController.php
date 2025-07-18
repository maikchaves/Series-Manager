<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Autenticador;
use App\Http\Requests\SeriesFormRequest;
use App\Mail\SeriesCreated;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use App\Models\User;
use App\Repositories\EloquentSeriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\SeriesRepository;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{

    public function __construct(private SeriesRepository $repository)
    {
        //esse construtor permite já usar o repositório em todo o controller usando o $this->repository
        $this->middleware(Autenticador::class)->except(['index']);
        //o except é para não precisar de autenticação para ver a lista de séries
    }

    /**
     * This function retrieves a list of series and generates an HTML unordered list.
     *
     * @return string The HTML representation of the series list.
     */
    public function index(Request $request)
    {
        //Antes ainda de chamar a view, verifico se tem a mensagem na sessão
        //$mensagem = $request->session()->get('mensagem.sucesso');
        $mensagem = session('mensagem.sucesso');

        // Simulando a chamada à API de séries
        //o scopo local criado no model já vai garantir que vem ordenado por nome
        //$series = Serie::query()->orderBy('nome')->get();
        $series = Series::all();

        return view('series.index')
            ->with('series', $series)
            ->with('mensagemSucesso', $mensagem);
    }

    public function create()
    {
        return view('series.create');
    }

    //utiliza o request criado (e não o FormRequest do laravel), pois permite reunir
    //as validações em um só lugar
    public function store(SeriesFormRequest $request)
    {

        $data = [
            'name' => $request->name,
            'seasonsQty' => $request->seasonsQty,
            'episodesPerSeason' => $request->episodesPerSeason,
        ];
        $serie = $this->repository->add($data);

        //O método "to" adiciona o destinatário informado à lista de destinatários do Mailable que é passado por parâmetro. 
        //Sendo assim, a cada novo send nós não enviamos o e-mail apenas para o novo destinatário, 
        //mas sim para todos os destinatários anteriores além do recém adicionado à lista existente.
        /*$email = new SeriesCreated(
            $serie->name,
            $serie->id,
            $request->seasonsQty,
            $request->episodesPerSeason
        );*/

        //Envia e-mail para o usuário autenticado
        //Mail::to($request->user())->send($email);

        //Envia e-mail para todos os usuários
        $users = User::all();

        foreach ($users as $index => $user) {
            $email = new SeriesCreated(
                $serie->name,
                $serie->id,
                $request->seasonsQty,
                $request->episodesPerSeason
            );

            //Para enviar de forma assíncrona, basta usar o método queue e alterar o QueueConnection no .env
            //Mail::to($user)->send($email);
            $when = now()->addSeconds($index *5);
            //Mail::to($user)->queue($email);
            Mail::to($user)->later($when, $email);
        }

        //return redirect('/series');
        return to_route('series.index')->with('mensagem.sucesso', "Série {$serie->name} adicionada com sucesso");
    }

    //public function destroy(Request $request){
    public function destroy(Series $series, Request $request)
    {

        //Serie::destroy(($request->series));
        $series->delete();


        //quando enviar a sessão para rota index, ele procurará esse put chamado mensagem.sucesso
        // -> pode ir no with do route $request->session()->flash('mensagem.sucesso', "Série {$series->nome} removida com sucesso");
        //Uma mensagem de sessão pode ser feita assim, porém ele não faz o flash, então a mensagem não será apagada sem um session forget
        //session(['mensagem.sucesso' => 'Série removida com sucesso']);

        return to_route('series.index')->with('mensagem.sucesso', "Série {$series->name} removida com sucesso");
    }

    public function edit(Series $series, Request $request)
    {

        return view('series.edit')->with('series', $series);
    }


    public function update(Series $series, SeriesFormRequest $request)
    {
        //$series->nome = $request->nome;
        $series->fill($request->all());
        //O fill usa o fillable para atualizar tudo que tem o mesmo nome do que está definido lá
        $series->save();

        return to_route('series.index')->with('mensagem.sucesso', "Série {$series->name} atualizada com sucesso");
    }
};
