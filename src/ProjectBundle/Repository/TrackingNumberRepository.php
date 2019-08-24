<?php

namespace ProjectBundle\Repository;

/**
 * TrackingNumberRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TrackingNumberRepository extends \Doctrine\ORM\EntityRepository
{
	private $qb;

	public function findAllData()
    {
		return $this->qb = $this->createQueryBuilder('t')
			->orderBy('t.id', 'ASC');
    }

	public function findSelectDataByOrder($order)
    {
		$this->findAllData();
		$this->qb->select('t.id', 't.orderNumber', 't.trackingNumber', 'sc.id as shippingCarrierId', 'sc.name as shippingCarrierName', 'sc.trackingUrl as trackingUrl')
					->leftjoin('t.shippingCarrier', 'sc');
		$this->qb->andWhere('t.customerOrder = :customer_order')
				->setParameter('customer_order', $order);
		return $this->qb;
    }
}
