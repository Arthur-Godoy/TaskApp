<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
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
                                    <div class="ps-3 row g-0 active w-100 rounded-end pb-1">
                                @else
                                    <div class="ps-3 row g-0 w-100 rounded-end pb-1">
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
                                <button type="button" class="buttonPurple fs-6" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <ion-icon name="add"></ion-icon> Novo Quadro
                                </button>
                            </li>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content bg-dark">
                                    <div class="modal-header bgMenu">
                                        <h5 class="modal-title" id="exampleModalLabel">Novo Quadro</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body bgMenu rounded-bottom">
                                        <form action="{{ route('boardNew') }}" method="POST">
                                            @csrf
                                            <label class="d-block mb-3" for="name">Insira o nome da Nova Sessão</label>
                                            <input class="bgMenu border-0 border-bottom d-block mb-4 ms-4" type="text" name="name" required>
                                            <button type="submit" class="btn btn-primary px-4">Criar</button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                    </ul>
                    <div class="dropdown px-3 pb-4 align-self-bottom">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <ion-icon name="contact" class="fs-2"></ion-icon>
                            <span class="d-none d-sm-inline mx-1">{{ $user->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
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
                                <button class="addButton buttonPurple" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><ion-icon name="add"></ion-icon>Nova Tarefa</button>
                            @else
                                <h1 class="fs-3">{{ $board->name }}</h1>
                                <form class="d-flex">
                                    <button class="buttonPurple" type="submit"><ion-icon name="add"></ion-icon>Nova Tarefa</button>
                                </form>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</body>
</html>

