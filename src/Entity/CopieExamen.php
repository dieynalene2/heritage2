<?php

class CopieExamen extends AbstractDocument {
    private float $noteBrute;
    private float $noteFinale;
    private bool $penaliteAppliquee;
    private string $dateLimite;

    public function __construct(string $dateDepot, float $noteBrute, bool $penaliteAppliquee, string $dateLimite, ?int $id = null) {
        parent::__construct($dateDepot, $id);
        $this->verifierNote($noteBrute);
        $this->noteBrute = $noteBrute;
        $this->penaliteAppliquee = $penaliteAppliquee;
        $this->dateLimite = $dateLimite;
    }

    public function calculerNoteFinale(float $noteFinale): void {
        if ($this->penaliteAppliquee) {
            $this->noteFinale = max(0, $this->noteBrute - 2);
        } else {
            $this->noteFinale = $this->noteBrute;
        }
    }

    public function getNoteBrute(): float {
        return $this->noteBrute;
    }
    public function setNoteBrute(float $noteBrute): void {
        $this->verifierNote($noteBrute);
        $this->noteBrute = $noteBrute;
    }
    public function getNoteFinale(): float {
        return $this->noteFinale;
    }
    public function isPenaliteAppliquee(): bool {
        return $this->penaliteAppliquee;
    }
    public function setPenaliteAppliquee(bool $penaliteAppliquee): void {
        $this->penaliteAppliquee = $penaliteAppliquee;
    }
    private function verifierNote(float $note): void {
        if ($note < 0 || $note > 20) {
            throw new InvalidArgumentException("La note doit être comprise entre 0 et 20.");
        }
    }
}