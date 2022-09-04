<?php

namespace Module;

use Model\User;

class ModelMapper
{

    /** maps model string to instance. */
    public function map(string $model)
    {
        return match ($model) {
            'Model\User' => new User(),
            default => throw new \Exception('Invalid Model given:' . $model),
        };
        
    }

}