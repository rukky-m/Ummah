<?php

namespace App\Http\Controllers;
 
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use Illuminate\Http\Request;
use App\Notifications\Support\TicketOpened;
use App\Notifications\Support\NewMessageReceived;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
 
class SupportController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $tickets = $user->tickets()->latest('last_message_at')->get();
        return view('support.index', compact('tickets'));
    }

    public function create()
    {
        return view('support.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);
 
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $ticket = $user->tickets()->create([
            'subject' => $request->subject,
            'priority' => $request->priority,
            'status' => 'open',
            'last_message_at' => now(),
        ]);

        $ticket->messages()->create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_admin' => false,
        ]);
 
        // Notify Admins
        $admins = \App\Models\User::whereHas('roles', function($q) {
            $q->whereIn('name', ['admin', 'staff']);
        })->get();
        Notification::send($admins, new TicketOpened($ticket));
 
        return redirect()->route('support.show', $ticket)->with('success', 'Support ticket created successfully.');
    }

    public function show(SupportTicket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $messages = $ticket->messages()->oldest()->get();
        return view('support.show', compact('ticket', 'messages'));
    }

    public function message(Request $request, SupportTicket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        $message = $ticket->messages()->create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_admin' => false,
        ]);
 
        $ticket->update(['last_message_at' => now()]);
 
        // Notify Admins
        $admins = \App\Models\User::whereHas('roles', function($q) {
            $q->whereIn('name', ['admin', 'staff']);
        })->get();
        Notification::send($admins, new NewMessageReceived($message));
 
        return back()->with('success', 'Message sent.');
    }
}
