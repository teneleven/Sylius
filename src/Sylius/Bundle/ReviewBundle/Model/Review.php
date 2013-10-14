<?php

namespace Sylius\Bundle\ReviewBundle\Model;

use Sylius\Bundle\CoreBundle\Model\UserInterface;

/**
 * Review
 */
class Review implements ReviewInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var integer
     */
    protected $rating;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @var string
     */
    protected $moderationStatus;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var integer
     */
    protected $guestReviewer;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->moderationStatus = 'new';
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * {@inheritdoc}
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setModerationStatus($moderationStatus)
    {
        $this->moderationStatus = $moderationStatus;
    
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getModerationStatus()
    {
        return $this->moderationStatus;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGuestReviewer()
    {
        return $this->guestReviewer;
    }

    /**
     * {@inheritdoc}
     */
    public function setGuestReviewer(GuestReviewerInterface $guestReviewer)
    {
        $this->guestReviewer = $guestReviewer;

        return $this;
    }

    public function getReviewerName()
    {
        if(!empty($this->user)){
            return $this->getUser()->getFirstName();
        }
        if(!empty($this->guestReviewer)) {
            return $this->getGuestReviewer()->getName();
        }
    }

    public function getReviewerEmail()
    {
        if(!empty($this->user)){
            return $this->getUser()->getEmail();
        }
        if(!empty($this->guestReviewer)) {
            return $this->getGuestReviewer()->getEmail();
        }
    }
}
