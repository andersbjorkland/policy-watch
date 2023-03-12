<?php

declare(strict_types=1);

use App\Model\Parliament\Person;
use SilverStripe\Admin\ModelAdmin;

class ParliamentAdmin extends ModelAdmin
{
    private static $managed_models = [
        Person::class
    ];

    private static string $url_segment = 'parliament';

    private static string $menu_title = 'Parliament Admin';
}
