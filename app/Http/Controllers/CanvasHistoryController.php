<?php

namespace App\Http\Controllers;

use App\CanvasHistory;
use App\SchoolClass;

use Validator;

use Illuminate\Http\Request;

class CanvasHistoryController extends Controller
{
    private $canvasHistoryCount = 25;
    private $classId;

    public function __construct(Request $request)
    {
        $classId = $request->input('class_id');

        $validation = $this->classIdValidator(['class_id' => $classId]);

        if ($validation->fails()) {
            return response()->json([
                'error' => 1,
                'message' => trans('api.canvas-item.failure.invalid-class-id')
            ]);
        }

        $this->classId = $classId;
    }

    private function getCanvasHistoryCount()
    {
        return $this->canvasHistoryCount;
    }

    /**
     * Returns the canvas history from the database
     *
     * @return \Illuminate\Http\Redirect
     */
    public function index()
    {
        $classId = $this->classId;

        $canvasHistory = [];
        $canvasHistoryRecords = CanvasHistory::where('class_id', $classId)->get();

        foreach ($canvasHistoryRecords as $canvasHistoryRecord) {
            array_push($canvasHistory, [
                'id' => $canvasHistoryRecord->id,
                'canvas_item_id' => $canvasHistoryRecord->canvas_item_id,
                'type' => $canvasHistoryRecord->type,
                'position_x' => $canvasHistoryRecord->position_x,
                'position_y' => $canvasHistoryRecord->position_y,
                'previous_position_x' => $canvasHistoryRecord->previous_position_x,
                'previous_position_y' => $canvasHistoryRecord->previous_position_y
            ]);
        }

        return response()->json([
            'canvas_history' => $canvasHistory,
            'canvas_action_undo_count' => SchoolClass::where('id', $classId)->first()->canvas_action_undo_count,
            'error' => 0,
            'message' => trans('api.canvas-history.success.index')
        ]);
    }

    /**
     * Store the canvas history in the database
     *
     * @return \Illuminate\Http\Redirect
     */
    public function store(Request $request)
    {
        $newCanvasHistoryRecords = $request->input('canvas_history');
        $canvasActionUndoCount = $request->input('canvas_action_undo_count');
        $classId = $this->classId;

        if ($newCanvasHistoryRecords == null) {
            $newCanvasHistoryRecords = [];
        }

        $canvasHistoryCount = $this->getCanvasHistoryCount();

        $data = [  
            'canvas_history' => $newCanvasHistoryRecords,
            'canvas_action_undo_count' => $canvasActionUndoCount
        ];

        $validation = $this->validator($data);

        if (!$validation->fails()) {
            SchoolClass::where('id', $classId)
                ->update([
                    'canvas_action_undo_count' => $canvasActionUndoCount
                ]);

            CanvasHistory::where('class_id', $classId)->delete();

            foreach ($newCanvasHistoryRecords as $key => $newCanvasHistoryRecord) {
                $newCanvasHistoryRecords[$key]['class_id'] = $classId;
            }

            CanvasHistory::insert($newCanvasHistoryRecords);

            return response()->json([
                'error' => 0,
                'message' => trans('api.canvas-history.success.store')
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => trans('api.canvas-history.failure.store')
        ]);
    }

    /**
     * Validates an array of information.
     *
     * @return Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'canvas_history' => 'array|max:' . $this->getCanvasHistoryCount(),
            'canvas_action_undo_count' => 'required|integer|max:' . $this->getCanvasHistoryCount()
        ]);
    }

    /**
     * Validates an array of information.
     *
     * @return Validator
     */
    protected function classIdValidator(array $data)
    {
        return Validator::make($data, [
            'class_id'     => 'required|integer|ownsclass'
        ]);
    }
}