<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Membership extends Model
{
    public const TYPES = [
        'member' => 'Membre',
        'volunteer' => 'Bénévole',
        'professional' => 'Professionnel du numérique',
        'partner' => 'Partenaire',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'membership_type',
        'expertise',
        'motivation',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
