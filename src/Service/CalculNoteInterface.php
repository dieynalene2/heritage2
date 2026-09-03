<?php

namespace App\Service;

use App\Entity\CopieExamen;

interface CalculNoteInterface
{
    public function calculerNote(CopieExamen $copie): float;
}