<?php

declare(strict_types=1);

use App\Model\Person;
use SilverStripe\Admin\ModelAdmin;

class PersonAdmin extends ModelAdmin
{
    private static $managed_models = [
        Person::class
    ];

    private static string $url_segment = 'persons';

    private static string $menu_title = 'Person Admin';
}
