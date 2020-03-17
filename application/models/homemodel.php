<?php

class HomeModel
{
    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    /**
     * Get all tasks from database
     */
    public function getAllTasks()
    {
        $sql = "SELECT * FROM tasks";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // libs/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change libs/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    /**
     * Add a task to database
     * @param string $user_name Username
     * @param string $email Email
     * @param string $desc Desctiption
     */
    public function addTask($user_name, $email, $desc)
    {
        $respones = [];
        $errors = [];
        // clean the input from javascript code for example
        $user_name = strip_tags($user_name);
        $email = strip_tags($email);
        $desc = strip_tags($desc);

        if (strlen($user_name) > 20 || strlen($user_name) < 3) {
            $errors[] = 'Username incorrect';
        }

        if (strlen($desc) > 300 || strlen($desc) < 3) {
            $errors[] = 'Note incorrect';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email not valid';
        }
        if (!empty($errors)) {
            $respones['errors'] = $errors;
            return $respones;
        }

        $sql = "INSERT INTO tasks (user_name, email, notes) VALUES (:user_name, :email, :notes)";
        $query = $this->db->prepare($sql);

        try {
            $query->execute(array(':user_name' => $user_name, ':email' => $email, ':notes' => $desc));
            $respones['success'] = 'Task add successfuly';
            return $respones;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Delete a task in the database
     * Please note: this is just an example! In a real application you would not simply let everybody
     * add/update/delete stuff!
     * @param int $task_id Id of tasks
     */
    public function deleteTask($task_id)
    {
        $sql = "DELETE FROM tasks WHERE id = :task_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':task_id' => $task_id));
    }
}
