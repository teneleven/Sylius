<?php

namespace Sylius\Bundle\ReviewBundle\Model;

use Sylius\Bundle\CoreBundle\Model\UserInterface;
use Sylius\Bundle\ResourceBundle\Model\TimestampableInterface;

interface ReviewInterface extends TimestampableInterface
{
    /**
     * @param string $title
     * @return ReviewInterface
     */
    public function setTitle($title);

    /**
     * @return string 
     */
    public function getTitle();

    /**
     * @param integer $rating
     * @return ReviewInterface
     */
    public function setRating($rating);

    /**
     * @return integer 
     */
    public function getRating();

    /**
     * @param string $comment
     * @return ReviewInterface
     */
    public function setComment($comment);

    /**
     * @return string 
     */
    public function getComment();

    /**
     * @param string $moderationStatus
     * @return ReviewInterface
     */
    public function setModerationStatus($moderationStatus);

    /**
     * @return string 
     */
    public function getModerationStatus();

    /**
     * Set user.
     *
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user);

    /**
     * Get user.
     *
     * @return UserInterface
     */
    public function getUser();

    /**
     * Set guestReviewer.
     *
     * @param GuestReviewerInterface $guestReviewer
     */
    public function setGuestReviewer(GuestReviewerInterface $guestReviewer);

    /**
     * Get guestReviewer.
     *
     * @return GuestReviewerInterface
     */
    public function getGuestReviewer();
}