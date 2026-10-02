<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MembershipController extends Controller
{
    public function create(): View
    {
        return view('pages.membership', [
            'membershipTypes' => Membership::TYPES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'membership_type' => ['required', Rule::in(array_keys(Membership::TYPES))],
            'expertise' => ['nullable', 'string', 'max:255'],
            'motivation' => ['required', 'string', 'min:20', 'max:3000'],
        ]);

        Membership::create([
            ...$validated,
            'user_id' => $request->user()?->id,
        ]);

        return redirect()
            ->route('membership.create')
            ->with('success', 'Votre demande d’adhésion a bien été enregistrée. L’équipe AfriCode Lab vous recontactera.');
    }
}
