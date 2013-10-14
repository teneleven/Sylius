<?php

namespace Sylius\Bundle\ReviewBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

class ReviewController extends ResourceController {

    public function approveAction(Request $request, $id) 
    {
        $review = $this->get('sylius.repository.review')->find($id);

        $review->setModerationStatus('approved');

        $this->update($review);
        
        return $this->redirect($this->generateUrl('sylius_backend_review_update', array('id' => $review->getId())));
    }

    public function denyAction(Request $request, $id) 
    {
        $review = $this->get('sylius.repository.review')->find($id);

        $review->setModerationStatus('denied');

        $this->update($review);

        return $this->redirect($this->generateUrl('sylius_backend_review_update', array('id' => $review->getId())));
    }
}