<?php

namespace App\Http\Controllers;

use App\Item;
use App\CanvasItem;

use Auth;
use Validator;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Store the class items in the database.
     *
     * @return \Illuminate\Http\Redirect
     */
    public function storeCanvasItems()
    {
        $request = $this->request;
        $items = $request->input('items');
        $classId = $request->input('class_id');

        if($items != null) {
            foreach ($items as $key => $item) {
                if (isset($item['canvas_item_id']) && $item['canvas_item_id'] != null) {
                    CanvasItem::where('id', $item['canvas_item_id'])
                        ->where('class_id', $classId)
                        ->update([
                            'position_x' => $item['position_x'],
                            'position_y' => $item['position_y']
                        ]
                    );
                } elseif(isset($item['item_id'])) {
                    $canvasItem = new CanvasItem;

                    $canvasItem->item_id = $item['item_id'];
                    $canvasItem->class_id = $classId;
                    $canvasItem->position_x = $item['position_x'];
                    $canvasItem->position_y = $item['position_y'];

                    $canvasItem->save();

                    $items[$key]['canvas_item_id'] = $canvasItem->id;
                }
            }
        } else {
            return [];
        }
        return $items;
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

        foreach($canvasItemsToCopy as $classObjectToCopy) {
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

        if($request->input('canvas_items') != null) {
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
