<?php

namespace App\Http\Controllers;

use App\Gallery;

class TaskController extends Controller {

    protected $respose;
    public function index() {
        return $tasks = Gallery::all();
    }

    public function show($id) {
        //Get the task
        $task = Gallery::find($id);
        if (!$task) {
            return $this->response->errorNotFound('Gallery Not Found');
        }
        return $task;
    }

    public function destroy($id) {
        //Get the task
        $task = Gallery::find($id);
        if (!$task) {
            return $this->response->errorNotFound('Gallery Not Found');
        }

        if ($task->delete()) {
            return $this->response->withItem($task, new GalleryTransformer());
        } else {
            return $this->response->errorInternalError('Could not delete a task');
        }
    }

    public function store(Request $request) {
        if ($request->isMethod('put')) {
            //Get the task
            $task = Gallery::find($request->task_id);
            if (!$task) {
                return $this->response->errorNotFound('Gallery Not Found');
            }
        } else {
            $task = new Gallery;
        }

        $task->id = $request->input('task_id');
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->user_id = 1; //$request->user()->id;

        if ($task->save()) {
            return $this->response->withItem($task, new GalleryTransformer());
        } else {
            return $this->response->errorInternalError('Could not updated/created a task');
        }
    }

}
