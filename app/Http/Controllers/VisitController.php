<?php

namespace App\Http\Controllers;

use App\Actions\GenerateVisitMeasurementDecision;
use App\Actions\GenerateVisitTriagePrediction;
use App\Models\Visit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class VisitController extends Controller
{
	public function index(): Response
	{
		$visits = Visit::query()
			->latest('created_at')
			->get()
			->map(fn (Visit $visit): array => [
				'id' => $visit->id,
				'patient_name' => $visit->patient_name,
				'age' => $visit->age,
				'gender' => $visit->gender,
				'arrival_with_ambulance' => $visit->arrival_with_ambulance,
				'ess_code' => $visit->ess_code,
				'current_queue_priority' => $visit->current_queue_priority,
				'created_at' => $visit->created_at?->toDateTimeString(),
			]);

		return Inertia::render('Visits/AllVisits', [
			'visits' => $visits,
		]);
	}

	public function store(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'patient_name' => ['required', 'string', 'max:255'],
			'age' => ['required', 'integer', 'min:0', 'max:255'],
			'gender' => ['required', 'in:male,female'],
			'arrival_with_ambulance' => ['required', 'boolean'],
			'ess_code' => ['required', 'integer', 'min:0', 'max:255'],
		]);

		$visit = Visit::create($validated);

		return redirect()
			->route('visits.priority.edit', $visit)
			->with('success', 'Visit created. Generate prediction, then set final queue priority.');
	}

	public function generateMeasurementDecision(
		Request $request,
		Visit $visit,
		GenerateVisitMeasurementDecision $generateVisitMeasurementDecision,
	): RedirectResponse
	{
		$validated = $request->validate([
			'decision_type' => ['required', 'in:vp,bg'],
		]);

		$generateVisitMeasurementDecision($visit, $validated['decision_type']);

		return redirect()
			->route('visits.priority.edit', $visit)
			->with('success', 'Measurement decision generated.');
	}

	public function generateTriagePrediction(
		Request $request,
		Visit $visit,
		GenerateVisitTriagePrediction $generateVisitTriagePrediction,
	): RedirectResponse
	{
		$validated = $request->validate([
			'stage' => ['nullable', 'in:initial,post_measurement'],
		]);

		$stage = $validated['stage'] ?? 'initial';

		$generateVisitTriagePrediction($visit, $stage);

		return redirect()
			->route('visits.priority.edit', $visit)
			->with('success', 'Triage prediction generated. Set final queue priority.');
	}

	public function editPriority(Visit $visit): Response
	{
		$latestPrediction = $visit->predictions()
			->latest('created_at')
			->first();

		$latestVpDecision = $visit->measurementDecisions()
			->where('decision_type', 'vp')
			->latest('created_at')
			->first();

		$latestBgDecision = $visit->measurementDecisions()
			->where('decision_type', 'bg')
			->latest('created_at')
			->first();

		return Inertia::render('Visits/SetPriority', [
			'visit' => [
				'id' => $visit->id,
				'patient_name' => $visit->patient_name,
				'age' => $visit->age,
				'gender' => $visit->gender,
				'arrival_with_ambulance' => $visit->arrival_with_ambulance,
				'ess_code' => $visit->ess_code,
				'current_queue_priority' => $visit->current_queue_priority,
			],
			'recommendation' => $latestPrediction ? [
				'stage' => $latestPrediction->stage,
				'predicted_priority' => $latestPrediction->predicted_priority,
				'tc_probability' => $latestPrediction->tc_probability,
				'model_name' => $latestPrediction->model_name,
				'model_version' => $latestPrediction->model_version,
			] : null,
			'measurement_decisions' => [
				'vp' => $latestVpDecision ? [
					'measurement_affects_tc_probability' => $latestVpDecision->measurement_affects_tc_probability,
					'should_measure' => $latestVpDecision->should_measure,
				] : null,
				'bg' => $latestBgDecision ? [
					'measurement_affects_tc_probability' => $latestBgDecision->measurement_affects_tc_probability,
					'should_measure' => $latestBgDecision->should_measure,
				] : null,
			],
		]);
	}

	public function updatePriority(Request $request, Visit $visit): RedirectResponse
	{
		$validated = $request->validate([
			'current_queue_priority' => ['required', 'integer', 'between:1,5'],
		]);

		$visit->update([
			'current_queue_priority' => $validated['current_queue_priority'],
			'priority_updated_at' => now(),
		]);

		return redirect()
			->route('visits.index')
			->with('success', 'Queue priority saved.');
	}
}
