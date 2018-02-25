<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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

}
