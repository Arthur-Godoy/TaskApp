<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubTask;
use App\Models\Task;

class SubTaskController extends Controller
{
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
}
