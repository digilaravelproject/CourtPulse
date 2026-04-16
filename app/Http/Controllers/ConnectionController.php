<?php

namespace App\Http\Controllers;

use App\Models\ConnectionRequest;
use App\Models\User;
use App\Mail\ConnectionRequestSent;
use App\Mail\ConnectionRequestAccepted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ConnectionController extends Controller
{
    // ── Send Connection Request ───────────────────────────────────────────
    // public function send(Request $request)
    // {
    //     $request->validate(['receiver_id' => 'required|exists:users,id']);

    //     $authId     = auth()->id();
    //     $receiverId = $request->receiver_id;

    //     if ($authId === $receiverId) {
    //         return response()->json(['message' => 'Cannot connect with yourself.'], 422);
    //     }

    //     // Already exists check
    //     $existing = ConnectionRequest::where(function ($q) use ($authId, $receiverId) {
    //         $q->where('sender_id', $authId)->where('receiver_id', $receiverId);
    //     })->orWhere(function ($q) use ($authId, $receiverId) {
    //         $q->where('sender_id', $receiverId)->where('receiver_id', $authId);
    //     })->first();

    //     if ($existing) {
    //         return response()->json([
    //             'message' => 'Request already exists.',
    //             'status'  => $existing->status,
    //         ], 422);
    //     }

    //     ConnectionRequest::create([
    //         'sender_id'   => $authId,
    //         'receiver_id' => $receiverId,
    //         'status'      => 'pending',
    //     ]);

    //     return response()->json(['message' => 'Connection request sent!', 'status' => 'sent']);
    // }

    // // ── Accept Request ────────────────────────────────────────────────────
    // public function accept(ConnectionRequest $connectionRequest)
    // {
    //     // Sirf receiver hi accept kar sakta hai
    //     abort_unless($connectionRequest->receiver_id === auth()->id(), 403);

    //     $connectionRequest->update(['status' => 'accepted']);

    //     if (request()->ajax()) {
    //         return response()->json(['message' => 'Connection accepted!', 'status' => 'connected']);
    //     }

    //     return back()->with('success', 'Connection accepted!');
    // }

    // // ── Reject Request ────────────────────────────────────────────────────
    // public function reject(ConnectionRequest $connectionRequest)
    // {
    //     abort_unless($connectionRequest->receiver_id === auth()->id(), 403);

    //     $connectionRequest->update(['status' => 'rejected']);

    //     if (request()->ajax()) {
    //         return response()->json(['message' => 'Connection rejected.', 'status' => 'rejected']);
    //     }

    //     return back()->with('success', 'Connection rejected.');
    // }

    public function send(Request $request)
    {
        $sender   = auth()->user();
        $receiver = User::findOrFail($request->receiver_id);

        // Pehle se request exist karta hai to dobara mat bhejo
        $alreadyExists = ConnectionRequest::where(function ($q) use ($sender, $receiver) {
            $q->where('sender_id', $sender->id)->where('receiver_id', $receiver->id);
        })->orWhere(function ($q) use ($sender, $receiver) {
            $q->where('sender_id', $receiver->id)->where('receiver_id', $sender->id);
        })->exists();

        if ($alreadyExists) {
            return back()->with('info', 'Request already sent or already connected.');
        }

        // DB mein save karo
        ConnectionRequest::create([
            'sender_id'   => $sender->id,
            'receiver_id' => $receiver->id,
            'status'      => 'pending',
        ]);

        // ✅ Receiver ko mail bhejo
        Mail::to($receiver->email)->send(new ConnectionRequestSent($sender, $receiver));

        return back()->with('success', 'Connection request bhej diya gaya!');
    }

    /**
     * Request accept karne par — original sender ko mail jata hai
     */
    public function accept(ConnectionRequest $connectionRequest)
    {
        $acceptor  = auth()->user();  // jisne accept kiya
        $requester = $connectionRequest->sender; // jisne request bheja tha

        // Sirf receiver hi accept kar sakta hai
        abort_unless($connectionRequest->receiver_id === $acceptor->id, 403);

        $connectionRequest->update(['status' => 'accepted']);

        // ✅ Original sender (requester) ko mail bhejo
        Mail::to($requester->email)->send(new ConnectionRequestAccepted($acceptor, $requester));

        return back()->with('success', 'Connection request accept ho gayi!');
    }

    /**
     * Request reject / withdraw karo (mail nahi jata)
     */
    public function reject(ConnectionRequest $connectionRequest)
    {
        abort_unless(
            $connectionRequest->receiver_id === auth()->id() ||
                $connectionRequest->sender_id   === auth()->id(),
            403
        );

        $connectionRequest->delete();

        return back()->with('success', 'Connection request remove ho gayi.');
    }

    // ── My Connections & Pending Requests ─────────────────────────────────
    public function myConnections()
    {
        $authId = auth()->id();
        $user   = auth()->user();

        // Connected users
        $connected = ConnectionRequest::where('status', 'accepted')
            ->where(function ($q) use ($authId) {
                $q->where('sender_id', $authId)->orWhere('receiver_id', $authId);
            })
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->map(fn($r) => $r->sender_id === $authId ? $r->receiver : $r->sender);

        // Pending requests received
        $pendingReceived = ConnectionRequest::where('receiver_id', $authId)
            ->where('status', 'pending')
            ->with('sender')
            ->latest()
            ->get();

        // Pending requests sent
        $pendingSent = ConnectionRequest::where('sender_id', $authId)
            ->where('status', 'pending')
            ->with('receiver')
            ->latest()
            ->get();

        $layout = match (true) {
            $user->hasRole('advocate') => 'layouts.advocate',
            $user->hasRole('clerk')    => 'layouts.clerk',
            default                    => 'layouts.guest',
        };

        return view('connections.index', compact(
            'connected',
            'pendingReceived',
            'pendingSent',
            'layout'
        ));
    }
}
