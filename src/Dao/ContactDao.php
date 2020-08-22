<?php

namespace App\Dao;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContactRepository;

/*
 * Data Access Object for Contact entity. Provides all data related methods for retrieving and persisting contact data.
 */
class ContactDao {
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;

	/**
	 * @var ContactRepository
	 */
	private $contact_repository;

	public function __construct(
		EntityManagerInterface $em,
		ContactRepository $repository
	) {
		$this->entityManager = $em;
		$this->contact_repository = $repository;
	}

	/**
	 * Load all contacts in database.
	 * @return array<Contact>
	 */
	public function loadAllContacts(): array {
		return $this->contact_repository->findAll();
	}

	public function loadContactBySlug(string $slug): ?Contact {
		/** we must tell PHPStan to ignore next call, because it is a magic method */
		/** @phpstan-ignore-next-line */
		return $this->contact_repository->findOneBySlug($slug);
	}

	public function saveContact(Contact $contact): void {
		$this->entityManager->persist($contact);
		$this->entityManager->flush();
	}

	public function deleteContact(Contact $contact): void {
		$this->entityManager->remove($contact);
		$this->entityManager->flush();
	}
}
