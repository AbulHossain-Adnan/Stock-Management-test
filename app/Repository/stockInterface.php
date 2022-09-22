<?php
namespace App\Repository;

interface stockInterface 
{
    public function getAllStock($make_true = null);
    public function createOrUpdate($request,$stock=null);

}