<?php

namespace ProjectBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * BannerCampaignRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BannerCampaignRepository extends EntityRepository
{
    public function findAllData($arr_query_data=false)
    {
        $qb = $this->createQueryBuilder('b');
		$qb->orderBy('b.position', 'ASC')
            ->addOrderBy('b.publicDate', 'DESC')
			->addOrderBy('b.createdAt', 'DESC');

		$q = $arr_query_data['q'];
  		if($q){
			//search
  			$qb->andWhere($qb->expr()->orX(
	  	      	$qb->expr()->like('b.title', ':query')
			))
  			->setParameter('query', '%'.$q.'%');
  		}

  		return $qb;
    }

    public function findAllActiveData()
    {
        $qb = $this->findAllData();
        $qb->andWhere($qb->expr()->andX(
                $qb->expr()->like('b.status', ':status'),
                $qb->expr()->lte('b.publicDate', ':publicdate')
            ))
            ->setParameters(array(
                'status' => 1,
                'publicdate' => date('Y-m-d')
            ))
        ;
        return $qb;
    }
}