<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class CommunicationController extends Controller
{
    public static function getId()
    {
        return  session('userId');
    }

    public function index()
    {
        $userId = $this->getId();

        // Fetch messages where the user is either the sender or receiver
        $communications = Communication::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get();

        $users = User::all();

        return view('communications.index', compact('communications', 'users'));
    }

    public function store(Request $request)
    {
        logger('store:');
        $validated = $request->validate([
            'receiver_id' => 'required',
            'message' => 'required|string|max:1000',
            // 'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);
        // $attachmentPath = null;
        // if ($request->hasFile('attachment')) {
        //     $attachmentPath = $request->file('attachment')->store('attachments');
        // }
        $message = Communication::create([
            'sender_id' => $this->getId(),
            'receiver_id' => $request->receiver_id,
            'project_id' => $request->project_id,
            'message' => $request->message,
            // 'attachment' => $attachmentPath,
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => $message->load('sender')]);
        }
        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    public function list($userId)
    {
        $chatters = User::whereIn('id', function ($query) use ($userId) {
            $query->select('sender_id')
                ->from('communications')
                ->where('receiver_id', $userId);
        })->orWhereIn('id', function ($query) use ($userId) {
            $query->select('receiver_id')
                ->from('communications')
                ->where('sender_id', $userId);
        })->get();
        return view('communications.list', compact('chatters'));
    }

    public function fetchMessages($receiverId)
    {
        $userId = session('userId');
        // logger('fetchMessage:');
        $messages = Communication::where(function ($query) use ($userId, $receiverId) {
            $query->where('sender_id', $userId)->where('receiver_id', $receiverId);
            logger('query' . $query->toSql());
        })->orWhere(function ($query) use ($userId, $receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $userId);
        })
            ->with('sender:id,name') // Include sender information
            ->orderBy('created_at', 'asc')
            ->get();
        // $currentUser = User::where('id', $userId)->first();
        // $messages->currentUserName = $currentUser->name;
        // logger('messages->currentUsername: ' . );
        return response()->json($messages);
    }
}
