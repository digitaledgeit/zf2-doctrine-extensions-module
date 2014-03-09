<?php

namespace DeitDoctrineExtensionsModule\EntityManager;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Entity aware initializer
 * @author James Newell <james@digitaledgeit.com.au>
 */
class EntityManagerAwareInitializer implements InitializerInterface {

	/**
	 * Injects the entity manager into services
	 * @param   mixed                   $service
	 * @param   ServiceLocatorInterface $serviceLocator
	 * @return  void
	 */
	public function initialize($service, ServiceLocatorInterface $serviceLocator) {
		if ($service instanceof EntityManagerAwareInterface) {
			$service->setEntityManager($serviceLocator->get('Doctrine\ORM\EntityManager'));
		}
	}

}
 