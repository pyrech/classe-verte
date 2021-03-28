<?php

namespace App\Controller;

use App\Content;
use App\EstCeQueCEst;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function index(EstCeQueCEst $estCeQueCEst)
    {
        $content = new Content($estCeQueCEst->bientotLaClasseVerte());

        return $this->render('default/index.html.twig', [
            'title' => $content->getTitle(),
            'subtitle' => $content->getSubtitle(),
            'start' => new \DateTime($_ENV['START']),
            'now' => new \DateTime(),
        ]);
    }
}
