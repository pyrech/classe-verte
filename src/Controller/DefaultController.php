<?php

namespace App\Controller;

use App\Content;
use App\EstCeQueCEst;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{
    public function index(EstCeQueCEst $estCeQueCEst)
    {
        $content = new Content(
            $estCeQueCEst->bientotLaClasseVerte()
        );

        $url = $this->generateUrl('index', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $title = $content->getTitle();
        $subtitle = $content->getSubtitle();

        $counter = $this->getCounter();

        $html = <<<HTML
<!doctype html>
<html class="no-js" lang="fr" prefix="og: http://ogp.me/ns#">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>Est-ce que c'est bientôt la classe verte ?</title>
        <meta name="description" content="$title" />
        <meta property="og:title" content="Est-ce que c'est bientôt la classe verte ?" />
        <meta property="og:description" content="$title" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="$url" />
        <meta property="og:locale" content="fr" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" type="image/png" href="/logo.png" sizes="320x320">

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
        $counter
    </body>
</html>
HTML;

        return new Response($html);
    }

    private function getCounter(): string
    {
        $start = new \DateTime(getenv('START'));
        $now = new \DateTime();

        if ($now >= $start) {
            return '';
        }

        $timestamp = (int) $start->getTimestamp();
        $diff = $now->diff($start);

        return <<<HTML
<div class="counter">
    Temps restant avant la classe verte:
    <span class="part days">
        <span class="number">{$diff->days}</span>
        <span class="unit">{$this->getDirtyFrenchPlurial($diff->days, 'jour', 'jours')}</span>,
    </span>
    <span class="part hours">
        <span class="number">{$diff->h}</span>
        <span class="unit">{$this->getDirtyFrenchPlurial($diff->h, 'heure', 'heures')}</span>,
    </span>
    <span class="part minutes">
        <span class="number">{$diff->i}</span>
        <span class="unit">{$this->getDirtyFrenchPlurial($diff->i, 'minute', 'minutes')}</span>
        et
    </span>
    <span class="part seconds">
        <span class="number">{$diff->s}</span>
        <span class="unit">{$this->getDirtyFrenchPlurial($diff->s, 'seconde', 'secondes')}</span>
    </span>
</div>
<script type="text/javascript">
var dn = document.querySelector('.counter .days .number');
var du = document.querySelector('.counter .days .unit');
var hn = document.querySelector('.counter .hours .number');
var hu = document.querySelector('.counter .hours .unit');
var mn = document.querySelector('.counter .minutes .number');
var mu = document.querySelector('.counter .minutes .unit');
var sn = document.querySelector('.counter .seconds .number');
var su = document.querySelector('.counter .seconds .unit');

var a = function(c, s, p) {return c >= 1 ? p : s;};
var b = function() {
  var t = {$timestamp} - new Date().getTime()/1000;
  var d = Math.floor( t/(60*60*24) );
  var h = Math.floor( (t/(60*60)) % 24 );
  var m = Math.floor( (t/60) % 60 );
  var s = Math.floor( (t) % 60 );

  dn.innerHTML = d;
  du.innerHTML = a(d, 'jour', 'jours');
  hn.innerHTML = h;
  hu.innerHTML = a(h, 'heure', 'heures');
  mn.innerHTML = m;
  mu.innerHTML = a(m, 'minute', 'minutes');
  sn.innerHTML = s;
  su.innerHTML = a(s, 'seconde', 'secondes');
};
window.setInterval(b, 1000);
b();
</script>
HTML;
    }

    private function getDirtyFrenchPlurial(int $count, string $singular, string $plurial): string
    {
        return $count > 1 ? $plurial : $singular;
    }
}
