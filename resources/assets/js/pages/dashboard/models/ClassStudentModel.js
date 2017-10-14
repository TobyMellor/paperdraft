// An 'Class student' is a 'students' seating position for the given class
// e.g. Student: Toby Mellor -- Class student: Student is stored at x: 25, y: 5
// This is specific to a particular classroom

// Example:
// [
//    1: {
//       "id": 1,
//       "student_id": 1,
//       "canvas_item_id": 1,
//    }
// ]
class ClassStudentModel {
    index(classId) {
        $.APIAjax({
            url: '/api/class-student',
            type: 'GET',
            data: {
                class_id: classId,
            },
            success: function(jsonResponse) {
                studentController.jsonClassStudents = jsonResponse;

                studentController.init();
            },
            error: function(jsonResponse) {}
        });
    }

    destroy(classId, classStudentId) {
        $.APIAjax({
            url: '/api/class-student/' + classStudentId,
            type: 'DELETE',
            data: {
                class_id: classId
            },
            success: function(jsonResponse) {
                notificationController.handleNotification(jsonResponse.message, 'success');  
            },
            error: function(jsonResponse) {}
        });
    }
}