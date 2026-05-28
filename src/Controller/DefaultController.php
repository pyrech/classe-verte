<?php

namespace App\Controller;

use App\Content;
use App\EstCeQueCEst;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EstCeQueCEst $estCeQueCEst): Response
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
