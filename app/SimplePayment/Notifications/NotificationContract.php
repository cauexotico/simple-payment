<?php

namespace SimplePayment\Notifications;

interface NotificationContract
{
    public function getName(): string;
    public function notify(): bool;
}
