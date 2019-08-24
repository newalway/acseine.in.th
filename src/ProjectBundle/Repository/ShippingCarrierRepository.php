<?php

namespace ProjectBundle\Repository;

/**
 * ShippingCarrierRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ShippingCarrierRepository extends \Doctrine\ORM\EntityRepository
{
	private $qb;

	public function findAllData()
    {
		return $this->qb = $this->createQueryBuilder('s')
			->orderBy('s.id', 'ASC');
    }

	public function findSelectAllData()
    {
		$this->findAllData();
		return $this->qb->select('s.id', 's.name', 's.trackingUrl');
    }
}
