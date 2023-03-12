<?php

declare(strict_types=1);

namespace App\Command;

use App\API\ParliamentClient;
use App\Model\Parliament\Person;
use GuzzleHttp\Client;
use SilverStripe\Dev\BuildTask;

class FetchParliamentTask extends BuildTask
{

    private static $segment = 'FetchParliamentTask';

    protected $title = 'Load parliament data';

    protected $description = 'Loads database with parliament data';

    public function run($request)
    {
        $client = new ParliamentClient();

        $persons = $client->getPersonList();

        foreach ($persons as $person) {
            $person->write();
        }

        echo "Persons found: " . count($persons) . PHP_EOL;
    }
}
