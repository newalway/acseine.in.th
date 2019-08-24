<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\ORM\EntityManagerInterface;
use ProjectBundle\Entity\User;
use ProjectBundle\Entity\Blog;
use ProjectBundle\Entity\BlogImage;
use ProjectBundle\Entity\BrandType;
use ProjectBundle\Entity\Brand;
use ProjectBundle\Entity\Product;
use ProjectBundle\Entity\Promotion;
use ProjectBundle\Entity\Banner;
use ProjectBundle\Entity\Contact;
use ProjectBundle\Entity\SettingOption;
use ProjectBundle\Entity\Authentication;
use ProjectBundle\Entity\Pages;
use ProjectBundle\Entity\Showroom;
use ProjectBundle\Entity\OurClient;
use ProjectBundle\Entity\CustomerPaymentBankTransfer;
use ProjectBundle\Entity\CustomerOrder;
use ProjectBundle\Entity\CustomerOrderDelivery;
use ProjectBundle\Entity\BankAccount;
use ProjectBundle\Entity\CustomerOrderItem;
use ProjectBundle\Entity\History;
use ProjectBundle\Entity\Location;
use ProjectBundle\Entity\ProductCategory;
use ProjectBundle\Entity\TrackingNumber;

use ProjectBundle\Form\Type\CustomerRegisterType;
use ProjectBundle\Form\Type\CustomerPaymentBankTransferType;
use ProjectBundle\Form\Type\ContactType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;


use ProjectBundle\Form\Type\PaymentBankTransferType;

use JMS\SecurityExtraBundle\Annotation\Secure;
use GuzzleHttp\Client;

class MainController extends Controller
{
    const CACHE_EXPIRES = 300;

    public function getPublicUserAction(Request $request)
	{
		$data = array();
		$loggedin = false;
		$user = $this->getUser(); //not all user_data
		if($user){
			$user_roles = $user->getRoles();
			$data['first_name'] = $user->getFirstName();
			$data['last_name'] = $user->getLastName();
			$data['email'] = $user->getEmail();
            $data['roles'] = $user_roles;
			$loggedin = true;
		}

		return new JsonResponse([
			'status' => true,
			'loggedin' => $loggedin,
			'user' => $data,
			'time' => date('Y/m/d H:i:s')
		]);
	}

