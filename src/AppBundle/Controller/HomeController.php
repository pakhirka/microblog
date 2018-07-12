<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\PostType;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request): Response
    {   
	   $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findBy([], ['createdAt' => 'DESC']);

      //  $paginator = $this->get('knp_paginator');
       // $posts = $paginator->paginate($posts, $request->query->getInt('page', 1), 0);

		
		$post = new Post();
        $form = $this->createForm(PostType::class, $post);
		
		
        $form->handleRequest($request);
	
        return $this->render('homepage/index.html.twig', [
            'posts' => $posts,
            'form' => $form->createView(),
        ]);
		
    }
	
   	

    /**
     * @Route("/{slug}", name="homepage_view")
     *
     * @ParamConverter("post", class="AppBundle:Post", options={"repository_method" = "findWithAuthor"})
     *
     * @param Post $post
     * @param Request $request
     *
     * @return Response
     */
    public function showAction(Post $post, Request $request): Response
    {

    }
 
}
