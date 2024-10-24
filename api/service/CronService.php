<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/service/Service.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/configs/Database.php";
class CronService implements Service
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM cron";
        $result = $this->db->queryDB(null, $sql, Database::SELECTALL);
        return $result;
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM cron WHERE id = :id";
        $array = array(array(":id", $id));
        $result = $this->db->queryDB($array, $sql, Database::SELECTSINGLE);
        return $result;
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO cron (starts_at, ends_at, is_active) 
                VALUES (:starts_at, :ends_at, :is_active)";
        $result = $this->db->queryDB($data, $sql, Database::EXECUTE);
    }

    public function modify(int $id, array $data)
    {
        $sql = "UPDATE cron 
                SET starts_at = :starts_at, ends_at = :ends_at, is_active = :is_active
                WHERE id = $id";
        $result = $this->db->queryDB($data, $sql, Database::EXECUTE);
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM cron WHERE id = :id";
        $array = array(array(":id", $id));
        $result = $this->db->queryDB($array, $sql, Database::EXECUTE);
    }
}
