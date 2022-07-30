<?php

namespace App\Controller;

use App\Content;
use App\EstCeQueCEst;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EstCeQueCEst $estCeQueCEst)
    {
        $content = new Content($estCeQueCEst->bientotLaClasseVerte());

        return $this->render('default/index.html.twig', [
            'title' => $content->getTitle(),
            'subtitle' => $content->getSubtitle(),
            'start' => $estCeQueCEst->getStart(),
            'now' => new \DateTime(),
        ]);
    }
}
