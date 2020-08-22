<?php

namespace App\Tests\Controller;

use App\Tests\DatabaseTestBase;

class ContactControllerTest extends DatabaseTestBase {
	public function testShowIndex() {
		$client = self::getClient();
		$client->request('GET', '/');
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}

	public function testShowInsertContactForm() {
		$client = self::getClient();
		$client->request('GET', '/kontakt');
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}

	public function testContactForm() {
		$client = self::getClient();

		// request insert form
		$client->request('GET', '/kontakt');
		$this->assertEquals(200, $client->getResponse()->getStatusCode());

		// submit insert form
		$client->submitForm('contact_form_save', [
			'contact_form[name]' => 'Johny Mnemonic',
		]);
		$this->assertEquals(302, $client->getResponse()->getStatusCode());

		// request update form
		$client->request('GET', '/kontakt/johny-mnemonic');
		$this->assertEquals(200, $client->getResponse()->getStatusCode());

		// submit update form
		$crawler = $client->submitForm('contact_form_save', [
			'contact_form[name]' => 'Blade Runner',
		]);
		$this->assertEquals(302, $client->getResponse()->getStatusCode());

		// request update form for old name
		$client->request('GET', '/kontakt/johny-mnemonic');
		$this->assertEquals(404, $client->getResponse()->getStatusCode());

		// request update form for new name
		$client->request('GET', '/kontakt/blade-runner');
		$this->assertEquals(200, $client->getResponse()->getStatusCode());

		// request list of contacts and check if Blade Runner is there and Johny Mnemonic is not
		$crawler = $client->request('GET', '/');
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
		$this->assertEquals(
			1,
			$crawler
				->filter('a')
				->reduce(function ($node, $i) {
					return $node->text() == 'Blade Runner';
				})
				->count(),
		);
		$this->assertEquals(
			0,
			$crawler
				->filter('a')
				->reduce(function ($node, $i) {
					return $node->text() == 'Johny Mnemonic';
				})
				->count(),
		);
	}
}
