<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\SubTask;
use App\Models\Task;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    public function index(){
        if(auth()->user()){
            return redirect(route('dashboard'));
        }else{
            return view('welcome');
        }
    }

    public function dashboard(){
        $user = auth()->user();
        $boards = Board::all()->where('user_id', $user->id);

        return view('dashboard',['user' => $user, 'boards' => $boards]);
    }

    private function changeTaskStatus($id){
        $task = Task::findOrFail($id);
        $subtasks = SubTask::all()->where('task_id', $id);
        $subtasksDone = $subtasks->where('status', 1);

        if($subtasksDone == $subtasks){
            $task->status = 2;
            $task->update();
        }else if(count($subtasksDone) >= 1){
            $task->status = 1;
            $task->update();
        }else if(count($subtasksDone) == 0){
            $task->status = 0;
            $task->update();
        }
    }

    public function newTask(Request $request){
        try{
            $task = new Task;
            $task->title = $request->title;
            $task->description = $request->description;
            $task->status = '0';
            $task->board_id = $request->board_id;
            $task->save();

            foreach($request->subtasks as $subtaskRequest){
                $subtask = new SubTask;
                $subtask->content = $subtaskRequest;
                $subtask->status = false;
                $subtask->task_id = $task->id;
                $subtask->save();
            }

            return redirect(route('board', ['id' => $request->board_id]));

        }catch(\Illuminate\Database\QueryException $e){
            return redirect(route('board', ['id' => $request->board_id]))->with('message', 'Erro!!  Numero de caracteres excedido');
        }

    }

    public function editTask($id, Request $request){
        $task = Task::findOrFail($id);

        try{
            $task->title = $request->title;
            $task->description = $request->description;
            $task->update();

            if($request->subtasks){
                foreach($request->subtasks as $subtaskRequest){
                    $subtask = new SubTask;
                    $subtask->content = $subtaskRequest;
                    $subtask->status = false;
                    $subtask->task_id = $id;
                    $subtask->save();
                }
            }
            $this->changeTaskStatus($task->id);

            return redirect(route('board', ['id' => $task->board_id]));
        }catch(\Illuminate\Database\QueryException $e){
            return redirect(route('board', ['id' => $task->board_id]))->with('message', 'Erro!!  Numero de caracteres excedido');
        }
    }

    public function deleteTask($id){
        $task = Task::findOrFail($id);
        $board = $task->board_id;

        try{
            $task->delete();

            return redirect(route('board', ['id' => $board]));
        }catch(\Illuminate\Database\QueryException $e){
            return redirect(route('board', ['id' => $board]))->with('message', 'Erro ao Deletar a Tarefa');
        }
    }

}
