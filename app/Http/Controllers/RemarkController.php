<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class RemarkController extends Controller
{
    //
    public function store(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'content' => ['required', 'string']
        ]);

        $remark = $ticket->remarks()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content']
        ]);

        return back()->with('success', 'Remark added successfully.');
    }
}
