<?php
/**
admin model
**/

class AdminModel
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

    public function getAllTasks()
    {
        $sql = "SELECT * FROM tasks";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

	public function updateStatus($data)
    {
        $id = strip_tags($data['id']);
        $status = strip_tags($data['status']);

        $sql = "UPDATE tasks SET status = :status WHERE id = :task_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':task_id' => $id, ':status' => $status));
    }

	public function updateNotes($data)
    {
        $id = strip_tags($data['id']);
        $note = strip_tags($data['desc']);

        $sql = "UPDATE tasks SET notes = :notes, admin_update = 1 WHERE id = :task_id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':task_id' => $id, ':notes' => $note));
    }

}
