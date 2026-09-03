<?php

namespace App\Service;



class CalculNoteAvecRetardService implements CalculNoteInterface
{
    public function calculerNote( $copie): float
    {
        $note = $copie->getNoteBrute();

        if ($copie->getDateDepot() > $copie->getDateLimite()) {
            $note -= 2;
        }

        return max(0, $note);
    }
}