<?php

namespace App\Http\Controllers;

use App\Item;
use App\CanvasItem;
use App\CanvasHistory;

use Auth;
use Validator;

use Illuminate\Http\Request;

class CanvasItemController extends Controller
{
    private $classId;

    public function __construct(Request $request)
    {
        $classId = $request->input('class_id');

        $validation = $this->validator(['class_id' => $classId]);

        if ($validation->fails()) {
            return response()->json([
                'error' => 1,
                'message' => trans('api.canvas-item.failure.invalid-class-id')
            ]);
        }

        $this->classId = $classId;
    }

    /**
     * Display a listing of the canvas-items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $classId = $this->classId;

        $canvasItems = [];

        $canvasItems['canvas_items'] = CanvasItem::where('class_id', $classId)
            ->get();

        $canvasItems['soft_deleted_canvas_items'] = CanvasItem::onlyTrashed()
            ->whereIn('id',
                CanvasHistory::where('class_id', $classId)
                    ->where('type', 'deletion')
                    ->get()
                    ->pluck('canvas_item_id')
                    ->all()
            )->get(); // Gets the required soft-deleted canvasItems by the canvasHistory

        return response()->json([
            'canvas_items' => $canvasItems,
            'error' => 0,
            'message' => trans('api.canvas-item.success.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $canvasItem = $request->input('canvas_item');
        $classId = $this->classId;
        var_dump($this->classId);

        $storedCanvasItem = new CanvasItem;

        $storedCanvasItem->item_id = $canvasItem['item_id'];
        $storedCanvasItem->class_id = $classId;
        $storedCanvasItem->position_x = $canvasItem['position_x'];
        $storedCanvasItem->position_y = $canvasItem['position_y'];

        $storedCanvasItem->save();

        if ($canvasItem['soft_deleted'] === "true") {
            $storedCanvasItem->delete();
        }

        return response()->json([
            'canvas_item' => $storedCanvasItem,
            'error' => 0,
            'message' => trans('api.canvas-item.success.store')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $canvasItem = $request->input('canvas_item');
        $classId = $this->classId;

        if ($canvasItem['soft_deleted'] != null && $canvasItem['soft_deleted']) {
            $storedCanvasItem = CanvasItem::withTrashed()
                ->where('class_id', $classId)
                ->where('id', $id)
                ->restore();
        }

        CanvasItem::where('class_id', $classId)
            ->where('id', $id)
            ->update([
                'position_x' => $canvasItem['position_x'],
                'position_y' => $canvasItem['position_y']
            ]);

        return response()->json([
            'canvas_item' => $canvasItem,
            'error' => 0,
            'message' => trans('api.canvas-item.success.update')
        ]);
    }

    /**
     * Update a batch of resources in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchUpdate(Request $request)
    {
        $canvasItems = $request->input('canvas_items');
        $classId = $this->classId;

        $responses = [];

        foreach ($canvasItems as $canvasItem) {
            $request->request->add(['canvas_item' => $canvasItem]);

            array_push($responses, $this->update($request, $canvasItem['id'])->getData()->canvas_item);
        }

        return response()->json([
            'canvas_items' => $responses,
            'error' => 0,
            'message' => trans('api.canvas-item.success.batch-update')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $canvasItem = $request->input('canvas_item');
        $classId = $this->classId;

        CanvasItem::where('class_id', $classId)
            ->where('id', $id)
            ->delete();

        return response()->json([
            'error' => 0,
            'message' => trans('api.canvas-item.success.destroy')
        ]);
    }

    /**
     * Remove a batch of resources from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batchDestroy(Request $request)
    {
        $canvasItems = $request->input('canvas_items');
        $classId = $this->classId;

        if ($canvasItems != null) {
            $canvasItemIds = array_map(function($canvasItems) { return $canvasItems['id']; }, $canvasItems);

            CanvasItem::where('class_id', $classId)
                ->whereIn('id', $canvasItemIds)
                ->delete();

            return response()->json([
                'error' => 0,
                'message' => trans('api.canvas-item.success.batch-destroy')
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => trans('api.canvas-item.failure.batch-destroy')
        ]);
    }

    /**
     * Duplicate class items from one class to another
     *
     * @return null
     */
    // public function duplicateCanvasItems($classIdToCopy, $classIdToPaste)
    // {
    //     $canvasItemsToCopy = CanvasItem::where('class_id', $classIdToCopy)->get();

    //     $canvasItemsToPaste = [];

    //     foreach ($canvasItemsToCopy as $classObjectToCopy) {
    //         array_push($canvasItemsToPaste, [
    //             'item_id' => $canvasItemToCopy->item_id,
    //             'class_id' => $classIdToPaste,
    //             'position_x' => $canvasItemToCopy->position_x,
    //             'position_y' => $canvasItemToCopy->position_y,
    //         ]);
    //     }

    //     CanvasItem::insert($canvasItemsToPaste);
    // }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'class_id'     => 'required|integer|ownsclass'
        ]);
    }
}