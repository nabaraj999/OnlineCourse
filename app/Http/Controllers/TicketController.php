<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'issue' => 'required|string',
        ]);

        $ticket = Ticket::create($validatedData);

        return response()->json([
            'message' => 'Ticket submitted successfully!',
            'ticket_id' => $ticket->id,
        ], 201);
    }
}
