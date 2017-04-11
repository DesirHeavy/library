<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $page = 1;

        return $this->redirectToRoute('bibli_homepage',array('page' => $page));
    }
}
