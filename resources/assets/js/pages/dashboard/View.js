class View {
    addCanvasItem(item, canvasItem) {
        var canvasItemId        = canvasItem.id,
            classStudentId      = canvasItem.student_id,
            canvasItemPositionX = canvasItem.position_x * squareWidth,
            canvasItemPositionY = canvasItem.position_y * squareWidth;

        var itemLocation = item.location,
            itemWidth    = item.width,
            itemHeight   = item.height; // TODO: Change to multipliers, don't store actual height

        if (classStudentId !== null) {
            this.updateSeatAssignmentLabel(classStudentId, true);
        }

        $('.drop-target').append(
            '<div class="drag-item" canvas-item-id="' + canvasItemId + '" style="left: ' + canvasItemPositionX + 'px; top: ' + canvasItemPositionY + 'px; background-image: url(\'/assets/images/objects/' + itemLocation + '\'); background-size: ' + squareWidth + 'px; height: ' + squareWidth + 'px; width: ' + squareWidth + 'px;"></div>'
        );

        $('.drop-target').children().show();
    }

    addClassStudent(classStudent) {
        var classStudentId          = classStudent.id,
            name                    = classStudent.name,
            gender                  = classStudent.gender,
            pupilPremium            = classStudent.pupil_premium,
            abilityCap              = classStudent.ability_cap,
            currentAttainmentLevel  = classStudent.current_attainment_level,
            targetAttainmentLevel   = classStudent.target_attainment_level;

        $('#class-students').append(
            '<tr class-student-id="' + classStudentId + '">' +
                '<td class="student-td-1">' +
                    '<input class="styled selected-student" checked="checked" class-student-id="' + classStudentId + '" type="checkbox">' +
                '</td>' +
                '<td class="student-td-2">' +
                    '<div class="media-left media-middle">' +
                        '<a class="btn bg-teal-400 ' + (gender === 'male' ? 'tooltip-blue' : 'tooltip-pink') + ' btn-rounded btn-icon btn-xs" href="javascript:void(0);">' +
                            '<div class="letter-icon">' + name.charAt(0).toUpperCase() + '</div>' +
                        '</a>' +
                    '</div>' +
                    '<div class="media-body">' +
                        '<a href="javascript:void(0);" class="display-inline-block text-default text-semibold letter-icon-title">' +
                            name +
                        '</a>' +
                        '<div class="text-muted text-size-small assignment-status">' +
                            '<span class="status-mark border-danger position-left"></span> Not assigned to a seat' +
                        '</div>' +
                    '</div>' +
                '</td>' +
                '<td class="student-td-3">' +
                    '<span class="text-muted text-size-small">' + (gender[0].toUpperCase() + gender.slice(1)) + '</span>' +
                '</td>' +
                '<td class="student-td-4">' +
                    '<button type="button" class="btn btn-danger" id="delete-student">' +
                        '<i class="icon-diff-removed"></i>' +
                    '</button>' +
                '</td>' +
            '</tr>');

        $('.styled').uniform();
    }

    updateCanvasItemPosition(canvasItemId, canvasItemPositionX, canvasItemPositionY) {
        var canvasItem = this.getCanvasItem(canvasItemId);

        canvasItem.css('left', canvasItemPositionX * squareWidth);
        canvasItem.css('top', canvasItemPositionY * squareWidth);
    }

    removeCanvasItem(canvasItemId) {
        var canvasItem = this.getCanvasItem(canvasItemId);

        canvasItem.tooltip('destroy');
        canvasItem.draggable('destroy');
        canvasItem.remove();
    }

    removeCanvasItems() {
        $('.drag-item').fadeOut(1000, function() {
            $(this).draggable('destroy');
            $(this).tooltip('destroy');
            $(this).remove();
        });
    }

    clearSelectedBoard(selectedCanvasItems) {
        if ($.isEmptyObject(selectedCanvasItems.parent)) {
            $('#selected-no-items').parent().children(':nth-child(2)').fadeOut(250, function() {
                $('#selected-no-items').fadeIn(250);
            });
        } else {
            $('#selected-no-items').fadeOut(250, function() {
                $('#selected-no-items').parent().children(':nth-child(2)').fadeIn(250);
            });
        }

        $('#selected-position').empty();
        $('#selected-students').empty();
        $('.selected-name').empty();
        $('.drag-item').removeClass('outline-highlight');
    }

    // TODO: Needs code refactoring
    updateSelectedBoard(selectedBoardItems) {
        if (Object.keys(selectedBoardItems).length > 2) {
            selectedBoardItems[selectedBoardItems.length - 1].name = '[' + (selectedBoardItems.length - 2) + ' more]';
        }
        
        var selectedItemNames = $.extend(true, [], selectedBoardItems),
            selectedStudents = [];

        selectedItemNames.splice(1, selectedBoardItems.length - 3);

        selectedItemNames = selectedItemNames.map(function(selectedName){
            return selectedName.name;
        }).join(', ');

        $('.selected-name').text(selectedItemNames);
        $('#selected-image').attr('src', assetsBasePath + selectedBoardItems[0].location);
        $('#selected-delete').html('Delete <i class="icon-database-remove position-right"></i>');
        $('#remove-seated-students').hide();

        if (!shouldAlwaysLabel) {
            $('.drag-item').tooltip('destroy');
        }

        for (var index in selectedBoardItems) {
            var selectedBoardItem          = selectedBoardItems[index],
                selectedBoardItemId        = selectedBoardItem.id,
                selectedBoardItemPositionX = selectedBoardItem.position_x,
                selectedBoardItemPositionY = selectedBoardItem.position_y;

            if (index == 1) {
                $('#selected-delete').html('Delete All <i class="icon-database-remove position-right"></i>');
            }

            if (index == 2) {
                $('#selected-position').append('<strong>' + selectedBoardItems[Object.keys(selectedBoardItems).length - 1].name + '</strong>');
            } else if (index < 2) {
                $('#selected-position').append('<strong>X:</strong> ' + selectedBoardItemPositionX + ', <strong>Y:</strong> ' + selectedBoardItemPositionY + '<br />');
            }

            var classStudents = studentController.classStudents;

            if (Object.keys(studentController.classStudents).length > 0) {
                if (selectedBoardItem.student_id !== null) {
                    var canvasItems = canvasController.canvasItems;

                    selectedStudents.push(studentController.classStudents[selectedBoardItem.student_id].name);

                    this.setCanvasItemTooltip(selectedBoardItemId, classStudents[canvasItems[selectedBoardItemId].student_id].name, classStudents[canvasItems[selectedBoardItemId].student_id].gender);
                    this.showCanvasItemTooltip(selectedBoardItemId);

                    $('#remove-seated-students').show();
                }
            } else {
                $('#selected-students').text('There are no students in this class.');
            }

            this.getCanvasItem(selectedBoardItemId).addClass('outline-highlight');
        }

        if (Object.keys(studentController.classStudents).length > 0) {
            if (selectedStudents.length > 1) {
                $('#selected-students').text(selectedStudents.slice(0, selectedStudents.length - 1).join(', ') + ", and " + selectedStudents.slice(-1));
            } else if (selectedStudents.length === 1) {
                $('#selected-students').text(selectedStudents[0]);
            } else {
                $('#selected-students').text('No student is assigned to the desk(s).');
            }
        }
    }

    getCanvasItemId(element) {
        return element.attr('canvas-item-id');
    }

    getCanvasItem(canvasItemId) {
        return $('.drag-item[canvas-item-id=' + canvasItemId + ']');
    }

    isCanvasItemConnected(canvasItemId) {
        var canvasItem = this.getCanvasItem(canvasItemId);

        if (canvasItem.css('background-image').indexOf('desk-connected-') > -1) {
            return true;
        }

        return false;
    }

    updateCanvasItemBackgroundImage(canvasItemId, canvasBackgroundImage) {
        var canvasItemElement = this.getCanvasItem(canvasItemId);
        
        canvasItemElement.css('background-image', 'url(\'' + assetsBasePath + canvasBackgroundImage + '\')');
    }

    setActiveClass(classId) {
        $('.class-button-active').removeClass('class-button-active').addClass('class-button');
        $('.class-options-active').removeClass('class-options-active').addClass('class-options');

        $('.class-button[class-id=' + classId + ']').removeClass('class-button').addClass('class-button-active');
        $('.class-options[class-id=' + classId + ']').removeClass('class-options').addClass('class-options-active');

        $('#classes-href').attr('href', '/dashboard/classes/' + classId);
        $('.class-button-create').attr('href', '/dashboard/classes/' + classId + '/create');

        $('#class-name').text($('.class-button-active').find('.sidebar-class-name').text());
    }

    changeClass(buttonElement) {
        hasUserMadeChanges = false;

        $('.class-button.class-button-active').removeClass('class-button-active');
        buttonElement.addClass('class-button-active');

        $('.class-options-active').removeClass('class-options-active').addClass('class-options');
        buttonElement.parent()
            .children().eq(1)
            .children().eq(0)
            .addClass('class-options-active')
            .removeClass('class-options');

        $('#class-students').html('');

        var classId   = parseInt(buttonElement.attr('class-id'));
        var classType = buttonElement.attr('type');

        canvasController.view.setActiveClass(classId);

        canvasController.classId = classId;
        canvasController.clearSession();

        canvasController.loadCanvasItems();
        studentController.loadClassStudents();
        historyController.loadCanvasHistory();

        if (classType === 'seating-plan') {
            $('.panel[name="student_panel"]').fadeIn();
            $('#students-list').fadeIn();
        } else {
            $('.panel[name="student_panel"]').fadeOut();
            $('#students-list').fadeOut();
        }
    }

    updateStudentButtons() {
        var selectedStudents = this.getSelectedStudents(),
            generateButton   = $('#generate-seating-positions');

        if (selectedStudents.length > 0) {
            generateButton.text('Assign Seats to Selected (' + selectedStudents.length + ')');

            generateButton.parent().show();
        } else {
            generateButton.parent().hide();
        }
    }

    getSelectedStudents() {
        return $('.selected-student:checked').map(function() {
            return $(this).attr('class-student-id');
        }).get();
    }

    setCanvasItemTooltip(canvasItemId, studentName, studentGender) {
        var canvasItem = this.getCanvasItem(canvasItemId),
            nameSplit  = studentName.split(' ');

        if (nameSplit.length > 1) {
            studentName = nameSplit[0] + ' ' + nameSplit[1].charAt(0);
        }

        if (studentName.length > 9) {
            studentName = studentName.split(' ')[0].charAt(0);
        }

        if (shouldAlwaysLabel) {
            canvasItem.tooltip('destroy');
        }

        canvasItem.attr('title', studentName);

        if (studentGender === 'male') {
            canvasItem.tooltip({
                template: '<div class="tooltip"><div class="bg-teal tooltip-blue"><div class="tooltip-arrow"></div><div class="tooltip-inner custom-tooltip-inner"></div></div></div>',
                trigger: 'manual',
                animation: false,
                placement: this.getBestTooltipPlacement(canvasItemId)
            });
        } else {
            canvasItem.tooltip({
                template: '<div class="tooltip"><div class="bg-teal tooltip-pink"><div class="tooltip-arrow"></div><div class="tooltip-inner custom-tooltip-inner"></div></div></div>',
                trigger: 'manual',
                animation: false,
                placement: this.getBestTooltipPlacement(canvasItemId)
            });
        }

        if (shouldAlwaysLabel) {
            canvasItem.tooltip('show');
        }
    }

    showCanvasItemTooltip(canvasItemId) {
        var canvasItem = this.getCanvasItem(canvasItemId);

        canvasItem.tooltip('show');
    }

    getBestTooltipPlacement(canvasItemId) {
        var canvasItem = canvasController.canvasItems[canvasItemId];
        canvasItem.tooltip_occupied_positions = null;

        var occupiedTooltipPositions = canvasController.getTooltipOccupiedPositions(),
            checkPositions = [
                [
                    [canvasItem.position_x,     canvasItem.position_y - 1], // directly above
                    [canvasItem.position_x - 1, canvasItem.position_y - 1],
                    [canvasItem.position_x + 1, canvasItem.position_y - 1]
                ],
                [
                    [canvasItem.position_x,     canvasItem.position_y + 1], // directly below
                    [canvasItem.position_x - 1, canvasItem.position_y + 1],
                    [canvasItem.position_x + 1, canvasItem.position_y + 1]
                ],
                [
                    [canvasItem.position_x + 1, canvasItem.position_y], // directly right
                    [canvasItem.position_x + 2, canvasItem.position_y],
                    [canvasItem.position_x + 3, canvasItem.position_y]
                ],
                [
                    [canvasItem.position_x - 1, canvasItem.position_y], // directly left
                    [canvasItem.position_x - 2, canvasItem.position_y],
                    [canvasItem.position_x - 3, canvasItem.position_y]
                ]
            ],
            checkExemptions = [],
            checkPositionX, checkPositionY;

        for (var i = 0; i < checkPositions.length; i++) {
            if (utils.isArrayInArray(occupiedTooltipPositions, [checkPositions[i][0][0], checkPositions[i][0][1]])) {
                checkExemptions.push(i);
                break;
            }
        }

        for (var i = 0; i < checkPositions.length; i++) {
            if (checkExemptions.indexOf(i) === -1) {
                for (var j = 0; j < checkPositions[i].length; j++) {
                    if (i > 1 && j > 0) {
                        continue; // don't bother checking for chairs too far to left/right
                    }

                    if (!canvasController.isPositionInBounds(checkPositions[i][j][0], checkPositions[i][j][1]) || canvasController.isCanvasItemInPosition(checkPositions[i][j][0], checkPositions[i][j][1])) {
                        break;
                    }
                }

                if (j === 3) {
                    canvasItem.tooltip_occupied_positions = checkPositions[i];

                    switch (i) {
                        case 0:
                            return 'top';
                        case 1:
                            return 'bottom';
                        case 2:
                            return 'right';
                        default:
                            return 'left';
                    }
                }
            }
        }

        canvasItem.tooltip_occupied_positions = checkPositions[0];

        return 'top';
    }

    updateSeatAssignmentLabels() {
        var classStudents = studentController.classStudents,
            canvasItems   = canvasController.canvasItems,
            canvasItem, classStudentId, classStudent;

        for (var index in canvasItems) {
            canvasItem     = canvasItems[index];
            classStudentId = canvasItem.student_id;

            if (classStudentId !== null) {
                classStudent = classStudents[classStudentId];

                $('tr[class-student-id="' + classStudentId + '"]').find('.media-body').html(
                    '<a href="javascript:void(0);" class="display-inline-block text-default text-semibold letter-icon-title">' +
                        classStudent.name +
                    '</a>' +
                    '<div class="text-muted text-size-small assignment-status">' +
                        '<span class="status-mark border-success position-left"></span> Assigned to a seat' +
                    '</div>'
                );
            }
        }
    }

    updateSeatAssignmentLabel(classStudentId, isAssignedSeat) {
        var classStudents = studentController.classStudents;

        if (Object.keys(classStudents).length > 0) {
            var classStudent = classStudents[classStudentId];

            $('tr[class-student-id="' + classStudentId + '"]').find('.media-body').html(
                '<a href="javascript:void(0);" class="display-inline-block text-default text-semibold letter-icon-title">' +
                    classStudent.name +
                '</a>' +
                '<div class="text-muted text-size-small assignment-status">' +
                    '<span class="status-mark ' + (isAssignedSeat ? 'border-success' : 'border-danger') + ' position-left"></span> ' + (isAssignedSeat ? 'Assigned to a seat' : 'Not assigned to a seat') + 
                '</div>'
            );
        }
    }

    updateExemptionList(firstStudentId = null) {
        var classStudents = studentController.classStudents,
            potentialExemptions;

        if (firstStudentId === null) {
            potentialExemptions = studentController.getPotentialExemptions();
        } else {
            potentialExemptions = studentController.getPotentialExemptions(firstStudentId);
        }

        $('select[name="exemption-1"]').html('<option value="" disabled selected>Select 1st troublesum student</option>');

        $.each(classStudents, function (i, classStudent) {
            $('select[name="exemption-1"]').append($('<option>', { 
                value: classStudent.student_id,
                text:  classStudent.name
            }));
        });

        $('select[name="exemption-2"]').html('<option value="" disabled selected>Select 2nd troublesum student</option>');

        $.each(potentialExemptions.second_students, function (i, potentialExemption) {
            $('select[name="exemption-2"]').append($('<option>', { 
                value: potentialExemption[0],
                text:  potentialExemption[1]
            }));
        });

        $('select[name="exemption-1"]').val(potentialExemptions.first_student).select2();
        $('select[name="exemption-2"]').val('').select2();

        $('#add-exemption').prop('disabled', true);
    }

    addExemption(firstStudentId, secondStudentId) {
        var classStudents = studentController.classStudents;

        $('#exemptions-table-body').append(
            '<tr>' +
                '<td>' + classStudents[firstStudentId].name + '</td>' +
                '<td>' + classStudents[secondStudentId].name + '</td>' +
                '<td>' +
                    '<button id="remove-exemption" class="btn btn-danger btn-sm" type="button" first-student-id="' + firstStudentId + '" second-student-id="' + secondStudentId + '">' +
                        '<i class="icon-diff-removed"></i>' +
                    '</button>' +
                '</td>' +
            '</tr>')

        $('#exemptions-table').fadeIn();

        notificationController.handleNotification('Exemption successfully added! ' + classStudents[firstStudentId].name + ' and ' + classStudents[secondStudentId].name + ' will not be seated next to eachother!', 'success');
    }

    removeExemption(firstStudentId, secondStudentId) {
        $('button[first-student-id="' + firstStudentId + '"][second-student-id="' + secondStudentId + '"], button[first-student-id="' + secondStudentId + '"][second-student-id="' + firstStudentId + '"]')
            .parent()
            .parent()
            .fadeOut(300, function() {
                $(this).remove();

                if ($('#exemptions-table-body').find('tr').length === 0) {
                    $('#exemptions-table').fadeOut();
                }
            });

        if ($('#modal-assign-seating-positions').is(':visible')) {
            notificationController.handleNotification('Exemption successfully removed!', 'success');
        }
    }

    confirmPageLeave(buttonElement = null, externalLink = null) {
        swal({
            title:              "Do you want to save changes made to '" + $('#class-name').text() + "'?",
            text:               "Your changes will be lost if you don't save them.",
            type:               "warning",
            showCancelButton:   true,
            confirmButtonColor: "#66BB6A",
            confirmButtonText:  "Save seating plan",
            cancelButtonText:   "Continue without saving",
            closeOnConfirm:     false,
            closeOnCancel:      true
        }, function(isConfirm){
            if (isConfirm) {
                $('.confirm').html('Loading <i class="icon-spinner2 spinner confirming-spinner"></i>');

                canvasController.saveCanvasItems(buttonElement, externalLink);

                swal({
                    title:              "Saved!",
                    text:               "Your changes to '" + $('#class-name').text() + "' have been saved.",
                    confirmButtonColor: "#66BB6A",
                    type:               "success",
                    timer:              2000
                });
            } else {
                if (buttonElement != null) {
                    canvasController.view.changeClass(buttonElement);
                } else if (externalLink != null) {
                    window.location.href = externalLink;
                }
            }
        });
    }

    confirmPlanClear() {
        swal({
            title:              "Are you sure you want to clear '" + $('#class-name').text() + "'?",
            text:               "Your changes will be lost.",
            type:               "warning",
            showCancelButton:   true,
            confirmButtonColor: "#FF7043",
            confirmButtonText:  "Clear seating plan",
            cancelButtonText:   "Continue without clearing",
            closeOnConfirm:     false,
            closeOnCancel:      true
        }, function(isConfirm){
            if (isConfirm) {
                window.location.replace('/dashboard/classes/' + canvasController.classId + '/clear');
            }
        });
    }

    loadUserPreferences(userPreferences) {
        for (var settingName in userPreferences) {
            var settingValue = userPreferences[settingName];

            switch (settingName) {
                case 'always_labelled':
                    shouldAlwaysLabel = (settingValue === 'true');

                    $('#always-label-seats').prop('checked', shouldAlwaysLabel);
                    $('.styled-white').uniform();

                    break;
                case 'panel_positions':
                    var panelPositions = JSON.parse(settingValue.replaceAll('&quot;', '"'));

                    // there's probably a nicer way of doing this
                    if (panelPositions[0] === 'selected_panel') {
                        if (panelPositions[1] === 'student_panel') {
                            $('.panel[name="student_panel"]').detach().insertBefore($('.panel[name="item_panel"]'));
                        }
                    } else if (panelPositions[0] === 'item_panel') {
                        $('.panel[name="item_panel"]').detach().insertBefore($('.panel[name="selected_panel"]'));

                        if (panelPositions[1] === 'student_panel') {
                            $('.panel[name="student_panel"]').detach().insertBefore($('.panel[name="selected_panel"]'));
                        }
                    } else if (panelPositions[0] === 'student_panel') {
                        $('.panel[name="student_panel"]').detach().insertBefore($('.panel[name="selected_panel"]'));

                        if (panelPositions[1] === 'item_panel') {
                            $('.panel[name="item_panel"]').detach().insertBefore($('.panel[name="selected_panel"]'));
                        }
                    }

                    break;
            }
        }
    }
}