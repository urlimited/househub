<?php

namespace App\DTO;

abstract class BaseModelDTO
{
    abstract static public function prepareDataToRepository(array $data): static;
}
