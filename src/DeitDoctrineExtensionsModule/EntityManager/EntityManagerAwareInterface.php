<?php

namespace DeitDoctrineExtensionsModule\EntityManager;
use Doctrine\ORM\EntityManagerInterface as EntityManager;

/**
 * Entity aware interface
 * @author James Newell <james@digitaledgeit.com.au>
 */
interface EntityManagerAwareInterface {

	/**
	 * Gets the entity manager
	 * @return  EntityManager
	 */
	public function getEntityManager();

	/**
	 * Sets the entity manager
	 * @param   EntityManager $entityManager
	 * @return  $this
	 */
	public function setEntityManager(EntityManager $entityManager);

}
 