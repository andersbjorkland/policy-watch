<?php

declare(strict_types=1);

namespace App\Command;

use App\API\Downloader;
use App\API\ParliamentClient;
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

        $downloader = new Downloader();
        $start_time = microtime(true);
        $downloader->downloadImageBatch($persons);
        $elapsed_time = microtime(true) - $start_time;
        echo "Elapsed time: " . $elapsed_time . " seconds" . PHP_EOL;

        foreach ($persons as $person) {
            $person->write();
        }

        echo "Persons found: " . count($persons) . PHP_EOL;
    }
}
