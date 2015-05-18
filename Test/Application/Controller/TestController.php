<?php

namespace Origammi\Bundle\BlocksBundle\Test\Application\Controller;

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
    public function indexAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository('TestEntities:TestPost');
        $repo->findAll();

        return new Response('test');
    }
}
