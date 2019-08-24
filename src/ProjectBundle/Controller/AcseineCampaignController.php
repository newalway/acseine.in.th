<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use ProjectBundle\Entity\BannerCampaign;
use ProjectBundle\Entity\CounselingRegister;
use ProjectBundle\Entity\Blog;
use ProjectBundle\Entity\BlogImage;

use ProjectBundle\Form\Type\CounselingRegisterType;

class AcseineCampaignController extends Controller
{
	const CACHE_EXPIRES = 300;

	public function indexAction(Request $request)
    {
		$em = $this->getDoctrine();
		$banners = $em->getRepository(BannerCampaign::class)->findAllActiveData()->getQuery()->getResult();
        $blogs  = $em->getRepository(Blog::class)->findAllActiveData()->setMaxResults(3)->getQuery()->getResult();
		$response = $this->render('ProjectBundle:'.$this->container->getParameter('view_acseine_campaign').':index.html.twig', array(
			'banners'=>$banners,
			'blogs'=>$blogs
		));

		$response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true); //(optional) set a custom Cache-Control directive
        return $response;
    }

	public function promotionAction(Request $request)
	{
		$em = $this->getDoctrine();
		$banners = $em->getRepository(BannerCampaign::class)->findAllActiveData()->getQuery()->getResult();
		$blogs  = $em->getRepository(Blog::class)->findAllActiveData()->setMaxResults(3)->getQuery()->getResult();
		$response = $this->render('ProjectBundle:'.$this->container->getParameter('view_acseine_campaign').':promotion.html.twig', array(
			'banners'=>$banners,
			'blogs'=>$blogs
		));

		$response->setSharedMaxAge(self::CACHE_EXPIRES);
		$response->headers->addCacheControlDirective('must-revalidate', true); //(optional) set a custom Cache-Control directive
		return $response;
	}

	public function moistbalanceAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_acseine_campaign').':moistbalance.html.twig', array());

		$response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true); //(optional) set a custom Cache-Control directive
        return $response;
    }

	public function sunshieldAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_acseine_campaign').':sunshield.html.twig', array());

		$response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true); //(optional) set a custom Cache-Control directive
        return $response;
    }

	public function brightfitAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_acseine_campaign').':brightfit.html.twig', array());

		$response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true); //(optional) set a custom Cache-Control directive
        return $response;
    }

	public function ad_controlAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_acseine_campaign').':ad_control.html.twig', array());

		$response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true); //(optional) set a custom Cache-Control directive
        return $response;
    }

	public function registerAction(Request $request)
    {
		$date_now = date('Y-m-d');
		$date_start = '2019-03-22';
		$date_end = '2019-04-30';
		if($date_now >= $date_start and $date_now <= $date_end){
			return $this->render('ProjectBundle:'.$this->container->getParameter('view_acseine_campaign').':register.html.twig', array());
		}else if($date_now > $date_end){
			return $this->render('ProjectBundle:'.$this->container->getParameter('view_acseine_campaign').':close.html.twig', array());
		}else {
			return $this->redirectToRoute('acseine_campaign_index');
		}
    }

	public function thanksAction(Request $request)
    {
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_acseine_campaign').':thanks.html.twig', array());
    }

	public function terms_of_useAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_acseine_campaign').':terms_of_use.html.twig', array());

		$response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true); //(optional) set a custom Cache-Control directive
        return $response;
    }

	public function counselingAction(Request $request)
    {
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_acseine_campaign').':counseling.html.twig', array());
    }

	public function blogAction(Request $request)
    {
        $util = $this->container->get('utilities');
        $session = $request->getSession();
        $repository = $this->getDoctrine()->getRepository(Blog::class);
        $query = $repository->findAllActiveData();
        $paginated = $util->setPaginatedOnPagerfanta($query,12);
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_acseine_campaign').':blog.html.twig', array(
            'paginated' =>$paginated
        ));

		$response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true); //(optional) set a custom Cache-Control directive
        return $response;
    }

    public function blog_detailAction(Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine();
        $data = $em->getRepository(Blog::class)->getActiveDataById($request->get('id'))->getQuery()->getSingleResult();
        if (!$data) { throw $this->createNotFoundException('No data found'); }
        $data_image = $em->getRepository(BlogImage::class)->findBy(array('blog' => $request->get('id')), array('id' => 'ASC'));
        $recent_blogs  = $em->getRepository(Blog::class)->getActiveDataByRecent($request->get('id'))->setMaxResults(6)->getQuery()->getResult();
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_acseine_campaign').':blog_detail.html.twig', array(
            'data'=>$data,'data_image'=>$data_image,'recent_blogs'=>$recent_blogs
        ));

		$response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true); //(optional) set a custom Cache-Control directive
        return $response;
    }

}
