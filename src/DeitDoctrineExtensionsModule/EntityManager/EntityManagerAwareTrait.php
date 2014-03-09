<?php

namespace DeitDoctrineExtensionsModule\EntityManager;
use Doctrine\ORM\EntityManagerInterface as EntityManager;

/**
 * Entity aware trait
 * @author James Newell <james@digitaledgeit.com.au>
 */
trait EntityManagerAwareTrait {

	/**
	 * The entity manager
	 * @var EntityManager
	 */
	private $entityManager;

	/**
	 * @inheritdoc
	 */
	public function getEntityManager() {
		return $this->entityManager;
	}

	/**
	 * @inheritdoc
	 */
	public function setEntityManager(EntityManager $entityManager) {
		$this->entityManager = $entityManager;
		return $this;
	}

}
 