<?php

namespace ProjectBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\Intl\Locale;

class ProductCategoryRepository extends EntityRepository
{
	private $qb;

	public function findPublicDataJoinedProduct($locale=false)
    {
		$locale = ($locale) ? $locale : Locale::getDefault();
		$this->findAllData();
		$this->qb->addSelect('s', 'st', 'p', 'pt')
				->join('c.series', 's')
				->join('s.translations', 'st')
				->join('s.products', 'p')
				->join('p.translations', 'pt')
				->addOrderBy('s.position', 'ASC')
				->addOrderBy('p.position', 'ASC')
				// ->andWhere("st.locale = '$locale'")
				// ->andWhere("pt.locale = '$locale'")
				;

		//public product
		$this->qb->andWhere('NOW() >= p.publishDate')
		            ->andWhere($this->qb->expr()->andX(
		                $this->qb->expr()->eq('p.status', ':status')
		            ))
            		->setParameter('status', 1);

		return $this->qb;
	}

	public function findAllData($arr_query_data=false, $locale=false)
    {
		$locale = ($locale) ? $locale : Locale::getDefault();

		$this->qb = $this->createQueryBuilder('c');
		//join translation
		$this->qb->join('c.translations', 'ct')
				->select('c', 'ct')
				->where("ct.locale = '$locale'")
				->orderBy('c.position', 'ASC')
				->addOrderBy('c.createdAt', 'DESC');

		$this->setSearchData($arr_query_data);

  		return $this->qb;
    }

	protected function setSearchData($arr_query_data)
	{
		if(isset($arr_query_data['q'])){
			//search from translation
  			$this->qb->where($this->qb->expr()->orX(
	  	      	$this->qb->expr()->like('ct.title', ':query'),
	  			$this->qb->expr()->like('ct.shortDesc', ':query')
			))
  			->setParameter('query', '%'.$arr_query_data['q'].'%');
  		}
	}
}
