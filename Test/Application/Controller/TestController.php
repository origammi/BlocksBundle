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
 * @Extra\Route("/")
 */
class TestController extends Controller
{
    /**
     * @Extra\Route("", name="test_index")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $post = new TestPost();

        /** @var Form $form */
        $form = $this
            ->createFormBuilder($post, ['cascade_validation' => true])
            ->add('title')
            ->add('blocks', 'origammi_blocks')
            ->add('save', 'submit')
            ->setAction($this->generateUrl('test_index'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $post = $form->getData();
            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush($post);
            $this->addFlash('success', 'Post saved!');

            return $this->redirectToRoute('test_index');
        }

        return $this->render(
            'views/Test/index.html.twig',
            [ 'form' => $form->createView() ]
        );
    }
}
