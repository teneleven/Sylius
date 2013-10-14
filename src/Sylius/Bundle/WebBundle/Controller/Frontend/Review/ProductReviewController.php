<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\WebBundle\Controller\Frontend\Review;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sylius\Bundle\CoreBundle\Model\Review;
use Sylius\Bundle\ReviewBundle\Form\Type\ReviewType;
use Sylius\Bundle\ReviewBundle\Model\GuestReviewer;

/**
 * ProductReview controller.
 *
 * @author Justin Hilles <justin@1011i.com>
 */
class ProductReviewController extends Controller
{
    public function newAction(Request $request, $product)
    {	
        $form = $this->createForm('guest_review');
        
		return $this->render('SyliusWebBundle:Frontend\Review:_new.html.twig', array('form' => $form->createView(), 'product' => $product));
    }

    public function listAction(Request $request, $product, $min = 3)
    {
        $reviews = $this->get('sylius.repository.review')->findBy(array('product' => $product, 'moderationStatus' => 'approved'));

        return $this->render('SyliusWebBundle:Frontend\Review:_list.html.twig', compact('reviews', 'min'));
    }

    /**
     *  THIS NEEDS MAJOR REFACTORING
     **/
    public function handleReviewAction(Request $request, $slug)
    {
    	$form = $this->createForm('guest_review');

	    $form->handleRequest($request);

	    if ($form->isValid()) {

	        $data = $form->getData();

            $review = new Review;

            if(is_string($slug)) {
                
                $product = $this->get('sylius.repository.product')->findOneBy(array('slug' => $slug));
            }
            
            $review->setProduct($product);

            $user = new GuestReviewer;
            $user->setName($data['name']);
            $user->setEmail($data['email']);

            $review->setGuestReviewer($user);

            $review->setTitle($data['title']);
            $review->setComment($data['comment']);
            $review->setRating($data['rating']);
            
			$em = $this->getDoctrine()->getManager();
		    $em->persist($review);
		    $em->flush();
	    }  
	    
	    return $this->redirect($this->generateUrl('sylius_product_show', array('slug' => $product->getSlug())));  	
    }
}