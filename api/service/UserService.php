<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/service/Service.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/api/configs/Database.php";
class UserService implements Service
{
    private  $db;
    public function __construct(Database $db)
    {
        $this->db = $db;;
    }
    public function selectAll()
    {
        $sql = "SELECT * FROM user";
        $result = $this->db->queryDB(null, $sql, Database::SELECTALL);
        return $result;
    }

    public function selectById(int $id)
    {
        $sql = "SELECT * FROM user WHERE id = :id";
        $array = array(array(":id", $id));

        $result = $this->db->queryDB($array, $sql, Database::SELECTSINGLE);
        return $result;
    }

    public function create(array $data)
    {
        // $array = array(array("mail", $id)); // prepare for binding before injecting in function 

        $sql = "INSERT INTO user (mail, wallet,referral,p_referral) 
VALUES (:mail, :wallet,:referral,p_referral)";
        $result = $this->db->queryDB($data, $sql, Database::EXECUTE);
    }

    public  function modify(int $id, array $data)
    {
        $sql = "UPDATE user 
SET mail = :mail, wallet = :wallet, referral= :referral, p_referral= :p_referral
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
