<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReminderController extends Controller
{
    /**
     * Display a listing of the reminders for a quiz.
     *
     * @param  int  $quizId
     * @return \Illuminate\Http\Response
     */
    public function index($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $reminders = Reminder::where('quiz_id', $quizId)
            ->orderBy('min_score', 'asc')
            ->get();
        
        return view('admin.reminders.index', compact('quiz', 'reminders'));
    }

    /**
     * Show the form for creating a new reminder.
     *
     * @param  int  $quizId
     * @return \Illuminate\Http\Response
     */
    public function create($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        return view('admin.reminders.create', compact('quiz'));
    }

    /**
     * Store a newly created reminder in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quiz_id' => 'required|exists:quizzes,id',
            'min_score' => 'required|numeric|min:0',
            'max_score' => 'required|numeric|gte:min_score',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'type' => 'required|string|in:event,all-day,recurring',
            'color' => 'nullable|string|max:7',
            // 'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ]);
        }

        $data = $request->all();
        
        // Handle boolean values
        $data['is_active'] = $request->has('is_active') ? true : false;
        
        // Handle recurrence data if present
        if ($request->type === 'recurring' && $request->has('recurrence')) {
            $data['recurrence_data'] = $request->recurrence;
        }
        
        // Handle extra data if present
        if ($request->has('extra')) {
            $data['extra_data'] = $request->extra;
        }

        // Create or update reminder
        if ($request->id) {
            $reminder = Reminder::findOrFail($request->id);
            $reminder->update($data);
            $message = 'Reminder updated successfully';
        } else {
            $reminder = Reminder::create($data);
            $message = 'Reminder created successfully';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $reminder,
            'redirect' => route('reminders.index', $request->quiz_id)
        ]);
    }

    /**
     * Show the form for editing the specified reminder.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reminder = Reminder::findOrFail($id);
        $quiz = $reminder->quiz;
        
        return view('admin.reminders.edit', compact('reminder', 'quiz'));
    }

    /**
     * Remove the specified reminder from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reminder = Reminder::findOrFail($id);
        $quizId = $reminder->quiz_id;
        $reminder->delete();

        return response()->json([
            'status' => true,
            'message' => 'Reminder deleted successfully',
            'redirect' => route('reminders.index', $quizId)
        ]);
    }
}