<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Task;
use App\Http\Requests\TaskRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $user_id = Auth::id();
        //pass the parameter to filter the user to the logged one.
        $tasks = DB::table('tasks')
                ->where('user_id', '=', $user_id)
                ->get();

        foreach ($tasks as $task) {
            switch ($task->is_done) {
                case '1':
                    $task->is_done = "Pending";
                break;
                case '2':
                    $task->is_done = "In Progress";
                break;
                case '3':
                    $task->is_done = "Completed";
                break;
            }            

            if($task->is_done == "Completed"){

                $dateEndsIn = $task->ended_at;
                $diffToEnd = now()->diffInDays(Carbon::parse($dateEndsIn));
                $task->ended_at = $diffToEnd." Days";
                $task->started_at = "0";

            } else {

                $task->ended_at = "";
                $dateStartIn = $task->started_at;
                $diffToStart = now()->diffInDays(Carbon::parse($dateStartIn));
                $task->started_at = $diffToStart." Days";

            }

        }
        
        return view('tasks.index', ['tasks'=>$tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $user = Auth::user();
        $user_id = Auth::id();
        return view('tasks.create', ['user_id'=>$user_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TaskRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TaskRequest $request)
    {
        $task = new Task;
		$task->title = $request->input('title');
		$task->description = $request->input('description');
		$task->started_at = $request->input('started_at');
		$task->ended_at = $request->input('ended_at');
		$task->user_id = $request->input('user_id');
		$task->is_done = $request->input('is_done');
        $task->save();

        return to_route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.show',['task'=>$task]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $user = Auth::user();
        $user_id = Auth::id();
        return view('tasks.edit',['task'=>$task,'user_id'=>$user_id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TaskRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
		$task->title = $request->input('title');
		$task->description = $request->input('description');
		$task->started_at = $request->input('started_at');
		$task->ended_at = $request->input('ended_at');
		$task->user_id = $request->input('user_id');
		$task->is_done = $request->input('is_done');
        $task->save();

        return to_route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return to_route('tasks.index');
    }
}
