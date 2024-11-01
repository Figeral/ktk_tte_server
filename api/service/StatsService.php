<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/service/Service.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/configs/Database.php";
class StatsService implements Service
{
    private $db;
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM stats";
        $result = $this->db->queryDB(null, $sql, Database::SELECTALL);
        return $result;
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM stats WHERE id = :id";
        $array = array(array(":id", $id));

        $result = $this->db->queryDB($array, $sql, Database::SELECTSINGLE);
        return $result;
    }

    public function create(array $data)
    {
        $sql = "INSERT INTO stats (score, claims, restarted, created_at, updated_at, id_user, id_cron) 
                VALUES (:score, :claims, :restarted, :created_at, :updated_at, :id_user, :id_cron)";
        $result = $this->db->queryDB($data, $sql, Database::EXECUTE);
    }

    public function modify(int $id, array $data)
    {
        $sql = "UPDATE stats 
                SET score = :score, claims = :claims, restarted = :restarted, 
                    updated_at = :updated_at, id_user = :id_user, id_cron = :id_cron
                WHERE id = $id";
        $result = $this->db->queryDB($data, $sql, Database::EXECUTE);
    }
    public function modifySpecific(int $id, string $col, array $data)
    {
        $sql = "UPDATE stats 
                SET $col=:$col
                WHERE id = $id";
        $result = $this->db->queryDB($data, $sql, Database::EXECUTE);
    }
    public function delete(int $id)
    {
        $sql = "DELETE FROM stats 
                WHERE id = :id";
        $array = array(array(":id", $id));
        $result = $this->db->queryDB($array, $sql, Database::EXECUTE);
    }

    public function getStatsByUser(int $userId)
    {
        $sql = "SELECT * FROM stats WHERE id_user = :id_user";
        $array = array(array(":id_user", $userId));
        $result = $this->db->queryDB($array, $sql, Database::SELECTSINGLE);
        return $result;
    }

    public function getStatsByCron(int $cronId)
    {
        $sql = "SELECT * FROM stats WHERE id_cron = :id_cron";
        $array = array(array(":id_cron", $cronId));
        $result = $this->db->queryDB($array, $sql, Database::SELECTALL);
        return $result;
    }

    public function updateScore(int $id, int $newScore)
    {
        $sql = "UPDATE stats SET score = :score, updated_at = NOW() WHERE id = :id";
        $array = array(
            array(":score", $newScore),
            array(":id", $id)
        );
        $result = $this->db->queryDB($array, $sql, Database::EXECUTE);
        return $result;
    }
}
