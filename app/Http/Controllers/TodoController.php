<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo as TD;
use Illuminate\Support\Facades\Crypt;

class TodoController extends Controller
{
    
    /**
     * To test the similarity.
     * @param $test_val
     * @return true or false
     */

    public function show_to_be_updated($id)
    {
        return view('home-update')->with('todo_id', Crypt::decryptString($id));
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

    public funtion sampleFunction(){
        
    }
}
