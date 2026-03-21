<?php

namespace App\Http\Controllers;
 
use App\Models\SupportTicket;
use App\Models\SupportMessage;
use Illuminate\Http\Request;
use App\Notifications\Support\NewMessageReceived;
use Illuminate\Support\Facades\Auth;
 
class AdminSupportController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::with('user')->latest('last_message_at')->get();
        return view('admin.support.index', compact('tickets'));
    }

    public function show(SupportTicket $ticket)
    {
        $messages = $ticket->messages()->with('user')->oldest()->get();
        return view('admin.support.show', compact('ticket', 'messages'));
    }

    public function message(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = $ticket->messages()->create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_admin' => true,
        ]);
 
        $ticket->update([
            'last_message_at' => now(),
            'status' => 'in_progress'
        ]);
 
        // Notify User
        $ticket->user->notify(new NewMessageReceived($message));
 
        return back()->with('success', 'Response sent.');
    }

    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $ticket->update(['status' => $request->status]);

        return back()->with('success', 'Ticket status updated.');
    }
}
