<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class TaskController extends Controller
{

    public function index() {
        $date = request("date");

        if ($date) {
            $tasks = Task::where([
                ['date', $date],
            ])->get();
        } else {
            $tasks = Task::all();
        }
        return Response::json($tasks, 200);
    }

    public function store(Request $request) {
        $task = new Task;
        $task->description = $request->description;
        $task->save();

        return Response::json([ "message" => "Tarefa criada com sucesso!"], 201);
    }

    public function show($id) {
        $task = Task::findOrFail($id);

        return Response::json($task, 200);
    }

    public function destroy($id) {
        $task = Task::findOrFail($id);
        $task->delete();

        return Response::json(["message" => "Tarefa: {$task->description}, foi deletada com sucesso!"], 200);
    }

    public function update(Request $request) {
        $task = [
            "description" => $request->description,
            "date" => date("y/m/d"),
        ];

        Task::where("id", $request->id)->update($task);

        return Response::json(["message" => "Tarefa atualizada para: {$request->description}"], 200);
    }

}
