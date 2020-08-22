<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use function Symfony\Component\String\u;
use Symfony\Component\Validator\Constraints;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 *
 * Represents a single contact.
 */
class Contact {
	/**
	 * @var int
	 *
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", unique=true, length=50)
	 * @Constraints\NotBlank()
	 * @Constraints\Length(
	 *     max=50
	 * )
	 */
	private $slug;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=50)
	 * @Constraints\NotBlank()
	 * @Constraints\Length(
	 *     max=50
	 * )
	 */
	private $name;

	/**
	 * @var ?string
	 *
	 * @ORM\Column(type="string", nullable=true, length=50)
	 * @Constraints\Length(
	 *     max=50
	 * )
	 */
	private $phone;

	/**
	 * @var ?string
	 *
	 * @ORM\Column(type="string", nullable=true, length=50)
	 * @Constraints\Email()
	 * @Constraints\Length(
	 *     max=50
	 * )
	 */
	private $email;

	/**
	 * @var ?string
	 *
	 * @ORM\Column(type="text", nullable=true)
	 * @Constraints\Length(
	 *     max=10000
	 * )
	 */
	private $remark;

	public function getId(): ?int {
		return $this->id;
	}

	public function getSlug(): ?string {
		return $this->slug;
	}

	public function setSlug(?string $slug): void {
		$this->slug = $slug;
	}

	public function getName(): ?string {
		return $this->name;
	}

	public function setName(?string $name): void {
		$this->name = $name;
	}

	public function getPhone(): ?string {
		return $this->phone;
	}

	public function setPhone(?string $phone): void {
		$this->phone = $phone;
	}

	public function getEmail(): ?string {
		return $this->email;
	}

	public function setEmail(?string $email): void {
		$this->email = $email;
	}

	public function getRemark(): ?string {
		return $this->remark;
	}

	public function setRemark(?string $remark): void {
		$this->remark = $remark;
	}
}
