<?php

namespace App\Service;

use App\Service\DateUtils;

readonly class SoumettreCopieDTO
    {
        

        private function __construct(
            public float $noteBrute,
            public \DateTimeImmutable $dateDepot,
            public \DateTimeImmutable $dateLimite
        ) {
            
            $this->noteBrute = NoteValidator::validate($noteBrute);

            // $this->dateDepot = DateUtils::convertirDate($dateDepot, 'date de depot');
            // $this->dateLimite = DateUtils::convertirDate($dateLimi , 'date limite');
        }

        public static function fromArray(array $data): SoumettreCopieDTO
        {
            $noteBrute = $data['note_brute'] ?? null;
            $dateDepot = $data['date_depot'] ?? null;
            $dateLimite = $data['date_limite'] ?? null;

            return new SoumettreCopieDTO($noteBrute, $dateDepot, $dateLimite);
        }
            
    }