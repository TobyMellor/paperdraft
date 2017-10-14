class StudentController {
    constructor() {
        this.jsonClassStudents = [];
        this.classStudents     = {}; // Stores students in an object
        this.selectedStudents  = {
            male:   [],
            female: []
        };

        this.maleSeatsAvailable   = [];
        this.femaleSeatsAvailable = [];

        this.exemptions = [];

        this.classStudentsModel = new ClassStudentModel;
        this.view               = new View;
    }

    loadClassStudents() {
        var classStudentsModel = this.classStudentsModel;

        classStudentsModel.index(canvasController.classId);
    }

    init() {
        var jsonClassStudentsRecords = this.jsonClassStudents;

        if (jsonClassStudentsRecords.class_students.length === 0) {
            $('#student-panel-content').fadeOut(300, function() {
                $('#no-students').fadeIn();
            });
        } else {
            $('#no-students').fadeOut(300, function() {
                $('#student-panel-content').fadeIn();
            });
        }

        // Take JSON array of all students and store them locally
        for (var index in jsonClassStudentsRecords.class_students) {
            var classStudentRecord = jsonClassStudentsRecords.class_students[index];

            this.addClassStudent(classStudentRecord);
        }

        this.view.updateSeatAssignmentLabels();
        this.view.updateStudentButtons();

        if (!$.isEmptyObject(selectedCanvasItems.parent)) {
            canvasController.updateSelected([selectedCanvasItems.parent.id]);
        }
    }

    addClassStudent(classStudentRecord) {
        this.classStudents[classStudentRecord.id] = {
            student_id:                 classStudentRecord.student_id,
            name:                       classStudentRecord.name,
            gender:                     classStudentRecord.gender,
            pupil_premium:              classStudentRecord.pupil_premium,
            ability_cap:                classStudentRecord.ability_cap,
            current_attainment_level:   classStudentRecord.current_attainment_level,
            target_attainment_level:    classStudentRecord.target_attainment_level,
            tooltip_occupied_positions: null,
            exemptions:                 [],
        }

        this.view.addClassStudent(classStudentRecord);
    }

    deleteClassStudent(classStudentId) {
        var canvasItems        = canvasController.canvasItems,
            classStudentsModel = this.classStudentsModel;

        for (var index in canvasItems) {
            var canvasItem = canvasItems[index];

            if (canvasItem.student_id == classStudentId) {
                this.view.getCanvasItem(canvasItem.id).tooltip('destroy');

                canvasItem.student_id = null;

                break;
            }
        }

        canvasController.refreshSelected();
        delete this.classStudents[classStudentId];
        classStudentsModel.destroy(canvasController.classId, classStudentId);
    }

    removeSelectedStudents() {
        var canvasItems = canvasController.canvasItems,
            selectedIds = canvasController.getSelectedIds(),
            classStudentId, i;

        for (i = 0; i < selectedIds.length; i++) {
            classStudentId = canvasItems[selectedIds[i]].student_id;

            if (classStudentId !== null) {
                this.view.updateSeatAssignmentLabel(classStudentId, false);
            }

            canvasItems[selectedIds[i]].student_id = null;

            this.view.getCanvasItem(selectedIds[i]).tooltip('destroy');
        }

        canvasController.refreshSelected();
        $('#remove-seated-students').fadeOut();

        notificationController.handleNotification('The selected students were successfully removed from their seats!', 'success');
    }

    getSelectedStudents(orderExemptions = false) {
        this.updateSelectedStudents();

        var selectedStudents = this.selectedStudents;
        selectedStudents = selectedStudents.male.concat(selectedStudents.female);

        if (orderExemptions) { // deal with exemptions first
            for (var i = 0; i < selectedStudents.length; i++) {
                var selectedStudent = selectedStudents[i],
                    exemptions      = selectedStudent.exemptions;

                if (exemptions.length > 0) {
                    selectedStudents = selectedStudents.splice(i, 1).concat(selectedStudents); // make exemptions appear first because we should deal with them first
                }
            }

            return selectedStudents;
        }

        return selectedStudents;
    }

    getSeatedStudents() {
        var canvasItems = canvasController.canvasItems,
            seatedStudents = [];

        for (var index in canvasItems) {
            var canvasItem = canvasItems[index];

            if (canvasItem.student_id !== null) {
                seatedStudents.push(this.classStudents[canvasItem.student_id]);
            }
        }

        return seatedStudents;
    }

    isStudentSeated(classStudentId) {
        var seatedStudents = this.getSeatedStudents();

        if (seatedStudents.hasOwnProperty(classStudentId)) {
            return true;
        }

        return false;
    }

    clearSeatedStudents() {
        var canvasItems = canvasController.canvasItems,
            classStudentId;

        this.maleSeatsAvailable   = [];
        this.femaleSeatsAvailable = [];

        for (var index in canvasItems) {
            classStudentId = canvasItems[index].student_id;

            if (classStudentId !== null) {
                this.view.updateSeatAssignmentLabel(classStudentId, false);
            }

            canvasItems[index].student_id = null;
        }


        $('.drag-item').tooltip('destroy');
    }

    updateSelectedStudents() {
        var selectedStudents  = this.view.getSelectedStudents();
        this.selectedStudents = {
            'male':   [],
            'female': []
        };

        for (var i = 0; i < selectedStudents.length; i++) {
            var selectedStudentId = selectedStudents[i];

            this.selectedStudents[this.classStudents[selectedStudentId].gender].push(this.classStudents[selectedStudentId]);
        }

        this.view.updateStudentButtons();
    }

    assignmentAlgorithmBoyGirl(exemptions) {
        var selectedParent = canvasController.canvasItems[selectedCanvasItems.parent.id],
            anchorPoint    = [selectedParent.position_x, selectedParent.position_y];

        this.clearSeatedStudents();
        this.pairOppositeGenders(canvasController.canvasItemsGrid, anchorPoint);
        this.updateSelectedStudents();

        var selectedStudents = this.selectedStudents,
            selectedStudent;

        for (var i = 0; i < this.getSelectedStudents().length * 2; i++) { // * 2 because could be 100% of one gender
            var index = Math.floor(i / 2);

            if (i % 2 === 0) {
                if (selectedStudents.male.length <= index) {
                    continue;
                }

                selectedStudent = selectedStudents.male[index];

                if (!this.attemptSeatPlacement(this.maleSeatsAvailable, this.femaleSeatsAvailable, selectedStudent)) {
                    break;
                }
            } else {
                if (selectedStudents.female.length <= index) {
                    continue;
                }

                selectedStudent = selectedStudents.female[index];

                if (!this.attemptSeatPlacement(this.femaleSeatsAvailable, this.maleSeatsAvailable, selectedStudent)) {
                    break;
                }
            }
        }

        canvasController.refreshSelected();

        notificationController.handleNotification('Finished assigning ' + this.getSeatedStudents().length + ' student(s) to seat(s).', 'success');
        canvasController.showCanvasItemTooltips();

        this.view.updateSeatAssignmentLabels();
    }

    attemptSeatPlacement(attemptedSeatsAvailable, incorrectSeatsAvailable, selectedStudent) {
        var canvasItemId;

        if (attemptedSeatsAvailable.length === 0 && selectedStudent.exemptions.length === 0) { // for simplicity, don't allow exempt students to sit in incorrect gender seats
            if (incorrectSeatsAvailable.length > 0) {
                canvasItemId = canvasController.canvasItemsGrid[incorrectSeatsAvailable[0][0]][incorrectSeatsAvailable[0][1]];

                canvasController.canvasItems[canvasItemId].student_id = selectedStudent.student_id;

                notificationController.handleNotification(selectedStudent.name + ' was seated with the same gender due to lack of seats available.', 'warning');

                incorrectSeatsAvailable.shift();
            } else {
                notificationController.handleNotification('Some students could not be seated due to lack of seats available.', 'error');

                return false;
            }
        } else {
            if (selectedStudent.exemptions.length > 0) {
                var validSeatFound = false;

                for (var i = 0; i < attemptedSeatsAvailable.length; i++) { // check every correct-gendered seating position for one that we're not exempt from
                    var potentialCanvasItemId = canvasController.canvasItemsGrid[attemptedSeatsAvailable[i][0]][attemptedSeatsAvailable[i][1]];

                    var potentialExemptPositions = this.middleOutHollowSearch(canvasController.canvasItemsGrid, [attemptedSeatsAvailable[i][0], attemptedSeatsAvailable[i][1]]);

                    for (var j = 0; j < potentialExemptPositions.length; j++) {
                        var potentialExemptPosition = potentialExemptPositions[j];

                        if (potentialExemptPosition[0] !== null) {
                            var canvasItemId = canvasController.canvasItemsGrid[potentialExemptPosition[0][0]][potentialExemptPosition[0][1]],
                                canvasItem   = canvasController.canvasItems[canvasItemId];

                            if (selectedStudent.exemptions.indexOf(canvasItem.student_id) > -1) { // this seat is no good as a surrounding seat contains an exempt student
                                j = potentialExemptPositions.length + 1;
                                break;
                            }
                        }
                    }

                    if (j !== potentialExemptPositions.length + 1) { 
                        validSeatFound = true;
                        break;
                    }
                }

                if (validSeatFound) {
                    canvasController.canvasItems[potentialCanvasItemId].student_id = selectedStudent.student_id;

                    attemptedSeatsAvailable.splice(utils.getArrayInArrayPosition(attemptedSeatsAvailable, [attemptedSeatsAvailable[i][0], attemptedSeatsAvailable[i][1]]), 1);
                } else {
                    notificationController.handleNotification(selectedStudent.name + ' could not be seated in any same-gendered seats while satisfying all exemption rules.', 'error');
                }
            } else {
                canvasItemId = canvasController.canvasItemsGrid[attemptedSeatsAvailable[0][0]][attemptedSeatsAvailable[0][1]];
                canvasController.canvasItems[canvasItemId].student_id = selectedStudent.student_id;

                attemptedSeatsAvailable.shift();
            }
        }

        return true;
    }

    pairOppositeGenders(canvasItemsGrid, anchorPoint, anchorsGender = 'males') {
        var oppositesFound = this.middleOutHollowSearch(canvasItemsGrid, anchorPoint),
            i, j;
        
        if (anchorsGender === 'males') {
            this.maleSeatsAvailable.push(anchorPoint);
        } else {
            this.femaleSeatsAvailable.push(anchorPoint);
        }
        
        for (i = 0; i < oppositesFound.length; i++) {
            var oppositeFound = oppositesFound[i];
            
            for (j = 0; j < oppositeFound.length; j++) {
                if (oppositeFound[j] !== null) {
                    if (!utils.isArrayInArray(this.maleSeatsAvailable, oppositeFound[j])
                            && !utils.isArrayInArray(this.femaleSeatsAvailable, oppositeFound[j])) {
                        this.pairOppositeGenders(canvasItemsGrid, oppositeFound[j], anchorsGender === 'males' ? 'females' : 'males');
                    }
                }
            }
        }
    }

    middleOutHollowSearch(canvasItemsGrid, anchorPoint) {
        var searchSize            = 3,
            totalSpacesToSearch   = (searchSize * 4) - 8,
            canvasItemsGridLength = canvasItemsGrid.length,
            itemsFound            = [
                [],
                [],
                [],
                []
            ],
            centerOffset, centerPoints, centerPoint, searchRadius, i, result;
            
        while (!utils.doesEveryElementHaveChildren(itemsFound)) {
            searchRadius         = Math.floor(searchSize / 2);
            centerOffset         = -1;
            totalSpacesToSearch += 4;

            centerPoints = [
                [anchorPoint[0], anchorPoint[1] + searchRadius],
                [anchorPoint[0] + searchRadius, anchorPoint[1]],
                [anchorPoint[0], anchorPoint[1] - searchRadius],
                [anchorPoint[0] - searchRadius, anchorPoint[1]]
            ];

            for (i = 0; i < totalSpacesToSearch - 4; i++) {
                if (i % 4 === 0) { // offset + 1 from center search for the next 4 iterations
                    centerOffset++;
                }

                if (itemsFound[i % 4].length > 0) { // we don't need to check this direction anymore
                    continue;
                }

                centerPoint = centerPoints[i % 4];

                if (!canvasController.isPositionInBounds(centerPoint[0], centerPoint[1])) {
                    itemsFound[i % 4].push(null); // something is out of bounds so stop searching this direction
                    continue;
                }
                
                if (i % 2 === 1) { // y is the changing plane
                    if (itemsFound[1].length === 0) {
                        result = this.getNonEmptyCanvasItemsGridElement(canvasItemsGrid, centerPoint[0], centerPoint[1] + centerOffset, centerOffset, searchRadius, itemsFound, i);

                        if (result !== null) {
                            itemsFound[1].push(result);
                        }
                    } else if (itemsFound[3].length === 0) {
                        result = this.getNonEmptyCanvasItemsGridElement(canvasItemsGrid, centerPoint[0], centerPoint[1] - centerOffset, centerOffset, searchRadius, itemsFound, i);

                        if (result !== null) {
                            itemsFound[3].push(result);
                        }
                    }
                } else {
                    if (itemsFound[0].length === 0) {
                        result = this.getNonEmptyCanvasItemsGridElement(canvasItemsGrid, centerPoint[0] + centerOffset, centerPoint[1], centerOffset, searchRadius, itemsFound, i);

                        if (result !== null) {
                            itemsFound[0].push(result);
                        }
                    } else if (itemsFound[2].length === 0) {
                        result = this.getNonEmptyCanvasItemsGridElement(canvasItemsGrid, centerPoint[0] - centerOffset, centerPoint[1], centerOffset, searchRadius, itemsFound, i);

                        if (result !== null) {
                            itemsFound[2].push(result);
                        }
                    }
                }
            }

            centerOffset++;

            if (itemsFound[0].length === 0) {
                if (canvasController.isPositionInBounds(centerPoints[3][0], centerPoints[3][1] + centerOffset)) {
                    if (canvasItemsGrid[centerPoints[3][0]][centerPoints[3][1] + centerOffset] !== -1) {
                        itemsFound[0].push([centerPoints[3][0], centerPoints[3][1] + centerOffset])
                    }
                }
            }

            if (itemsFound[1].length === 0) {
                if (canvasController.isPositionInBounds(centerPoints[0][0] + centerOffset, centerPoints[0][1])) {
                    if (canvasItemsGrid[centerPoints[0][0] + centerOffset][centerPoints[0][1]] !== -1) {
                        itemsFound[1].push([centerPoints[0][0] + centerOffset, centerPoints[0][1]])
                    }
                }
            }

            if (itemsFound[2].length === 0) {
                if (canvasController.isPositionInBounds(centerPoints[1][0], centerPoints[1][1] - centerOffset)) {
                    if (canvasItemsGrid[centerPoints[1][0]][centerPoints[1][1] - centerOffset] !== -1) {
                        itemsFound[2].push([centerPoints[1][0], centerPoints[1][1] - centerOffset])
                    }
                }
            }

            if (itemsFound[3].length === 0) {
                if (canvasController.isPositionInBounds(centerPoints[2][0] - centerOffset, centerPoints[2][1])) {
                    if (canvasItemsGrid[centerPoints[2][0] - centerOffset][centerPoints[2][1]] !== -1) {
                        itemsFound[3].push([centerPoints[2][0] - centerOffset, centerPoints[2][1]])
                    }
                }
            }

            searchSize += 2;
        }

        return this.sortByDifference(itemsFound, anchorPoint);
    }

    getNonEmptyCanvasItemsGridElement(canvasItemsGrid, positionX, positionY, centerOffset, searchRadius, itemsFound, i) {
        if (canvasController.isPositionInBounds(positionX, positionY)) {
            if (canvasItemsGrid[positionX][positionY] !== -1 && (i >= 4 || itemsFound[i % 4].length === 0)) {
                if (centerOffset !== searchRadius || (itemsFound[(i - 1) % 4].length === 0 && itemsFound[(i + 1) % 4].length === 0)) {
                    return [positionX, positionY];
                }
            }
        }
        
        return null;
    }

    addExemption(firstStudentId, secondStudentId) {
        var classStudents = this.classStudents,
            firstStudent  = classStudents[firstStudentId],
            secondStudent = classStudents[secondStudentId];

        if (firstStudent.exemptions.length > 3) {
            notificationController.handleNotification(firstStudent.name + ' could not be exempt because they\'re already exempt from 4 people (max).', 'error');
        } else if (secondStudent.exemptions.length > 3) {
            notificationController.handleNotification(secondStudent.name + ' could not be exempt because they\'re already exempt from 4 people (max).', 'error');
        } else {
            if (firstStudent.exemptions.indexOf(secondStudentId) === -1) {
                firstStudent = firstStudent.exemptions.push(secondStudentId);
            }

            if (secondStudent.exemptions.indexOf(firstStudentId) === -1) {
                secondStudent = secondStudent.exemptions.push(firstStudentId);
            }

            canvasController.view.addExemption(firstStudentId, secondStudentId);
        }
    }

    removeExemption(firstStudentId, secondStudentId) {
        var classStudents = this.classStudents,
            firstStudent  = classStudents[firstStudentId],
            secondStudent = classStudents[secondStudentId];

        firstStudent.exemptions.splice(firstStudent.exemptions.indexOf(secondStudentId), 1);
        secondStudent.exemptions.splice(secondStudent.exemptions.indexOf(firstStudentId), 1);

        canvasController.view.removeExemption(firstStudentId, secondStudentId);
    }

    clearExemptions() {
        var classStudents = this.classStudents,
            classStudent, exemptions;

        for (var index in classStudents) {
            classStudent = classStudents[index];
            exemptions   = classStudent.exemptions;

            for (var i = 0; i < exemptions.length; i++) {
                this.removeExemption(parseInt(index), exemptions[i]);
            }
        }
    }

    getPotentialExemptions(firstStudentId = null) {
        var classStudents       = this.classStudents,
            exemptions          = this.exemptions,
            potentialExemptions = {
                first_student:   null,
                second_students: []
            };

        if (Object.keys(classStudents).length === 0) {
            return null;
        }

        if (firstStudentId === null) {
            firstStudentId = parseInt(Object.keys(classStudents)[0]);
        }

        potentialExemptions.first_student = [firstStudentId, classStudents[firstStudentId].name];

        for (var secondStudentId in classStudents) {
            var secondStudentId = parseInt(secondStudentId);

            if (secondStudentId !== firstStudentId && classStudents[secondStudentId].exemptions.indexOf(firstStudentId) === -1) {
                potentialExemptions.second_students.push([secondStudentId, classStudents[secondStudentId].name])
            }
        }

        return potentialExemptions;
    }

    sortByDifference(itemsFound, anchorPoint) {
        var swapped;
        
        do {
            swapped = false;
            
            for (var i = 0; i < itemsFound.length - 1; i++) {
                if (this.shouldSwap(itemsFound[i][0], itemsFound[i + 1][0], anchorPoint, i)) {
                    var temp = itemsFound[i];
                    
                    itemsFound[i] = itemsFound[i + 1];
                    itemsFound[i + 1] = temp;
                    
                    swapped = true;
                }
            }
            
        } while (swapped);
        
        return itemsFound
    }

    shouldSwap(a, b, anchorPoint, i) {
        if (a === null || b === null) {
            return false;
        }
        
        if (Math.abs((a[0] - anchorPoint[0]) + (a[1] - anchorPoint[1])) > Math.abs((b[0] - anchorPoint[0]) + (b[1] - anchorPoint[1]))) {
            return true;
        }
        
        return false;
    }
}