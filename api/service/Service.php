<?php

interface Service
{
    public function selectAll();
    public function selectById(int $id);
    public function create(array $data);
    public  function modify(int $id, array $data);
    public function delete(int $id);
}
