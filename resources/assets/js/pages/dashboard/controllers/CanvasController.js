class CanvasController {
    constructor(jsonItems, classId, gridSize = 23) {
        this.jsonItems = jsonItems, // items never change so we're not loading them dynamically
        this.jsonCanvasItems;

        this.canvasItems            = {}, // e.g. Table is stored at X: 5, Y: 8 in the grid
        this.items                  = {}, // e.g. A Table desk.png, A Teachers Desk teachers_desk.png
        this.canvasItemsGrid        = [], // e.g. Grid of all possible locations to store items
        this.copyClipboard          = [],
        this.softDeletedCanvasItems = {};

        this.classId  = classId,
        this.gridSize = gridSize;

        this.canvasItemModel = new CanvasItemModel,

        this.view = new View;
    }

    loadCanvasItems() {
        this.canvasItemModel.index(this.classId);
    }

    init() {
        var jsonItems       = this.jsonItems,
            jsonCanvasItems = this.jsonCanvasItems;

        var items       = this.items,
            canvasItems = this.canvasItems; 

        this.generateGrid(this.gridSize);

        // Take JSON array of all items and store them locally
        for (var jsonItem in jsonItems) {
            var item = jsonItems[jsonItem];

            this.addItem(item);
        }

        if (jsonCanvasItems.canvas_items.canvas_items.length > 0) {
            // Take JSON array of all canvasItems and store them locally
            for (var jsonCanvasItem in jsonCanvasItems.canvas_items.canvas_items) {
                var canvasItem = jsonCanvasItems.canvas_items.canvas_items[jsonCanvasItem];

                this.addCanvasItem(canvasItem);
            }
        } else {
            this.updateSelected([]); 
        }

        for (var jsonSoftDeletedCanvasItem in jsonCanvasItems.canvas_items.soft_deleted_canvas_items) {
            var softDeletedCanvasItem = jsonCanvasItems.canvas_items.soft_deleted_canvas_items[jsonSoftDeletedCanvasItem];

            this.addSoftDeletedCanvasItem(softDeletedCanvasItem);
        }
    }

    // Stores the item locally
    addItem(item) {
        var items = this.items;

        var item = items[item.id] = {
            'name':     item.name,
            'height':   item.height,
            'width':    item.width,
            'location': item.location
        };
    }

    // A pseudo canvasItem is only stored locally, and will be stored to the database on-save 
    createPseudoCanvasItem(itemId) {
        this.createCanvasItem(itemId);
    }

    createCanvasItem(itemId, positionX = null, positionY = null) {
        var canvasItems     = this.canvasItems,
            canvasItemModel = this.canvasItemModel,
            classId         = this.classId;

        var canvasItem = {
            item_id:                    itemId,
            student_id:                 null,
            tooltip_occupied_positions: null
        };

        hasUserMadeChanges = true;

        canvasItem.id = 'Pseudo-' + Math.floor(Math.random() * 99999) + 1;

        if (positionX !== null && positionY !== null) {
            canvasItem.position_x = positionX;
            canvasItem.position_y = positionY;
        } else if (!$.isEmptyObject(selectedCanvasItems.parent)) {
            var parentCanvasItemPositionX = canvasItems[selectedCanvasItems.parent.id].position_x,
                parentCanvasItemPositionY = canvasItems[selectedCanvasItems.parent.id].position_y;

            var nearestEmptySpace = this.getNearestEmpty(parentCanvasItemPositionX, parentCanvasItemPositionY, 5, 5);

            if (nearestEmptySpace !== -1) {
                canvasItem.position_x = nearestEmptySpace[0];
                canvasItem.position_y = nearestEmptySpace[1];
            }
        } else {
            canvasItem.position_x = 0;
            canvasItem.position_y = 0;
        }

        return this.addCanvasItem(canvasItem, true);
    }

    // Stores the canvasItem locally and adds it to the view (canvas)
    addCanvasItem(canvasItem, isPseudoCanvasItem = false) {
        var items           = this.items,
            canvasItems     = this.canvasItems,
            canvasItemsGrid = this.canvasItemsGrid;

        var canvasItem = canvasItems[canvasItem.id] = {
            id:                         canvasItem.id,
            item_id:                    canvasItem.item_id,
            student_id:                 canvasItem.student_id,
            position_x:                 canvasItem.position_x,
            position_y:                 canvasItem.position_y,
            pseudo_item:                isPseudoCanvasItem,
            soft_deleted:               false,
            tooltip_occupied_positions: null
        };

        var item = items[canvasItem.item_id];
        
        canvasItemsGrid[canvasItem.position_x][canvasItem.position_y] = canvasItem.id;

        this.view.addCanvasItem(item, canvasItem); // Render canvas item to view
        this.updateSelected([canvasItem.id]); // Select the newly added item
        this.initializeDraggable(); // Allow it to be dragged

        if (isPseudoCanvasItem) {
            historyController.addCanvasHistory({
                canvas_item_id:      canvasItem.id,
                item_id:             canvasItem.item_id,
                type:                'addition',
                previous_position_x: canvasItem.position_x,
                previous_position_y: canvasItem.position_y,
                position_x:          null,
                position_y:          null
            });
        }
    }

    addSoftDeletedCanvasItem(softDeletedCanvasItem) {
        var items = this.items,
            softDeletedCanvasItems = this.softDeletedCanvasItems;

        softDeletedCanvasItems[softDeletedCanvasItem.id] = {
            id:                         softDeletedCanvasItem.id,
            item_id:                    softDeletedCanvasItem.item_id,
            student_id:                 softDeletedCanvasItem.student_id,
            position_x:                 softDeletedCanvasItem.position_x,
            position_y:                 softDeletedCanvasItem.position_y,
            pseudo_item:                softDeletedCanvasItem.pseudo_item,
            soft_deleted:               true,
            tooltip_occupied_positions: null
        };
    }

    updatePseudoCanvasItemToReal(oldCanvasItemId, newCanvasItemId, isSoftDeleted = false) {
        var canvasItemsGrid = this.canvasItemsGrid,
            canvasHistory   = historyController.canvasHistory,
            canvasItems;

        if (isSoftDeleted) {
            canvasItems = this.softDeletedCanvasItems;
        } else {
            canvasItems = this.canvasItems;
        }

        Object.defineProperty(canvasItems, newCanvasItemId,
            Object.getOwnPropertyDescriptor(canvasItems, oldCanvasItemId));

        delete canvasItems[oldCanvasItemId];

        var canvasItem = canvasItems[newCanvasItemId];

        canvasItem.pseudo_item = false;
        canvasItem.id = newCanvasItemId;


        if (!isSoftDeleted) {
            canvasItemsGrid[canvasItem.position_x][canvasItem.position_y] = newCanvasItemId;
        }
        
        $.grep(canvasHistory, function(e){
            if (e.canvas_item_id == oldCanvasItemId) {
                e.canvas_item_id = newCanvasItemId;
            }
        });

        historyController.canvasHistory = canvasHistory;
    }

    removeCanvasItem(canvasItemId) {
        var canvasItems            = this.canvasItems,
            canvasItemsGrid        = this.canvasItemsGrid,
            softDeletedCanvasItems = this.softDeletedCanvasItems, 
            view                   = this.view,
            canvasItem             = canvasItems[canvasItemId],
            classStudentId         = canvasItem.student_id;

        canvasItemsGrid[canvasItem.position_x][canvasItem.position_y] = -1;

        this.updateConnectedCanvasItems(canvasItem.position_x, canvasItem.position_y, [], null)

        this.addSoftDeletedCanvasItem(canvasItem);

        delete canvasItems[canvasItem.id];

        if (classStudentId !== null) {
            view.updateSeatAssignmentLabel(classStudentId, false);
        }

        view.removeCanvasItem(canvasItemId);
    }

    restoreSoftDeletedCanvasItem(softDeletedCanvasItemId) {
        var softDeletedCanvasItems = this.softDeletedCanvasItems,
            classStudentId         = softDeletedCanvasItems[softDeletedCanvasItemId].student_id;

        if (classStudentId !== null) {
            if (studentController.isStudentSeated(classStudentId)) {
                classStudentId = null;
            }
        }

        this.addCanvasItem($.extend({}, softDeletedCanvasItems[softDeletedCanvasItemId]));

        delete softDeletedCanvasItems[softDeletedCanvasItemId];
    }

    softDeleteCanvasItem(canvasItemId) {
        var canvasItems = this.canvasItems;

        this.removeCanvasItem(canvasItemId);
        this.updateSelected(Object.keys(canvasItems).length > 0 ? [Object.keys(canvasItems)[0]] : []);
    }

    softDeleteCanvasItems() {
        var canvasItems = this.canvasItems,
            selectedIds = this.getSelectedIds();

        for (var index in selectedIds) {
            var canvasItemId = selectedIds[index];

            historyController.addCanvasHistory({
                canvas_item_id:      canvasItemId,
                type:                'deletion',
                previous_position_x: canvasItems[canvasItemId].position_x,
                previous_position_y: canvasItems[canvasItemId].position_y,
                position_x:          null,
                position_y:          null
            });

            this.removeCanvasItem(canvasItemId);
        }

        this.updateSelected(Object.keys(canvasItems).length > 0 ? [Object.keys(canvasItems)[0]] : []);
    }

    deleteCanvasItems() {
        var canvasItemModel        = this.canvasItemModel,
            softDeletedCanvasItems = this.softDeletedCanvasItems,
            classId                = this.classId;

        if (Object.keys(softDeletedCanvasItems).length > 0) {
            canvasItemModel.batchDestroy(classId, softDeletedCanvasItems);
        }
    }

    isCanvasItemInPosition(positionX, positionY) {
        var canvasItemsGrid = this.canvasItemsGrid;

        if (positionX >= canvasItemsGrid.length - 1 || canvasItemsGrid[positionX][positionY] != -1) {
            return true;
        }

        return false;
    }

    // Updates the canvasItem position and syncs with grid
    // returns false if item is not allowed in this location
    updateCanvasItemPosition(canvasItem, positionX, positionY) {
        var canvasItemsGrid = this.canvasItemsGrid;

        if (this.isPositionInBounds(positionX, positionY)) {
            if (!this.isCanvasItemInPosition(positionX, positionY)) { // TODO: Also check if parent is moving into child and allow that
                canvasItemsGrid[canvasItem.position_x][canvasItem.position_y] = -1; // Free up the old position

                canvasItem.position_x = positionX;
                canvasItem.position_y = positionY;

                canvasItemsGrid[positionX][positionY] = canvasItem.id; // Occupy the new position

                return true;
            }
        }

        this.view.updateCanvasItemPosition(canvasItem.id, canvasItem.position_x, canvasItem.position_y); // Ensure the item doesn't move

        return false;
    }

    // Generates a grid array (Size: size * size) that shows all of the locations of canvasItems
    // -1 indicates no item is stored in that spot, anything else is the canvasItem id.

    // Example:
    // [
    //     [-1, -1, -1, 5, ..., 18],
    //     [2, -1, -1, -1, ..., -1],
    //     ...
    //     [-1, 3, -1, -1, ..., -1],
    // ]
    generateGrid(gridSize) {
        var canvasItemsGrid = this.canvasItemsGrid,
            canvasItems = this.canvasItems;

        for (let i = 0; i <= gridSize; i++) {
            canvasItemsGrid[canvasItemsGrid.push([]) - 1].length = gridSize;
            canvasItemsGrid[i].fill(-1);
        }

        for (let i = 0; i < canvasItems.length; i++) {
            canvasItemsGrid[canvasItems[i].position_x][canvasItems[i].position_y] = i;
        }
    }

    initializeDraggable() {
        var items = this.items,
            canvasItems = this.canvasItems,
            view = this.view;

        $('.drag-item').draggable({
            grid: [squareWidth, squareWidth],
            containment: '.drop-target',
            drag: function() {
                hasUserMadeChanges = true; // The users changed something. We'll use this to ask if they want to save

                var parentCanvasItemId = view.getCanvasItemId($(this));

                // We need the new location of the canvasItem as it may be outdated in the canvasItems array
                var newParentCanvasItemPositionX = Math.round($(this).position().left / squareWidth),
                    newParentCanvasItemPositionY = Math.round($(this).position().top / squareWidth),
                    oldParentCanvasItemPositionX = canvasItems[parentCanvasItemId].position_x,
                    oldParentCanvasItemPositionY = canvasItems[parentCanvasItemId].position_y;

                if (newParentCanvasItemPositionX != oldParentCanvasItemPositionX
                        || newParentCanvasItemPositionY != oldParentCanvasItemPositionY) { // Continue if the item has moved
                    if (canvasController.updateCanvasItemPosition(
                        canvasItems[parentCanvasItemId],
                        newParentCanvasItemPositionX,
                        newParentCanvasItemPositionY
                    )) {
                        var lastDeltaX = newParentCanvasItemPositionX - oldParentCanvasItemPositionX,
                            lastDeltaY = newParentCanvasItemPositionY - oldParentCanvasItemPositionY;

                        selectedCanvasItems.parent.last_delta_x = lastDeltaX;
                        selectedCanvasItems.parent.last_delta_y = lastDeltaY;

                        var selectedCanvasItemIds = [parentCanvasItemId];

                        var sortedChildren = []; // Stores childrenIds sorted based on the parents movement direction. If the parent moves right, the children will update from right to left to prevent collisions

                        for (var childrenId in selectedCanvasItems.children) {
                            if (Math.abs(lastDeltaX) >= Math.abs(lastDeltaY) && lastDeltaX > 0) {
                                sortedChildren.push([childrenId, -selectedCanvasItems.children[childrenId].relative_position_x]); // right
                            } else if (Math.abs(lastDeltaX) >= Math.abs(lastDeltaY) && lastDeltaX < 0) {
                                sortedChildren.push([childrenId, selectedCanvasItems.children[childrenId].relative_position_x]); // left
                            } else if (Math.abs(lastDeltaX) <= Math.abs(lastDeltaY) && lastDeltaY > 0) {
                                sortedChildren.push([childrenId, -selectedCanvasItems.children[childrenId].relative_position_y]); // up
                            } else if (Math.abs(lastDeltaX) <= Math.abs(lastDeltaY) && lastDeltaY < 0) {
                                sortedChildren.push([childrenId, selectedCanvasItems.children[childrenId].relative_position_y]); // down
                            }
                        }

                        sortedChildren.sort(
                            function(a, b) {
                                return a[1] - b[1];
                            }
                        );

                        for (let i = 0; i < sortedChildren.length; i++) {
                            var childCanvasItemId = sortedChildren[i][0],
                                childCanvasItem = canvasItems[childCanvasItemId];

                            var oldChildPositionX = childCanvasItem.position_x,
                                oldChildPositionY = childCanvasItem.position_y;

                            var childRelativePositionX = selectedCanvasItems.children[childCanvasItemId].relative_position_x,
                                childRelativePositionY = selectedCanvasItems.children[childCanvasItemId].relative_position_y;
                            
                            if (canvasController.updateCanvasItemPosition(
                                childCanvasItem,
                                newParentCanvasItemPositionX + childRelativePositionX,
                                newParentCanvasItemPositionY + childRelativePositionY
                            )) {
                                view.removeCanvasItem(childCanvasItem.id);

                                selectedCanvasItemIds.push(childCanvasItemId);

                                view.addCanvasItem(items[childCanvasItem.item_id], childCanvasItem);

                                canvasController.updateConnectedCanvasItems(oldChildPositionX, oldChildPositionY, [], null);
                                canvasController.updateConnectedCanvasItems(childCanvasItem.position_x, childCanvasItem.position_y, [
                                    [oldChildPositionX, oldChildPositionY, []]
                                ], 0);
                            }
                        }

                        canvasController.updateSelected(selectedCanvasItemIds);
                        canvasController.initializeDraggable();

                        canvasController.updateConnectedCanvasItems(oldParentCanvasItemPositionX, oldParentCanvasItemPositionY, [], null);
                        canvasController.updateConnectedCanvasItems(newParentCanvasItemPositionX, newParentCanvasItemPositionY, [
                            [oldParentCanvasItemPositionX, oldParentCanvasItemPositionY, []]
                        ], 0);
                    }
                }
            },
            start: function() {
                var pendingCanvasHistoryRecords = historyController.pendingCanvasHistoryRecords,
                    selectedIds = canvasController.getSelectedIds();

                pendingCanvasHistoryRecords = [];

                for (var index in selectedIds) {
                    var canvasItemId = selectedIds[index];

                    pendingCanvasHistoryRecords.push({ // Store the canvasItem's history
                        canvas_item_id:      canvasItemId,
                        type:                'movement',
                        previous_position_x: canvasItems[canvasItemId].position_x,
                        previous_position_y: canvasItems[canvasItemId].position_y
                    });
                }
                
                historyController.pendingCanvasHistoryRecords = pendingCanvasHistoryRecords;

                rect.remove(); // Remove the drag rectangle on canvasItem drag
            },
            stop: function() {
                var pendingCanvasHistoryRecords = historyController.pendingCanvasHistoryRecords;

                if (pendingCanvasHistoryRecords[0].previous_position_x != canvasItems[pendingCanvasHistoryRecords[0].canvas_item_id].position_x
                        || pendingCanvasHistoryRecords[0].previous_position_y != canvasItems[pendingCanvasHistoryRecords[0].canvas_item_id].position_y) {
                    for (var index in pendingCanvasHistoryRecords) {
                        var pendingCanvasHistoryRecord = pendingCanvasHistoryRecords[index],
                            canvasItemId = pendingCanvasHistoryRecord.canvas_item_id;

                        pendingCanvasHistoryRecord.position_x = canvasItems[canvasItemId].position_x;
                        pendingCanvasHistoryRecord.position_y = canvasItems[canvasItemId].position_y;

                        historyController.addCanvasHistory(pendingCanvasHistoryRecord);
                    }
                }

                if (shouldAlwaysLabel) {
                    canvasController.showCanvasItemTooltips();
                }
            },
            create: function() {
                var canvasItemId = view.getCanvasItemId($(this));
                
                canvasController.updateConnectedCanvasItems(canvasItems[canvasItemId].position_x, canvasItems[canvasItemId].position_y, [], null);
            }
        });
    }

    // Handles canvasController.selectedCanvasItems which stores:
    //     Parent - The item the user is dragging/clicked on
    //     Children - Items (if any) that have a relative position to the parent
    // This will also update the selectedBoard in the view
    // Accepts array of canvasItemIds e.g. [2, 5, 7]
    updateSelected(canvasItemIds, shouldClearView = true) {
        var canvasItems = this.canvasItems,
            items       = this.items,
            view        = this.view;

        var selectedBoardItems = [];

        if (canvasItemIds.length > 0) {
            canvasItemIds.forEach(function(canvasItemId, index) {
                var selectedParentId = selectedCanvasItems.parent.id;
                var childrenIndexOf = Object.keys(selectedCanvasItems.children).toString().split(',').map(Number).indexOf(canvasItemId); // Object.keys returns strings, lets change to integers to use indexOf

                if (index == 0) {
                    if (selectedParentId != canvasItemId) {
                        if (childrenIndexOf != -1) { // If the new selected parent was a child, make the old selected parent a child (switch)
                            selectedCanvasItems.children[selectedParentId] = {
                                relative_position_x: canvasItems[selectedParentId].position_x - canvasItems[canvasItemId].position_x,
                                relative_position_y: canvasItems[selectedParentId].position_y - canvasItems[canvasItemId].position_y
                            }

                            delete selectedCanvasItems.children[canvasItemId];
                        } else {
                            selectedCanvasItems.children = {};
                        }
                    }

                    selectedCanvasItems.parent.id = canvasItemId;

                    selectedBoardItems[index] = {
                        id:         canvasItemId,
                        student_id: canvasItems[canvasItemId].student_id,
                        position_x: canvasItems[canvasItemId].position_x,
                        position_y: canvasItems[canvasItemId].position_y,
                        location:   items[canvasItems[canvasItemId].item_id].location,
                        name:       items[canvasItems[canvasItemId].item_id].name
                    };
                } else {
                    if (childrenIndexOf == -1) {
                        selectedCanvasItems.children[canvasItemIds[index]] = {
                            relative_position_x: canvasItems[canvasItemId].position_x - canvasItems[selectedParentId].position_x,
                            relative_position_y: canvasItems[canvasItemId].position_y - canvasItems[selectedParentId].position_y
                        }
                    }
                }
            });

            for (var canvasItemId in selectedCanvasItems.children) {
                var index = Object.keys(selectedCanvasItems.children).indexOf(canvasItemId) + 1;

                if (canvasItemId in canvasItems) { // We might have just deleted the child
                    selectedBoardItems[index] = {
                        id:         canvasItemId,
                        student_id: canvasItems[canvasItemId].student_id,
                        position_x: canvasItems[canvasItemId].position_x,
                        position_y: canvasItems[canvasItemId].position_y,
                        location:   items[canvasItems[canvasItemId].item_id].location,
                        name:       items[canvasItems[canvasItemId].item_id].name
                    };
                }
            }

            view.clearSelectedBoard(selectedCanvasItems);
            view.updateSelectedBoard(selectedBoardItems);
        } else {
            selectedCanvasItems = {
                parent:   {},
                children: {}
            };

            if (shouldClearView) {
                view.clearSelectedBoard(selectedCanvasItems);
            }
        }
    }

    refreshSelected() {
        this.updateSelected(this.getSelectedIds());
    }

    getSelectedIds() {
        var selectedIds = [selectedCanvasItems.parent.id];

        for (var canvasItemId in selectedCanvasItems.children) {
            selectedIds.push(canvasItemId);
        }

        return selectedIds;
    }
    
    getNearestEmpty(positionX, positionY, maxCheckHeight, maxCheckWidth) {
        var x     = 0,
            y     = 0,
            delta = [0, -1],
            potentialEmptyX,
            potentialEmptyY;

        for (let i = 0; i < Math.pow(Math.max(maxCheckWidth, maxCheckHeight), 2); i++) {
            if ((-maxCheckWidth / 2 < x && x <= maxCheckWidth / 2) && (-maxCheckHeight / 2 < y && y <= maxCheckHeight / 2)) {
                potentialEmptyX = x + positionX;
                potentialEmptyY = y + positionY;

                if (this.isPositionInBounds(potentialEmptyX, potentialEmptyY)) {
                    if (!this.isCanvasItemInPosition(x + positionX, y + positionY)) {
                        return [x + positionX, y + positionY];
                    }
                }
            }

            if (x === y || (x < 0 && x === -y) || (x > 0 && x === 1 - y)) {
                delta = [-delta[1], delta[0]];
            }

            x += delta[0];
            y += delta[1];
        }

        return -1;
    }

    updateConnectedCanvasItems(canvasItemPositionX, canvasItemPositionY, checkExemptions, checkExemptionsIndex = null) {
        var canvasItemsGrid = this.canvasItemsGrid,
            canvasItems     = this.canvasItems,
            items           = this.items,
            view            = this.view;

        var canvasItemId = canvasItemsGrid[canvasItemPositionX][canvasItemPositionY];

        var adjacentDirections = [
            ['northwest', 'north', 'northeast'],
            ['west',       null,   'east'],
            ['southwest', 'south', 'southeast']
        ]; // All of the possible directions about an item (null), named to what the images are e.g. (north) desk-connected-north.png
        
        // checkExemptions will keep track of what we've checked so we don't have to check them more than once or infinitely loop
        // e.g. prevent: 'connected south' -> check south -> 'connected north' -> check north -> (loop)
        // 
        // Example:
        // [
        //     5,
        //     7,
        //     [
        //         [5, 6, 'north', false], // 'isDirectConnection', false means don't check this any further
        //         [5, 8, 'south', false]
        //     ]
        // ]

        if (checkExemptionsIndex === null) {
            checkExemptionsIndex = checkExemptions.push([
                canvasItemPositionX,
                canvasItemPositionY,
                [] // Connected items and their directions e.g. [[5, 6, 'north', false], [5, 8, 'south', false]]
            ]) - 1;
        }

        if (canvasItemId == -1 || canvasItems[canvasItemId].item_id == 1) { // Tables are the only supported item type TODO: canvasItemId == -1?
            if (this.isPositionInBounds(canvasItemPositionX, canvasItemPositionY)) { // Check if check location is out of bounds
                for (let i = 0; i < 3; i++) {
                    for (let x = 0; x < 3; x++) {
                        if (i == 1 && x == 1) { // Skip the position we're already in
                            continue;
                        }
                        
                        var checkPositionX = canvasItemPositionX - 1 + x,
                            checkPositionY = canvasItemPositionY - 1 + i;

                        if (this.isPositionInBounds(checkPositionX, checkPositionY)) {
                            var canvasItemIdInCheckPosition = canvasItemsGrid[checkPositionX][checkPositionY],
                                hasAlreadyBeenChecked = utils.isArrayInArray(checkExemptions, [checkPositionX, checkPositionY]),
                                shouldCheckFurther = true; // Only used to check previously checked items

                            if (hasAlreadyBeenChecked) {
                                if (canvasItemIdInCheckPosition != -1 && canvasItems[canvasItemIdInCheckPosition].item_id == 1) { // Connect alreadyChecked item, but put isDirectConnected to false to prevent further checking
                                    hasAlreadyBeenChecked = false;
                                    shouldCheckFurther = false;
                                }
                            }

                            if (!hasAlreadyBeenChecked) {
                                if (canvasItemIdInCheckPosition != -1 && canvasItems[canvasItemIdInCheckPosition].item_id == 1) { // There's a table item in the position we're checking
                                    if (adjacentDirections[i][x].length == 9) { // Check position is northwest, northeast, southeast or southwest (all 9 characters long)
                                        // We need to check to see if adjacent items are present. i.e. northwest requires north (center x, same y) and west (same x, center y)  to be present
                                        var canvasItemIdAdjacentCheckPositionX = canvasItemsGrid[canvasItemPositionX][checkPositionY],
                                            canvasItemIdAdjacentCheckPositionY = canvasItemsGrid[checkPositionX][canvasItemPositionY];

                                        if (canvasItemIdAdjacentCheckPositionX != -1 
                                                && canvasItems[canvasItemIdAdjacentCheckPositionX].item_id == 1
                                                && canvasItemIdAdjacentCheckPositionY != -1
                                                && canvasItems[canvasItemIdAdjacentCheckPositionY].item_id == 1) {
                                            checkExemptions[checkExemptionsIndex][2].push([checkPositionX, checkPositionY, adjacentDirections[i][x], checkExemptionsIndex > 0 || !shouldCheckFurther ? false : true]);
                                        }
                                    } else {
                                        checkExemptions[checkExemptionsIndex][2].push([checkPositionX, checkPositionY, adjacentDirections[i][x], checkExemptionsIndex > 0 || !shouldCheckFurther ? false : true]);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if (checkExemptions[checkExemptionsIndex][2].length > 0) { // There's connected items
                var connectedAdjacentDirections = []; // Stores directions from checkExemptions e.g. [["south", 1, 3], ["west", 0, 3]] => ["south", "west"] => "south-west"

                for (let x = 0; x < checkExemptions[checkExemptionsIndex][2].length; x++) {
                    connectedAdjacentDirections.push(checkExemptions[checkExemptionsIndex][2][x][2]);
                }

                view.updateCanvasItemBackgroundImage(canvasItemId, 'desk-connected-' + connectedAdjacentDirections.join('-') + '.png');

                let isDirectConnection = checkExemptions[checkExemptionsIndex][2][0][3];

                if (isDirectConnection) { // Only check direct connections
                    for (let x = 0; x < checkExemptions[checkExemptionsIndex][2].length; x++) { // Check each connection
                        if (!utils.isArrayInArray(checkExemptions, [checkExemptions[checkExemptionsIndex][2][x][0], checkExemptions[checkExemptionsIndex][2][x][1]])) { 
                            let nextCheckPositionX = checkExemptions[checkExemptionsIndex][2][x][0];
                            let nextCheckPositionY = checkExemptions[checkExemptionsIndex][2][x][1];

                            this.updateConnectedCanvasItems(nextCheckPositionX, nextCheckPositionY, checkExemptions, null);
                        }
                    }
                }
            } else if (canvasItemId != -1 && view.isCanvasItemConnected(canvasItemId)) {
                view.updateCanvasItemBackgroundImage(canvasItemId, items[canvasItems[canvasItemId].item_id].location);
            }
        }
    }

    isPositionInBounds(positionX, positionY) {
        var gridSize = this.gridSize;

        if (positionX >= 0
                && positionY >= 0
                && positionX < gridSize
                && positionY < gridSize) {
            return true;
        }

        return false;
    }

    saveCanvasItems(buttonElement = null, externalLink = null) {   
        var canvasItems            = this.canvasItems,
            softDeletedCanvasItems = this.softDeletedCanvasItems,
            canvasItemModel        = this.canvasItemModel,
            classId                = this.classId;

        var mergedCanvasItems = $.extend({}, canvasItems, softDeletedCanvasItems); // Merge canvasItems and softDeletedCanvasItems since we need to store softDeleted too so user use history to revert back later

        for (var canvasItemId in mergedCanvasItems) {
            var canvasItem = mergedCanvasItems[canvasItemId];

            if (canvasItem.pseudo_item) {
                this.view.removeCanvasItem(canvasItemId);
                canvasItemModel.store(classId, canvasItem);
            }
        }

        if (Object.keys(canvasItems).length > 0) {
            canvasItemModel.batchUpdate(classId, canvasItems);
        }

        this.deleteCanvasItems(this.softDeletedCanvasItems);

        historyController.storeCanvasHistory(buttonElement, externalLink);

        hasUserMadeChanges = false;
    }

    clearSession() {
        this.view.removeCanvasItems();

        this.canvasItems = {};
        this.canvasItemsGrid = [];

        selectedCanvasItems = {
            parent:   {},
            children: {}
        };

        studentController.classStudents     = {};
        studentController.selectedStudents  = {
            male:   [],
            female: []
        };

        studentController.maleSeatsAvailable   = [];
        studentController.femaleSeatsAvailable = [];
    }

    getTooltipOccupiedPositions() {
        var occupiedTooltipPositions = [],
            canvasItems              = this.canvasItems,
            j;

        for (var index in canvasItems) {
            var canvasItem = canvasItems[index];

            if (canvasItem.tooltip_occupied_positions !== null) {
                for (j = 0; j < canvasItem.tooltip_occupied_positions.length; j++) {
                    var tooltipOccupiedPosition = canvasItem.tooltip_occupied_positions[j];

                    occupiedTooltipPositions.push(tooltipOccupiedPosition);
                }
            }
        }

        return occupiedTooltipPositions;
    }

    showCanvasItemTooltips() {
        var canvasItems   = this.canvasItems,
            selectedIds   = this.getSelectedIds(),
            classStudents = studentController.classStudents,
            canvasItem, classStudentId, classStudent;

        for (var index in canvasItems) {
            canvasItem     = canvasItems[index];
            classStudentId = canvasItem.student_id;

            if (classStudentId !== null) {
                classStudent = classStudents[classStudentId];

                canvasController.view.setCanvasItemTooltip(index, classStudent.name, classStudent.gender);
                canvasController.view.showCanvasItemTooltip(index);
            }
        }
    }

    copyCanvasItems(isCut = false) {
        var selectedIds   = this.getSelectedIds(),
            canvasItems   = this.canvasItems;

        this.copyClipboard = [];

        for (let i = 0; i < selectedIds.length; i++) {
            this.copyClipboard.push(canvasItems[selectedIds[i]]);

            if (isCut) {
                this.removeCanvasItem(selectedIds[i]);
            }
        }
    }

    pasteCanvasItems() {
        var copyClipboard = this.copyClipboard;

        for (var i = 0; i < copyClipboard.length; i++) {
            var copiedCanvasItemPositionX = copyClipboard[i].position_x,
                copiedCanvasItemPositionY = copyClipboard[i].position_y,
                pastedCanvasItemPositionX, pastedCanvasItemPositionY, nearestEmptySpace;


            if (this.canvasItemsGrid[copiedCanvasItemPositionX + 1][copiedCanvasItemPositionY + 1] !== -1 || !this.isPositionInBounds(copiedCanvasItemPositionX + 1, copiedCanvasItemPositionY + 1)) {
                nearestEmptySpace = this.getNearestEmpty(copyClipboard[i].position_x, copyClipboard[i].position_y, 5, 5);

                if (nearestEmptySpace == -1) {
                    alert('There is no space to paste the item at ' + copiedCanvasItemPositionX + ', ' + copiedCanvasItemPositionY);

                    break;
                }

                pastedCanvasItemPositionX = nearestEmptySpace[0];
                pastedCanvasItemPositionY = nearestEmptySpace[1];
            } else {
                pastedCanvasItemPositionX = copiedCanvasItemPositionX + 1;
                pastedCanvasItemPositionY = copiedCanvasItemPositionY + 1;
            }

            this.createCanvasItem(copyClipboard[i].item_id, pastedCanvasItemPositionX, pastedCanvasItemPositionY);

            copyClipboard[i] = this.canvasItems[Object.keys(this.canvasItems)[Object.keys(this.canvasItems).length - 1]]
        }
    }
}