<?php

use App\Http\Controllers\EpisodesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\Autenticador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Rotas podem ser agrupadas quando usam o mesmo controlador
Route::get('/series', [SeriesController::class, 'index']);
Route::get('/series/criar', [SeriesController::class, 'create']);
Route::post('/series/criar', [SeriesController::class, 'store']);
*/

/* Essa forma são as rotas agrupadas, porém há uma maneira mais resumida de agrupamento,
porém DEVEM-SE usar as nomenclaturas pré-definidas. Neste caso, a rota /criar deveria ser create
Route::controller(SeriesController::class)->group(function () {
    Route::get('/series', 'index');
    Route::get('/series/criar', 'create');
    Route::post('/series/criar', 'store');
});
*/

/* Maneira mais resumida de agrupamento, porém usa nomenclaturas de rotas pré-definidas.
Por exemplo, a rota /criar deveria ser create, mas exibiria o nome em inglês na URL

Update -> Há como adaptar os verbos padrões para o português alterando o método boot
no arquivo app/providers/RouteServiceProvider
*/

Route::resource('/series', SeriesController::class)
    ->except('show');

Route::middleware('autenticador')->group(function () {

    //se navegar direto para raiz, será direcinoado para /series
    Route::get('/', function () {
        return redirect('/series');
    });


    //except indica que tem todos os métodos, exceto esses
    //->only(['index', 'create', 'store', 'destroy', 'edit', 'update']);
    //only indica que as demais rotas não estão implementadas


    /* Se eu usar o @method('DELETE') no formulário, posso usar o verbo delete, incorporando no resource acima
Route::post('/series/destroy/{serieId}', [SeriesController::class, 'destroy'])
->name('series.destroy'); // nome da rota para o método destroy do controlador
*/

    Route::get('/series/{series}/seasons', [SeasonsController::class, 'index'])->name('seasons.index');

    Route::get('/seasons/{season}/episodes', [EpisodesController::class, 'index'])->name('episodes.index');
    Route::post('/seasons/{season}/episodes', [EpisodesController::class, 'update'])->name('episodes.update');
});




Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/logout', [LoginController::class, 'destroy'])->name('logout');
Route::post('/login', [LoginController::class, 'store'])->name('signin');

Route::get('/register', [UsersController::class, 'create'])->name('users.create');
Route::post('/register', [UsersController::class, 'store'])->name('users.store');
