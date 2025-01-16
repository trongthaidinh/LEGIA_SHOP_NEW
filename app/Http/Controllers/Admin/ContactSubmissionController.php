<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'new');
        
        $submissions = ContactSubmission::when($status !== 'all', function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);
            
        return view('admin.contact-submissions.index', compact('submissions', 'status'));
    }

    public function show(ContactSubmission $submission)
    {
        if ($submission->status === 'new') {
            $submission->markAsRead();
        }
        
        return view('admin.contact-submissions.show', compact('submission'));
    }

    public function markAsReplied(ContactSubmission $submission)
    {
        $submission->markAsReplied();
        
        return redirect()
            ->route(app()->getLocale() . '.admin.contact-submissions.index')
            ->with('success', __('Contact submission marked as replied'));
    }

    public function destroy(ContactSubmission $submission)
    {
        $submission->delete();
        
        return redirect()
            ->route(app()->getLocale() . '.admin.contact-submissions.index')
            ->with('success', __('Contact submission deleted successfully'));
    }
} 