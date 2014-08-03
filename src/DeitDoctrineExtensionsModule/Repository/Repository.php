<?php

namespace DeitDoctrineExtensionsModule\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use Zend\Paginator\Paginator as ZendPaginator;

/**
 * Repository
 * @author James Newell <james@digitaledgeit.com.au>
 */
class Repository extends EntityRepository {

	/**
	 * Creates a new query from DQL
	 * @param   string        $dql          The query
	 * @param   mixed[string] $params       The query parameters
	 * @return  \Doctrine\ORM\Query
	 * @throws
	 */
	protected function createQueryFromDql($dql, array $params = array()) {
		$qb = $this->getEntityManager()->createQuery($dql);
		$qb->setParameters($params);
		return $qb;
	}

	/**
	 * Maps the specified criteria to the query builder
	 * @param   QueryBuilder  $qb           The query builder
	 * @param   mixed[string] $criteria     The search criteria
	 * @param   mixed[string] $ordering     The result ordering
	 * @return  \Doctrine\ORM\QueryBuilder
	 * @throws
	 */
	protected function mapCriteriaToBuilder(QueryBuilder $qb, array $criteria = [], array $ordering = []) {

		$method = 'orWhere';

		//get the metadata
		$metadata = $this->getClassMetadata();

		foreach ($criteria as $propertyName => $property) {

			if (is_array($property)) {
				$propertyValue  = $property['value'];
				$comparator     = $property['operator'];
			} else {
				$propertyValue  = $property;
				$comparator     = 'eq';
			}

			//check the property exists on the entity (otherwise the query may contain injected DQL)
			if (!$metadata->hasField($propertyName) && !$metadata->hasAssociation($propertyName)) {
				throw new \InvalidArgumentException("Invalid property \"$propertyName\".");
			}

			//add the criteria
			if ($comparator === 'eq')
				$qb->$method($qb->expr()->eq('e.'.$propertyName, $qb->expr()->literal($propertyValue)));
			elseif ($comparator === 'neq')
				$qb->$method($qb->expr()->neq('e.'.$propertyName, $qb->expr()->literal($propertyValue)));
			elseif ($method === 'lt')
				$qb->$method($qb->expr()->lt('e.'.$propertyName, $qb->expr()->literal($propertyValue)));
			elseif ($comparator === 'lte')
				$qb->$method($qb->expr()->lte('e.'.$propertyName, $qb->expr()->literal($propertyValue)));
			elseif ($comparator === 'gt')
				$qb->$method($qb->expr()->gt('e.'.$propertyName, $qb->expr()->literal($propertyValue)));
			elseif ($comparator === 'gte')
				$qb->$method($qb->expr()->gte('e.'.$propertyName, $qb->expr()->literal($propertyValue)));
			elseif ($comparator === 'like')
				$qb->$method($qb->expr()->like('e.'.$propertyName, $qb->expr()->literal($propertyValue)));
			elseif ($comparator === 'notlike')
				$qb->$method($qb->expr()->notlike('e.'.$propertyName, $qb->expr()->literal($propertyValue)));
		}

		//order by each property
		foreach ($ordering as $propertyName => $propertyValue) {
			$qb->orderBy('e.'.$propertyName, $propertyValue);
		}

		return $qb;
	}

	/**
	 * Paginates a query
	 * @param   \Doctrine\ORM\QueryBuilder $qb
	 * @return  ZendPaginator
	 */
	protected function createPaginator(\Doctrine\ORM\QueryBuilder $qb) {
		return new ZendPaginator(new DoctrinePaginatorAdapter(new DoctrinePaginator($qb->getQuery())));
	}

	/**
	 * Performs a query
	 * @param   string  $dql
	 * @param   mixed[] $params
	 * @return  array
	 * @deprecated
	 */
	protected function query($dql, array $params = []) {
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameters($params);
		return $query->getResult();
	}

	/**
	 * Performs a query and paginates the results
	 * @param   string $dql
	 * @return  ZendPaginator
	 * @deprecated
	 */
	protected function queryAndPaginate($dql) {
		$query      = $this->getEntityManager()->createQuery($dql);
		$paginator  = new ZendPaginator(new DoctrinePaginatorAdapter(new DoctrinePaginator($query)));
		return $paginator;
	}

}