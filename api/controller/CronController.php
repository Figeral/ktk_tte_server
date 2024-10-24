<?php
require $_SERVER["DOCUMENT_ROOT"] . "/api/service/CronService.php";
class CronController
{
    private CronService $service;
    public function __construct()
    {
        $this->service = new CronService(new Database());
    }
    #[Route('GET', '/cron/{id}')]
    public function getCronById()
    {
        $id =  $_GET['id'];
        return  $this->service->selectById($id);
    }

    #[Route('GET', '/crons')]
    public function getCron()
    {

        return  $this->service->selectAll();
    }
    #[Route('POST', '/cron')]
    public function postCron()
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
    #[Route('PUT', '/cron/{id}')]
    public function putCron()
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
    #[Route('DELETE', '/cron')]
    public function deleteCron()
    {
        $id = $_GET['id'];
        try {
            $this->service->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
