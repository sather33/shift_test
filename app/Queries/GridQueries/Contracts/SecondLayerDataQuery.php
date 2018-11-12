<?php
namespace App\Queries\GridQueries\Contracts;

interface SecondLayerDataQuery
{
    public function data($column, $direction, $belongs_to_id);

    public function filteredData($column, $direction, $keyword, $belongs_to_id);
}