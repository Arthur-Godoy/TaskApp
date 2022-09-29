@extends('layouts.main', ['boards' => $boards, 'userName' => $user->name])
@section('title', 'TaskApp - Board')

@section('content')
    @if (count($tasks) == 0)
        <div style="padding-top: 23%" class="text-center fs-2 text-muted">
            Você nao tem nenhuma tarefa para ser exibida!!
        </div>
    @else
        <div class="container row">
            <div class="col-md-4">
                <div class="shadow shadow-lg taskCard">
                    <h1>opa</h1>
                </div>
            </div>
            <div class="col-md-4">

            </div>
            <div class="col-md-4">

            </div>

        </div>
    @endif
@endsection
