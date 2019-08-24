<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CounselingRegister
 *
 * @ORM\Table(name="counseling_register")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\CounselingRegisterRepository")
 * @ORM\HasLifecycleCallbacks
 */
class CounselingRegister
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
    * @ORM\Column(type="string", length=255)
    */
	private $name;

    /**
    * @ORM\Column(name="phone", type="string", length=255, nullable=true)
    */
	private $phone;

    /**
    * @ORM\Column(type="string", length=255)
    */
	private $email;

    /**
    * @ORM\Column(type="text", length=65535, nullable=true)
    */
	private $message;

    /**
    * @ORM\Column(type="text", length=65535, nullable=true)
    */
	private $q1;

    /**
    * @ORM\Column(type="array", nullable=true)
    */
	private $q2;

    /**
    * @ORM\Column(type="array", nullable=true)
    */
	private $q3;

    /**
    * @ORM\Column(type="array", nullable=true)
    */
	private $q4;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status = 4;

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
     * Get the value of Id
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
     * Get the value of Name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param mixed name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Phone
     *
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of Phone
     *
     * @param mixed phone
     *
     * @return self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of Email
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of Email
     *
     * @param mixed email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of Message
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of Message
     *
     * @param mixed message
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of Status
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of Status
     *
     * @param mixed status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

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

    /**
     * Get the value of q1
     *
     * @return mixed
     */
    public function getQ1()
    {
        return $this->q1;
    }

    /**
     * Set the value of q1
     *
     * @param mixed q1
     *
     * @return self
     */
    public function setQ1($q1)
    {
        $this->q1 = $q1;

        return $this;
    }

    /**
     * Get the value of q2
     *
     * @return mixed
     */
    public function getQ2()
    {
        return $this->q2;
    }

    /**
     * Set the value of q2
     *
     * @param mixed q2
     *
     * @return self
     */
    public function setQ2($q2)
    {
        $this->q2 = $q2;

        return $this;
    }

    /**
     * Get the value of q3
     *
     * @return mixed
     */
    public function getQ3()
    {
        return $this->q3;
    }

    /**
     * Set the value of q3
     *
     * @param mixed q3
     *
     * @return self
     */
    public function setQ3($q3)
    {
        $this->q3 = $q3;

        return $this;
    }

    /**
     * Get the value of q4
     *
     * @return mixed
     */
    public function getQ4()
    {
        return $this->q4;
    }

    /**
     * Set the value of q4
     *
     * @param mixed q4
     *
     * @return self
     */
    public function setQ4($q4)
    {
        $this->q4 = $q4;

        return $this;
    }

}
