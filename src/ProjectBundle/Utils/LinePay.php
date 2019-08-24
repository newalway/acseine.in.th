<?php

namespace ProjectBundle\Utils;

use ProjectBundle\Entity\Authentication;
use ProjectBundle\Entity\AccessToken;
use ProjectBundle\Entity\RefreshToken;
use ProjectBundle\Entity\SettingOption;
use ProjectBundle\Entity\CustomerPaymentEpayment;
use ProjectBundle\Entity\CustomerOrder;
use ProjectBundle\Entity\BankAccount;
use ProjectBundle\Entity\CustomerPaymentOmise;
use ProjectBundle\Entity\CustomerPaymentLinepay;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;

use Exception;
use GuzzleHttp\Client;
use phpbrowscap\Browscap;
use GeoIp2\Database\Reader;

class LinePay
{
	private $kernel;
	private $factory;
	private $mailer;
	private $router;

	private $util;
	private $live_mode;
	private $payment_data;
	private $reserve_response;
	private $confirm_response;
	private $line_api_version;
	private $currency;
	private $product_name;

	public function __construct($kernel, $factory, \Swift_Mailer $mailer, Router $router)
	{
		$this->container = $kernel->getContainer();
		$this->factory = $factory;
		$this->mailer = $mailer;
		$this->router = $router;

		$this->util = $this->container->get('utilities');
		$this->live_mode = $this->getLiveMode();
		$this->payment_data = array();
		$this->reserve_response = array();
		$this->confirm_response = array();
		$this->line_api_version = 'v2';
		$this->currency = 'THB';
		$this->product_name = 'ACSEINE THAILAND';
	}

	public function getLinepayChanelID()
	{
		$public_key = $this->util->getAuthenticationValue('linepay_channel_id');
		return $public_key;
	}
	public function getLinepayChanelSecretKey()
	{
		$secret_key = $this->util->getAuthenticationValue('linepay_channel_secret_key');
		return $secret_key;
	}
	// public function getLinepayChanelIDAuth()
	// {
	// 	$public_key = $this->getLinepayChanelID();
	// 	#Authentication to Omise API is done via HTTP Basic Auth with your key as user name. Password is not required.
	// 	return 'Basic '.base64_encode($public_key.":".'');
	// }
	// public function getLinepayChanelSecretKeyAuth()
    // {
	// 	$secret_key = $this->getLinepayChanelSecretKey();
    //     return 'Basic '.base64_encode($secret_key.':');
    // }

	public function getLiveMode()
	{
		return filter_var($this->util->getAuthenticationValue('linepay_livemode'), FILTER_VALIDATE_BOOLEAN);
	}

	public function getLinepayUri()
	{
		if($this->live_mode){
			$linepay_uri = $this->container->getParameter('linepay_uri');
		}else{
			$linepay_uri = $this->container->getParameter('linepay_sandbox_uri');
		}
		return $linepay_uri;
	}

	public function getLinepayReserveUri()
	{
		$linepay_uri = $this->getLinepayUri();
		return $linepay_uri.$this->line_api_version.'/payments/request';
	}
	public function getLinepayConfirmUri($transaction_id)
	{
		$sub_uri='';
		if($transaction_id){
			$sub_uri='/'.$transaction_id;
		}
		$linepay_uri = $this->getLinepayUri();
		return $linepay_uri.$this->line_api_version.'/payments'.$sub_uri.'/confirm';
	}
	public function getLinepayPaymentUri($transaction_id, $order_id=null)
	{
		$linepay_uri = $this->getLinepayUri();
		$sub_rui = '?transactionId='.$transaction_id;
		if($order_id){
			$sub_rui .= '&orderId'.$order_id;
		}
		return $linepay_uri.$this->line_api_version.'/payments'.$sub_rui;
	}

	public function linepayReserve($arr_cart_data, $order_number)
	{
		$arr_cart_data_summary = $arr_cart_data['summary'];
		$confirm_url = $this->router->generate('checkout_linepay_confirm_payment', array(), UrlGeneratorInterface::ABSOLUTE_URL);
		$cancel_url = $this->router->generate('checkout', array(), UrlGeneratorInterface::ABSOLUTE_URL);
		$reserve_uri = $this->getLinepayReserveUri();
		$this->payment_data = array(
			'productName' => $this->product_name,
			'amount' => $arr_cart_data_summary['total'],
			'currency' => $this->currency,
			'orderId' => $order_number,
			'confirmUrl' => $confirm_url,
			'cancelUrl' => $cancel_url,
			'capture' => 'true',
			'langCd' => 'th',
			'confirmUrlType' => 'CLIENT',
			'productImageUrl' => 'https://www.acseine.in.th/acseine/original/images/about/acs.jpg',
		);

		$response = $this->callLinePay('POST', $reserve_uri, $this->payment_data);
		//retrieve reserve response
		$this->reserve_response = json_decode($response->getBody(), true);

		return $this->reserve_response;
	}

