<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index()
    {
        $users = DB::table('users')->get();
        $usersArray = $users->pluck('name', 'id')->all();
        return view('reports.index', ['users'=>$usersArray]);
    }

    public function search(Request $request)
    {
        $user_id = $request->input('searchTerm');
        $results = DB::table('tasks')
                ->where('user_id', '=', $user_id)
                ->get();

        foreach ($results as $task) {
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
        return $results;
    }
}