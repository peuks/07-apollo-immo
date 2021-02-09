<?php

namespace App\Entity;

use App\Entity\Property;
use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * @var sting|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2,max=100)
     */
    private $firstname;

    /**
     * @var sting|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2,max=100)
     */
    private $lastname;

    /**
     * @var sting|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2,max=100)
     */
    private $name;

    /**
     * @var sting|null
     * @Assert\NotBlank()
     * @Assert\Regex(
     * pattern="/^((\+)33|0|0033)[1-9](\d{2}){4}$/")
     */
    private $phone;

    /**
     * @var sting|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var sting|null
     * @Assert\NotBlank()
     * @Assert\Length(min=10,max=1024)
     */

    private $message;
    /**
     *
     * @var Property|null
     */

    private $property;
    /**
     * Get the value of firstname
     *
     * @return  sting|null
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  sting|null  $firstname
     *
     * @return  self
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     *
     * @return  sting|null
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  sting|null  $lastname
     *
     * @return  self
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get pattern="^((\+)33|0)[1-9](\d{2}){4}$")
     *
     * @return  sting|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set pattern="^((\+)33|0)[1-9](\d{2}){4}$")
     *
     * @param  sting|null  $phone  pattern="^((\+)33|0)[1-9](\d{2}){4}$")
     *
     * @return  self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return  sting|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  sting|null  $email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of message
     *
     * @return  sting|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @param  sting|null  $message
     *
     * @return  self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of property
     *
     * @return  Property|null
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set the value of property
     *
     * @param  Property|null  $property
     *
     * @return  self
     */
    public function setProperty(Property $property)
    {
        $this->property = $property;

        return $this;
    }
}
