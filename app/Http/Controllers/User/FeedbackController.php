<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    private function allowedTargetRoles(string $myRole): array
    {
        return match ($myRole) {
            'advocate' => ['clerk', 'ca'],
            'clerk'    => ['advocate', 'ca'],
            'ca'       => ['advocate', 'clerk'],
            'guest'    => ['advocate', 'clerk'],
            default    => [],
        };
    }

    public function showPage()
    {
        try {
            $user        = Auth::user();
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
        } catch (\Exception $e) {
            Log::error('Feedback Page Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load feedback page.']);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'receiver_id'  => 'required|exists:users,id',
                'rating'       => 'required|integer|min:1|max:5',
                'comment'      => 'nullable|string|max:1000',
                'is_anonymous' => 'nullable|boolean',
            ]);

            $me     = Auth::user();
            $target = User::findOrFail($request->receiver_id);

            if ($target->id === $me->id) {
                return back()->with('error', 'You cannot give feedback to yourself.');
            }

            $allowed = $this->allowedTargetRoles($me->role);
            if (!in_array($target->role, $allowed)) {
                return back()->with('error', "You cannot give feedback to a {$target->role}.");
            }

            $exists = Feedback::where('given_by', $me->id)->where('given_to', $target->id)->exists();
            if ($exists) {
                return back()->with('error', 'You have already given feedback to this user.');
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

            return back()->with('success', "Feedback submitted successfully for {$target->name}!");
        } catch (\Exception $e) {
            Log::error('Feedback Store Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to submit feedback.']);
        }
    }

    public function userDetail(User $user)
    {
        try {
            $me = Auth::user();
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
        } catch (\Exception $e) {
            Log::error('Feedback User Detail Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to load details.']);
        }
    }

    public function destroy(Feedback $feedback)
    {
        try {
            if ($feedback->given_by !== Auth::id() && !Auth::user()->hasRole('admin')) {
                abort(403);
            }
            $feedback->delete();
            return back()->with('success', 'Feedback deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Feedback Delete Error: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Failed to delete feedback.']);
        }
    }

    public static function clerkHasFeedback(int $clerkId): bool
    {
        return Feedback::where('given_by', $clerkId)->exists();
    }
}
