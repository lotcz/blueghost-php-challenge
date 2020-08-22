<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test basic functionality of routes.
 */
class RoutesTest extends WebTestCase {
	/**
	 * @dataProvider urlProvider
	 */
	public function testPageIsSuccessful($url) {
		$client = self::createClient();
		$client->request('GET', $url);
		$this->assertResponseIsSuccessful();
	}

	public function urlProvider() {
		yield ['/'];
		yield ['/kontakt'];
	}
}
