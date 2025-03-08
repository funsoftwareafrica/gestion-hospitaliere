<?php

namespace App\Service;

use App\Entity\Urgence;

class TriService
{
    public function attribuerGravite(Urgence $urgence): int
    {
        // Logique de tri simple basée sur le motif
        $motif = strtolower($urgence->getMotif());

        if (strpos($motif, 'vitale') !== false) {
            return 1; // Priorité maximale
        } elseif (strpos($motif, 'grave') !== false) {
            return 2; // Priorité moyenne
        } else {
            return 3; // Priorité faible
        }
    }
}
