<?php

namespace AppBundle\Entity;

/**
 * Searches
 */
class Searches
{
    /**
     * @var integer
     */
    private $userId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $created = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     */
    private $query;

    /**
     * @var boolean
     */
    private $isavailable = '0';

    /**
     * @var \DateTime
     */
    private $updated;


    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Searches
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Searches
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Searches
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

    /**
     * Set query
     *
     * @param string $query
     *
     * @return Searches
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get query
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set isavailable
     *
     * @param boolean $isavailable
     *
     * @return Searches
     */
    public function setIsavailable($isavailable)
    {
        $this->isavailable = $isavailable;

        return $this;
    }

    /**
     * Get isavailable
     *
     * @return boolean
     */
    public function getIsavailable()
    {
        return $this->isavailable;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Searches
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
     * @var integer
     */
    private $id;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
