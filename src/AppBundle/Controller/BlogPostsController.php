<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\BlogPostType;
use AppBundle\Entity\BlogPost;

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
        $form = $this->createForm(BlogPostType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /**
             * @var $blogPost BlogPost
             */
            $blogPost = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($blogPost);
            $em->flush();

            return $this->redirectToRoute('edit', [
                'blogPost' => $blogPost->getId(),
            ]);
        }

        return $this->render('BlogPosts/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{blogPost}", name="edit")
     */
    public function editAction(Request $request, BlogPost $blogPost) {
        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('list');
        }

        return $this->render('BlogPosts/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
