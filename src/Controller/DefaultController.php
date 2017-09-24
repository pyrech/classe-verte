<?php

namespace App\Controller;

use App\Content;
use App\EstCeQueCEst;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function index(EstCeQueCEst $estCeQueCEst)
    {
        $content = new Content(
            $estCeQueCEst->bientotLaClasseVerte()
        );

        $title = $content->getTitle();
        $subtitle = $content->getSubtitle();

        $html = <<<HTML
<!doctype html>
<html class="no-js" lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Est-ce que c'est bientôt la classe verte ?</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <style type="text/css">
            body {
                text-align:center;
                padding-top:40px
            }
            p.msg {
                font-family:Verdana;
                font-size:40px;
                padding-bottom:40px
            }
        </style>
    </head>
    <body>
        <p class="msg">$title</p>
        <p class="msg">$subtitle</p>
    </body>
</html>
HTML;

        return new Response($html);
    }
}
