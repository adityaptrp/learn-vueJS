<?php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\{Controller};
use App\Http\Resources\{NoteResource};
use App\Models\{Note, Subject};
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with('subject')->latest()->get();
        return NoteResource::collection($notes);
    }

    public function show(Subject $subject, Note $note)
    {
        return NoteResource::make($note);
    }

    public function store()
    {
        $this->validateRequest(request());
        $subject = Subject::findOrFail(request('subject_id'));
        $note = Note::create([
            'subject_id' => $subject->id,
            'title' => request('title'),
            'slug' => Str::slug(request('title')),
            'description' => request('description')
        ]);

        return response()->json([
            'message' => 'Your note was created',
            'note' => $note,
        ]);
    }

    public function update(Note $note)
    {
        $this->validateRequest(request());
        $subject = Subject::findOrFail(request('subject_id'));
        $note->update([
            'subject_id' => $subject->id,
            'title' => request('title'),
            'description' => request('description')
        ]);

        return response()->json([
            'message' => 'Your note was updated',
            'note' => $note,
        ]);
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return response()->json([
            'message' => 'Your note was deleted'
        ], 200);
    }

    public function validateRequest(Request $request)
    {
        $request->validate([
            'subject_id' => ['required'],
            'title' => ['required'],
            'description' => ['required'],
        ]);
    }
}
