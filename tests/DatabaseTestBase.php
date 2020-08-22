<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;

/**
 * Base class for tests using database. It will create new empty database before running tests.
 */
class DatabaseTestBase extends WebTestCase {
	protected static $client;
	protected static $application;

	protected static function getClient() {
		if (null === self::$client) {
			self::$client = static::createClient();
			self::bootKernel();
		}
		return self::$client;
	}

	protected static function getApplication() {
		if (null === self::$application) {
			$client = self::getClient();
			self::$application = new Application($client->getKernel());
			self::$application->setAutoExit(false);
		}
		return self::$application;
	}

	protected static function runCommand($command) {
		$command = sprintf('%s --quiet', $command);
		return self::getApplication()->run(new StringInput($command));
	}

	protected function setUp() {
		self::runCommand('doctrine:database:drop --force');
		self::runCommand('doctrine:database:create');
		self::runCommand('doctrine:schema:update --force');
		//self::runCommand('doctrine:fixtures:load --purge-with-truncate');
	}
}
