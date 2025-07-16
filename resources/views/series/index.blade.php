<x-layout title="{{ __('messages.app_name') }}" :mensagem-sucesso="$mensagemSucesso">

    @auth
        <a href="{{ route('series.create') }}" class="btn btn-dark mb-2">Adicionar</a>
        <!-- <a href="/series/create" class="btn btn-dark mb-2">Criar</a> dessa forma se adequa a Route:resources, porém o nome da rota na url fica em inglês -->
    @endauth

    <ul class="list-group">

        @foreach ($series as $serie)
            <li class="list-group-item d-flex justify-content-between align-content-center">
                @auth
                    <a href="{{ route('seasons.index', $serie->id) }}">
                @endauth
                    {{ $serie->name }}
                @auth
                    </a>

                @endauth


                @auth
                    <spam class="d-flex">
                        <a href="{{ route('series.edit', $serie->id) }}" class="btn btn-primary btn-sm"><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-pencil" viewBox="0 0 16 16">
                                <path
                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325">
                                </path>
                            </svg>
                        </a>

                        <form action="{{ route('series.destroy', $serie->id) }}" method="post" class="ms-2">
                            @csrf

                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"">X</button>
                        </form>
                    </spam>
                @endauth

            </li>
        @endforeach
    </ul>
</x-layout>
