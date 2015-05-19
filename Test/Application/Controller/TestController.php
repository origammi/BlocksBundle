<?php

namespace Origammi\Bundle\BlocksBundle\Test\Application\Controller;

use Origammi\Bundle\BlocksBundle\Test\Application\Entity\TestPost;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @Extra\Route("")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction()
    {
        $post = new TestPost();

        $form = $this
            ->createFormBuilder($post)
            ->add('title')
            ->add('blocks', 'origammi_blocks')
            ->getForm();

        return $this->render(
            'views/Test/index.html.twig',
            [ 'form' => $form->createView() ]
        );
    }
}
