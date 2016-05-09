<?php

namespace AppBundle\Entity;

/**
 * Favoris
 */
class Favoris
{
    /**
     * @var integer
     */
    private $userId;

    /**
     * @var integer
     */
    private $consultantId;

    /**
     * @var boolean
     */
    private $isavailable = '1';

    /**
     * @var \DateTime
     */
    private $updated;

    /**
     * @var \DateTime
     */
    private $created = 'CURRENT_TIMESTAMP';


    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Favoris
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
     * Set consultantId
     *
     * @param integer $consultantId
     *
     * @return Favoris
     */
    public function setConsultantId($consultantId)
    {
        $this->consultantId = $consultantId;

        return $this;
    }

    /**
     * Get consultantId
     *
     * @return integer
     */
    public function getConsultantId()
    {
        return $this->consultantId;
    }

    /**
     * Set isavailable
     *
     * @param boolean $isavailable
     *
     * @return Favoris
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
     * @return Favoris
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
     * @return Favoris
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
}
