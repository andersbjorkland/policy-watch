<?php

declare(strict_types=1);

namespace App\Command;

use SilverStripe\Core\Injector\Injector;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Dev\FixtureFactory;
use SilverStripe\Dev\YamlFixture;

class InitTask extends BuildTask
{

    private static $segment = 'InitTask';

    protected $title = 'Load initial data';

    protected $description = 'Loads database with initial data';

    public function run($request)
    {
        /** @var FixtureFactory $fixtureFactory */
        $fixtureFactory = Injector::inst()->create(FixtureFactory::class);

        /** @var YamlFixture $fixture */
        $fixture = Injector::inst()->create(YamlFixture::class, __DIR__ . '/../../assets/fixtures/parties.yml');

        $fixture->writeInto($fixtureFactory);
    }
}
