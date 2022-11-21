<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\SubTask;
use App\Models\Task;

class BoardController extends Controller
{
    public function board($id){
        $user = auth()->user();
        $boards = Board::all()->where('user_id', $user->id);
        $board = $boards->where('id', $id)->first();

        if($board != null){
            $tasks = Task::all()->where('board_id', $board->id);
            foreach($tasks as $task){
                $task->subtasks = SubTask::all()->where('task_id', $task->id);
                $task->subtaskAll= count(SubTask::all()->where('task_id', $task->id));
                $task->subtaskDone= count(SubTask::all()->where('task_id', $task->id)->where('status', true));
            }
        }else{
            $tasks = [];
        }

        if($board == null && sizeof($boards) != 0){
            return redirect(route('board', ['id' => $boards[0]->id]));
        }
        return view('taskBoard.appMain',['boards' => $boards, 'board' => $board, 'user' => $user, 'tasks' => $tasks]);
    }

    public function newBoard(Request $request){
        try{
            $user = auth()->user();
            $board = new Board;
            $board->name = $request->name;
            $board->user_id = $user->id;
            $board->save();

            return redirect(route('board', ['id' => $board->id]));
        }catch(\Illuminate\Database\QueryException $e){
            return redirect(route('board'))->with('message', 'Erro!!  Numero de caracteres excedido');
        }
    }

    public function editBoard($id, Request $request){
            $board = Board::findOrFail($id);
            $board->name = $request->name;
            $board->update();

            return redirect(route('dashboard'));
    }

    public function deleteBoard($id){
        Board::findOrFail($id)->delete();

        return redirect(route('dashboard'));
    }

}
