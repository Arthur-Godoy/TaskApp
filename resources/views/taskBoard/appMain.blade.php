@extends('layouts.main', ['boards' => $boards, 'userName' => $user->name])
@section('title', 'TaskApp - Board')

@section('content')
    @if (count($tasks) == 0)
        <div style="padding-top: 23%" class="text-center fs-2 text-muted">
            Você nao tem nenhuma tarefa para ser exibida!!
        </div>
    @else
        
    @endif
@endsection
