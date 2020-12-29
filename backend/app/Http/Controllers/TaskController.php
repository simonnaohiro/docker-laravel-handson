<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use App\Models\Folder;
use App\Models\Task;
use Facade\Ignition\Tabs\Tab;

class TaskController extends Controller
{
    public function index(int $id)
    {
        // 全てのフォルダを取得
        $folders = Folder::all();

        //選ばれたフォルダを取得する
        $current_folder = Folder::find($id);

        //選ばれたフォルダに紐づくタスクを取得する
        $tasks = $current_folder->tasks()->get();

        
        return view('tasks/index', [
            'folders' => $folders,
            'current_folder_id' => $id,
            'tasks' => $tasks,
        ]);
    }

    public function showCreateForm(int $id)
    {
        return view('tasks/create', [
            'folder_id' => $id
        ]);
    }

    public function create(int $id, CreateTask $request)
    {
        $current_folder = Folder::find($id);
    
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;
    
        $current_folder->tasks()->save($task);
    
        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }

    public function showEditForm(int $id, int $task_id)
    {
        $task = Task::find($task_id);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }
    
    public function edit(int $id, int $task_id, EditTask $request)
    {
        // $task_idで指定したTaskをDBから検索し、$taskへ代入。インスタンスを作成する
        $task = Task::find($task_id);

        // 先に取得してきたタスクのインスタンスのタイトル、状態、期限日にフォームに入力した値を代入
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        // 変更を保存（DB）
        $task->save();

        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
}
