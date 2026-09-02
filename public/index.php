<?php
require_once dirname( __DIR__) . '/vendor/autoload.php';



use App\Entity\CopieExamen;

$dateDepot = new DateTime('2026-09-01');
$dateLimite = new DateTime('2026-09-10');

$copie = new CopieExamen(
    dateDepot: $dateDepot,
    noteBrute: 15,
    penaliteAppliquee: 2,
    dateLimite: $dateLimite
);

echo "ID : ";
var_dump($copie->getId());

echo "Date dépôt : ";
echo $copie->getDateDepot()->format('Y-m-d') ;

echo "Note brute : ";
echo $copie->getNoteBrute();

echo "Pénalité : ";
echo $copie->getPenaliteAppliquee();

echo "Note finale : ";
echo $copie->getNoteFinale() ;