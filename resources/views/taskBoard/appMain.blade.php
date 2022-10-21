@extends('layouts.main', ['boards' => $boards, 'userName' => $user->name])
@section('title', 'TaskApp - Board')

@section('content')
    @if (count($tasks) == 0)
        <div style="padding-top: 23%" class="text-center fs-2 text-muted">
            Você nao tem nenhuma tarefa para ser exibida!!
        </div>
    @else
        <div class="container row" >
            <div class="col-md-4">
                <ion-icon class="text-warning pt-2 fs-5" name="arrow-dropright-circle"></ion-icon> A fazer
                @foreach ($tasks->where('status', 0) as $task)

                    <div class="p-3 m-3 rounded shadow shadow-lg taskCard bgMenu">
                        <h6 class="text-break">{{ $task->title }}</h6>
                        <small class="text-muted">{{ $task->subtaskDone.' de '.$task->subtaskAll }} etapas</small>
                        <button class="btn-show" data-bs-toggle="modal" data-bs-target="#taskModal{{ $task->id }}">ver mais</button>
                    </div>
                @endforeach
            </div>

            <div class="col-md-4">
                <ion-icon class="text-info pt-2 fs-5" name="arrow-dropright-circle"></ion-icon> Em progresso
                @foreach ($tasks->where('status', 1) as $task)
                    <div class="p-3 m-3 rounded shadow shadow-lg taskCard bgMenu">
                        <h6>{{ $task->title }}</h6>
                        <small class="text-muted">{{ $task->subtaskDone.' de '.$task->subtaskAll }} etapas</small>
                        <button class="btn-show" data-bs-toggle="modal" data-bs-target="#taskModal{{ $task->id }}">ver mais</button>
                    </div>
                @endforeach
            </div>

            <div class="col-md-4">
                <ion-icon class="text-success pt-2 fs-5" name="arrow-dropright-circle"></ion-icon> Feito
                @foreach ($tasks->where('status', 2) as $task)
                    <div class="p-3 m-3 rounded shadow shadow-lg taskCard bgMenu">
                        <h6>{{ $task->title }}</h6>
                        <small class="text-muted">{{ $task->subtaskDone.' de '.$task->subtaskAll }} etapas</small>
                        <button class="btn-show" data-bs-toggle="modal" data-bs-target="#taskModal{{ $task->id }}">ver mais</button>
                    </div>
                @endforeach
            </div>
        </div>

        @foreach ($tasks as $task)
            <!-- ModalShowTask -->
            <div class="modal fade" id="taskModal{{ $task->id }}" tabindex="-1" aria-labelledby="taskModalLabel{{ $task->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-body bgMenu rounded py-3 px-4">
                            <div class="container row">
                                <div class="col-md-11 g-0">
                                    <h5>{{ $task->title }}</h5>
                                </div>
                                <div class="dropdown col-md-1 g-0">
                                    <a href="#" class="text-white text-decoration-none" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <ion-icon class="fs-4" name="more"></ion-icon>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                                        <li>
                                            <button data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}" class="btn btn-outlined text-white">Editar</button>
                                        </li>
                                        <li>
                                            <form action="{{ route('deleteTask', ['id' => $task->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-outlined text-danger">Deletar</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <p class="text-muted mb-3 text-break">{{ $task->description }}</p>
                            <p>Subtasks ({{ $task->subtaskDone }} de {{ $task->subtaskAll }})</p>

                            <form action="{{ route('changeSubtasksStatus') }}" class="mx-2" name="subtask" method="POST" >
                                @csrf
                                <input name="task_id" type="hidden" value="{{ $task->id }}">
                                @foreach ($task->subtasks as $subtask)
                                    <a class="del" onclick="event.preventDefault(); document.getElementById('deleteSubtask{{$subtask->id}}').submit();"><ion-icon name="close"></ion-icon></a>
                                    <div class="content my-2 p-2 rounded">
                                        @if ($subtask->status)
                                            <input name="subtasks[]" class="form-check-input" type="checkbox" id="flexCheckDefault" disabled checked>
                                            <label class="d-inline text-break form-check-label text-decoration-line-through text-muted w-100" for="flexCheckDefault">
                                                {{ $subtask->content }}
                                            </label>
                                        @else
                                            <input name="subtasks[]" class="form-check-input" type="checkbox" value="{{ $subtask->content }}">
                                            <label class="text-break form-check-label" for="flexCheckDefault">
                                                {{ $subtask->content }}
                                            </label>
                                        @endif
                                    </div>
                                @endforeach
                                <button class="my-2 buttonPurple w-100" type="submit">Enviar Concluidos</button>
                            </form>

                            @foreach ($task->subtasks as $subtask)
                                <form action="{{ route('deleteSubtask', ['id'=>$subtask->id]) }}" method="POST" id="deleteSubtask{{$subtask->id}}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div><!-- EndModalShowTask -->

            <!-- ModalEditTask -->
            <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-body bgMenu rounded py-3 px-4">
                            <h5 class="py-3">Editar: {{ $task->title }}</h5>
                            <form action="{{ route('editTask', ['id' => $task->id])}}" method="POST">
                                @csrf
                                @method('PUT')
                                <input name="board_id" type="hidden" value="{{ $board->id }}">
                                <label class="form-label" for="title"><small>Titulo</small></label>
                                <input class="form-control bg-transparent text-light" type="text" name="title" value="{{ $task->title }}" required>
                                <label class="form-label mt-3" for="description"><small>Descrição</small></label>
                                <textarea
                                    style="resize: none"
                                    class="form-control bg-transparent text-light"
                                    name="description" rows="5"
                                    required
                                >{{$task->description}}</textarea>
                                <label class="form-label mt-3"><small>Adicionar Subtarefas</small></label>
                                <div id="subtasks{{ $task->id }}">
                                    <div class="d-inline" id="{{ $task->id }}0">
                                        <input style="width: 90%" class="mt-3 form-control bg-transparent text-light d-inline" type="text" name="subtasks[]" placeholder="Ex: Fazer Café" required>
                                    </div>
                                    <div class="d-inline" id="btn{{ $task->id }}0">
                                        <button type="button" class="btn btn-outline d-inline btn-sm" onclick="removeSubtaskField('{{ $task->id }}0');"><ion-icon name="close" class="fs-5"></ion-icon></button>
                                    </div>
                                    <!--Filled from /public/js/subtasksFront.js-->
                                </div>
                                <small class="text-muted d-block">Caso queira deletar subtarefas, delete e depois crie outra</small>

                                <button type="button" onclick="addSubtaskField('{{ $task->id }}')" class="buttonWhite w-100 mt-5">Add SubTask</button>
                                <button type="submit" class="buttonPurple w-100 mt-5">Editar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- EndEditTaskModal -->

        @endforeach
    @endif
@endsection
