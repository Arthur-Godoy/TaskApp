<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <script src="/js/subtasksFront.js"></script>
    <link rel="stylesheet" href="/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid content">
        <div class="row ge-0 ">
            <div class="col-md-3 col-xl-2 px-0  menuBorderRigth">
                <div class="d-flex flex-column pt-2 min-vh-100 bgMenu">
                    <div class="ms-3 mt-2 mb-4">
                        <a href="/" class="d-flex align-items-center text-white text-decoration-none">
                            <ion-icon name="link" class="fs-3"></ion-icon>
                            <span class="fs-3">Task App</span>
                        </a>
                        <small class="text-muted mb-4">Todos os Quadros ({{ count($boards) }})</small>
                    </div>
                    <ul class="nav mb-auto fs-5 me-3">
                        @if (count($boards) == 0)
                            <li class="d-inline text-center pb-3">
                                Não Há nenhuma sessão!
                            </li>
                        @else
                            @foreach ($boards as $boardSingle)
                                @if ($board->id == $boardSingle->id)
                                    <div class="ps-3 row g-0 active w-100 rounded-end pb-2">
                                @else
                                    <div class="ps-3 row g-0 w-100 rounded-end pb-2">
                                @endif
                                    <ion-icon class="fs-5 mt-2 col-md-3" name="bookmarks"></ion-icon>
                                    <li class=" d-inline col-md-6">
                                        <a href="{{ route('board',['id' => $boardSingle->id]) }}" class="nav-link px-0 d-inline fs-6">
                                            <span class="d-inline ">{{ $boardSingle->name }}</span>
                                        </a>
                                    </li>
                                </div>
                            @endforeach
                        @endif
                        <div class="ps-3 row g-0 w-100 rounded-end mt-3 text-center">
                            <li class=" d-inline col-md-12">
                                <button type="button" class="buttonPurple fs-6" data-bs-toggle="modal" data-bs-target="#newBoardModal">
                                    <ion-icon name="add"></ion-icon> Nova Sessão
                                </button>
                            </li>
                        </div>
                    </ul>
                    <div class="dropdown px-3 pb-4 align-self-bottom">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <ion-icon name="contact" class="fs-2"></ion-icon>
                            <span class="d-none d-sm-inline mx-1">{{ $user->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li>
                                <a class="dropdown-item" href="{{route('dashboard')}}">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="/logout" method="POST">
                                    @csrf
                                    <a class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">Sign out</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col g-0">
                <header>
                    <nav class="navbar bgMenu px-5 menuBorderBottom">
                        <div class="container-fluid py-3">
                            @if ($board == null)
                                <h1 class="fs-3">Bem Vindo !</h1>
                                <button class="addButton buttonPurple" type="button" data-bs-toggle="modal" data-bs-target="#newBoardModal"><ion-icon name="add"></ion-icon>Nova Tarefa</button>
                            @else
                                    <h1 class="fs-3">{{ $board->name }}</h1>
                                    <button class="addButton buttonPurple" type="button" data-bs-toggle="modal" data-bs-target="#newTaskModal"><ion-icon name="add"></ion-icon>Nova Tarefa</button>
                            @endif
                        </div>
                    </nav>
                </header>
                <div class="content w-100">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- ModalNewBoard -->
    <div class="modal fade" id="newBoardModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-body bgMenu rounded py-3 px-4">
                    <h5 class="modal-title mb-4" >Nova Sessão</h5>
                    <form action="{{ route('boardNew') }}" method="POST">
                        @csrf
                        <label class="form-label" for="name"><small>Nome da Sessão</small></label>
                        <input class="form-control bg-transparent text-light" type="text" name="name" placeholder="ex: Dia-a-Dia" maxlength="50" required>
                        <button type="submit" class="btn btn-primary px-4 mt-5">Criar</button>
                        <button type="button" class="btn btn-danger mt-5" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- EndModal -->

    @if ($board != null)
        <!-- ModalNewTask -->
        <div class="modal fade" id="newTaskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark">
                    <div class="modal-body bgMenu rounded py-3 px-4">
                        <h5 class="py-3">Add Nova Tarefa</h5>
                        <form action="{{ route('taskNew')}}" method="POST">
                            @csrf
                            <input name="board_id" type="hidden" value="{{ $board->id }}">
                            <label class="form-label" for="title"><small>Titulo</small></label>
                            <input class="form-control bg-transparent text-light" type="text" name="title" placeholder="ex: Tomar Café da Manhã" required>
                            <label class="form-label mt-3" for="description"><small>Descrição</small></label>
                            <textarea
                                style="resize: none"
                                class="form-control bg-transparent text-light"
                                name="description" rows="5"
                                placeholder="ex: Um bom café da manhã é a refeição mais importante do dia, portanto é fundamental que seja tomada com calma, e seja escolhida uma refeição bem nutritiva"
                                required
                            ></textarea>
                            <label class="form-label mt-3"><small>Subtarefas</small></label>
                            <div id="subtasksnew">
                                <div class="d-inline" id="new0">
                                    <input style="width: 90%" class="mt-3 form-control bg-transparent text-light d-inline" type="text" name="subtasks[]" placeholder="Ex: Fazer Café" required>
                                </div>
                                <div class="d-inline" id="btnnew0">
                                    <button type="button" class="btn btn-outline d-inline btn-sm" onclick="removeSubtaskField('new0');"><ion-icon name="close" class="fs-5"></ion-icon></button>
                                </div>
                                <!--Filled from /public/js/subtasksFront.js-->
                            </div>
                            <button type="button" onclick="addSubtaskField('new')" class="buttonWhite w-100 mt-5">Add SubTarefa</button>
                            <button type="submit" class="buttonPurple w-100 mt-5">Criar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- EndModal -->
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</body>
</html>

