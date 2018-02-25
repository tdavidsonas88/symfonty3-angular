<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\BlogPostType;

class BlogPostsController extends Controller
{
    /**
     * @Route("/", name="list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $blogPosts = $em->getRepository('AppBundle:BlogPost')->findAll();

        return $this->render('BlogPosts/list.html.twig', array(
            'blog_posts' => $blogPosts,
        ));
    }

    /**
     * @param Request $request
     * @Route("/create", name="create")
     */
    public function createAction(Request $request) {
        // $blogPost = new BlogPost();
        $form = $this->createForm(BlogPostType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $blogPost = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($blogPost);
            $em->flush();

            return $this->redirectToRoute('list');
        }

        return $this->render('BlogPosts/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
