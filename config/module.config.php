<?php

namespace DeitDoctrineExtensionsModule;

return [

	'service_manager' => [
		'initializers' => [

			/*
			 * Injects the entity manager into services
			 */
			'entityManager' => 'DeitDoctrineExtensionsModule\EntityManager\EntityManagerAwareInitializer',

		],
	],

];
