<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordNotification extends ResetPassword implements ShouldQueue
{
    use Queueable;

    /**
     * ResetPasswordNotification constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        parent::__construct($token);
    }
}
