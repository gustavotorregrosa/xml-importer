<?php

namespace App\Interfaces;

interface ISavesRegistry {
    public function saveRegistry($entityManager, $xml);
}