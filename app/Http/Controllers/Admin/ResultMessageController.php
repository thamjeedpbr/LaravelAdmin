<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ResultMessage;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResultMessageController extends Controller
{
    /**
     * Display a listing of the result messages for a quiz.
     *
     * @param  int  $quizId
     * @return \Illuminate\Http\Response
     */
    public function index($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $resultMessages = ResultMessage::where('quiz_id', $quizId)
            ->orderBy('min_score', 'asc')
            ->get();
        
        return view('admin.result_messages.index', compact('quiz', 'resultMessages'));
    }

    /**
     * Show the form for creating a new result message.
     *
     * @param  int  $quizId
     * @return \Illuminate\Http\Response
     */
    public function create($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        return view('admin.result_messages.create', compact('quiz'));
    }

    /**
     * Store a newly created result message in storage.
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
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ]);
        }

        // Check for overlapping score ranges
        $overlapping = ResultMessage::where('quiz_id', $request->quiz_id)
            ->where(function($query) use ($request) {
                $query->whereBetween('min_score', [$request->min_score, $request->max_score])
                    ->orWhereBetween('max_score', [$request->min_score, $request->max_score])
                    ->orWhere(function($q) use ($request) {
                        $q->where('min_score', '<=', $request->min_score)
                          ->where('max_score', '>=', $request->max_score);
                    });
            });
            
        if ($request->id) {
            $overlapping = $overlapping->where('id', '!=', $request->id);
        }
        
        $overlapping = $overlapping->first();
        
        if ($overlapping) {
            return response()->json([
                'status' => false,
                'message' => 'Score range overlaps with an existing message',
            ]);
        }

        // Create or update result message
        if ($request->id) {
            $resultMessage = ResultMessage::findOrFail($request->id);
            $resultMessage->update($request->all());
            $message = 'Result message updated successfully';
        } else {
            $resultMessage = ResultMessage::create($request->all());
            $message = 'Result message created successfully';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $resultMessage,
            'redirect' => route('result_messages.index', $request->quiz_id)
        ]);
    }

    /**
     * Show the form for editing the specified result message.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resultMessage = ResultMessage::findOrFail($id);
        $quiz = $resultMessage->quiz;
        
        return view('admin.result_messages.edit', compact('resultMessage', 'quiz'));
    }

    /**
     * Remove the specified result message from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resultMessage = ResultMessage::findOrFail($id);
        $quizId = $resultMessage->quiz_id;
        $resultMessage->delete();

        return response()->json([
            'status' => true,
            'message' => 'Result message deleted successfully',
            'redirect' => route('result_messages.index', $quizId)
        ]);
    }
}