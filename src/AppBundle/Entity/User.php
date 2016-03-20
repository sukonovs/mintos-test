<?php

namespace AppBundle\Entity;

/**
 * User model
 *
 * @author Roberts Sukonovs <roberts.sukonovs@gmail.com>
 * @package AppBundle\Entity
 */

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", scale=2, options={"default" = 0.00})
     */
    protected $available_for_investments;

    /**
     * @ORM\OneToMany(targetEntity="Investment", mappedBy="user", cascade={"persist"})
     */
    protected $investments;

    /**
     * User constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->investments = new ArrayCollection();
    }

    /**
     * Checks if user can invest
     *
     * @return bool
     */
    public function CanInvest() {

        return $this->getAvailableForInvestments() > 0;
    }
    
    /**
     * Set available_for_investments
     *
     * @param string $availableForInvestments
     * @return User
     */
    public function setAvailableForInvestments($availableForInvestments)
    {
        $this->available_for_investments = $availableForInvestments;

        return $this;
    }

    /**
     * Get available_for_investments
     *
     * @return string 
     */
    public function getAvailableForInvestments()
    {
        return $this->available_for_investments;
    }

    /**
     * Add investments
     *
     * @param Investment $investments
     * @return User
     */
    public function addInvestment(Investment $investments)
    {
        $this->investments[] = $investments;

        return $this;
    }

    /**
     * Remove investments
     *
     * @param Investment $investments
     */
    public function removeInvestment(Investment $investments)
    {
        $this->investments->removeElement($investments);
    }

    /**
     * Get investments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInvestments()
    {
        return $this->investments;
    }
}
