<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consultant
 *
 * @ORM\Table(name="consultant")
 * @ORM\Entity(repositoryClass="AppBundle\Repositories\ConsultantRepository")
 */
class Consultant
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="isu", type="string", length=100, nullable=false)
     */
    private $isu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="recruitement", type="date", nullable=false)
     */
    private $recruitement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="separation", type="date", nullable=true)
     */
    private $separation;

    /**
     * @var string
     *
     * @ORM\Column(name="function_title", type="string", length=255, nullable=false)
     */
    private $functionTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="skills_level", type="string", length=100, nullable=true)
     */
    private $skillsLevel;

    /**
     * @var string
     *
     * @ORM\Column(name="manager", type="text", length=65535, nullable=true)
     */
    private $manager;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=12, nullable=false)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="text", length=65535, nullable=false)
     */
    private $adresse;

    /**
     * @var array
     *
     * @ORM\Column(name="main_tag", type="json_array", length=65535, nullable=true)
     */
    private $mainTag;

    /**
     * @var array
     *
     * @ORM\Column(name="technical_tag", type="json_array", length=65535, nullable=true)
     */
    private $technicalTag;

    /**
     * @var array
     *
     * @ORM\Column(name="functional_tag", type="json_array", length=65535, nullable=true)
     */
    private $functionalTag;

    /**
     * @var array
     *
     * @ORM\Column(name="new_tag", type="json_array", length=65535, nullable=true)
     */
    private $newTag;

    /**
     * @var array
     *
     * @ORM\Column(name="activity_area", type="json_array", length=65535, nullable=true)
     */
    private $activityArea;

    /**
     * @var array
     *
     * @ORM\Column(name="wishes", type="json_array", length=65535, nullable=true)
     */
    private $wishes;

    /**
     * @var array
     *
     * @ORM\Column(name="languages", type="json_array", length=65535, nullable=true)
     */
    private $languages;

    /**
     * @var array
     *
     * @ORM\Column(name="training", type="json_array", length=65535, nullable=true)
     */
    private $training;

    /**
     * @var string
     *
     * @ORM\Column(name="client", type="string", length=255, nullable=true)
     */
    private $client;

    /**
     * @var array
     *
     * @ORM\Column(name="availability", type="json_array", length=65535, nullable=false)
     */
    private $availability;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mission_start", type="date", nullable=true)
     */
    private $missionStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mission_end", type="date", nullable=true)
     */
    private $missionEnd;

    /**
     * @var integer
     *
     * @ORM\Column(name="mission_extension", type="integer", nullable=true)
     */
    private $missionExtension = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created = 'CURRENT_TIMESTAMP';



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
     * Set id
     *
     * @param integer $id
     *
     * @return Consultant
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Consultant
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Consultant
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set isu
     *
     * @param string $isu
     *
     * @return Consultant
     */
    public function setIsu($isu)
    {
        $this->isu = $isu;

        return $this;
    }

    /**
     * Get isu
     *
     * @return string
     */
    public function getIsu()
    {
        return $this->isu;
    }

    /**
     * Set recruitement
     *
     * @param \DateTime $recruitement
     *
     * @return Consultant
     */
    public function setRecruitement($recruitement)
    {
        $this->recruitement = $recruitement;

        return $this;
    }

    /**
     * Get recruitement
     *
     * @return \DateTime
     */
    public function getRecruitement()
    {
        return $this->recruitement;
    }

    /**
     * Set separation
     *
     * @param \DateTime $separation
     *
     * @return Consultant
     */
    public function setSeparation($separation)
    {
        $this->separation = $separation;

        return $this;
    }

    /**
     * Get separation
     *
     * @return \DateTime
     */
    public function getSeparation()
    {
        return $this->separation;
    }

    /**
     * Set functionTitle
     *
     * @param string $functionTitle
     *
     * @return Consultant
     */
    public function setFunctionTitle($functionTitle)
    {
        $this->functionTitle = $functionTitle;

        return $this;
    }

    /**
     * Get functionTitle
     *
     * @return string
     */
    public function getFunctionTitle()
    {
        return $this->functionTitle;
    }

    /**
     * Set skillsLevel
     *
     * @param string $skillsLevel
     *
     * @return Consultant
     */
    public function setSkillsLevel($skillsLevel)
    {
        $this->skillsLevel = $skillsLevel;

        return $this;
    }

    /**
     * Get skillsLevel
     *
     * @return string
     */
    public function getSkillsLevel()
    {
        return $this->skillsLevel;
    }

    /**
     * Set manager
     *
     * @param string $manager
     *
     * @return Consultant
     */
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Get manager
     *
     * @return string
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Consultant
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Consultant
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Consultant
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set mainTag
     *
     * @param array $mainTag
     *
     * @return Consultant
     */
    public function setMainTag($mainTag)
    {
        $this->mainTag = $mainTag;

        return $this;
    }

    /**
     * Get mainTag
     *
     * @return array
     */
    public function getMainTag()
    {
        return $this->mainTag;
    }

    /**
     * Set technicalTag
     *
     * @param array $technicalTag
     *
     * @return Consultant
     */
    public function setTechnicalTag($technicalTag)
    {
        $this->technicalTag = $technicalTag;

        return $this;
    }

    /**
     * Get technicalTag
     *
     * @return array
     */
    public function getTechnicalTag()
    {
        return $this->technicalTag;
    }

    /**
     * Set functionalTag
     *
     * @param array $functionalTag
     *
     * @return Consultant
     */
    public function setFunctionalTag($functionalTag)
    {
        $this->functionalTag = $functionalTag;

        return $this;
    }

    /**
     * Get functionalTag
     *
     * @return array
     */
    public function getFunctionalTag()
    {
        return $this->functionalTag;
    }

    /**
     * Set newTag
     *
     * @param array $newTag
     *
     * @return Consultant
     */
    public function setNewTag($newTag)
    {
        $this->newTag = $newTag;

        return $this;
    }

    /**
     * Get newTag
     *
     * @return array
     */
    public function getNewTag()
    {
        return $this->newTag;
    }

    /**
     * Set activityArea
     *
     * @param array $activityArea
     *
     * @return Consultant
     */
    public function setActivityArea($activityArea)
    {
        $this->activityArea = $activityArea;

        return $this;
    }

    /**
     * Get activityArea
     *
     * @return array
     */
    public function getActivityArea()
    {
        return $this->activityArea;
    }

    /**
     * Set wishes
     *
     * @param array $wishes
     *
     * @return Consultant
     */
    public function setWishes($wishes)
    {
        $this->wishes = $wishes;

        return $this;
    }

    /**
     * Get wishes
     *
     * @return array
     */
    public function getWishes()
    {
        return $this->wishes;
    }

    /**
     * Set languages
     *
     * @param array $languages
     *
     * @return Consultant
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;

        return $this;
    }

    /**
     * Get languages
     *
     * @return array
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Set training
     *
     * @param array $training
     *
     * @return Consultant
     */
    public function setTraining($training)
    {
        $this->training = $training;

        return $this;
    }

    /**
     * Get training
     *
     * @return array
     */
    public function getTraining()
    {
        return $this->training;
    }

    /**
     * Set client
     *
     * @param string $client
     *
     * @return Consultant
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set availability
     *
     * @param array $availability
     *
     * @return Consultant
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * Get availability
     *
     * @return array
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Set missionStart
     *
     * @param \DateTime $missionStart
     *
     * @return Consultant
     */
    public function setMissionStart($missionStart)
    {
        $this->missionStart = $missionStart;

        return $this;
    }

    /**
     * Get missionStart
     *
     * @return \DateTime
     */
    public function getMissionStart()
    {
        return $this->missionStart;
    }

    /**
     * Set missionEnd
     *
     * @param \DateTime $missionEnd
     *
     * @return Consultant
     */
    public function setMissionEnd($missionEnd)
    {
        $this->missionEnd = $missionEnd;

        return $this;
    }

    /**
     * Get missionEnd
     *
     * @return \DateTime
     */
    public function getMissionEnd()
    {
        return $this->missionEnd;
    }

    /**
     * Set missionExtension
     *
     * @param integer $missionExtension
     *
     * @return Consultant
     */
    public function setMissionExtension($missionExtension)
    {
        $this->missionExtension = $missionExtension;

        return $this;
    }

    /**
     * Get missionExtension
     *
     * @return integer
     */
    public function getMissionExtension()
    {
        return $this->missionExtension;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Consultant
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Consultant
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
    
    public function getWeeksRemaining(){
        if(!empty($this->getMissionEnd())){
            $interval = $this->getMissionEnd()->diff(new \DateTime("now"));
            return intval($interval->days / 7);
        }else if($this->getAvailability()["value"]==3){
            return -1;
        }else if($this->getAvailability()["value"]==4){
            return 0;
        }else{
            return 10000;
        }
    }
            
}
