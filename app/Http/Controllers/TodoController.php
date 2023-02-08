<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo as TD;
use Illuminate\Support\Facades\Crypt;

class TodoController extends Controller
{
    //
    //
    
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    // 
    // 
    
    /**
     * To test the similarity.
     * @param $test_val
     * @return true or false
     */
     
    public function test_similarity($test_val)
    {
        $get_all_task = TD::where('active_status', 1)->get();
        $val = "";
        $bool_val = false;
        //return $get_all_task;

        foreach ($get_all_task as $num => $task) {
            $sim_val = similar_text(strtoupper($test_val), strtoupper($task->task), $perc);
            if ($perc > 90) {
                $bool_val = true;
                break;
            }
        }
        return $bool_val;
    }

    public function create(Request $request)
    {
        $request->validate([
            'task'      => 'required|string|min:5|max:255|unique:todos,task',
        ], [
            'task.required'         => 'Task is required',
            'task.unique'           => 'Task Must Be Unique',
            'task.max'              => 'Task Must Be 255 Characters Long',
            'task.min'              => 'Task Must Be 5 Characters Short',

        ]);

        $to_do = new TD();
        $to_do->task = strtoupper($request->task);//$(this).
        $to_do->task_description = strtoupper($request->task_description);//$(this).
        $to_do->active_status = 1;

        if($this->test_similarity($request->task) == true){
            return redirect('/home')->with('danger_message', 'Invalid Input, Duplicate Data Found!');
        }
        else{
            if ($to_do->save()) {
                return redirect('/home')->with('success_message', 'Task Has Been Succesfully Created!');
            }
            else{
                return redirect('/home')->with('danger_message', 'DATABASED ERROR!');
            }
        }
    }

    public function show_to_be_updated($id)
    {
        $get_todo_data = TD::findorfail(Crypt::decryptString($id));

        return view('home-update')->with('todos_updated', $get_todo_data);
    }

    public function remove($id)
    {
        $to_remove = TD::findorfail(Crypt::decryptString($id));
        $to_remove->active_status = 0;

        if ($to_remove->save()) {
            return redirect('/home')->with('success_message', 'Task Has Been Succesfully Removed!');
        }
        else{
            return redirect('/home')->with('danger_message', 'DATABASED ERROR!');
        }
    }

    public function update(Request $request)
    {
        $to_update = TD::findorfail(Crypt::decryptString($request->edit_id));
        $to_update->task = strtoupper($request->task);//$(this).
        $to_update->task_description = strtoupper($request->task_description);//$(this).
        $to_update->active_status = 1;

        if ($to_update->save()) {
            return redirect('/home')->with('success_message', 'Task Has Been Succesfully Updated!');
        }
        else{
            return redirect('/home')->with('danger_message', 'DATABASED ERROR!');
        }
    }
}
