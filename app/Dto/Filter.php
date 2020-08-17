<?php
namespace App\Dto;

class Filter{
    public int $page = 0;
    public int $limit = 0;
    public string $orderBy = "";
    public string $orderType = "";
    public int $month = 0;
    public int $year = 0;
    public int $monthTo = 0;
    public int $yearTo = 0;
    public array $fieldsFilter = [];
    public bool $exacts = false;
}