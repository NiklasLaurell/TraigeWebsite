<?php

namespace App\Actions;

use App\Models\Visit;
use App\Models\VisitMeasurementDecision;

class GenerateVisitMeasurementDecision
{
    public function __invoke(Visit $visit, string $decisionType): VisitMeasurementDecision
    {
        $measurementAffectsTcProbability = 0.5000;
        $shouldMeasure = $measurementAffectsTcProbability >= 0.5000;

        return $visit->measurementDecisions()->create([
            'decision_type' => $decisionType,
            'measurement_affects_tc_probability' => $measurementAffectsTcProbability,
            'should_measure' => $shouldMeasure,
            'model_name' => 'measurement_decision_model_placeholder',
            'model_version' => 'v0',
            'input_snapshot' => [
                'ess_code' => (int) $visit->ess_code,
                'age' => (int) $visit->age,
                'gender' => $visit->gender,
                'arrival_with_ambulance' => (bool) $visit->arrival_with_ambulance,
                'decision_type' => $decisionType,
            ],
        ]);
    }
}
