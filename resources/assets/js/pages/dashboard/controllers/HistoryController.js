class HistoryController {
    constructor() {
        this.jsonCanvasHistory = [];

        this.canvasHistory = []; // Stores array of objects containing actions performed by the user
        this.canvasActionUndoCount = 1; // How many times to undo away from most recent action
        this.pendingCanvasHistoryRecords = []; // Store positions when drag starts, store them in canvasHistory on stop

        this.maxCanvasHistoryCount = 25; // Only used when storing to database

        this.canvasHistoryModel = new CanvasHistoryModel;
        this.view = new View;
    }

    loadCanvasHistory() {
        var canvasHistoryModel = this.canvasHistoryModel;

        canvasHistoryModel.index(canvasController.classId);
    }

    init() {
        var jsonCanvasHistoryRecords = this.jsonCanvasHistory;

        // Take JSON array of all items and store them locally
        for (var index in jsonCanvasHistoryRecords.canvas_history) {
            var canvasHistoryRecord = jsonCanvasHistoryRecords.canvas_history[index];

            this.addCanvasHistory(canvasHistoryRecord);
        }

        this.canvasActionUndoCount = jsonCanvasHistoryRecords.canvas_action_undo_count;
    } 

    addCanvasHistory(canvasHistoryRecord) {
        var canvasActionUndoCount = this.canvasActionUndoCount;

        if (canvasActionUndoCount > 1) { // User has undone, then performed another action
            this.canvasHistory.splice(this.canvasHistory.length - canvasActionUndoCount + 1, canvasActionUndoCount);
            this.canvasActionUndoCount = 1;
        }

        this.canvasHistory.push({
            canvas_item_id:      canvasHistoryRecord.canvas_item_id,
            type:                canvasHistoryRecord.type,
            previous_position_x: canvasHistoryRecord.previous_position_x,
            previous_position_y: canvasHistoryRecord.previous_position_y,
            position_x:          canvasHistoryRecord.position_x,
            position_y:          canvasHistoryRecord.position_y
        });
    }

    storeCanvasHistory(buttonElement = null, externalLink = null) {
        var canvasHistory         = this.canvasHistory,
            canvasHistoryModel    = this.canvasHistoryModel,
            maxCanvasHistoryCount = this.maxCanvasHistoryCount,
            canvasActionUndoCount = this.canvasActionUndoCount,
            classId               = canvasController.classId;

        var slicedHistory = canvasHistory.slice(Math.max(canvasHistory.length - maxCanvasHistoryCount, 0)); // Don't send > maxCanvasHistoryCount to DB

        canvasHistoryModel.store(classId, slicedHistory, canvasActionUndoCount, buttonElement, externalLink);

        this.canvasActionUndoCount = canvasActionUndoCount;
    }

    undoCanvasAction() {
        var canvasHistory          = this.canvasHistory,
            canvasActionUndoCount  = this.canvasActionUndoCount,
            canvasItems            = canvasController.canvasItems,
            view                   = this.view,
            softDeletedCanvasItems = canvasController.softDeletedCanvasItems;

        if (Object.keys(canvasHistory).length - canvasActionUndoCount >= 0) {
            var action       = canvasHistory[canvasHistory.length - canvasActionUndoCount],
                canvasItemId = action.canvas_item_id;

            switch (action.type) {
                case 'deletion':
                    canvasController.restoreSoftDeletedCanvasItem(canvasItemId, action.item_id, action.previous_position_x, action.previous_position_y);
                    break;
                case 'addition':
                    canvasController.softDeleteCanvasItem(canvasItemId);
                    break;
                default:
                    var canvasItem = canvasItems[canvasItemId];

                    var currentItemPositionX = canvasItem.position_x,
                        currentItemPositionY = canvasItem.position_y;

                    var canvasItemPositionX = action.previous_position_x,
                        canvasItemPositionY = action.previous_position_y;

                    canvasController.updateCanvasItemPosition(canvasItem, canvasItemPositionX, canvasItemPositionY)
                    view.updateCanvasItemPosition(canvasItemId, canvasItemPositionX, canvasItemPositionY);
                    canvasController.updateSelected([selectedCanvasItems.parent.id]);

                    canvasController.updateConnectedCanvasItems(canvasItemPositionX, canvasItemPositionY, [], null);
                    canvasController.updateConnectedCanvasItems(currentItemPositionX, currentItemPositionY, [], null);
            } 

            canvasActionUndoCount++;

            this.canvasActionUndoCount = canvasActionUndoCount;
        } else {
            alert('Nothing else to undo!');
        }
    }

    redoCanvasAction() {
        var canvasHistory = this.canvasHistory,
            canvasActionUndoCount = this.canvasActionUndoCount,
            canvasItems = canvasController.canvasItems,
            view = this.view;

        if (canvasActionUndoCount > 1) {
            var action = canvasHistory[canvasHistory.length - canvasActionUndoCount + 1];

            var canvasItemId = action.canvas_item_id;

            switch (action.type) {
                case 'deletion':
                    canvasController.softDeleteCanvasItem(canvasItemId);
                    break;
                case 'addition':
                    canvasController.restoreSoftDeletedCanvasItem(canvasItemId, action.item_id, action.previous_position_x, action.previous_position_y);
                    break;
                default:
                    var canvasItem = canvasItems[canvasItemId];

                    var currentItemPositionX = canvasItem.position_x,
                        currentItemPositionY = canvasItem.position_y;

                    var canvasItemPositionX = action.position_x,
                        canvasItemPositionY = action.position_y;

                    canvasController.updateCanvasItemPosition(canvasItem, canvasItemPositionX, canvasItemPositionY);
                    view.updateCanvasItemPosition(canvasItemId, canvasItemPositionX, canvasItemPositionY);
                    canvasController.updateSelected([selectedCanvasItems.parent.id]);

                    canvasController.updateConnectedCanvasItems(canvasItemPositionX, canvasItemPositionY, [], null);
                    canvasController.updateConnectedCanvasItems(currentItemPositionX, currentItemPositionY, [], null);
            }
            
            canvasActionUndoCount--;

            this.canvasActionUndoCount = canvasActionUndoCount;
        } else {
            alert('Nothing left to redo!');
        }
    }
}