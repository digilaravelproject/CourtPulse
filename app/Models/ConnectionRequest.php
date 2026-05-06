<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectionRequest extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'status', 'notes'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    /**
     * Get the connection status between two users.
     * 
     * @param int $authId
     * @param int $targetId
     * @return string (none, connected, sent, received)
     */
    public static function getStatus(int $authId, int $targetId): string
    {
        $req = self::query()->where(function ($q) use ($authId, $targetId) {
            $q->where('sender_id', $authId)->where('receiver_id', $targetId);
        })->orWhere(function ($q) use ($authId, $targetId) {
            $q->where('sender_id', $targetId)->where('receiver_id', $authId);
        })->first();

        if (! $req) return 'none';
        if ($req->status === 'accepted') return 'connected';
        if ($req->sender_id === $authId) return 'sent';
        return 'received'; // auth user ko request aayi hai
    }

    /**
     * Check if two users are connected.
     * 
     * @param int $authId
     * @param int $targetId
     * @return bool
     */
    public static function areConnected(int $authId, int $targetId): bool
    {
        return self::query()->where('status', 'accepted')
            ->where(function ($q) use ($authId, $targetId) {
                $q->where('sender_id', $authId)->where('receiver_id', $targetId);
            })->orWhere(function ($q) use ($authId, $targetId) {
                $q->where('sender_id', $targetId)->where('receiver_id', $authId);
                $q->where('status', 'accepted');
            })->exists();
    }
}
