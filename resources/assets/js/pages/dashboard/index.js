$(document).ready(function() {
    $('.drop-target').on('mousedown', '.drag-item', function() {
        var canvasItemId = canvasController.view.getCanvasItemId($(this));
        var selectedCanvasItemIds = [canvasItemId];

        if (Object.keys(selectedCanvasItems.children).indexOf(canvasItemId) != -1) {
            for (var selectedCanvasItemId in selectedCanvasItems.children) {
                if (selectedCanvasItemId == canvasItemId) {
                    selectedCanvasItemId = selectedCanvasItems.parent.id;
                }

                selectedCanvasItemIds.push(selectedCanvasItemId);
            }
        }

        canvasController.updateSelected(selectedCanvasItemIds);
    });

    $('.drop-target').on('click', '.drag-item', function() {
        var canvasItemId = canvasController.view.getCanvasItemId($(this));

        canvasController.updateSelected([], false);
        canvasController.updateSelected([canvasItemId]);
    });

    $('.create-canvas-item').click(function() {
        var itemId = parseInt($(this).attr('item-id'));

        canvasController.createPseudoCanvasItem(itemId);
    });

    $('#save-button').click(function() {
        canvasController.saveCanvasItems();
        userController.saveUserPreferences();

        notificationController.handleNotification('The seating plan was saved successfully!', 'success');
    });

    $('#undo-button').click(function() {
        historyController.undoCanvasAction();
    });

    $('#redo-button').click(function() {
        historyController.redoCanvasAction();
    });

    $('#copy-selected').click(function() {
        canvasController.copyCanvasItems();

        $('#paste-selected').fadeIn();
    });

    $('#paste-selected').click(function() {
        canvasController.pasteCanvasItems();
    });

    $('.class-button').not('.class-button-create').click(function() {
        if (hasUserMadeChanges) {
            canvasController.view.confirmPageLeave($(this));
        } else {
            canvasController.view.changeClass($(this));
        }
    });

    $('#selected-delete').click(function() {
        canvasController.softDeleteCanvasItems();
    });

    $(document).on('keydown', function(e) {
        if ((e.which === 8 || e.which === 46) && !$(e.target).is('input, textarea')) { // The 'delete' or 'backspace' key, but not when the user is typing
            e.preventDefault();
            canvasController.softDeleteCanvasItems();
        } else if (e.ctrlKey || e.metaKey) { // The 'ctrl' (windows) or 'cmd' (mac) key
            if (e.which === 90) { // The 'z' key (combined with ctrl or cmd)
                historyController.undoCanvasAction();
            } else if (e.which === 89) { // The 'y' key (combined with ctrl or cmd)
                historyController.redoCanvasAction();
            }
        }
    }).bind('copy', function() {
        canvasController.copyCanvasItems();
    }).bind('cut', function() {
        canvasController.copyCanvasItems(true);
    }).bind('paste', function() {
        canvasController.pasteCanvasItems();
    });

    $(document).on('click', 'a', function(event) {
        if ($(this).attr('href') !== 'javascript:void(0);') {
            if (hasUserMadeChanges) {
                event.preventDefault();

                var clickedLink = $(this).attr('href');

                if (clickedLink != 'javascript:void(0);') {
                    canvasController.view.confirmPageLeave(null, clickedLink);
                }
            }
        }
    });

    $(document).on('change', '.selected-student', function() {
        studentController.updateSelectedStudents();
    });

    $(document).on('click', '#select-all', function() {
        var selectAll = $(this);

        $('.selected-student').each(function() {
            if ($(this).prop('checked') && selectAll.text() === 'Deselect All') {
                $(this).click();
            } else if (!$(this).prop('checked') && selectAll.text() === 'Select All') {
                $(this).click();
            }
        });

        if (selectAll.text() === 'Deselect All') {
            selectAll.text('Select All');
        } else {
            selectAll.text('Deselect All');
        }
    });

    $(document).on('click', '#generate-seating-positions', function() {
        $('#algorithm-boy-girl-settings').hide();
        $('select[name="assignment-algorithm"]').val('').trigger('change');
        $('#auto-assign-seating-positions').prop('disabled', true);

        studentController.clearExemptions();
        canvasController.view.updateExemptionList();

        $('#modal-assign-seating-positions').modal('show');
    });

    $(document).on('click', '#remove-seating-positions', function() {
        studentController.clearSeatedStudents();
        notificationController.handleNotification('All students have been successfully cleared from all seats!', 'success');
    });

    $(document).on('change', 'select[name="assignment-algorithm"]', function() {
        if ($(this).val() === 'boy-girl') {
            var selectedStudents       = studentController.getSelectedStudents(),
                sortedSelectedStudents = studentController.selectedStudents;

            $('#boy-girl-warning').hide();
            $('#boy-girl-warning-text').text('');

            if (Object.keys(canvasController.canvasItems).length < selectedStudents.length) {
                $('#boy-girl-warning-text').append('You have less desks than students. Some students will not be allocated a desk.<br />');
            }

            if (Math.abs(sortedSelectedStudents.male.length - sortedSelectedStudents.female.length) > sortedSelectedStudents.male.length * 0.25) {
                $('#boy-girl-warning-text').append('You have a drastically different number of boys/girls. Some students may be seated with the same gender.');
            }

            if ($('#boy-girl-warning-text').text() !== '') {
                $('#boy-girl-warning').show();
            }

            $('#algorithm-boy-girl-settings').fadeIn();

            $('#auto-assign-seating-positions').prop('disabled', false);
        }
    });

    $(document).on('change', 'select[name="exemption-1"]', function() {
        canvasController.view.updateExemptionList(parseInt($(this).val()));
    });

    $(document).on('change', 'select[name="exemption-2"]', function() {
        $('#add-exemption').prop('disabled', false);
    });

    $(document).on('click', '#add-exemption', function() {
        var firstStudentId  = parseInt($('select[name="exemption-1"]').val()),
            secondStudentId = parseInt($('select[name="exemption-2"]').val());

        studentController.addExemption(firstStudentId, secondStudentId);
        canvasController.view.updateExemptionList(firstStudentId);
    });

    $(document).on('click', '#remove-exemption', function() {
        var firstStudentId  = parseInt($(this).attr('first-student-id')),
            secondStudentId = parseInt($(this).attr('second-student-id'));

        studentController.removeExemption(firstStudentId, secondStudentId);
    });

    $(document).on('click', '#auto-assign-seating-positions', function() {
        $('#modal-assign-seating-positions').modal('hide');

        if ($('select[name="assignment-algorithm"]').val() === 'boy-girl') {
            studentController.assignmentAlgorithmBoyGirl();
        }
    });

    $(document).on('click', '#always-label-seats', function() {
        shouldAlwaysLabel = $(this).prop('checked');

        userController.setUserPreference('always_labelled', shouldAlwaysLabel);
    });

    $(document).delegate('#delete-student', 'click', function() {
        var tableRow = $(this).parent().parent();

        studentController.deleteClassStudent(tableRow.attr('class-student-id'));

        tableRow.fadeOut(300, function() {
            $(this).remove();


            if ($('.student-table').find('tr').length === 1) {
                $('#student-panel-content').fadeOut(300, function() {
                    $('#no-students').fadeIn();
                });
            }
        });
    });

    $(document).on('click', '.clear-seatingplan', function() {
        canvasController.view.confirmPlanClear();
    });

    $(document).on('click', '#remove-seated-students', function() {
        studentController.removeSelectedStudents();
    });

    $('select').select2();
    $('.styled').uniform({
        radioClass: 'choice'
    });
    $('.styled-white').uniform({
        wrapperClass: 'uniform-styled-white'
    });

    $('.drop-target').css('width', squareWidth * 23);
    $('.drop-target').css('height', squareWidth * 23);
    $('.drop-target').css('background-size', squareWidth);
    $('#canvas').css('margin-top', ($('.main-canvas').width() - (squareWidth * 23)) / 2);
    $('#canvas').css('margin-left', ($('.main-canvas').width() - (squareWidth * 23)) / 2);
    $('.main-panel-body').css('height', $('.main-canvas').width());
    $('svg').attr('width', $('#canvas').width());
    $('svg').attr('height', $('#canvas').width());


    $(".row-sortable").sortable({
        connectWith: '.row-sortable',
        items: '.panel',
        helper: 'original',
        cursor: 'move',
        handle: '[data-action=move]',
        revert: 100,
        containment: '.content-wrapper',
        forceHelperSize: true,
        placeholder: 'sortable-placeholder',
        forcePlaceholderSize: true,
        tolerance: 'pointer',
        start: function(e, ui){
            ui.placeholder.height(ui.item.outerHeight());
        },
        stop: function (e, ui) {
            var panelPositions = [null, null, null];

            panelPositions[$('.panel').index($('.panel[name="selected_panel"]')) - 1] = 'selected_panel';
            panelPositions[$('.panel').index($('.panel[name="item_panel"]')) - 1]     = 'item_panel';
            panelPositions[$('.panel').index($('.panel[name="student_panel"]')) - 1]  = 'student_panel';

            userController.setUserPreference('panel_positions', JSON.stringify(panelPositions));
        }
    });

    bootstrapper(); // Start initializing
});

