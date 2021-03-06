<?php

/**
 * This is the "base controller class". All other "real" controllers extend this class.
 */
class Controller extends Parametres
{
    /**
     * @var null Database Connection
     */
	private $models = array();

    public $db = null;

    /**
     * Whenever a controller is created, open a database connection too. The idea behind is to have ONE connection
     * that can be used by multiple models (there are frameworks that open one connection per model).
     */
    function __construct()
    {

        $this->openDatabaseConnection();
    }

    /**
     * Open the database connection with the credentials from application/config/config.php
     */
    private function openDatabaseConnection()
    {
        // set the (optional) options of the PDO connection. in this case, we set the fetch mode to
        // "objects", which means all results will be objects, like this: $result->user_name !
        // For example, fetch mode FETCH_ASSOC would return results like this: $result["user_name] !
        // @see http://www.php.net/manual/en/pdostatement.fetch.php
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        // generate a database connection, using the PDO connector
        // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
        $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS, $options);
    }

    /**
     * Load the model of the module with the given name.
	 * stroge all loaded modules in private variable array
	 * if already created return object from array
	 * if not create and write into array
     * @param string $model_name The name of the model
     * @return object model
     */

    protected function loadModuleModel($model_name)
    {
	 	$isfront = parent::$is_backend ? "/backend" : "/frontend";
		$module_name = get_called_class();

		if(!isset($this->models[$module_name])) {
			require "application/modules/" . $module_name . $isfront . "/model/default.php";
			$this->models[$module_name] = new $model_name($this->db);
		}
        return $this->models[$module_name];
    }
    /**
     * Load the model with the given name.
     * loadModel("TaskModel") would include models/taskmodel.php and create the object in the controller, like this:
     * $tasks_model = $this->loadModel('TasksModel');
     * Note that the model class name is written in "CamelCase", the model's filename is the same in lowercase letters
     * @param string $model_name The name of the model
     * @return object model
     */
    protected function loadModel($model_name)
    {
        require 'application/models/' . strtolower($model_name) . '.php';
        // return new model (and pass the database connection to the model)
        return new $model_name($this->db);
    }


}
