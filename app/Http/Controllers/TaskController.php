<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\SubTask;
use App\Models\Task;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    public function index(){
        return(view('welcome'));
    }

    public function board($id){
        $user = auth()->user();
        $boards = Board::all()->where('user_id', $user->id);
        $board = $boards->where('id', $id)->first();
        if($board != null){
            $tasks = Task::all()->where('board_id', $board->id);
        }else{
            $tasks = [];
        }
        return(view('taskBoard.appMain',['boards' => $boards, 'board' => $board, 'user' => $user, 'tasks' => $tasks]));
    }

    public function newBoard(Request $request){
        $user = auth()->user();
        $board = new Board;
        $board->name = $request->name;
        $board->user_id = $user->id;
        $board->save();
        return(redirect(route('board', ['id' => $board->id])));
    }
}
