<?php

namespace DeitDoctrineExtensionsModule\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * An identifiable entity
 * @author James Newell <james@digitaledgeit.com.au>
 */
trait IdentifiableTrait {

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 */
	protected $id;

	/**
	 * Get the ID
	 * @return  int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Set the ID
	 * @param   int $id
	 * @return  $this
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

}