<?php 

namespace AppBundle\Entity;

/**
 * Investment model
 *
 * @author Roberts Sukonovs <roberts.sukonovs@gmail.com>
 * @package AppBundle\Entity
 */

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="investments")
 */
class Investment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="investments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Loan", inversedBy="investments", fetch="EAGER")
     * @ORM\JoinColumn(name="loan_id", referencedColumnName="id")
     */
    protected $loan;

    /**
     * @ORM\Column(type="decimal", scale=2, options={"default" = 0.00})
     */
    protected $amount;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * Investment constructor.
     */
    public function __construct() {
        $this->date = new DateTime;
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
     * Set user
     *
     * @param User $user
     * @return Investment
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set loan
     *
     * @param Loan $loan
     * @return Investment
     */
    public function setLoan(Loan $loan = null)
    {
        $this->loan = $loan;

        return $this;
    }

    /**
     * Get loan
     *
     * @return Loan
     */
    public function getLoan()
    {
        return $this->loan;
    }

    /**
     * Set amount
     *
     * @param string $amount
     * @return Investment
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
     * Set date
     *
     * @param \DateTime $date
     * @return Investment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
}
