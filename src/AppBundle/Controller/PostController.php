<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\PostType;

/**
 * Post controller.
 *
 * @Route("posts")
 */
class PostController extends Controller
{
	
    /**
     * Lists all post entities.
     *
     * @Route("/", name="admin_posts_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository('AppBundle:Post')->findAll();

        return $this->render('backend/post/index.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * Creates a new post entity.
     *
     * @Route("/new", name="admin_posts_new")
     * @Method({"GET", "POST"})
	 * defaults={"_format"="json"}
     */
    public function newAction(Request $request)
    {
		$data = '';

		if ($request->isXMLHttpRequest()) {

		
		$securityContext = $this->container->get('security.authorization_checker');
		if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
					$data = $request->getContent();
					$post = new Post;
					
					$post->setContent($request->get('content'));
					$em = $this->getDoctrine()->getManager();
					$em->persist($post);
					$em->flush();

					//fuck ORM\ManyToOne	
					$sql = "UPDATE post SET user_id = :userid WHERE id = :postid";
					$stmt = $em->getConnection()->prepare($sql);
					$stmt->bindValue(':userid', $this->getUser()->getId());
					$stmt->bindValue(':postid', $post->getId());
					$result = $stmt->execute();	
						
					$data = ['user' => $this->getUser()->getUsername(), 'content' => $request->get('content'), 'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
					'delpath' => $this->generateUrl('admin_posts_delete', array('id' => $post->getId()))];
					return new JsonResponse($data);
		}	
		}
		return new JsonResponse(Response::HTTP_UNAUTHORIZED); 
    }

    /**
     * Finds and displays a post entity.
     *
     * @Route("/data", name="admin_posts_data")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();
					
		$sql = "SELECT  user.username,  post.content,  post.created_at FROM post INNER JOIN user ON post.user_id = user.id";
		$stmt = $em->getConnection()->prepare($sql);
		$stmt->execute();	
		$data = $stmt->fetchAll();

		return new JsonResponse(json_encode($data));

    }

    /**
     * Displays a form to edit an existing post entity.
     *
     * @Route("/{id}/edit", name="admin_posts_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Post $post)
    {
        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm(PostType::class, $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', sprintf('Post "%s" successfully edited', $post->getName()));

            return $this->redirectToRoute('admin_posts_edit', array('id' => $post->getId()));
        }

        return $this->render('backend/post/edit.html.twig', array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a post entity.
     *
     * @Route("/del/{id}", name="admin_posts_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Post $post)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        $this->addFlash('success', sprintf('Post "%s" successfully deleted', $post->getContent()));       

        return $this->redirectToRoute('homepage');
    }

}
