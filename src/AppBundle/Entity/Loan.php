<?php namespace AppBundle\Entity;

/**
 * Loan model
 *
 * @author Roberts Sukonovs <roberts.sukonovs@gmail.com>
 * @package AppBundle\Entity
 */

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="loans")
 */
class Loan
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
    protected $amount;

    /**
     * @ORM\Column(type="decimal", scale=2, options={"default" = 0.00})
     */
    protected $available_for_investments;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;

    /**
     * @ORM\OneToMany(targetEntity="Investment", mappedBy="loan")
     */
    protected $investments;

    /**
     * User constructor
     */
    public function __construct()
    {
        $this->investments = new ArrayCollection();
    }

    /**
     * Checks if loan can accept new investments
     * 
     * @return bool
     */
    public function canBeInvested() {
        
        return $this->getAvailableForInvestments() > 0;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param string $amount
     * @return Loan
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set available_for_investments
     *
     * @param string $availableForInvestments
     * @return Loan
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
     * @return Loan
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

    /**
     * Set title
     *
     * @param string $title
     * @return Loan
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
}
