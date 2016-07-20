<?php

namespace App\Http\Controllers;

use App\Item;
use App\CanvasItem;

use Auth;
use Validator;

use Illuminate\Http\Request;

// TODO: Use built in json manager
class ItemController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Store the canvas item in the database.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function storeCanvasItem()
    {
        $request = $this->request;
        $canvasItem = $request->input('canvas_item');
        $classId = $request->input('class_id');

        $response = [];

        if ($canvasItem != null) {
            $storedCanvasItem = new CanvasItem;

            $storedCanvasItem->item_id = $canvasItem['item_id'];
            $storedCanvasItem->class_id = $classId;
            $storedCanvasItem->position_x = $canvasItem['position_x'];
            $storedCanvasItem->position_y = $canvasItem['position_y'];

            $storedCanvasItem->save();

            $response = [$storedCanvasItem->id];
        }

        return $response;
    }

    /**
     * Store the canvas items in the database.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function storeCanvasItems()
    {
        $request = $this->request;
        $canvasItems = $request->input('canvas_items');
        $classId = $request->input('class_id');

        if ($canvasItems != null) {
            foreach ($canvasItems as $key => $canvasItem) {
                if (isset($canvasItem['canvas_item_id']) && $canvasItem['canvas_item_id'] != null) {
                    CanvasItem::where('id', $canvasItem['canvas_item_id'])
                        ->where('class_id', $classId)
                        ->update([
                            'position_x' => $canvasItem['position_x'],
                            'position_y' => $canvasItem['position_y']
                        ]
                    );
                } else if (isset($canvasItem['item_id'])) {
                    $canvasItem = new CanvasItem;

                    $canvasItem->item_id = $canvasItem['item_id'];
                    $canvasItem->class_id = $classId;
                    $canvasItem->position_x = $canvasItem['position_x'];
                    $canvasItem->position_y = $canvasItem['position_y'];

                    $canvasItem->save();

                    $canvasItems[$key]['canvas_item_id'] = $canvasItem->id;
                }
            }
        } else {
            return [];
        }
        return $canvasItems;
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

    /**
     * Get all canvas items
     *
     * @return \Illuminate\Http\Redirect
     */
    public function getCanvasItems()
    {
        $request = $this->request;
        $classId = $request->input('class_id');

        $canvasItems = CanvasItem::where('class_id', $classId)
            ->get();
        return $canvasItems;
    }

    public function deleteCanvasItems()
    {
        $request = $this->request;
        $classId = $request->input('class_id');

        if ($request->input('canvas_items') != null) {
            $canvasItems = $request->input('canvas_items');

            $canvasItemIds = array_map(function($canvasItems){ return $canvasItems['canvas_item_id']; }, $canvasItems);

            CanvasItem::where('class_id', $classId)
                ->whereIn('id', $classItemIds)
                ->delete(); 
        } else {
            CanvasItem::where('class_id', $classId)
                ->delete(); 
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, []);
    }
}
