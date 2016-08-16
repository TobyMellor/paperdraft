<?php

namespace App\Http\Controllers;

use App\CanvasHistory;
use App\SchoolClass;

use Validator;

use Illuminate\Http\Request;

class CanvasHistoryController extends Controller
{
    private $canvasHistoryCount = 25;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    private function getCanvasHistoryCount()
    {
        return $this->canvasHistoryCount;
    }

    /**
     * Store the canvas history in the database
     *
     * @return \Illuminate\Http\Redirect
     */
    public function store()
    {
        $request = $this->request;
        $newCanvasHistoryRecords = $request->input('canvas_history');
        $canvasActionUndoCount = $request->input('canvas_action_undo_count');
        $classId = $request->input('class_id');

        if ($newCanvasHistoryRecords == null) {
            $newCanvasHistoryRecords = [];
        }

        $canvasHistoryCount = $this->getCanvasHistoryCount();

        $response = [];

        $data = [
            'canvas_history' => $newCanvasHistoryRecords,
            'class_id' => $classId,
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

            $response = ['success'];
        } else {
            $response = ['Canvas history is too large or doesn\'t exist.'];
        }

        return $response;
    }

    /**
     * Returns the canvas history from the database
     *
     * @return \Illuminate\Http\Redirect
     */
    public function index()
    {
        $request = $this->request;
        $classId = $request->input('class_id');

        $response = [
            'canvas_history' => [],
            'canvas_action_undo_count' => SchoolClass::where('id', $classId)->first()->canvas_action_undo_count
        ];

        $canvasHistoryRecords = CanvasHistory::where('class_id', $classId)->get();

        foreach ($canvasHistoryRecords as $canvasHistoryRecord) {
            array_push($response['canvas_history'], [
                'id' => $canvasHistoryRecord->id,
                'canvas_item_id' => $canvasHistoryRecord->canvas_item_id,
                'type' => $canvasHistoryRecord->type,
                'position_x' => $canvasHistoryRecord->position_x,
                'position_y' => $canvasHistoryRecord->position_y,
                'previous_position_x' => $canvasHistoryRecord->previous_position_x,
                'previous_position_y' => $canvasHistoryRecord->previous_position_y
            ]);
        }

        return $response;
    }

    /**
     * Validates an array of information.
     *
     * @return Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'class_id' => 'required|integer|exists:classes,id',
            'canvas_history' => 'array|max:' . $this->getCanvasHistoryCount(),
            'canvas_action_undo_count' => 'required|integer|max:' . $this->getCanvasHistoryCount()
        ]);
    }
}