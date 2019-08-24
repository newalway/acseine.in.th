<?php

namespace ProjectBundle\Repository;

/**
 * CustomerOrderDeliveryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CustomerOrderDeliveryRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCustomerOrderDeliveryByOrder($customerOrder,$addressType)
    {
        //QueryBuilder
        $qb = $this->createQueryBuilder('cod')
                   ->select('cod','o')
                   ->innerJoin('cod.customerOrder', 'o')
                   ->where('o.cancelled <> :status')
                   ->andWhere('o.deleted <> :status')
                   ->andWhere('cod.customerOrder = :customer_order_id')
                   ->andWhere('cod.addressType =:addressType')
                   ->setParameter('status', 1)
                   ->setParameter('customer_order_id', $customerOrder)
                   ->setParameter('addressType', $addressType);
        return $qb;
    }

    public function findCustomerOrderDeliveryByOrderAndType($customerOrder, $addressType)
    {
        //QueryBuilder
        $qb = $this->createQueryBuilder('cod')
                   ->select('cod')
                   ->where('cod.customerOrder = :customer_order_id')
                   ->andWhere('cod.addressType =:addressType')
                   ->setParameter('customer_order_id', $customerOrder)
                   ->setParameter('addressType', $addressType);
        return $qb;
    }
}