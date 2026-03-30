<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visit extends Model
{
    use HasFactory, HasUuids;

    /**
     * The primary key type.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'patient_name',
        'age',
        'gender',
        'arrival_with_ambulance',
        'ess_code',
        'current_queue_priority',
        'priority_updated_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'patient_name' => 'string',
            'age' => 'integer',
            'gender' => 'string',
            'arrival_with_ambulance' => 'boolean',
            'ess_code' => 'integer',
            'current_queue_priority' => 'integer',
            'priority_updated_at' => 'datetime',
        ];
    }

    public function predictions(): HasMany
    {
        return $this->hasMany(VisitPrediction::class);
    }

    public function measurementDecisions(): HasMany
    {
        return $this->hasMany(VisitMeasurementDecision::class);
    }
}
