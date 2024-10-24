<?php
require $_SERVER["DOCUMENT_ROOT"] . "/api/service/UserService.php";

class UserController
{
    private  $service;
    public function __construct()
    {
        $this->service = new UserService(new Database());
    }
    #[Route('GET', '/user/{id}')]
    public function getUserById()
    {

        $id =  $_GET['id'];
        return  $this->service->selectById($id);
    }

    #[Route('GET', '/users')]
    public function getUser()
    {

        return  $this->service->selectAll();
    }
    #[Route('POST', '/user')]
    public function postUser()
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
    #[Route('PUT', '/user/{id}')]
    public function putUser()
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
    #[Route('DELETE', '/user/{id}')]
    public function deleteUser()
    {
        $id =  $_GET['id'];
        try {
            $this->service->delete($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
