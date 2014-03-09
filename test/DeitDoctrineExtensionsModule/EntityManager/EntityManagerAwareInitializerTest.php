<?php

namespace DeitDoctrineExtensionsModule\EntityManager;
use Zend\ServiceManager\Config as ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

/**
 * Test service
 * @author James Newell <james@digitaledgeit.com.au>
 */
class EntityManagerAwareTestService implements EntityManagerAwareInterface {
	use EntityManagerAwareTrait;
}

/**
 * Entity aware initializer test
 * @author James Newell <james@digitaledgeit.com.au>
 */
class EntityManagerAwareInitializerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * The service manager
	 * @var     ServiceManager
	 */
	private $serviceManager;

	/**
	 * @inheritdoc
	 */
	protected function setUp() {

		//mock up the entity manager
		$entityManager = $this->getMock(
			'\Doctrine\ORM\EntityManager',
			[
				'getRepository',
				'getClassMetadata',
				'persist',
				'flush'
			],
			[],
			'',
			false
		);

		//create the service manager
		$this->serviceManager = new ServiceManager(new ServiceManagerConfig([
			'initializers' => [
				'entityManager' => 'DeitDoctrineExtensionsModule\EntityManager\EntityManagerAwareInitializer',
			],
			'invokables' => [
				'MyService' => 'DeitDoctrineExtensionsModule\EntityManager\EntityManagerAwareTestService',
			],
			'factories' => [
				'Doctrine\ORM\EntityManager' => function() use($entityManager) {
					return $entityManager;
				},
			],
		]));
	}

	/**
	 * @inheritdoc
	 */
	protected function tearDown() {
		$this->serviceManager = null;
	}

	/**
	 * Tests the entity manager is injected
	 */
	public function testEntityManagerIsInjected() {

		//get the service
		$service = $this->serviceManager->get('MyService');

		//check the service is aware of the entity manager
		$this->assertInstanceOf('DeitDoctrineExtensionsModule\EntityManager\EntityManagerAwareInterface', $service);

		//check the service has an instance of the entity manager
		$this->assertInstanceOf('Doctrine\ORM\EntityManagerInterface', $service->getEntityManager());

	}

}
 