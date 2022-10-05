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

            foreach($tasks as $task){
                $task->subtasks = SubTask::all()->where('task_id', $task->id);
                $task->subtaskAll= count(SubTask::all()->where('task_id', $task->id));
                $task->subtaskDone= count(SubTask::all()->where('task_id', $task->id)->where('status', true));
            }

        }else{
            $tasks = [];
        }

        if($board == null && sizeof($boards) != 0){
            return(redirect(route('board', ['id' => $boards[0]->id])));
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

    public function newTask(Request $request){
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

        return(redirect(route('board', ['id' => $request->board_id])));
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

    public function changeSubtasksStatus(Request $request){

        $task = Task::findOrFail($request->task_id);
        $subtasks = SubTask::all()->where('task_id', $request->task_id);

        if($request->subtasks != null){
            foreach($subtasks as $subtask){
                foreach($request->subtasks as $subtaskRequest){
                    $status = boolval($subtask->status);
                    if($subtask->content == $subtaskRequest && $status == false){
                        $subtask->status = 1;
                        $subtask->update();
                    }
                }
            }
        }

        $this->changeTaskStatus($task->id);

        return(redirect(route('board', ['id' => $task->board_id])));
    }

    public function deleteSubtask($id){
        $subtask = SubTask::findOrFail($id);
        $task = Task::findOrFail($subtask->task_id);
        $subtask->delete();

        $this->changeTaskStatus($task->id);

        return(redirect(route('board', ['id' => $task->board_id])));
    }

    public function editTask($id, Request $request){
        $task = Task::findOrFail($id);
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

        return(redirect(route('board', ['id' => $task->board_id])));
    }

    public function deleteTask($id){
        $task = Task::findOrFail($id);
        $board = $task->board_id;
        $task->delete();

        return(redirect(route('board', ['id' => $board])));
    }

    public function dashboard(){
        $user = auth()->user();
        $boards = Board::all()->where('user_id', $user->id);

        return(view('dashboard',['user' => $user, 'boards' => $boards]));
    }

    public function editBoard($id, Request $request){
        $board = Board::findOrFail($id)->first();
        $board->name = $request->name;
        $board->update();

        return( redirect(route('dashboard')));
    }

    public function deleteBoard($id){
        Board::findOrFail($id)->first()->delete();

        return( redirect(route('dashboard')));
    }
}
