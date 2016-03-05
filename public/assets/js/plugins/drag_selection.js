var activeObjects;

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
        if(checkAgain) {
            $('.drag-item').each(function() {
                if ($(this).hasClass('ui-draggable-dragging')) {
                    isDragging = true;
                }
            });
        }

        if(!isDragging) {
            checkAgain = false;
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
    }

    function getActiveObjectsInsideSelection()
    {
        var leftX = startX / 32;
        var rightX = endX / 32;

        var topY = startY / 32;
        var bottomY = endY / 32;

        if(startX >= endX) {
            leftX = endX / 32;
            rightX = startX / 32;
        }
        if(startY >= endY) {
            topY = endY / 32;
            bottomY = startY / 32;
        }

        var selectedObjects = [];

        for(var i = 0; i < activeObjects.length; i++) {
            if(activeObjects[i].object_position_x >= Math.floor(leftX)
                    && activeObjects[i].object_position_x <= rightX
                    && activeObjects[i].object_position_y >= Math.floor(topY)
                    && activeObjects[i].object_position_y <= bottomY) {
                selectedObjects.push($('div[active-object-id="' + i + '"]'));
            }
        }

        if(selectedObjects.length > 0)
            updateSelected(selectedObjects);
    }
    
    // Global variables
    var dropTarget = document.getElementsByClassName('drop-target')[0];
    var paper = new Raphael('paper');
    var rect;
    var startX = 0, startY = 0, endX = 0, endY = 0;
    var offset = findPos(dropTarget);
    var isDragging = false;
    var checkAgain = true;
    
    dropTarget.onmousedown = function(event) {
        var mouseCoords = getCoords(event);
        startX = mouseCoords.x - offset[0];
        startY = mouseCoords.y - offset[1];
        rect = paper.rect(startX, startY, 0, 0);
        document.onmousemove = doDraw;
    };
    
    document.onmouseup = function(event) {
        if(!isDragging) {
            if (!rect.removed) {
                rect.remove();

                endX = getCoords(event).x - $('.drop-target').offset().left;
                endY = getCoords(event).y - $('.drop-target').offset().top;

                getActiveObjectsInsideSelection();
            }
        }

        document.onmousemove = null;
        isDragging = false;
        checkAgain = true;
    };
})();