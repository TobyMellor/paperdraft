// Canvas History is the previous actions a user has taken on the canvas
// e.g. canvasItem 1 movement to X: 5, Y: 8

// TODO: update this
// Example:
// [
//    {
//       "id": 1,
//       "canvas_item_id": "1",
//       "type": "movement",
//       "previous_position_x": 5,
//       "previous_position_y": 8 
//    }
// ]
class CanvasHistoryModel {
    index(classId) {
        $.APIAjax({
            url: '/api/canvas-history',
            type: 'GET',
            data: {
                class_id: classId
            },
            success: function(jsonResponse) {
                historyController.jsonCanvasHistory = jsonResponse;

                historyController.init();
            },
            error: function(jsonResponse) {}
        });
    }

    store(classId, canvasHistory, canvasActionUndoCount, buttonElement = null, externalLink = null) {
        $.APIAjax({
            url: '/api/canvas-history',
            type: 'POST',
            data: {
                canvas_history: canvasHistory,
                canvas_action_undo_count: canvasActionUndoCount,
                class_id: classId
            },
            success: function(jsonResponse) {
                setTimeout(function() {
                    if (buttonElement != null) {
                        canvasController.view.changeClass(buttonElement);
                    } else if (externalLink != null) {
                        window.location.href = externalLink;
                    }
                }, 2000);
            },
            error: function(jsonReponse) {}
        });
    }
}