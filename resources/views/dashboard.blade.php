<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task-App-Profile</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body class="content pt-5">
    <div class="container row mt-4">
        <div class="col-md-7 offset-1">
            <div>
                <h1 class="mb-3">Sessões</h1>
                <p><small class="text-muted ps-3">Aqui se pode Editar e Excluir sessões</small></p>
                @if (sizeof($boards) != 0)
                    @foreach ($boards as $board)
                        <a class="text-decoration-none" href="{{ route('board', ['id' => $board->id]) }}">
                            <div class="rounded bgMenu p-2 shadow d-flex mb-3">
                                <h5 class="mt-1 w-75 ms-3 d-inline"><ion-icon name="bookmarks" class="me-2"></ion-icon>{{ $board->name }}</h5>
                                <div class="w-25 d-flex flex-row-reverse">
                                    <form action="{{route('deleteBoard', ['id' => $board->id])}}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Deletar</button>
                                    </form>
                                    <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editBoardModal">Editar</button>
                                </div>
                            </div>
                        </a>
                    @endforeach
                    @else
                        <h5 class="m-5">Ainda Não tem nenhuma Sessão - <a class="btn-show ms-0" href="{{ route('board', ['id' => '1']) }}">Ir para o App</a></h5>
                @endif
            </div>
            <div class="mt-4 ms-2">
                <a class="btn-show ms-0" href="{{ route('board', ['id' => '1']) }}">Ir para o App</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class=" shadow p-3 mb-5 rounded bgMenu">
                <h6 class="fw-bold ps-2 pt-2">Meu Perfil</h6>
                <p class="ms-3"><ion-icon name="person"></ion-icon> {{ $user->name }}</p>
                <p class="ms-3"><ion-icon name="mail"></ion-icon> {{ $user->email }}</p>
                <p class="ms-3"><ion-icon name="contacts"></ion-icon> Sessões: {{ sizeOf($boards) }}</p>
            </div>
        </div>
    </div>

    @foreach ($boards as $board)
        <!-- ModalEditBoard -->
        <div class="modal fade" id="editBoardModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <div class="modal-body bgMenu rounded py-3 px-4">
                        <h5 class="modal-title mb-4" >Editar Sessão: {{ $board->name }}</h5>
                        <form action="{{ route('editBoard',['id'=>$board->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <label class="form-label" for="name"><small>Nome da Sessão</small></label>
                            <input class="form-control bg-transparent text-light" type="text" value="{{ $board->name }}" name="name" maxlength="50" required>
                            <button type="submit" class="btn btn-primary px-4 mt-5">Editar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- EndModal -->
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</body>
</html>



