<?php

use Mailjet\LaravelMailjet\MailjetServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\EventServiceProvider::class,
	MailjetServiceProvider::class,
];
