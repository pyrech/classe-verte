<?php

namespace App;

class Content
{
    public function __construct(
        private string $key,
    ) {}

    public function getTitle(): string
    {
        switch ($this->key) {
            case EstCeQueCEst::MORE_THAN_60_DAYS:
                return 'Non !';
            case EstCeQueCEst::MORE_THAN_30_DAYS:
            case EstCeQueCEst::MORE_THAN_14_DAYS:
            case EstCeQueCEst::MORE_THAN_7_DAYS:
            case EstCeQueCEst::MORE_THAN_3_DAYS:
            case EstCeQueCEst::MORE_THAN_2_DAYS:
            case EstCeQueCEst::MORE_THAN_24_HOURS:
            case EstCeQueCEst::MORE_THAN_12_HOURS:
            case EstCeQueCEst::MORE_THAN_6_HOURS:
            case EstCeQueCEst::MORE_THAN_1_HOUR:
            case EstCeQueCEst::LESS_THAN_1_HOUR:
                return 'Oui !';
            case EstCeQueCEst::IT_S_NOW:
                return 'C\'est maintenant 😎';
            case EstCeQueCEst::IT_S_OVER:
                return 'C\'est terminé !';
        }

        throw new \LogicException();
    }

    public function getSubtitle(): string
    {
        switch ($this->key) {
            case EstCeQueCEst::MORE_THAN_60_DAYS:
                return 'C\'est dans looooongtemps 😭';
            case EstCeQueCEst::MORE_THAN_30_DAYS:
                return 'Mais encore plusieurs semaines à patienter 🥹 !';
            case EstCeQueCEst::MORE_THAN_14_DAYS:
                return 'Plus que quelques semaines à attendre 🫡 !';
            case EstCeQueCEst::MORE_THAN_7_DAYS:
                return 'C\'est dans moins de 2 semaines 🎉';
            case EstCeQueCEst::MORE_THAN_3_DAYS:
                return 'C\'est bientôôôôt !';
            case EstCeQueCEst::MORE_THAN_2_DAYS:
                return 'Prêt pour ta meilleure semaine de l\'année ?';
            case EstCeQueCEst::MORE_THAN_24_HOURS:
                return 'Ta valise est prête ?';
            case EstCeQueCEst::MORE_THAN_12_HOURS:
                return 'Dernier dodo !';
            case EstCeQueCEst::MORE_THAN_6_HOURS:
                return 'Ce soir, on se la colle !';
            case EstCeQueCEst::MORE_THAN_1_HOUR:
                return 'Courage, encore quelques heures à tenir 😉';
            case EstCeQueCEst::LESS_THAN_1_HOUR:
                return 'On est d\'accord que plus personne ne bosse, là, non ?';
            case EstCeQueCEst::IT_S_NOW:
                return 'Qu\'est ce que tu fais ici ?? Profite ! 🍻';
            case EstCeQueCEst::IT_S_OVER:
                return 'Sniff, c\'est déjà terminé 😢';
        }

        throw new \LogicException();
    }
}
