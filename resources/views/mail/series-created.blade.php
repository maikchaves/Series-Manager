@component('mail::message')
# A série {{ $seriesName }} foi criada!

A série {{ $seriesName }} com {{ $seasonsQty }} temporadas e {{ $episodesPerSeason }} episódios por temporada foi criada com sucesso.

Acesse aqui:

@component('mail::button', ['url' => route('seasons.index', $idSeries)])
    Ver série
@endcomponent

@endcomponent
