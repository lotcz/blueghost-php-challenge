<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\SluggerInterface;

/*
 * Form for editing a Contact entity.
 */
class ContactForm extends AbstractType {
	/**
	 * Service that provides creation of "slugs" - url identifiers created from strings.
	 * @var SluggerInterface
	 */
	private $slugger;

	public function __construct(SluggerInterface $slugger) {
		$this->slugger = $slugger;
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(
		FormBuilderInterface $builder,
		array $options
	): void {
		$builder
			->add('name', null, [
				'attr' => ['autofocus' => true],
				'label' => 'Jméno',
			])
			->add('phone', null, [
				'label' => 'Telefon',
			])
			->add('email', null, [
				'label' => 'E-mail',
			])
			->add('remark', TextareaType::class, [
				'label' => 'Poznámka',
				'required' => false,
			])
			->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
				/** @var Contact */
				$contact = $event->getData();
				if (null !== ($name = $contact->getName())) {
					$contact->setSlug($this->slugger->slug($name)->lower());
				}
			});
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver): void {
		$resolver->setDefaults([
			'data_class' => Contact::class,
		]);
	}
}
