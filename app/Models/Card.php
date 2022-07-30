<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'description', 'order', 'column_id',
    ];

    public function scopeFilter(Builder $query, array $filters) {
        $query->when($filters['date'] ?? null, function (Builder $query, $date) {
            $query->whereDate('created_at', '=', $date);
        });

        match ($filters['status'] ?? null) {
            '0' => $query->onlyTrashed(),
            '1' => $query->withoutTrashed(),
            default => $query->withTrashed(),
        };
    }
}
