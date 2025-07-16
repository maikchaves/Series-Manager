<x-layout title="Temporadas de {!! $series->name !!}">

    <ul class="list-group">

        @foreach ($seasons as $season)
            <li class="list-group-item d-flex justify-content-between align-content-center">
                <a href="{{ route('episodes.index', $season->id) }}"> Temporada {{ $season->number }} </a>
                <spam class="badge bg-secondary">
                    {{ $season->numberOfWatchedEpisodes() }} / {{ $season->episodes->count() }}
                </spam>
            </li>
        @endforeach
    </ul>
</x-layout>
