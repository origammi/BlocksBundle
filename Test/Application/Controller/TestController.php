<?php

namespace Origammi\Bundle\BlocksBundle\Test\Application\Controller;

use Origammi\Bundle\BlocksBundle\Test\Application\Entity\TestPost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TestController
 *
 * @package   Origammi\Bundle\BlocksBundle\Test\Application\Controller
 * @author    Matej Velikonja <mvelikonja@astina.ch>
 * @copyright 2015 Astina AG (http://astina.ch)
 *
 * @Extra\Route("")
 */
class TestController extends Controller
{
    /**
     * @Extra\Route("/", name="test_list")
     *
     * @return Response
     */
    public function listAction()
    {
        $posts = $this->getDoctrine()->getRepository('TestEntities:TestPost')->findAll();

        return $this->render(
            'views/Test/list.html.twig',
            [ 'posts' => $posts ]
        );
    }

    /**
     * @Extra\Route("/new", name="test_new")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function newAction(Request $request)
    {
        $post = new TestPost();

        $form = $this->getForm($post, 'test_new');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $post = $form->getData();
            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush($post);
            $this->get('session')->getFlashBag()->add('success', 'Post saved!');

            return $this->redirect(
                $this->generateUrl('test_list')
            );
        }

        return $this->render(
            'views/Test/new.html.twig',
            [ 'form' => $form->createView() ]
        );
    }

    /**
     * @Extra\Route("/edit/{id}", name="test_edit")
     *
     * @param TestPost $post
     * @param Request  $request
     *
     * @return Response
     */
    public function editAction(TestPost $post, Request $request)
    {
        $form = $this->getForm($post, 'test_edit');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $post = $form->getData();
            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush($post);
            $this->get('session')->getFlashBag()->add('success', 'Post edited!');

            return $this->redirect(
                $this->generateUrl('test_list')
            );
        }

        return $this->render(
            'views/Test/new.html.twig',
            [ 'form' => $form->createView() ]
        );
    }

    /**
     * @param TestPost $post
     * @param string   $actionRoute
     *
     * @return Form
     */
    private function getForm(TestPost $post, $actionRoute)
    {
        $form = $this
            ->createFormBuilder($post, ['cascade_validation' => true])
            ->add('title')
            ->add('blocks', 'origammi_blocks')
            ->add('save', 'submit')
            ->setAction($this->generateUrl($actionRoute))
            ->getForm();

        return $form;
    }
}
