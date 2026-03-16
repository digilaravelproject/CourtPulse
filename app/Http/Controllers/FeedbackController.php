<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    private function allowedTargetRoles(string $myRole): array
    {
        return match ($myRole) {
            'advocate' => ['clerk', 'ca'],
            'clerk'    => ['advocate', 'ca'],
            'ca'       => ['advocate', 'clerk'],
            'guest'    => ['advocate', 'clerk'],   // guest sirf advocate + clerk ko feedback de sakta hai
            default    => [],
        };
    }

    public function showPage()
    {
        $user        = auth()->user();
        $role        = $user->role;
        $targetRoles = $this->allowedTargetRoles($role);

        $targets = User::whereIn('role', $targetRoles)
            ->where('status', 'active')
            ->get()
            ->groupBy('role');

        $givenTo = Feedback::where('given_by', $user->id)->pluck('given_to')->toArray();

        $myFeedbacks = Feedback::where('given_by', $user->id)->with('receiver')->latest()->get();
        $received    = Feedback::where('given_to', $user->id)->with('giver')->latest()->get();

        return view('shared.feedback', compact('user', 'role', 'targets', 'givenTo', 'myFeedbacks', 'received'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id'  => 'required|exists:users,id',
            'rating'       => 'required|integer|min:1|max:5',
            'comment'      => 'nullable|string|max:1000',
            'is_anonymous' => 'nullable|boolean',
        ]);

        $me     = auth()->user();
        $target = User::findOrFail($request->receiver_id);

        // Khud ko feedback nahi de sakte
        if ($target->id === $me->id) {
            return back()->with('error', 'Aap khud ko feedback nahi de sakte.');
        }

        // Role check
        $allowed = $this->allowedTargetRoles($me->role);
        if (!in_array($target->role, $allowed)) {
            return back()->with('error', "Aap {$target->role} ko feedback nahi de sakte.");
        }

        // Duplicate check
        $exists = Feedback::where('given_by', $me->id)->where('given_to', $target->id)->exists();
        if ($exists) {
            return back()->with('error', 'Aap pehle hi is user ko feedback de chuke hain.');
        }

        Feedback::create([
            'given_by'      => $me->id,
            'given_to'      => $target->id,
            'role_type'     => $target->role,
            'rating'        => $request->rating,
            'comment'       => $request->comment,
            'is_compulsory' => ($me->role === 'clerk'),
            'is_anonymous'  => $request->boolean('is_anonymous'),
        ]);

        return back()->with('success', "✓ {$target->name} ko feedback diya! Ab unke details unlock ho gaye.");
    }

    public function userDetail(User $user)
    {
        $me      = auth()->user();
        $allowed = $this->allowedTargetRoles($me->role);

        if (!in_array($user->role, $allowed) || $user->status !== 'active') {
            abort(403);
        }

        $gaveFeedback = Feedback::where('given_by', $me->id)->where('given_to', $user->id)->exists();

        $profile = match ($user->role) {
            'advocate' => $user->advocateProfile,
            'clerk'    => $user->clerkProfile,
            'ca'       => $user->caProfile,
            default    => null,
        };

        $feedbacksReceived = Feedback::where('given_to', $user->id)->with('giver')->latest()->get();
        $avgRating         = $feedbacksReceived->avg('rating');

        return view('shared.user-detail', compact(
            'user',
            'profile',
            'gaveFeedback',
            'feedbacksReceived',
            'avgRating',
            'me'
        ));
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return back()->with('success', 'Feedback deleted.');
    }

    public static function clerkHasFeedback(int $clerkId): bool
    {
        return Feedback::where('given_by', $clerkId)->exists();
    }
}
