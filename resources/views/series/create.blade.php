<x-layout title='Nova Série'>

    <form action="{{route('series.store')}}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-8">
                <label for="name" class="form-label">Nome:</label>
                <input autofocus ="text" id="name" name="name" class="form-control"
                    @isset($name) value="{{old('name')}}" @endisset>
            </div>

            <div class="col-2">
                <label for="seasonsQty" class="form-label">Número de temporadas:</label>
                <input type="text" id="seasonsQty" name="seasonsQty" class="form-control"
                    @isset($seasonsQty) value="{{old('seasonsQty')}}" @endisset>
            </div>

            <div class="col-2">
                <label for="episodesPerSeason" class="form-label">Eps / Temporada:</label>
                <input type="text" id="episodesPerSeason" name="episodesPerSeason" class="form-control"
                    @isset($episodesPerSeason) value="{{old('episodesPerSeason')}}" @endisset>
            </div>
    
    </div>

        <button type="submit" class="btn btn-primary">
            Adicionar
        </button>
    </form>

</x-layout>
