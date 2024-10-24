<?php

class Database
{

    const SELECTSINGLE = 1;
    const SELECTALL = 2;
    const EXECUTE = 3;

    private $pdo;
    private static $instance = null;

    public function __construct()
    {

        $this->pdo = new PDO("mysql:host=localhost;dbname=ktk_tte", "fitzgerard", "Diablomanore237@localhost");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    // public static function getInstance()
    // {
    //     if (self::$instance == null) {
    //         return self::$instance = new self();
    //     } else {
    //         return self::$instance;
    //     }
    // }
    // public function getConnection()
    // {
    //     return self::$pdo;
    // }
    public function queryDB(null|array $values, $query,  $mode = 1)
    {

        $stmt = $this->pdo->prepare($query);
        if (isset($values) && $values != null) {
            foreach ($values as $valueToBind) {
                $stmt->bindValue($valueToBind[0], $valueToBind[1]);
            };
        }

        $stmt->execute();



        if ($mode != self::SELECTSINGLE && $mode != self::SELECTALL && $mode != self::EXECUTE) {
            throw new Exception("Selection mode undefined , counld not proceed the query");
        } elseif ($mode === self::SELECTSINGLE) {
            return  array($stmt->fetch(PDO::FETCH_ASSOC));
        } elseif ($mode === self::SELECTALL) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
