<?php

class Admin extends Controller
{

	protected $view_path = "application/views/admin/";
	protected $model;
	protected $module;

    public function __construct()
    {
        parent::__construct();
		session_start();

		if(isset($_SESSION["user_id"])) {
			if($_SESSION["user_id"] == ADMIN_NAME) {
				$this->module = new module();
				parent::$is_backend = true;
			}
			else {
				$this->login();
				die(0);
			}
		}
		else {
				$this->login();
			die(0);
		}
	}

	public function index()
    {
        $tasks_model = $this->loadModel('HomeModel');
        $tasks = $tasks_model->getAllTasks();
		require $this->view_path."template/header.php";
		require $this->view_path."index.php";
		require $this->view_path."template/footer.php";
	}

	public function logout()
    {
		unset($_SESSION["user_id"]);
		header("location:".URL."admin");
	}

    public function login()
    {
        $status = null;
		if(isset($_POST["name"]) && isset($_POST["pass"])) {
			if($_POST["name"] == ADMIN_NAME && $_POST["pass"] == ADMIN_PASS) {
				$_SESSION["user_id"] = ADMIN_NAME;
				header("location:".URL."admin");
				exit(0);
			}
			else {
			    $status = 'Incorrect username or password';
				require $this->view_path."login.php";
				require $this->view_path."template/footer.php";
			}
		}
		else {
			require $this->view_path."login.php";
          	require $this->view_path."template/footer.php";
		}
	}

	public function changeStatus()
    {
        if(isset($_POST["id"]) && isset($_POST["status"])) {
            $admin_model = $this->loadModel('AdminModel');
            $admin_model->updateStatus($_POST);

            echo 'ok';
        }
    }

    public function updateDesc()
    {
        if (isset($_POST["id"]) && isset($_POST["desc"])) {
            $admin_model = $this->loadModel('AdminModel');
            $admin_model->updateNotes($_POST);

            echo 'ok';
        }
    }
}
