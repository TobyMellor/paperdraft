var canvasController;
var rect;

(function() {
    'use strict';
    
    // Get the absolute position of a particular object on the page
    // Source: http://www.quirksmode.org/js/findpos.html
    function findPos(obj) {
        var curleft = 0, curtop = 0;
        if (obj.offsetParent) {
            do {
                curleft += obj.offsetLeft;
                curtop += obj.offsetTop;
            } while (obj = obj.offsetParent);
            return [curleft, curtop];
        } else {
            return false;
        }
    }
    
    // Get the current position of the mouse, relative to the page
    function getCoords(event) {
        event = event || window.event;
        if (event.pageX || event.pageY) {
            return {x: event.pageX, y: event.pageY};
        }
        return {
            x: event.clientX + document.body.scrollLeft - document.body.clientLeft,
            y: event.clientY + document.body.scrollTop  - document.body.clientTop
        };
    }
    
    // Draw the shape based on the current coordinates and position at onmousedown
    function doDraw(event) {
        if (rect) {
            var mousePos = getCoords(event);
            var currentX = mousePos.x - offset[0];
            var currentY = mousePos.y - offset[1];
            var width = currentX - startX;
            var height = currentY - startY;

            if (width < 0) {
                rect.attr({'x': currentX, 'width': width * -1});
            } else {
                rect.attr({'x': startX, 'width': width});
            }

            if (height < 0) {
                rect.attr({'y': currentY, 'height': height * -1});
            } else {
                rect.attr({'y': startY, 'height': height});
            }
        }
    }

    function getCanvasItemsInsideSelection()
    {
        var leftX = startX / squareWidth;
        var rightX = endX / squareWidth;

        var topY = startY / squareWidth;
        var bottomY = endY / squareWidth;

        if (startX >= endX) {
            leftX = endX / squareWidth;
            rightX = startX / squareWidth;
        }

        if (startY >= endY) {
            topY = endY / squareWidth;
            bottomY = startY / squareWidth;
        }

        var selectedCanvasItems = [];
        var canvasItems = canvasController.canvasItems;

        for (var index in canvasItems) {
            var canvasItem = canvasItems[index];

            if (canvasItem.position_x >= Math.floor(leftX)
                    && canvasItem.position_x <= rightX
                    && canvasItem.position_y >= Math.floor(topY)
                    && canvasItem.position_y <= bottomY) {
                selectedCanvasItems.push(index);
            }
        }

        if (selectedCanvasItems.length > 0) {
            canvasController.updateSelected(selectedCanvasItems);
        }
    }
    
    // Global variables
    var dropTarget = document.getElementsByClassName('drop-target')[0];
    var canvas = new Raphael('canvas');
    var startX = 0, startY = 0, endX = 0, endY = 0;
    var offset = findPos(dropTarget);
    rect = canvas.rect(0, 0, 0, 0);
    
    dropTarget.onmousedown = function(event) {
        var mouseCoords = getCoords(event);
        startX = mouseCoords.x - offset[0];
        startY = mouseCoords.y - offset[1];
        rect = canvas.rect(startX, startY, 0, 0);
        document.onmousemove = doDraw;
    };
    
    document.onmouseup = function(event) {
        if (!rect.removed) {
            rect.remove();

            endX = getCoords(event).x - $('.drop-target').offset().left;
            endY = getCoords(event).y - $('.drop-target').offset().top;

            getCanvasItemsInsideSelection();
        }

        document.onmousemove = null;
    };
})();