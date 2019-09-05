<?php

namespace App\Controller;

use App\Content;
use App\EstCeQueCEst;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function index(EstCeQueCEst $estCeQueCEst)
    {
        $content = new Content($estCeQueCEst->bientotLaClasseVerte());

        return $this->render('default/index.html.twig', [
            'title' => $content->getTitle(),
            'subtitle' => $content->getSubtitle(),
            'counter' => $this->getCounter(),
            'start' => new \DateTime(getenv('START')),
            'now' => new \DateTime(),
        ]);
    }
}
