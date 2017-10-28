<?php

namespace HamzaBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Insect
 *
 * @ORM\Table(name="insect")
 * @ORM\Entity(repositoryClass="HamzaBundle\Repository\InsectRepository")
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 */
class Insect extends BaseUser implements UserInterface, \Serializable
{

    public function __construct() {
        parent::__construct();
        $this->friendsWithMe = new ArrayCollection();
        $this->myFriends = new ArrayCollection();
    }

//
//    /**
//     * Many Users have many Users.
//     * @ORM\ManyToMany(targetEntity="Insect", mappedBy="$myFriends")
//     */
//    protected $friendsWithMe;   


    /**
     * Many Users have many Users.
     * @ORM\ManyToMany(targetEntity="Insect")
     * @ORM\JoinTable(name="friends",
     *      joinColumns={@ORM\JoinColumn(name="insect_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="friend_insect_id", referencedColumnName="id")}
     *      )
     */

    private $myFriends;




    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Age", type="string", length=255)
     */
    private $age;   

    /**
     * @var string
     *
     * @ORM\Column(name="Race", type="string", length=255)
     */
    private $race;

    /**
     * @var string
     *
     * @ORM\Column(name="Famille", type="string", length=100)
     */
    private $famille; 

    /**
     * @var string
     *
     * @ORM\Column(name="Food", type="string", length=100)
     */
    private $food;




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
     * Set name
     *
     * @param string $name
     * @return Insect
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }    

    /**
     * Set age
     *
     * @param string $age
     * @return Insect
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }   

    /**
     * Set race
     *
     * @param string $race
     * @return Insect
     */
    public function setRace($race)
    {
        $this->race = $race;

        return $this;
    }  

    /**
     * Set famille
     *
     * @param string $famille
     * @return Insect
     */
    public function setFamille($famille)
    {
        $this->famille = $famille;

        return $this;
    }   

    /**
     * Set food
     *
     * @param string $food
     * @return Insect
     */
    public function setFood($food)
    {
        $this->food = $food;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    } 

    /**
     * Get age
     *
     * @return string 
     */
    public function getAge()
    {
        return $this->age;
    } 

    /**
     * Get race
     *
     * @return string 
     */
    public function getRace()
    {
        return $this->race;
    }   

    /**
     * Get famille
     *
     * @return string 
     */
    public function getFamille()
    {
        return $this->famille;
    } 

    /**
     * Get food
     *
     * @return string 
     */
    public function getFood()
    {
        return $this->food;
    }

    public function addMyFriend($friend){

        $this->myFriends[] = $friend;

    }    
    
    public function getMyFriends(){

        return $this->myFriends;

    }

    public function removeMyFriend($friend)
    {
        
        $this->myFriends->removeElement($friend);
    }


}
