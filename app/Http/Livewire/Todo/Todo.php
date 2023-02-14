<?php

namespace App\Http\Livewire\Todo;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Todo as TD;

class Todo extends Component
{
    public $task, $task_description, $errors_on_validation;
    public $task_old_if_fail, $task_description_old_if_fail;

    /**
     * To Assign Null Value For The Following Fields.
     * @param no parameter
     * @return task = null
     * @return task_description = null
     */
    
    public function mount()
    {
        $this->task = null;
        $this->task_description = null;
    }

    /**
     * Insert Rules For Validation.
     * @param no parameter
     * @return validated Data
     */
    protected $rules = [
        'task' => 'required|string|min:5|max:255|unique:todos,task'
    ];

    /**
     * To Create New Record (Description).
     * @param no parameter
     * @return sucess || unsuccess
     */

    public function create()
    {

        $this->validate();

        if($this->task == null && $this->task_description == null){
            return redirect('/home')->with('danger_message', 'Please Fill The Fields First.');
        }

        $to_dos = new TD();
        $to_dos->user_id = Auth::id();
        $to_dos->task = strtoupper($this->task);
        $to_dos->task_description = strtoupper($this->task_description);
        $to_dos->active_status = 1;

        if($this->test_similarity($this->task) == true)
        {
            return redirect('/home')->with('danger_message', 'Duplicate Data Found.');
        }
        else
        {
            if ($to_dos->save())
            {
                return redirect('/home')->with('success_message', 'Task Has Been Succesfully Created!');
            }else
            {
                $this->task_old_if_fail = $this->task;
                $this->task_description_old_if_fail =  $this->task_description;
                return redirect('/home')->with('danger_message', 'DATABASED ERROR!');
            }
        }
    }

    /**
     * To Render Component To The Views.
     * @param no parameter
     * @return All Values And Render It To The View
     */

    public function render()
    {
        return view('livewire.todo.todo');
    }

    /**
     * When Called It Will Create A Real-Time Validation.
     * @param no parameter
     * @return task = null
     * @return task_description = null
     */

    public function valOnly()
    {
        $this->validate();
    }

    /**
     * To Test and Compare The Similarities of 2 Strings.
     * @param $test_val
     * @return true or false
     */

    public function test_similarity($test_val)
    {
        $get_all_task = TD::where('active_status', 1)->get();
        $val = "";
        $bool_val = false;

        foreach ($get_all_task as $num => $task)
        {
            $sim_val = similar_text(strtoupper($test_val), strtoupper($task->task), $perc);
            if ($perc > 90) {
                $bool_val = true;
                break;
            }
        }

        return $bool_val;
    }

     /**
     * To redirect_back_with_action.
     * @param no parameter
     * @return return cancel_message
     */

    public function redirect_back_with_action()
    {
        return redirect('/home')->with('cancel_message', 'Cancelled!');
    }
}
