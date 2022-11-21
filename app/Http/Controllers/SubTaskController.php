<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubTask;
use App\Models\Task;

class SubTaskController extends Controller
{
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

        return redirect(route('board', ['id' => $task->board_id]));
    }

    public function deleteSubtask($id){
        $subtask = SubTask::findOrFail($id);
        $task = Task::findOrFail($subtask->task_id);

        try{
            $subtask->delete();
            $this->changeTaskStatus($task->id);
            return redirect(route('board', ['id' => $task->board_id]));
        }catch(\Illuminate\Database\QueryException $e){
            return redirect(route('board', ['id' => $task->board_id]))->with('message', 'Erro ao Deletar SubTarefa');
        }
    }
}
