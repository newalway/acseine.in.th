<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerPaymentLinepay
 *
 * @ORM\Table(name="customer_payment_linepay")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\CustomerPaymentLinepayRepository")
 * @ORM\HasLifecycleCallbacks
 */
class CustomerPaymentLinepay
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="CustomerOrder", inversedBy="customerPaymentLinepay")
     * @ORM\JoinColumn(name="customer_order_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $customerOrder;

    /**
	 * @ORM\Column(name="amount", type="decimal", scale=2)
	 */
	private $amount;

    /**
     * @ORM\Column(name="currency", type="string", length=45)
     */
    private $currency;

    /**
     * @ORM\Column(name="order_id", type="string", length=255)
     */
    private $orderId;

    /**
     * @ORM\Column(name="transaction_id", type="string", length=255, nullable = true)
     */
    private $transactionId;

    /**
     * @ORM\Column(name="payment_access_token", type="string", length=255, nullable = true)
     */
    private $paymentAccessToken;

    /**
     * @ORM\Column(name="reserve_info_payment_url_web", type="string", length=255, nullable = true)
     */
    private $reserveInfoPaymentUrlWeb;

    /**
     * @ORM\Column(name="reserve_info_payment_url_app", type="string", length=255, nullable = true)
     */
    private $reserveInfoPaymentUrlApp;

    /**
     * @ORM\Column(name="reserve_return_code", type="string", length=255, nullable = true)
     */
    private $reserveReturnCode;

    /**
     * @ORM\Column(name="reserve_return_message", type="string", length=255, nullable = true)
     */
    private $reserveReturnMessage;

    /**
     * @ORM\Column(name="confirm_return_code", type="string", length=255, nullable = true)
     */
    private $confirmReturnCode;

    /**
     * @ORM\Column(name="confirm_return_message", type="string", length=255, nullable = true)
     */
    private $confirmReturnMessage;

    /**
     * @ORM\Column(name="confirm_info_method", type="string", length=255, nullable = true)
     */
    private $confirmInfoMethod;

    /** @ORM\Column(name="updated_at", type="datetime", nullable = true) */
	private $updatedAt;

	/** @ORM\Column(name="created_at", type="datetime") */
	private $createdAt;

    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime('now'));
        if ($this->getCreatedAt() == null) {
          $this->setCreatedAt(new \DateTime('now'));
        }
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param int id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Customer Order
     *
     * @return mixed
     */
    public function getCustomerOrder()
    {
        return $this->customerOrder;
    }

    /**
     * Set the value of Customer Order
     *
     * @param mixed customerOrder
     *
     * @return self
     */
    public function setCustomerOrder($customerOrder)
    {
        $this->customerOrder = $customerOrder;

        return $this;
    }

    /**
     * Get the value of Amount
     *
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of Amount
     *
     * @param mixed amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get the value of Currency
     *
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of Currency
     *
     * @param mixed currency
     *
     * @return self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the value of Order Id
     *
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set the value of Order Id
     *
     * @param mixed orderId
     *
     * @return self
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get the value of Transaction Id
     *
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Set the value of Transaction Id
     *
     * @param mixed transactionId
     *
     * @return self
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * Get the value of Payment Access Token
     *
     * @return mixed
     */
    public function getPaymentAccessToken()
    {
        return $this->paymentAccessToken;
    }

    /**
     * Set the value of Payment Access Token
     *
     * @param mixed paymentAccessToken
     *
     * @return self
     */
    public function setPaymentAccessToken($paymentAccessToken)
    {
        $this->paymentAccessToken = $paymentAccessToken;

        return $this;
    }

    /**
     * Get the value of Reserve Info Payment Url Web
     *
     * @return mixed
     */
    public function getReserveInfoPaymentUrlWeb()
    {
        return $this->reserveInfoPaymentUrlWeb;
    }

    /**
     * Set the value of Reserve Info Payment Url Web
     *
     * @param mixed reserveInfoPaymentUrlWeb
     *
     * @return self
     */
    public function setReserveInfoPaymentUrlWeb($reserveInfoPaymentUrlWeb)
    {
        $this->reserveInfoPaymentUrlWeb = $reserveInfoPaymentUrlWeb;

        return $this;
    }

    /**
     * Get the value of Reserve Info Payment Urlapp
     *
     * @return mixed
     */
    public function getReserveInfoPaymentUrlApp()
    {
        return $this->reserveInfoPaymentUrlApp;
    }

    /**
     * Set the value of Reserve Info Payment Urlapp
     *
     * @param mixed reserveInfoPaymentUrlApp
     *
     * @return self
     */
    public function setReserveInfoPaymentUrlApp($reserveInfoPaymentUrlApp)
    {
        $this->reserveInfoPaymentUrlApp = $reserveInfoPaymentUrlApp;

        return $this;
    }

    /**
     * Get the value of Reserve Return Code
     *
     * @return mixed
     */
    public function getReserveReturnCode()
    {
        return $this->reserveReturnCode;
    }

    /**
     * Set the value of Reserve Return Code
     *
     * @param mixed reserveReturnCode
     *
     * @return self
     */
    public function setReserveReturnCode($reserveReturnCode)
    {
        $this->reserveReturnCode = $reserveReturnCode;

        return $this;
    }

    /**
     * Get the value of Reserve Return Message
     *
     * @return mixed
     */
    public function getReserveReturnMessage()
    {
        return $this->reserveReturnMessage;
    }

    /**
     * Set the value of Reserve Return Message
     *
     * @param mixed reserveReturnMessage
     *
     * @return self
     */
    public function setReserveReturnMessage($reserveReturnMessage)
    {
        $this->reserveReturnMessage = $reserveReturnMessage;

        return $this;
    }

    /**
     * Get the value of Confirm Return Code
     *
     * @return mixed
     */
    public function getConfirmReturnCode()
    {
        return $this->confirmReturnCode;
    }

    /**
     * Set the value of Confirm Return Code
     *
     * @param mixed confirmReturnCode
     *
     * @return self
     */
    public function setConfirmReturnCode($confirmReturnCode)
    {
        $this->confirmReturnCode = $confirmReturnCode;

        return $this;
    }

    /**
     * Get the value of Confirm Return Message
     *
     * @return mixed
     */
    public function getConfirmReturnMessage()
    {
        return $this->confirmReturnMessage;
    }

    /**
     * Set the value of Confirm Return Message
     *
     * @param mixed confirmReturnMessage
     *
     * @return self
     */
    public function setConfirmReturnMessage($confirmReturnMessage)
    {
        $this->confirmReturnMessage = $confirmReturnMessage;

        return $this;
    }

    /**
     * Get the value of Confirm Info Method
     *
     * @return mixed
     */
    public function getConfirmInfoMethod()
    {
        return $this->confirmInfoMethod;
    }

    /**
     * Set the value of Confirm Info Method
     *
     * @param mixed confirmInfoMethod
     *
     * @return self
     */
    public function setConfirmInfoMethod($confirmInfoMethod)
    {
        $this->confirmInfoMethod = $confirmInfoMethod;

        return $this;
    }

    /**
     * Get the value of Updated At
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of Updated At
     *
     * @param mixed updatedAt
     *
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of Created At
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of Created At
     *
     * @param mixed createdAt
     *
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

}
