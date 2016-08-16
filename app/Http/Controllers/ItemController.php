<?php

namespace App\Http\Controllers;

use App\Item;
use App\CanvasItem;
use App\CanvasHistory;

use Auth;
use Validator;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the canvas-items.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $classId = $request->input('class_id');

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $canvasItem = $request->input('canvas_item');
        $classId = $request->input('class_id');

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {} // TODO

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $canvasItem = $request->input('canvas_item');
        $classId = $request->input('class_id');

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
     * @return \Illuminate\Http\Response
     */
    public function batchUpdate(Request $request)
    {
        $canvasItems = $request->input('canvas_items');
        $classId = $request->input('class_id');

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
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $classId = $request->input('class_id');
        $canvasItem = $request->input('canvas_item');

        // $canvasItemIds = array_map(function($canvasItems) { return $canvasItems['id']; }, $canvasItems);

        // CanvasItem::where('class_id', $classId)
        //     ->whereIn('id', $canvasItemIds)
        //     ->delete();

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
     * @return \Illuminate\Http\Response
     */
    public function batchDestroy(Request $request)
    {
        $classId = $request->input('class_id');
        $canvasItems = $request->input('canvas_items');

        $canvasItemIds = array_map(function($canvasItems) { return $canvasItems['id']; }, $canvasItems);

        CanvasItem::where('class_id', $classId)
            ->whereIn('id', $canvasItemIds)
            ->delete();

        return response()->json([
            'error' => 0,
            'message' => trans('api.canvas-item.success.batch-destroy')
        ]);
    }

    /**
     * Duplicate class items from one class to another
     *
     * @return null
     */
    public function duplicateCanvasItems($classIdToCopy, $classIdToPaste)
    {
        $canvasItemsToCopy = CanvasItem::where('class_id', $classIdToCopy)->get();

        $canvasItemsToPaste = [];

        foreach ($canvasItemsToCopy as $classObjectToCopy) {
            array_push($canvasItemsToPaste, [
                'item_id' => $canvasItemToCopy->item_id,
                'class_id' => $classIdToPaste,
                'position_x' => $canvasItemToCopy->position_x,
                'position_y' => $canvasItemToCopy->position_y,
            ]);
        }

        CanvasItem::insert($canvasItemsToPaste);
    }


    /**
     * Get all items
     *
     * @return \Illuminate\Http\Redirect
     */
    public function getItems($paginate = null)
    {
        if ($paginate != null) {
            $items = Item::paginate();
        } else {
            $items = Item::all();
        }
        return $items;
    }

    // public function deleteCanvasItems()
    // {
    //     $request = $this->request;
    //     $classId = $request->input('class_id');
    //     $canvasItems = $request->input('canvas_items');

    //     if ($canvasItems != null) {
    //         $canvasItemIds = array_map(function($canvasItems) { return $canvasItems['id']; }, $canvasItems);

    //         CanvasItem::where('class_id', $classId)
    //             ->whereIn('id', $canvasItemIds)
    //             ->delete(); 
    //     }
    // }

    protected function validator(array $data)
    {
        return Validator::make($data, []);
    }
}