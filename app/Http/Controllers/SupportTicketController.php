<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Operator;

class SupportTicketController extends Controller
{
    public function store(Request $request)
    {
        logger('ticket.store function entered');
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'operator_id' => 'required|string|max:255',
        ]);

        $validated['client_id'] = session('client_id');
        $validated['status'] = 'open';
        logger('supportTicket' . json_encode($validated));
        SupportTicket::create($validated);
        return back()->with([
            'success' => true,
            'message' => 'Client request submitted successfully!',
        ]);
    }
    public function create(Request $request)
    {
        $operators = Operator::all();
        $messages = SupportTicket::where('client_id', session('client_id'))->get();
        logger('operators. ' . $operators);
        return view('tickets.create', compact('operators', 'messages'));
    }
    public function showAll(Request $request, $operator_id)
    {
        logger('ticket.showAll function entered');

        $tickets = SupportTicket::where('operator_id', $operator_id)->get();
        return view('tickets.index', compact('tickets'));
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Requests fetched successfully.',
        //     'data' => $tickets,
        // ]);
    }

    public function getOperators()
    {
        $operators = User::where('role', 'operator')->get();
        return response()->json($operators);
    }

    public function index()
    {
        $tickets = SupportTicket::where('client_id', session('client_id'))->get();
        return view('client.tickets.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = SupportTicket::findOrFail($id);
        return view('client.tickets.show', compact('ticket'));
    }
}
