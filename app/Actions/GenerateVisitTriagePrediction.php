<?php

namespace App\Actions;

use App\Models\Visit;
use App\Models\VisitPrediction;

class GenerateVisitTriagePrediction
{
    public function __invoke(Visit $visit, string $stage = 'initial'): VisitPrediction
    {
        $predictedPriority = min(max((int) $visit->ess_code, 1), 5);
        $tcProbability = 0.5000;

        return $visit->predictions()->create([
            'stage' => $stage,
            'predicted_priority' => $predictedPriority,
            'tc_probability' => $tcProbability,
            'model_name' => 'triage_model_placeholder',
            'model_version' => 'v0',
            'input_snapshot' => [
                'ess_code' => (int) $visit->ess_code,
                'age' => (int) $visit->age,
                'gender' => $visit->gender,
                'arrival_with_ambulance' => (bool) $visit->arrival_with_ambulance,
            ],
        ]);
    }
}
