<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Option;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class QuestionController extends Controller
{
    /**
     * Display a listing of the questions for a quiz.
     *
     * @param  int  $quizId
     * @return \Illuminate\Http\Response
     */
    public function index($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        return view('admin.questions.index', compact('quiz'));
    }

    /**
     * Show the form for creating a new question.
     *
     * @param  int  $quizId
     * @return \Illuminate\Http\Response
     */
    public function create($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $data = [
            'quiz_id' => $quizId,
            'no_of_options' => $quiz->default_option_count,
            'module_type' => 'Standard' // Default module type
        ];
        
        return view('admin.questions.create_or_update', [
            'data' => $data,
            'editable' => false
        ]);
    }

    /**
     * Show the form for bulk creating questions.
     *
     * @param  int  $quizId
     * @return \Illuminate\Http\Response
     */
    public function bulkCreate($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        
        $data = [
            'quiz_id' => $quizId,
            'no_of_questions' => 5, // Default number of questions
            'no_of_options' => $quiz->default_option_count,
            'module_type' => 'Standard' // Default module type
        ];
        
        return view('admin.questions.bulk_create_or_update', [
            'data' => $data
        ]);
    }

    /**
     * Store a newly created question in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'q_num' => 'required|integer',
            'group' => 'required|integer|min:1',
            'question_audio' => 'nullable|file|mimes:mp3|max:5120',
            'video_link' => 'nullable|string',
            'answer' => 'required|array',
            'answer.*.option' => 'required|string',
            'answer.*.true' => 'nullable|boolean',
            'answer.*.mark' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ]);
        }

        // Handle question audio upload
        $questionAudioPath = null;
        if ($request->hasFile('question_audio')) {
            $file = $request->file('question_audio');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/question_audio', $filename);
            $questionAudioPath = $filename;
        }

        // Create or update question
        $questionData = [
            'quiz_id' => $request->quiz_id,
            'question' => $request->question,
            'q_num' => $request->q_num,
            'group' => $request->group,
            'video_link' => $request->video_link,
        ];

        if ($questionAudioPath) {
            $questionData['question_audio'] = $questionAudioPath;
        }

        if ($request->id) {
            // Update existing question
            $question = Question::findOrFail($request->id);
            $question->update($questionData);
        } else {
            // Create new question
            $question = Question::create($questionData);
        }

        // Process options
        foreach ($request->answer as $key => $answerData) {
            $optionData = [
                'option' => $answerData['option'],
                'is_answer' => isset($answerData['true']) ? true : false,
                'mark' => isset($answerData['mark']) ? $answerData['mark'] : 0,
            ];

            if (isset($answerData['id']) && $answerData['id']) {
                // Update existing option
                $option = Option::findOrFail($answerData['id']);
                $option->update($optionData);
            } else {
                // Create new option
                $optionData['question_id'] = $question->id;
                Option::create($optionData);
            }
        }

        return response()->json([
            'status' => true,
            'message' => $request->id ? 'Question updated successfully' : 'Question created successfully',
            'data' => $question,
            'redirect' => route('questions.index', $request->quiz_id)
        ]);
    }

    /**
     * Store bulk questions in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBulk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'module_id' => 'required|exists:quizzes,id',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.q_num' => 'required|integer',
            'questions.*.group' => 'required|integer|min:1',
            'questions.*.question_audio' => 'nullable|file|mimes:mp3|max:5120',
            'questions.*.video_link' => 'nullable|string',
            'questions.*.answer' => 'required|array',
            'questions.*.answer.*.option' => 'required|string',
            'questions.*.answer.*.true' => 'nullable|boolean',
            'questions.*.answer.*.mark' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ]);
        }

        foreach ($request->questions as $questionData) {
            // Handle question audio upload
            $questionAudioPath = null;
            if (isset($questionData['question_audio']) && $questionData['question_audio'] && !is_string($questionData['question_audio'])) {
                $file = $questionData['question_audio'];
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/question_audio', $filename);
                $questionAudioPath = $filename;
            }

            // Create or update question
            $qData = [
                'quiz_id' => $request->module_id,
                'question' => $questionData['question'],
                'q_num' => $questionData['q_num'],
                'group' => $questionData['group'],
                'video_link' => $questionData['video_link'] ?? null,
            ];

            if ($questionAudioPath) {
                $qData['question_audio'] = $questionAudioPath;
            }

            if (isset($questionData['id'])) {
                // Update existing question
                $question = Question::findOrFail($questionData['id']);
                $question->update($qData);
            } else {
                // Create new question
                $question = Question::create($qData);
            }

            // Process options
            if (isset($questionData['answer'])) {
                foreach ($questionData['answer'] as $key => $answerData) {
                    $optionData = [
                        'option' => $answerData['option'],
                        'is_answer' => isset($answerData['true']) ? true : false,
                        'mark' => isset($answerData['mark']) ? $answerData['mark'] : 0,
                    ];

                    if (isset($answerData['id']) && $answerData['id']) {
                        // Update existing option
                        $option = Option::findOrFail($answerData['id']);
                        $option->update($optionData);
                    } else {
                        // Create new option
                        $optionData['question_id'] = $question->id;
                        Option::create($optionData);
                    }
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Questions created successfully',
            'redirect' => route('questions.index', $request->module_id)
        ]);
    }

    /**
     * Show the form for editing the specified question.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::with('options')->findOrFail($id);
        $quiz = $question->quiz;
        $module_type = 'Standard'; // Default module type

        return view('admin.questions.create_or_update', [
            'editable' => $question,
            'module_type' => $module_type,
            'options' => $question->options
        ]);
    }

    /**
     * Show the form for editing all questions in bulk.
     *
     * @param  int  $quizId
     * @return \Illuminate\Http\Response
     */
    public function bulkEdit($quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $questions = Question::with('options')
            ->where('quiz_id', $quizId)
            ->orderBy('q_num', 'asc')
            ->get();
        
        if ($questions->isEmpty()) {
            return redirect()->route('questions.bulk_create', $quizId);
        }

        $data = [
            'quiz_id' => $quizId,
            'module_type' => 'Standard', // Default module type
            'questions' => $questions
        ];

        return view('admin.questions.bulk_create_or_update', [
            'data' => $data
        ]);
    }

    /**
     * Get questions data for DataTables.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuestions(Request $request)
    {
        $quizId = $request->quizid;
        $questions = Question::where('quiz_id', $quizId)
            ->select(['id', 'question', 'q_num'])
            ->orderBy('q_num', 'asc');

        return DataTables::of($questions)
            ->addColumn('check_box', function ($question) {
                return '<div class="form-check">
                            <input class="form-check-input" type="checkbox" value="' . $question->id . '">
                        </div>';
            })
            ->addColumn('action', function ($question) {
                return '<div class="d-flex gap-2">
                            <a href="' . route('questions.edit', $question->id) . '" class="btn btn-sm btn-primary editBtn">Edit</a>
                            <button class="btn btn-sm btn-danger removeBtn" delete-url="' . route('questions.destroy', $question->id) . '">Delete</button>
                        </div>';
            })
            ->rawColumns(['check_box', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Get options for a question.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOptions(Request $request)
    {
        $quiz = Quiz::findOrFail($request->courses_module_id);
        $module_type = 'Standard'; // Default module type
        $options = $quiz->default_option_count;
        
        $view = view('admin.questions.course-answer-options', [
            'module_type' => $module_type,
            'options' => $options,
            'editable' => false,
            'data' => [
                'module_type' => $module_type
            ]
        ])->render();
        
        return response()->json([
            'status' => true,
            'data' => $view
        ]);
    }

    /**
     * Remove the specified question from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        
        // Delete question audio file if exists
        if ($question->question_audio) {
            Storage::delete('public/question_audio/' . $question->question_audio);
        }
        
        $question->delete();

        return response()->json([
            'status' => true,
            'message' => 'Question deleted successfully'
        ]);
    }
}