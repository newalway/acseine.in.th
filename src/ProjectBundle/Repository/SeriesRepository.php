<?php

namespace ProjectBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\Intl\Locale;

/**
 * SeriesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SeriesRepository extends \Doctrine\ORM\EntityRepository
{
	private $qb;

	public function findOnePublicDataJoinedProduct($id, $locale=false)
    {
		$locale = ($locale) ? $locale : Locale::getDefault();
		$this->findAllDataJoined($locale);
		$this->qb->addSelect('p', 'pt')
				->join('s.products', 'p')
				->join('p.translations', 'pt')
				->andWhere("s.id = '$id'")
				->andWhere("pt.locale = '$locale'")
				->addOrderBy('p.position', 'ASC')
				->addOrderBy('p.createdAt', 'DESC');

		//public product
		$this->qb->andWhere('NOW() >= p.publishDate')
		            ->andWhere($this->qb->expr()->andX(
		                $this->qb->expr()->eq('p.status', ':status')
		            ))
            		->setParameter('status', 1);

		return $this->qb;

		return $this->qb;
	}

	public function findAllDataJoined($arr_query_data=false, $locale=false)
    {
		$locale = ($locale) ? $locale : Locale::getDefault();
		$this->qb = $this->createQueryBuilder('s');
		//join translation
		$this->qb->select('s', 'st', 'pc', 'pct')
			->join('s.translations', 'st')
			->leftjoin('s.productCategory', 'pc')
			->leftjoin('pc.translations', 'pct')
			// ->where("st.locale = '$locale'")
			->orderBy('pc.position', 'ASC')
			->addOrderBy('s.position', 'ASC')
			->addOrderBy('s.createdAt', 'DESC');

		$this->setSearchData($arr_query_data);

		return $this->qb;
	}

	public function findAllData($arr_query_data=false, $locale=false)
    {
		$locale = ($locale) ? $locale : Locale::getDefault();

		$this->qb = $this->createQueryBuilder('s');
		//join translation
		$this->qb->select('s', 'st')
				->join('s.translations', 'st')
				->where("st.locale = '$locale'")
				->orderBy('s.position', 'ASC')
				->addOrderBy('s.createdAt', 'DESC');

		$this->setSearchData($arr_query_data);

  		return $this->qb;
    }

	protected function setSearchData($arr_query_data)
	{
  		if(isset($arr_query_data['q'])){
			//search from translation
  			$this->qb->where($this->qb->expr()->orX(
	  	      	$this->qb->expr()->like('st.title', ':query'),
				$this->qb->expr()->like('st.subTitle', ':query'),
	  			$this->qb->expr()->like('st.shortDesc', ':query')
			))
  			->setParameter('query', '%'.$arr_query_data['q'].'%');
  		}
	}
}