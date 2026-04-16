<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectionRequest extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'status'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    public static function getStatus(int $authId, int $targetId): string
    {
        $req = static::where(function ($q) use ($authId, $targetId) {
            $q->where('sender_id', $authId)->where('receiver_id', $targetId);
        })->orWhere(function ($q) use ($authId, $targetId) {
            $q->where('sender_id', $targetId)->where('receiver_id', $authId);
        })->first();

        if (! $req) return 'none';
        if ($req->status === 'accepted') return 'connected';
        if ($req->sender_id === $authId) return 'sent';
        return 'received'; // auth user ko request aayi hai
    }

    public static function areConnected(int $authId, int $targetId): bool
    {
        return static::where('status', 'accepted')
            ->where(function ($q) use ($authId, $targetId) {
                $q->where('sender_id', $authId)->where('receiver_id', $targetId);
            })->orWhere(function ($q) use ($authId, $targetId) {
                $q->where('sender_id', $targetId)->where('receiver_id', $authId);
                $q->where('status', 'accepted');
            })->exists();
    }
}
