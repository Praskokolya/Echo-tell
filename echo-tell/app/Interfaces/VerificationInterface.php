<?php

namespace App\Interfaces;

interface VerificationInterface
{
    public function verify(mixed $id): int;
}
