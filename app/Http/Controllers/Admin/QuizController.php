<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class QuizController extends Controller
{
    /**
     * Display a listing of the quizzes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quizzes = Quiz::select(['id', 'title', 'description', 'show_report', 'generate_pdf', 'created_at'])->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }
    

    /**
     * Show the form for creating a new quiz.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.quizzes.create');
    }

    /**
     * Store a newly created quiz in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'show_report' => 'boolean',
            'generate_pdf' => 'boolean',
            'default_option_count' => 'required|integer|min:2|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ]);
        }

        $data = $request->all();
        
        // Handle boolean values from form
        $data['show_report'] = $request->has('show_report') ? true : false;
        $data['generate_pdf'] = $request->has('generate_pdf') ? true : false;
        
        // Create or update quiz
        if ($request->has('id')) {
            $quiz = Quiz::findOrFail($request->id);
            $quiz->update($data);
            $message = 'Quiz updated successfully';
        } else {
            $quiz = Quiz::create($data);
            $message = 'Quiz created successfully';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $quiz,
            'redirect' => route('quizzes.index')
        ]);
    }

    /**
     * Display the specified quiz.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quiz = Quiz::with('questions.options')->findOrFail($id);
        return view('admin.quizzes.show', compact('quiz'));
    }

    /**
     * Show the form for editing the specified quiz.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quiz = Quiz::findOrFail($id);
        return view('admin.quizzes.edit', compact('quiz'));
    }

    /**
     * Update the specified quiz in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:quizzes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'show_report' => 'boolean',
            'generate_pdf' => 'boolean',
            'default_option_count' => 'required|integer|min:2|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ]);
        }

        $data = $request->all();
        
        // Handle boolean values from form
        $data['show_report'] = $request->has('show_report') ? true : false;
        $data['generate_pdf'] = $request->has('generate_pdf') ? true : false;
        
        $quiz = Quiz::findOrFail($request->id);
        $quiz->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Quiz updated successfully',
            'data' => $quiz,
            'redirect' => route('quizzes.index')
        ]);
    }

    /**
     * Remove the specified quiz from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return response()->json([
            'status' => true,
            'message' => 'Quiz deleted successfully'
        ]);
    }

    /**
     * Get quizzes data for DataTables.
     * 
     * This is a separate endpoint that returns JSON for DataTables
     * NOT a model binding route!
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuizzes()
    {
        $quizzes = Quiz::select(['id', 'title', 'description', 'show_report', 'generate_pdf', 'created_at']);

        return DataTables::of($quizzes)
            ->addColumn('check_box', function ($quiz) {
                return '<div class="form-check">
                            <input class="form-check-input" type="checkbox" value="' . $quiz->id . '">
                        </div>';
            })
            ->addColumn('action', function ($quiz) {
                return '<div class="d-flex gap-2">
                            <a href="' . route('quizzes.edit', $quiz->id) . '" class="btn btn-sm btn-primary editBtn">Edit</a>
                            <a href="' . route('questions.index', $quiz->id) . '" class="btn btn-sm btn-info">Questions</a>
                            <a href="' . route('result_messages.index', $quiz->id) . '" class="btn btn-sm btn-success">Result Messages</a>
                            <button class="btn btn-sm btn-danger removeBtn" delete-url="' . route('quizzes.destroy', $quiz->id) . '">Delete</button>
                        </div>';
            })
            ->rawColumns(['check_box', 'action'])
            ->addIndexColumn()
            ->make(true);
    }
}