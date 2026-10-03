<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\QueryReply;
use App\Models\ContactQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactQueryController extends Controller
{
    public function index(Request $request)
    {
        $builder = ContactQuery::query();

        // Optional search
        if ($request->filled('q')) {
            $search = $request->q;
            $builder->where(
                fn($q) => $q
                    ->where('name',   'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
            );
        }

        $queries = $builder
            ->orderByRaw("
                CASE WHEN status='unread' THEN 0
                     WHEN status='read'   THEN 1
                     WHEN status='solved' THEN 2 END
            ")
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->appends(['q' => $request->q]);

        return view('admin.contact-queries.index', compact('queries'));
    }

    public function show(ContactQuery $query)
    {
        // Mark as read on view
        if ($query->status === 'unread') {
            $query->update(['status' => 'read']);
        }

        return view('admin.contact-queries.show', compact('query'));
    }

    public function reply(Request $request, ContactQuery $query)
    {
        $data = $request->validate([
            'reply_message' => 'required|string',
        ]);

        // Send reply email
        Mail::to($query->email)
            ->send(new QueryReply($query, $data['reply_message']));

        // Mark solved
        $query->update(['status' => 'solved']);

        return redirect()
            ->route('contact-queries.index')
            ->with('status', 'Reply sent & query marked as solved.');
    }

    public function destroy(ContactQuery $query)
    {
        $query->delete();

        return redirect()
            ->route('contact-queries.index')
            ->with('status', 'Query deleted successfully.');
    }
}