	public function linepayConfirm($arr_cart_data, $transactionId)
	{
		$arr_cart_data_summary = $arr_cart_data['summary'];
		$data = array(
			'amount' => $arr_cart_data_summary['total'],
			'currency' => $this->currency,
		);

		$confirm_uri = $this->getLinepayConfirmUri($transactionId);
		$response = $this->callLinePay('POST', $confirm_uri, $data);
		//retrieve confirm response
		$this->confirm_response = json_decode($response->getBody(), true);

		return $this->confirm_response;
	}

	public function callLinePay($method, $uri, $postData=null)
	{
		$linepay_channel_id = $this->getLinepayChanelID();
		$linepay_channel_secret_key = $this->getLinepayChanelSecretKey();

		$client = new Client();
		try{
			return $client->request(
		         $method,
		         $uri,
		         [
					'headers' => [
						'Content-Type' => 'application/json',
						'Accept' => 'application/json',
						'X-LINE-ChannelId' => $linepay_channel_id,
						'X-LINE-ChannelSecret' => $linepay_channel_secret_key,
						// 'Authorization' => $auth
					],
					'json' => $postData //,'debug' => true
		         ]
			);
		}catch (Exception $e){
			return $e->getResponse();
		}
	}

	public function linepayValidateReserve()
	{
		$return_code = (isset($this->reserve_response['returnCode'])) ? $this->reserve_response['returnCode'] : null;
		$transaction_id = (isset($this->reserve_response['info']['transactionId'])) ? $this->reserve_response['info']['transactionId'] : null;
		$payment_url_web = (isset($this->reserve_response['info']['paymentUrl']['web'])) ? $this->reserve_response['info']['paymentUrl']['web'] : null;

		if($return_code=='0000' && $transaction_id && $payment_url_web){
			//the charge succeeded
			return true;
		}else{
			//the charge failed
			return false;
		}
	}

	public function linepayValidateConfirm()
	{
		$return_code = (isset($this->confirm_response['returnCode'])) ? $this->confirm_response['returnCode'] : null;
		$transaction_id = (isset($this->confirm_response['info']['transactionId'])) ? $this->confirm_response['info']['transactionId'] : null;

		if($return_code=='0000' && $transaction_id){
			//the charge succeeded
			return true;
		}else{
			//the charge failed
			return false;
		}
	}

	public function setLinepayError($message)
	{
		$session = $this->container->get('request_stack')->getCurrentRequest()->getSession();
		$session->getFlashBag()->add('linepay_errors', $message);
	}

	public function saveCustomerPaymentLinepay($customer_order, $arr_cart_data_summary)
	{
		$em = $this->container->get('doctrine')->getEntityManager();

		$customer_payment_linepay = null;
		$reserve_response = $this->reserve_response;
		if(!empty($reserve_response)){
			$customer_payment_linepay = new CustomerPaymentLinepay();
			$customer_payment_linepay->setCustomerOrder($customer_order);
			$customer_payment_linepay->setAmount($arr_cart_data_summary['total']);
			$customer_payment_linepay->setCurrency($this->currency);

			$customer_payment_linepay->setOrderId($this->payment_data['orderId']);
			$customer_payment_linepay->setTransactionId($reserve_response['info']['transactionId']);
			$customer_payment_linepay->setPaymentAccessToken($reserve_response['info']['paymentAccessToken']);
			$customer_payment_linepay->setReserveInfoPaymentUrlWeb($reserve_response['info']['paymentUrl']['web']);
			$customer_payment_linepay->setReserveInfoPaymentUrlApp($reserve_response['info']['paymentUrl']['app']);
			$customer_payment_linepay->setReserveReturnCode($reserve_response['returnCode']);
			$customer_payment_linepay->setReserveReturnMessage($reserve_response['returnMessage']);

			// $customer_payment_linepay->setConfirmReturnCode();
			// $customer_payment_linepay->setConfirmReturnMessage();
			// $customer_payment_linepay->setConfirmInfoMethod();

			$em->persist($customer_payment_linepay);
			$em->flush();
		}

		return $customer_payment_linepay;
	}

	public function updateCustomerPaymentLinepay($customer_payment_linepay)
	{
		$confirm_response = $this->confirm_response;
		$em = $this->container->get('doctrine')->getEntityManager();
		if($customer_payment_linepay && !empty($confirm_response) ){
			$customer_payment_linepay->setConfirmReturnCode($confirm_response['returnCode']);
			$customer_payment_linepay->setConfirmReturnMessage($confirm_response['returnMessage']);
			if(isset($confirm_response['info']['payInfo'][0]['method'])){
				$customer_payment_linepay->setConfirmInfoMethod($confirm_response['info']['payInfo'][0]['method']);
			}
			$em->flush();
		}
	}

	public function linepayProcessChargeSucceeded($customer_order)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		if($customer_order){
			// successfully
			$customer_order->setPaid(1);
			$em->flush();
		}else{
			return false;
		}
	}

	public function linepayProcessChargeFailed($customer_order)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		if($customer_order){
			$customer_order->setPaid(0);
			$customer_order->setFailed(1);
			$em->flush();
		}
	}


}
