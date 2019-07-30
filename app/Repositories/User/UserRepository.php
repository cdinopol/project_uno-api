<?php
namespace App\Repositories\User;

interface UserRepository
{
    public function createUser();
    public function getLastServer($id);
}