    public function _footerAction(Request $request)
    {
        $em = $this->getDoctrine();
        $news_recents  = $em->getRepository(Blog::class)->findAllActiveData()->setMaxResults(3)->getQuery()->getResult();
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':_footer.html.twig', array(
            'news_recents'=>$news_recents
        ));
    }

    public function indexAction(Request $request)
    {
        $banners = $this->getDoctrine()->getRepository(Banner::class)->findAllActiveData($request->getLocale())->getQuery()->getResult();
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':index.html.twig', array(
            'banners'=>$banners,
        ));

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true); //(optional) set a custom Cache-Control directive
        return $response;
    }

    public function aboutAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':about.html.twig', array());
        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function historyAction(Request $request)
    {
        $histories = $this->getDoctrine()->getRepository(History::class)->findAllData()->getQuery()->getResult();
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':history.html.twig', array(
            'histories'=>$histories,
        ));
        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function company_profileAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':company_profile.html.twig', array());
        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function terms_of_useAction(Request $request)
    {
        $data = $this->getDoctrine()->getRepository(Pages::class)->getActiveDataByName('terms_conditions',$request->getLocale());
        if (!$data) { throw $this->createNotFoundException('No data found'); }
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':terms_of_use.html.twig', array(
            'data'=>$data
        ));

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function counselingAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':counseling.html.twig', array());

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function in_shop_counselingAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':in_shop_counseling.html.twig', array());

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function shopAction(Request $request)
    {
        $locations = $this->getDoctrine()->getRepository(Location::class)->findDataJoinedShop()->getQuery()->getResult();
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':shop.html.twig', array(
            'locations'=>$locations
        ));

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function skin_problems_and_cosmeticsAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':skin_problems_and_cosmetics.html.twig', array());

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function skin_allergyAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':skin_allergy.html.twig', array());

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function skin_allergy_qaAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':skin_allergy_qa.html.twig', array());

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function skin_allergy_testAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':skin_allergy_test.html.twig', array());

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function skin_atopic_dermatitisAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':skin_atopic_dermatitis.html.twig', array());

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function skin_atopic_dermatitis_qaAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':skin_atopic_dermatitis_qa.html.twig', array());

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function skin_atopic_dermatitis_washAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':skin_atopic_dermatitis_wash.html.twig', array());

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function adult_acneAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':adult_acne.html.twig', array());

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function adult_acne_adviceAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':adult_acne_advice.html.twig', array());

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function uv_rays_and_drynessAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':uv_rays_and_dryness.html.twig', array());

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function testAction(Request $request)
    {
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':test.html.twig', array());

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function sitemapAction(Request $request)
    {
        $product_categories = $this->getDoctrine()->getRepository(ProductCategory::class)->findPublicDataJoinedProduct()->getQuery()->getResult();
        $locations = $this->getDoctrine()->getRepository(Location::class)->findDataJoinedShop()->getQuery()->getResult();

        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':sitemap.html.twig', array(
            'product_categories' => $product_categories,'locations'=>$locations
        ));

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function how_to_buyAction(Request $request)
    {
        $data = $this->getDoctrine()->getRepository(Pages::class)->getActiveDataByName('how_to_buy',$request->getLocale());
        if (!$data) { throw $this->createNotFoundException('No data found'); }
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':how_to_buy.html.twig', array(
            'data'=>$data
        ));

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    public function shipping_deliveryAction(Request $request)
    {
        $data = $this->getDoctrine()->getRepository(Pages::class)->getActiveDataByName('shipping_delivery',$request->getLocale());
        if (!$data) { throw $this->createNotFoundException('No data found'); }
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':shipping_delivery.html.twig', array(
            'data'=>$data
        ));

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }


    public function privacy_policyAction(Request $request)
    {
        $data = $this->getDoctrine()->getRepository(Pages::class)->getActiveDataByName('privacy_policy',$request->getLocale());
        if (!$data) { throw $this->createNotFoundException('No data found'); }
        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':privacy_policy.html.twig', array(
            'data'=>$data
        ));

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        return $response;
    }

    // public function serviceAction(Request $request)
    // {
    //     $data = $this->getDoctrine()->getRepository(Pages::class)->getActiveDataByName('service',$request->getLocale());
    //     if (!$data) { throw $this->createNotFoundException('No data found'); }
    //     return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':service.html.twig', array(
    //         'data'=>$data
    //     ));
    // }

    // public function contactAction(Request $request)
    // {
    //     $form = $this->createForm(ContactType::class, new Contact());
    //     $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':contact.html.twig', array(
    //         'form'=>$form->createView()
    //     ));
    //
    //     $response->setSharedMaxAge(self::CACHE_EXPIRES);
    //     $response->headers->addCacheControlDirective('must-revalidate', true);
    //     return $response;
    // }

    // public function contact_createAction(Request $request)
    // {
    //     $util = $this->container->get('utilities');
    //     $contact = new Contact();
    //     $form = $this->createForm(ContactType::class, $contact);
    //     $form->submit($request->request->all());
    //     $data = $form->getData();
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $em = $this->getDoctrine()->getManager();
    //         $em->persist($contact);
    //         $em->flush();
    //
    //         $subject = 'You have a new message(s) in your contact';
    //         $urls = $this->generateUrl('admin_contact_view',array('id'=>$data->getId()), UrlGeneratorInterface::ABSOLUTE_URL);
    //         $response = $this->sendmail($urls,$subject,$data);
    //         return new JsonResponse($response);
    //     }else{
    //         // $errors = $this->getFormErrorMessage($form);
    //         $errors = $util->getFormErrorMessage($form);
    //         $response['errors'] = $errors;
    //         $response['success'] = false;
    //         return new JsonResponse($response);
    //     }
    // }

    // public function blogAction(Request $request)
    // {
    //     $util = $this->container->get('utilities');
    //     $session = $request->getSession();
    //     $repository = $this->getDoctrine()->getRepository(Blog::class);
    //     $query = $repository->findAllActiveData();
    //     $paginated = $util->setPaginatedOnPagerfanta($query,12);
    //     return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':blog.html.twig', array(
    //         'paginated' =>$paginated
    //     ));
    // }

    // public function blog_detailAction(Request $request)
    // {
    //     $session = $request->getSession();
    //     $em = $this->getDoctrine();
    //     $data = $em->getRepository(Blog::class)->getActiveDataById($request->get('id'))->getQuery()->getSingleResult();
    //     if (!$data) { throw $this->createNotFoundException('No data found'); }
    //     $data_image = $em->getRepository(BlogImage::class)->findBy(array('blog' => $request->get('id')), array('id' => 'ASC'));
    //     $recent_blogs  = $em->getRepository(Blog::class)->getActiveDataByRecent($request->get('id'))->setMaxResults(5)->getQuery()->getResult();
    //     return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':blog_detail.html.twig', array(
    //         'data'=>$data,'data_image'=>$data_image,'recent_blogs'=>$recent_blogs
    //     ));
    // }

    // public function showroomAction(Request $request)
    // {
    //     $util = $this->container->get('utilities');
    //     $session = $request->getSession();
    //     $em = $this->getDoctrine();
    //     $query = $em->getRepository(Showroom::class)->findAllActiveData($request->getLocale());
    //     $paginated = $util->setPaginatedOnPagerfanta($query,12);
    //     $google_maps_api_key = $em->getRepository(Authentication::class)->findOneBy(['name'=>'google_maps_api_key']);
    //     return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':showroom.html.twig', array(
    //         'paginated' =>$paginated,
    //         'google_maps_api_key'=>$google_maps_api_key
    //     ));
    // }

    // public function searchAction(Request $request)
    // {
    //     $session = $request->getSession();
    //     return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':search.html.twig', array());
    // }

    // public function search_apiAction(Request $request)
    // {
    //     $session = $request->getSession();
    //
    //     $arr_data = array();
    //     $arr_result = array();
    //     $arr_query_data = array();
    //     $all_result = 0;
    //
    //     if($request->get('q')){
    //         $arr_query_data['q'] = $request->get('q');
    //         $em = $this->getDoctrine();
    //
    //         $product = $em->getRepository(Product::class)->findAllActiveData($arr_query_data)->getQuery()->getResult(2);
    //         $arr_data['product'] = $product;
    //         $arr_result['product'] = count($product);
    //
    //         $blog = $em->getRepository(Blog::class)->findAllActiveData($arr_query_data)->getQuery()->getResult(2);
    //         $arr_data['blog'] = $blog;
    //         $arr_result['blog'] = count($blog);
    //
    //         foreach ($arr_result as $key => $value) {
    //             $all_result = $all_result + $value;
    //         }
    //     }
    //
    //     $response = new JsonResponse();
    //     $response->setData(array(
    //         'data'  => $arr_data,
    //         'result' => $arr_result,
    //         'all_result' => $all_result,
    //         'time' => date('Y/m/d H:i:s'),
    //     ));
    //     $response->setSharedMaxAge(self::CACHE_EXPIRES);
    //     return $response;
    // }

    /**
    * @Secure(roles="ROLE_CLIENT, ROLE_CUSTOMER, ROLE_USER, ROLE_EDITOR, ROLE_ADMIN")
    */
    public function default_target_loginAction(Request $request)
    {
        $user = $this->getUser();
        $session = $request->getSession();
        $auth_checker = $this->get('security.authorization_checker');
        $util = $this->container->get('utilities');

        $util->destroySessionAfterLogin($request);

        if( $auth_checker->isGranted('ROLE_EDITOR') || $auth_checker->isGranted('ROLE_ADMIN') ){
            return $this->redirect($this->generateUrl('admin'));

        }elseif( $auth_checker->isGranted('ROLE_CLIENT') || $auth_checker->isGranted('ROLE_CUSTOMER') ){
            //check valid token for only customer is_set_password
            $is_set_pwd = $user->getIsSetPassword();
            if($is_set_pwd){
                try {
                    $acctoken = $util->getAccessToken();
                    //check token expire here
                } catch(\Exception $e) {
                	//no access token or expire redirect to generate_token
                    return $this->redirectToRoute('member_generate_token');
                }
            }

            if($auth_checker->isGranted('ROLE_CLIENT')){
                return $this->redirect($this->generateUrl('designer'));
            }else{
                return $this->redirect($this->generateUrl('fos_user_profile_show'));
            }

        }else{
            return $this->redirect($this->generateUrl('homepage'));
        }
    }

    public function default_target_logoutAction(Request $request)
    {
        $util = $this->container->get('utilities');

        $util->destroySessionAfterLogout($request);
        return $this->redirect($this->generateUrl('homepage'));
    }

    /**
    * @Secure(roles="ROLE_ADMIN, ROLE_EDITOR, ROLE_CUSTOMER, ROLE_CLIENT")
    */
    public function default_target_password_resettingAction(Request $request)
    {
        $util = $this->container->get('utilities');
        $session = $request->getSession();
        $user = $this->getUser();

        if($session->has('tmp_password_resetting')){
            //get password
            $new_pwd = $session->get('tmp_password_resetting');
            //get email
            $email = $user->getEmail();

            //get user scope
            $user_roles = $user->getRoles();
            if( in_array("ROLE_CLIENT",$user_roles) ){
                $scope = $this->container->getparameter('access_token_client_scope');
            }else{
                $scope = $this->container->getparameter('access_token_customer_scope');
            }

            //set oauth token
            $util->setAccessToken($email, $new_pwd, $scope);
            //reset session access token
            $token = $util->getAccessTokenFromDB();

            //remove session tmp_password_resetting
            $session->remove('tmp_password_resetting');
        }
        //return $this->redirect($this->generateUrl('fos_user_profile_show'));
        return $this->redirect($this->generateUrl('default_target_login'));
    }

    public function customer_registerAction(Request $request)
    {
        /*
        $session = $request->getSession();
        $user = $this->getUser();
        if($user){
          throw $this->createNotFoundException('You are not permitted to use that link to directly access that page');
        }

        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $form = $this->createForm(CustomerRegisterType::class, $user);
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':customer_register.html.twig', array('form' =>$form->createView()));
        */
    }

    public function customer_register_createAction(Request $request)
    {
        /*
        $util = $this->container->get('utilities');
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $user = $this->getUser();
        if($user){
          throw $this->createNotFoundException('You are not permitted to use that link to directly access that page');
        }

        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $form = $this->createForm(CustomerRegisterType::class, $user);
        $form->handleRequest($request);
        $datas = $form->getData();
        $email = $datas->getEmail();

        $chk_email = $em->getRepository(User::class)->findByEmailCanonical($email);
        if(count($chk_email)>0){
          $form->get('email')->addError(new FormError('The email is already used'));//already exists email
        }

        if ($form->isSubmitted() && $form->isValid())
        {
          $plainpass = $datas->getPlainPassword();
          $roles = array('ROLE_CUSTOMER');

          // we set username in user entity
          // $user->setUsername($email);
          // $user->setUsernameCanonical($email);

          $user->setRoles($roles);

          $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
          if($confirmationEnabled){
            // register with email comfirmation
            $mailer = $this->container->get('fos_user.mailer');
            $tokenGenerator = $this->container->get('fos_user.util.token_generator');
            //save confirmation token
            $user->setConfirmationToken($tokenGenerator->generateToken());
            //send confirmation email
            $mailer->sendConfirmationEmailMessage($user);
            //save user data
            $userManager->updateUser($user);
            //set oauth token
            $scope = $this->container->getparameter('access_token_customer_scope');
            $util->setAccessToken($email, $plainpass, $scope);
            $this->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
            $route = 'fos_user_registration_check_email';
            $this->get('session')->getFlashBag()->add('fos_user_success', 'registration.flash.user_created');
            return $this->redirect($this->generateUrl('fos_user_registration_check_email'));

          }else{
            // register with non comfirmation
            //enable customer status
            $user->setEnabled(1);
            //save user data
            $userManager->updateUser($user, true);
            //set oauth token
            $scope = $this->container->getparameter('access_token_customer_scope');
            $util->setAccessToken($email, $plainpass, $scope);
            return $this->redirect($this->generateUrl('customer_register_complete'));
          }
        }
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':customer_register.html.twig', array('form'=>$form->createview()));
        */
    }

    public function customer_register_completeAction(Request $request)
    {
        /*
        // $locale = $request->getLocale();
        // $translated = $this->get('translator')->trans('customer.registration');

        $session = $request->getSession();
        $flashBag = $this->get('session')->getFlashBag();
        foreach ($session->getFlashBag()->get('login_at_checkout', array()) as $val){
          if($val){
            //change flash login_at_checkout to register_at_checkout
            $flashBag->add('register_at_checkout', true);
          }
        }
        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':customer_register_complete.html.twig', array());
        */
    }

    /*
    protected function getFormErrorMessage($form)
    {
        $errors = array();
        if($form){
            foreach ($form as $fieldName => $formField) {
                foreach ($formField->getErrors(true) as $error) {
                    $errors[$fieldName] = $error->getMessage();
                }
            }
        }
        return $errors;
    }
    */

    protected function sendmail($urls,$subject,$data)
    {
        $em = $this->getDoctrine()->getManager()->getRepository(SettingOption::class);
        //Recipients
        $setting_option_email = $em->findOneByOptionName('contact_mail_address');
        $arr_contact_mail_address = explode(",", $setting_option_email->getOptionValue());
        //Sender name
        $setting_option_name = $em->findOneByOptionName('contact_mail_name');
        $contact_mail_name = $setting_option_name->getOptionValue();
        //Default email
        $sender_mail_address = $this->container->getParameter('default_sender_mail_address') ;

        $message = (new \Swift_Message($subject))
        ->setFrom(array($sender_mail_address => $contact_mail_name))
        ->setTo($arr_contact_mail_address)
        ->setBody(
            $this->renderView(
                'ProjectBundle:'.$this->container->getParameter('view_main').':_email.html.twig',
                array('urls'=> $urls,'subject'=>$subject,'data'=>$data)
            ),
            'text/html'
        );

        try{
            $this->get('mailer')->send($message);
            $response['success'] = true;
            $response['message'] = $this->get('translator')->trans('contact.send.thank');
        }catch(\Exception $e){
            #Do nothing
            $response['success'] = false;
            $response['message'] = $this->get('translator')->trans('contact.cannot.send');
        }

        return $response;
    }

    // public function promotionAction(Request $request)
    // {
    //     $util = $this->container->get('utilities');
    //     $session = $request->getSession();
    //     $repository = $this->getDoctrine()->getRepository(Promotion::class);
    //     $query = $repository->findAllActiveData();
    //     $paginated = $util->setPaginatedOnPagerfanta($query,10);
    //
    //     return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':promotion.html.twig', array(
    //         'paginated' =>$paginated
    //     ));
    // }

    // public function promotion_detailAction(Promotion $promotions,Request $request)
    // {
    //     $session = $request->getSession();
    //     $em = $this->getDoctrine();
    //
    //     $data_promotion = $em->getRepository(Promotion::class)->getActiveDataById($promotions)->getQuery()->getSingleResult();
    //
    //     $product_has_promotion = $this->getDoctrine()->getRepository(Product::class)->getActiveDataProductsByPromotionId($promotions)->getQuery();
    //     $util = $this->container->get('utilities');
    //     $limitPages = $this->container->getParameter('max_per_page_latest_product');
    //     $paginated = $util->setPaginatedOnPagerfanta($product_has_promotion,$limitPages);
    //
    //     return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':promotion_detail.html.twig', array(
    //         'paginated'=>$paginated,
    //         'promotions'=>$data_promotion
    //     ));
    // }

    // public function portfolioAction(Request $request)
    // {
    //     $data = $this->getDoctrine()->getRepository(Pages::class)->getActiveDataByName('portfolio',$request->getLocale());
    //     if (!$data) { throw $this->createNotFoundException('No data found'); }
    //     return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':portfolio.html.twig', array(
    //         'data'=>$data
    //     ));
    // }

    public function trackAction(Request $request)
    {
        $em = $this->getDoctrine();
        $customerOrder = $em->getRepository(CustomerOrder::Class)->findCustomerOrderHasItemByOrderNumber($request->get('no'))->getQuery()->getResult();

        $bankAccount = $em->getRepository(BankAccount::Class)->findAllActiveData()->getQuery()->getResult();
        $payment_bank_transfer = $em->getRepository(CustomerPaymentBankTransfer::class)->findCustomerPaymentBankTransferByOrder($customerOrder)->getQuery()->getResult();
        $arr_tracking_numbers = $em->getRepository(TrackingNumber::class)->findSelectDataByOrder($customerOrder)->getQuery()->getArrayResult();

        $response = $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':track.html.twig', array(
            'customerOrder'=>$customerOrder,
            'bankAccount'=>$bankAccount,
            'payment_bank_transfer'=>$payment_bank_transfer,
            'arr_tracking_numbers'=>$arr_tracking_numbers
        ));

        $response->setSharedMaxAge(self::CACHE_EXPIRES);
        $response->headers->addCacheControlDirective('must-revalidate', true); //(optional) set a custom Cache-Control directive
        return $response;
    }

    public function confirm_paymentAction(Request $request)
    {
        $util = $this->container->get('utilities');
        $payment_bank_transfer = new CustomerPaymentBankTransfer();
        $form = $this->createForm(CustomerPaymentBankTransferType::class,$payment_bank_transfer);

        $now_date = new \DateTime();
        $form->get('timeTransfer')->setData($now_date);

        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        $data = $form->getData();

        // $bankAccount =  new BankAccount();
        // $bankAccountObj = $em->getRepository(BankAccount::Class)->findOneById(8);
        // dump($bankAccountObj[0]->getId());

        if ($form->isSubmitted() && $form->isValid()) {
            // dump($data);
            $customerOrderObj = $em->getRepository(CustomerOrder::Class)->findCustomerOrderHasItemByOrderNumber($data->getOrderNumber())->getQuery()->getResult();

            if($form['attach_file']->getData()){
                $file = $form['attach_file']->getData();
                // dump($imageEn->getImage());
                // $file =	$file->getClientOriginalName();
                $extension = $file->guessExtension();
                $date = date("Y-m-d");
                $fileName = $date.rand(1, 99999).'.'.$extension;
                $file->move($this->container->getParameter('files_upload_bank_transfer'),$fileName);

                $payment_bank_transfer->setAttachFile($fileName);
                // $payment_bank_transfer->setBankAccount($bankAccountObj);
                $payment_bank_transfer->setCustomerOrder($customerOrderObj[0]);
                //dump($data);
                $em->persist($payment_bank_transfer);
                $em->flush();

                $util->sendMailPaymentBankTransfer($payment_bank_transfer);

                $message_success = $this->get('translator')->trans('payment.submit_succsess');
                $this->get('session')->getFlashBag()->add('notice', $message_success);
                return $this->redirect($this->generateUrl('confirm_payment'));

            }else{
                $this->get('session')->getFlashBag()->add('warning', 'Error file not found');
            }
        }

        return $this->render('ProjectBundle:'.$this->container->getParameter('view_main').':confirm_payment.html.twig', array(
            'form' =>$form->createView(),
        ));
    }

    public function search_paymentDataAction(Request $request){
        $payment_bank_transfer = new CustomerPaymentBankTransfer();
        //$form = $this->createForm(CustomerPaymentBankTransferType::class,$payment_bank_transfer);
        //$em = $this->getDoctrine()->getManager();
        // $form->handleRequest($request);

        if (isset($_REQUEST['orderId'])){
            $ordid = $request->get('orderId');
            $em = $this->getDoctrine()->getManager();
            $customerOrderObj = $em->getRepository(CustomerOrder::Class)->checkCustomerHasOrderById($ordid)->getQuery()->getOneOrNullResult();
            if (isset($customerOrderObj)){
            $customerOrderAddressObj = $em->getRepository(CustomerOrderDelivery::Class)->findCustomerOrderDeliveryByOrder($customerOrderObj,1)->getQuery()->getOneOrNullResult();
            $data  = array('firstname'=>$customerOrderAddressObj->getFirstName(),
                            'lastname'=>$customerOrderAddressObj->getLastName(),
                            'phone'=>$customerOrderAddressObj->getPhone(),
                            'orderNumber' =>$customerOrderObj->getOrderNumber(),
                            'totalPrice' =>$customerOrderObj->getTotalPrice()
            );

            $json_response = new JsonResponse();
    		// $json_response->setEncodingOptions(JSON_NUMERIC_CHECK);
            $json_response->setData($data);
            return $json_response;
            }else{
                return new JsonResponse(false);
            }
        }
    }

}
