<?php

namespace App\Contracts;

interface ApiClientInterface
{
    /**
     * @return array
     */
    public function get(): array;
}
