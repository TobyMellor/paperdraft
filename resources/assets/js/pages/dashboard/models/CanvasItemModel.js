// An 'canvas item' is a classroom 'item' that is stored at a location for a given class
// e.g. item: Table -- Canvas item: Table is stored at x: 25, y: 5
// This is specific to a particular classroom, and the items can be any 'item' (a Table)

// Example:
// [
//    1: {
//       "id": 1,
//       "item_id": 1,
//       "position_x": 25,
//       "position_y": 5,
//       "pseudo_item": false, // True when item exists in session, but not in the database
//       "soft_deleted": false // True when user deletes item, but still stored in database for use via CanvasHistory
//    }
// ]
class CanvasItemModel {
    index(classId) {
        $.APIAjax({
            url: '/api/canvas-item',
            type: 'GET',
            data: {
                class_id: classId
            },
            success: function(jsonResponse) {
                canvasController.jsonCanvasItems = jsonResponse;

                canvasController.init();
            },
            error: function(jsonResponse) {}
        });
    }

    store(classId, canvasItem) {
        $.APIAjax({
            url: '/api/canvas-item',
            type: 'POST',
            async: false, // TODO: Needs better solution
            data: {
                canvas_item: canvasItem,
                class_id:    classId
            },
            success: function(jsonResponse) {
                var returnedCanvasItem = jsonResponse.canvas_item;

                canvasController.updatePseudoCanvasItemToReal(canvasItem.id, returnedCanvasItem.id, returnedCanvasItem.deleted_at == null ? false : true);

                canvasItem.id = returnedCanvasItem.id;

                if (returnedCanvasItem.deleted_at == null) {
                    canvasController.addCanvasItem(canvasItem);
                } else {
                    canvasController.addSoftDeletedCanvasItem(canvasItem);
                }
            },
            error: function(jsonResponse) {}
        });
    }

    batchDestroy(classId, softDeletedCanvasItems) {
        $.APIAjax({
            url: '/api/canvas-item',
            type: 'DELETE',
            data: {
                canvas_items: softDeletedCanvasItems,
                class_id:     classId
            },
            success: function(jsonResponse) {},
            error: function(jsonReponse) {}
        });
    }

    batchUpdate(classId, canvasItems) {
        $.APIAjax({
            url: '/api/canvas-item',
            type: 'PUT',
            data: {
                canvas_items: canvasItems,
                class_id:     classId
            },
            success: function(jsonResponse) {},
            error: function(jsonReponse) {}
        });
    }
}