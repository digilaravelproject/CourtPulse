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
    public function send(Request $request)
    {
        $sender   = auth()->user();
        $receiver = User::findOrFail($request->receiver_id);

        $alreadyExists = ConnectionRequest::where(function ($q) use ($sender, $receiver) {
            $q->where('sender_id', $sender->id)->where('receiver_id', $receiver->id);
        })->orWhere(function ($q) use ($sender, $receiver) {
            $q->where('sender_id', $receiver->id)->where('receiver_id', $sender->id);
        })->exists();

        if ($alreadyExists) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Request already sent or connected.'], 400);
            }
            return back()->with('info', 'Request already sent or already connected.');
        }

        ConnectionRequest::create([
            'sender_id'   => $sender->id,
            'receiver_id' => $receiver->id,
            'status'      => 'pending',
        ]);

        Mail::to($receiver->email)->send(new ConnectionRequestSent($sender, $receiver));

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Connection request sent successfully!', 'status' => 'sent']);
        }
        return back()->with('success', 'Connection request bhej diya gaya!');
    }

    public function accept(ConnectionRequest $connectionRequest)
    {
        $acceptor  = auth()->user();
        $requester = $connectionRequest->sender;

        abort_unless($connectionRequest->receiver_id === $acceptor->id, 403);

        $connectionRequest->update(['status' => 'accepted']);

        Mail::to($requester->email)->send(new ConnectionRequestAccepted($acceptor, $requester));

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['message' => 'Connection accepted!', 'status' => 'connected']);
        }
        return back()->with('success', 'Connection request accept ho gayi!');
    }

    public function reject(ConnectionRequest $connectionRequest)
    {
        abort_unless(
            $connectionRequest->receiver_id === auth()->id() ||
                $connectionRequest->sender_id   === auth()->id(),
            403
        );

        $connectionRequest->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['message' => 'Connection rejected.', 'status' => 'rejected']);
        }
        return back()->with('success', 'Connection request remove ho gayi.');
    }

    public function myConnections()
    {
        $authId = auth()->id();
        $user   = auth()->user();

        $connected = ConnectionRequest::where('status', 'accepted')
            ->where(function ($q) use ($authId) {
                $q->where('sender_id', $authId)->orWhere('receiver_id', $authId);
            })
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->map(fn($r) => $r->sender_id === $authId ? $r->receiver : $r->sender);

        $pendingReceived = ConnectionRequest::where('receiver_id', $authId)
            ->where('status', 'pending')
            ->with('sender')
            ->latest()
            ->get();

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
