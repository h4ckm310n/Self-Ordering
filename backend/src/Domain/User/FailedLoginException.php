<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\DomainException\DomainException;

class FailedLoginException extends DomainException
{
    public $message = 'Failed to login.';
}