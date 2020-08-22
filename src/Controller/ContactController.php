<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Entity\Contact;
use App\Dao\ContactDao;
use App\Form\ContactForm;

/**
 * Handles displaying, editing and deleting of a Contact entity.
 */
class ContactController extends AbstractController {
	/**
	 * @var ContactDao
	 */
	private $contact_dao;

	public function __construct(ContactDao $dao) {
		$this->contact_dao = $dao;
	}

	private function createContactForm(Contact $contact): FormInterface {
		return $this->createForm(ContactForm::class, $contact)->add(
			'save',
			SubmitType::class,
			['label' => 'Uložit'],
		);
	}

	/**
	 * @Route("/kontakt/{slug?}", methods="GET|POST", name="contact_show")
	 *
	 * Show contact edit form and handle save action (method POST).
	 *
	 * @param  ?string   $slug
	 * @return Response
	 */
	public function showEditForm(Request $request, ?string $slug): Response {
		if (isset($slug)) {
			$contact = $this->contact_dao->loadContactBySlug($slug);
		} else {
			$contact = new Contact();
		}
		if (isset($contact)) {
			$form = $this->createContactForm($contact);
			$form->handleRequest($request);
			if ($form->isSubmitted() && $form->isValid()) {
				// TODO: contact name and slug might already exist,
				// we should handle that by either refusing to save duplicate or generating new unique slug
				$this->contact_dao->saveContact($contact);
				$this->addFlash('notice', 'Kontakt byl uložen.');
				return $this->redirectToRoute('index');
			}
			return $this->render('detail.html.twig', [
				'contact' => $contact,
				'form' => $form->createView(),
			]);
		} else {
			throw $this->createNotFoundException('Kontakt nenalezen!');
		}
	}

	/**
	 * @Route("/kontakt/{slug}/smazat", methods="GET|POST", name="contact_delete")
	 * @ParamConverter("contact", options={"mapping": {"slug": "slug"}})
	 *
	 * Show confirmation for contact deletion. If confirmed (method POST), delete contact and redirect to frontpage.
	 *
	 * @param  Contact $contact
	 * @return Response
	 */
	public function delete(Request $request, Contact $contact): Response {
		if ($request->isMethod('post')) {
			$this->contact_dao->deleteContact($contact);
			$this->addFlash('notice', 'Kontakt byl smazán.');
			return $this->redirectToRoute('index');
		} else {
			return $this->render('delete.html.twig', [
				'contact' => $contact,
			]);
		}
	}
}
