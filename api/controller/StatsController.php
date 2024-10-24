<?php
require $_SERVER["DOCUMENT_ROOT"] . "/api/service/StatsService.php";
class StatsController
{
    private StatsService $service;
    public function __construct()
    {
        $this->service = new StatsService(new Database());
    }

    #[Route('GET', '/stats/{id}')]
    public function getStatsById()
    {
        $id = (int) $_GET('id');
        return  $this->service->selectById($id);
    }

    #[Route('GET', '/stats')]
    public function getStats()
    {

        return  $this->service->selectAll();
    }

    // get stats of a particular user
    #[Route('GET', '/stats/user/{id}')]
    public function getStatsByUser()
    {
        $id = $_GET['id'];
        return $this->service->getStatsByUser($id);
    }

    #[Route('GET', '/stats/cron/{id}')]
    public function getStatsByCron()
    {
        $id = $_GET['id'];
        return $this->service->getStatsByCron($id);
    }


    #[Route('POST', '/stats')]
    public function postStats()
    {
        $result = json_decode(file_get_contents('php://input'), true);
        $data = array();
        foreach ($result as $key => $value) {
            array_push($data, array(":$key", $value));
        }
        try {
            $this->service->create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    #[Route('PUT', '/stats/{id}')]
    public function putStats()
    {

        $id =  $_GET['id'];
        $result = json_decode(file_get_contents('php://input'), true);
        $data = array();
        foreach ($result as $key => $value) {
            array_push($data, array(":$key", $value));
        }
        try {
            $this->service->modify($id, $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    #[Route('DELETE', '/stats/{id}')]
    public function deleteStats()
    {
        $id =  $_GET['id'];
        try {
            $this->service->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
