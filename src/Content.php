<?php

namespace App;

class Content
{
    /** @var string */
    private $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getTitle(): string
    {
        switch ($this->key) {
            case EstCeQueCEst::MORE_THAN_30_DAYS:
                return 'Non !';
            case EstCeQueCEst::MORE_THAN_14_DAYS:
                return 'Oui !';
            case EstCeQueCEst::MORE_THAN_7_DAYS:
                return 'Oui !';
            case EstCeQueCEst::MORE_THAN_2_DAYS:
                return 'Oui !';
            case EstCeQueCEst::MORE_THAN_24_HOURS:
                return 'Oui !';
            case EstCeQueCEst::MORE_THAN_12_HOURS:
                return 'Oui !';
            case EstCeQueCEst::MORE_THAN_6_HOURS:
                return 'Oui !';
            case EstCeQueCEst::MORE_THAN_1_HOUR:
                return 'Oui !';
            case EstCeQueCEst::LESS_THAN_1_HOUR:
                return 'Oui !';
            case EstCeQueCEst::IT_S_NOW:
                return 'C\'est maintenant \o/';
            case EstCeQueCEst::IT_S_OVER:
                return 'C\'est terminé !';
        }

        throw new \LogicException();
    }

    public function getSubtitle(): string
    {
        switch ($this->key) {
            case EstCeQueCEst::MORE_THAN_30_DAYS:
                return 'C\'est dans looooongtemps :\'(';
            case EstCeQueCEst::MORE_THAN_14_DAYS:
                return 'Encore quelques semaines à patienter !';
            case EstCeQueCEst::MORE_THAN_7_DAYS:
                return 'Moins de 2 semaines \o/';
            case EstCeQueCEst::MORE_THAN_2_DAYS:
                return 'Courage, plus que quelques jours à tenir !';
            case EstCeQueCEst::MORE_THAN_24_HOURS:
                return 'Ta valise est prête ?';
            case EstCeQueCEst::MORE_THAN_12_HOURS:
                return 'Dernier jour avant ta meilleure semaine de l\'année !';
            case EstCeQueCEst::MORE_THAN_6_HOURS:
                return 'Ce soir, on se la colle !';
            case EstCeQueCEst::MORE_THAN_1_HOUR:
                return 'Courage, encore quelques heures à tenir ;)';
            case EstCeQueCEst::LESS_THAN_1_HOUR:
                return 'On est d\'accord que plus personne ne bosse, là, non ?';
            case EstCeQueCEst::IT_S_NOW:
                return 'Qu\'est ce que tu fais ici ?? Profite !';
            case EstCeQueCEst::IT_S_OVER:
                return 'Sniff, c\'est déjà terminé :\'(';
        }

        throw new \LogicException();
    }
}
