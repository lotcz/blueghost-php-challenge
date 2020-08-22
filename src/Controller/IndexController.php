<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Dao\ContactDao;

/**
 * Handles displaying of list of Contact entity.
 */
class IndexController extends AbstractController {
	/**
	 * @var ContactDao
	 */
	private $contact_dao;

	public function __construct(ContactDao $dao) {
		$this->contact_dao = $dao;
	}

	/**
	 * @Route("/", methods="GET", name="index")
	 *
	 * List all contacts in database.
	 * @return Response
	 */
	public function index(): Response {
		$contacts = $this->contact_dao->loadAllContacts();
		return $this->render('index.html.twig', [
			'contacts' => $contacts,
		]);
	}
}
