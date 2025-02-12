<?php

namespace App\Models;

use App\DelegateAbcence\DelegateAbsence;
use App\Office\Office;
use App\Product\FoodType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delegate extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name',
        'benefits',
        'institution',
        'rank',
        'food_type_id',
        'office_id',
        'phone',
        'address',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function dryFoodReports()
    {
        return $this->hasMany(DryFoodReport::class);
    }

    public function rejects()
    {
        return view('papers.delegate-do-not-want');
    }

    public function delegateAbsences()
    {
        return $this->hasMany(DelegateAbsence::class);
    }

    public function foodType()
    {
        return $this->belongsTo(FoodType::class);
    }

    public function histories()
    {
        return $this->hasMany(DelegateHistory::class);
    }

    public function delegateFromHistory($date)
    {
        $delegate = DelegateHistory::where('delegate_id', $this->id)
            ->where('affected_at', '<=', $date)
            ->where(function ($query) use ($date) {
                $query->where('terminated_at', '>=', $date)
                    ->orWhereNull('terminated_at');
            })
            ->orderBy('affected_at', 'desc')
            ->first();
        // making the id from the delegate_histories.id to be from the delegates.id

        if ($delegate) {
            $delegate->id = $this->id;
           
        }

        return $delegate ?: $this;
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($delegate) {

            $lastEdition = DelegateHistory::where('delegate_id', $delegate->id)
                ->orderBy('affected_at', 'desc')
                ->first();

            if (!$lastEdition) {
                // create the old one
                DelegateHistory::create([
                    'delegate_id' => $delegate->id,
                    'number' => $delegate->getOriginal('number'),
                    'name' => $delegate->getOriginal('name'),
                    'benefits' => $delegate->getOriginal('benefits'),
                    'institution' => $delegate->getOriginal('institution'),
                    'rank' => $delegate->getOriginal('rank'),
                    'food_type_id' => $delegate->getOriginal('food_type_id'),
                    'office_id' => $delegate->getOriginal('office_id'),
                    'phone' => $delegate->getOriginal('phone'),
                    'address' => $delegate->getOriginal('address'),
                    'start_date' => $delegate->getOriginal('start_date'),
                    'end_date' => $delegate->getOriginal('end_date'),
                    'is_active' => $delegate->getOriginal('is_active'),
                    'affected_at' => $delegate->getOriginal('created_at'),
                    'terminated_at' => now()->format('Y-m-d'),
                ]);
                // create the current one
                DelegateHistory::create([
                    'delegate_id' => $delegate->id,
                    'number' => $delegate->number,
                    'name' => $delegate->name,
                    'benefits' => $delegate->benefits,
                    'institution' => $delegate->institution,
                    'rank' => $delegate->rank,
                    'food_type_id' => $delegate->food_type_id,
                    'office_id' => $delegate->office_id,
                    'phone' => $delegate->phone,
                    'address' => $delegate->address,
                    'start_date' => $delegate->start_date,
                    'end_date' => $delegate->end_date,
                    'is_active' => $delegate->is_active,
                    'affected_at' => now()->format('Y-m-d'),
                    'terminated_at' => null,
                ]);
            } else {

                if ($lastEdition->affected_at == now()->format('Y-m-d')) {
                    $lastEdition->update([
                        'number' => $delegate->number,
                        'name' => $delegate->name,
                        'benefits' => $delegate->benefits,
                        'institution' => $delegate->institution,
                        'rank' => $delegate->rank,
                        'food_type_id' => $delegate->food_type_id,
                        'office_id' => $delegate->office_id,
                        'phone' => $delegate->phone,
                        'address' => $delegate->address,
                        'start_date' => $delegate->start_date,
                        'end_date' => $delegate->end_date,
                        'is_active' => $delegate->is_active,
                    ]);
                } else {
                    $lastEdition->update([
                        'terminated_at' => now()->format('Y-m-d'),
                    ]);
                    DelegateHistory::create([
                        'delegate_id' => $delegate->id,
                        'number' => $delegate->getOriginal('number'),
                        'name' => $delegate->getOriginal('name'),
                        'benefits' => $delegate->getOriginal('benefits'),
                        'institution' => $delegate->getOriginal('institution'),
                        'rank' => $delegate->getOriginal('rank'),
                        'food_type_id' => $delegate->getOriginal('food_type_id'),
                        'office_id' => $delegate->getOriginal('office_id'),
                        'phone' => $delegate->getOriginal('phone'),
                        'address' => $delegate->getOriginal('address'),
                        'start_date' => $delegate->getOriginal('start_date'),
                        'end_date' => $delegate->getOriginal('end_date'),
                        'is_active' => $delegate->getOriginal('is_active'),
                        'affected_at' => now()->format('Y-m-d'),
                        'terminated_at' => null,
                    ]);
                }
            }
        });


    }
}