// This is the function generating the position by calculating
// mouse position, different offsets and option.
$.ui.draggable.prototype._generatePosition = function(event, constrainPosition) {
    var containment, co, top, left,
        o = this.options,
        scrollIsRootNode = this._isRootNode(this.scrollParent[0]),
        pageX = event.pageX,
        pageY = event.pageY;

    // Cache the scroll
    if (!scrollIsRootNode || !this.offset.scroll) {
        this.offset.scroll = {
            top: this.scrollParent.scrollTop(),
            left: this.scrollParent.scrollLeft()
        };
    }

    /*
     * - Position constraining -
     * Constrain the position to a mix of grid, containment.
     */

    // If we are not dragging yet, we won't check for options
    if (constrainPosition) {
        if (this.containment) {
            if (this.relativeContainer) {
                co = this.relativeContainer.offset();
                containment = [
                    this.containment[0] + co.left,
                    this.containment[1] + co.top,
                    this.containment[2] + co.left,
                    this.containment[3] + co.top
                ];
            } else {
                containment = this.containment;
            }

            if (event.pageX - this.offset.click.left < containment[0]) {
                pageX = containment[0] + this.offset.click.left;
            }
            if (event.pageY - this.offset.click.top < containment[1]) {
                pageY = containment[1] + this.offset.click.top;
            }
            if (event.pageX - this.offset.click.left > containment[2]) {
                pageX = containment[2] + this.offset.click.left;
            }
            if (event.pageY - this.offset.click.top > containment[3]) {
                pageY = containment[3] + this.offset.click.top;
            }
        }

        if (o.grid) {
            // Check for grid elements set to 0 to prevent divide by 0 error causing invalid argument errors in IE (see ticket #6950)
            top = o.grid[1] ? this.originalPageY + Math.round((pageY - this.originalPageY) / o.grid[1]) * o.grid[1] : this.originalPageY;
            pageY = containment ? ((top - this.offset.click.top >= containment[1] || top - this.offset.click.top > containment[3]) ? top : ((top - this.offset.click.top >= containment[1]) ? top - o.grid[1] : top + o.grid[1])) : top;

            left = o.grid[0] ? this.originalPageX + Math.round((pageX - this.originalPageX) / o.grid[0]) * o.grid[0] : this.originalPageX;
            pageX = containment ? ((left - this.offset.click.left >= containment[0] || left - this.offset.click.left > containment[2]) ? left : ((left - this.offset.click.left >= containment[0]) ? left - o.grid[0] : left + o.grid[0])) : left;
        }

        if (o.axis === "y") {
            pageX = this.originalPageX;
        }

        if (o.axis === "x") {
            pageY = this.originalPageY;
        }
    }

    // This is the only part added to the original function.
    // You have access to the updated position after it's been
    // updated through containment and grid, but before the
    // element is modified.
    // If there's an object in position, you prevent dragging.

    if (canvasController.isCanvasItemInPosition(
            Math.round((pageX - this.offset.click.left - this.offset.parent.left) / squareWidth),
            Math.round((pageY - this.offset.click.top - this.offset.parent.top) / squareWidth))) {
        return false;
    }

    return {
        top: (
            pageY - // The absolute mouse position
            this.offset.click.top - // Click offset (relative to the element)
            this.offset.relative.top - // Only for relative positioned nodes: Relative offset from element to offset parent
            this.offset.parent.top + // The offsetParent's offset without borders (offset + border)
            (this.cssPosition === "fixed" ? -this.offset.scroll.top : (scrollIsRootNode ? 0 : this.offset.scroll.top))
        ),
        left: (
            pageX - // The absolute mouse position
            this.offset.click.left - // Click offset (relative to the element)
            this.offset.relative.left - // Only for relative positioned nodes: Relative offset from element to offset parent
            this.offset.parent.left + // The offsetParent's offset without borders (offset + border)
            (this.cssPosition === "fixed" ? -this.offset.scroll.left : (scrollIsRootNode ? 0 : this.offset.scroll.left))
        )
    };
}