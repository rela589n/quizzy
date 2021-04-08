<?php

declare(strict_types=1);


namespace App\Lib\Tests\Pass\Exceptions;

use App\Models\Test;
use App\Models\User;
use Throwable;

final class PassTestSessionDoesntExists extends \RuntimeException
{
    private Test $test;
    private User $user;

    public function __construct(Test $test, User $user)
    {
        parent::__construct("Pass test session doesn't exists");
        $this->test = $test;
        $this->user = $user;
    }

    public function getTest(): Test
    {
        return $this->test;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
