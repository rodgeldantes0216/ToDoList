<?php

namespace App\Http\Livewire\Todo;

use Livewire\Component;
use App\Models\Todo as TD;
use Illuminate\Support\Facades\Crypt;

class TodoUpdate extends Component
{
    public $task, $task_description, $test_if_exist, $task_id;
    public $todos_update;

    /**
     * To Assign Null Value For The Following Fields.
     * @param no parameter
     * @return task = null
     * @return task_description = null
     */
    
    public function mount($id)
    {
        $this->todos_update = TD::findorfail(Crypt::decryptString($id));
        $this->task_id = $this->todos_update->id;
        $this->task = $this->todos_update->task;
        $this->task_description = $this->todos_update->task_description;
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
     * Creates A Real-Time Validation.
     * @param no parameter
     * @return task = null
     * @return task_description = null
     */

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * To Create New Record (Description).
     * @param no parameter
     * @return sucess || unsuccess
     */

    public function update_record()
    {


        // if($this->test_similarity($this->task) == true)
        // {
        //     return redirect('/home')->with('danger_message', 'Invalid Input, Duplicate Data Found!');
        // }
        // else
        // {
        // 


        $to_be_updated = [
            'task' => $this->task
        ];

        $this->test_if_exist = TD::firstOrNew($to_be_updated);
        
        if($this->test_if_exist->id == $this->task_id || !$this->test_if_exist->exists)
        {
            $this->todos_update->task = strtoupper($this->task);
            $this->todos_update->task_description = strtoupper($this->task_description);
            $this->todos_update->active_status = 1;
            if ($this->todos_update->save())
            {
                return redirect('/home')->with('success_message', 'Task Has Been Succesfully Created!');
            }else
            {
                
                return redirect('/home')->with('danger_message', 'DATABASED ERROR!');
            }
        }
        else{
            $this->validate();

            $this->todos_update->task = strtoupper($this->task);
            $this->todos_update->task_description = strtoupper($this->task_description);
            $this->todos_update->active_status = 1;
            if ($this->todos_update->save())
            {
                return redirect('/home')->with('success_message', 'Task Has Been Succesfully Created!');
            }else
            {
                
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
        return view('livewire.todo.todo-update');
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
