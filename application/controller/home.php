<?php


class Home extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        // load a model, perform an action, pass the returned data to a variable
        // NOTE: please write the name of the model "LikeThis"
        $tasks_model = $this->loadModel('HomeModel');
        $tasks = $tasks_model->getAllTasks();

        // load views. within the views we can echo out $tasks and $amount_of_tasks easily
        require 'application/views/_templates/header.php';
        require 'application/views/home/index.php';
        require 'application/views/_templates/footer.php';
    }


    /**
     * ACTION: addTask
     * This method handles what happens when you move to http://yourproject/tasks/addtask
     * IMPORTANT: This is not a normal page, it's an ACTION. This is where the "add a task" form on tasks/index
     * directs the user after the form submit. This method handles all the POST data from the form and then redirects
     * the user back to tasks/index via the last line: header(...)
     * This is an example of how to handle a POST request.
     */
    public function addTask()
    {
        $status = null;
        // if we have POST data to create a new task entry
        if (isset($_POST["submit_add_task"])) {
            // load model, perform an action on the model
            $home_model = $this->loadModel('HomeModel');
            $status = $home_model->addTask($_POST["name"], $_POST["email"],  $_POST["desc"]);
        }

        // where to go after task has been added
        header("location: " . URL . "home/index?status=" . json_encode($status));
    }

}
