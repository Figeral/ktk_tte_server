<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/service/Service.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/configs/Database.php";
class TaskService implements Service
{
    private  $db;
    public function __construct(Database $db)
    {
        $this->db = $db;;
    }
    public function selectAll()
    {
        $sql = "SELECT * FROM task";
        $result = $this->db->queryDB(null, $sql, Database::SELECTALL);
        return $result;
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM task WHERE id = :id";
        $array = array(array(":id", $id));

        $result = $this->db->queryDB($array, $sql, Database::SELECTSINGLE);
        return $result;
    }

    public function create(array $data)
    {
        // $array = array(array("mail", $id)); // prepare for binding before injecting in function 

        $sql = "INSERT INTO task (describe, link,status,image_link) 
VALUES (:describe, :link, :status,:image_link)";
        $result = $this->db->queryDB($data, $sql, Database::EXECUTE);
    }

    public  function modify(int $id, array $data)
    {
        $sql = "UPDATE task 
SET describe = :describe, link = :link, status = : status,link = :link
WHERE id = $id";
        $result = $this->db->queryDB($data, $sql, Database::EXECUTE); // prepare for binding before injecting in function 

    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM user 
WHERE id = :id";
        $array = array(array(":id", $id));
        $result = $this->db->queryDB($array, $sql, Database::EXECUTE);
    }
}
