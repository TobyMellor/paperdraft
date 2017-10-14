![logo_dark.png](https://bitbucket.org/repo/kyazra/images/3718154517-logo_dark.png)

# What is PaperDraft?

A school seating planner and class management system.

The project aims to automate seating plan creation for teachers by:

 1. Importing school data from a SIMS export
 2. Allowing Administrators to design classroom templates for all classrooms
 3. Applying algorithms, including boy-girl layouts and behavioral exemptions, to assign students seats within the classroom template
 4. Emailing teachers the final plans for each lesson, giving them the option to edit or create plans.
 
 
## Video Examples

**Canvas Basics**
Creating a replica of a classroom has never been easier; it even supports keyboard shortcuts for power users. The best part, you can assign students to desks in a boy-girl layout with one click. If you don't want two students sitting next to eachother, there's a solution for that.
https://youtu.be/oOyzv_53dUg

**Getting Started**
Here's what it looks like to register and go through the setup wizard.
https://youtu.be/FIcNM0LivUE

**Institutions**
You can become an admin of your school/institution. This means you can create room templates, create students, then allow any teachers you invited to use them.
https://youtu.be/zHbWIYSmzZs

**Student Management**
This is how easy it is to create, read, update and delete students.
https://youtu.be/z5CzoZfX3W4

# Getting Started

You'll need a server running Apache and PHP >=5.6.4.

 1. Install Composer Dependencies
 
 `composer install`
 
 2. Install NPM dependencies
 
 `npm install`
 
 3. Compile the Front-end JavaScript
 
 `gulp scripts`
 
 4. Create a `.env` file and populate the required fields
 
 `cp .env.example .env`
 
 You'll need to edit/create the following: `APP_URL`, `DB_*`, `MAIL_DRIVER=mailgun`, `MAILGUN_DOMAIN` and `MAILGUN_SECRET`
 
 5. Generate an application secret key, and the required OAuth tokens
 
 `php artisan key:generate`
 
 `php artisan passport:install`
 
 If you wish to extend the Application's OAuth 2.0 API, note down the secret keys output in this step.

6. Visit the `/dashboard` route

# JSON API Documentation

This API adopts the RESTful standard where possible.

API requests are throttled at 60 times in 1 minute.

## User

### Invite a user to register with the service to join your institution

`POST /api/user`

**NOTE: To use this API Route you need to be the owner of an institute and have an institution with less than 100 users.**

**Parameters:**

`email`

Required; Email; Length between 255 and 1; Email does not exist

`password`

Required; At least 6 characters

`password_confirmation`

Required; Matches `password`

### Updating a users profile

`PUT /api/user`

**NOTE: To use this API Route you must be authenticated as this user.**

**Parameters:**

`title`

Required; String; Must be "Mr", "Mrs", "Ms" or "Dr"

`first_name`

Required; Length between 1 and 20; Regex: `/^[a-zA-Z0-9\s-]+$/`

`last_name`

Required; Length between 1 and 20; Regex: `/^[a-zA-Z0-9\s-]+$/`

### Removing a user from your institution

`DELETE /api/user/{id}`

**NOTE: To use this API Route you need to be the owner of an institute and be in the same institution as the user.**

### Modifying a user's preferences

The only user preference that is supported currently is the order of the dragable panels on the right side of the dashboard.

`POST /api/user/setting`

## Institution

### Creating/updating an institution

`PUT /api/institution`

If the user calling this is not in an institution, they will be assigned to this institution. If they are in an institution, the name.

**Parameters:**

`institution_name`

Required; Length between 1 and 50; Regex: `/^[a-zA-Z0-9\s-]+$/`

## Class

### Creating a new Class

If the `class_id` parameter is present, the new class will be a duplicate of the class with the `class_id` provided.

`POST /api/class`

**Parameters:**

`class_name`

Required; Length between 1 and 30

`class_subject`

String; Length between 1 and 30

`for_institution`

True or False. If true, the class room will be made available to all teachers in the institution. If false, it is considered the creators own class room and is private to members of the institution.

`class_id`

Required; Owner of Class

### Updating a Class

`PUT /api/class/{id}`

**Parameters:**

`class_name`

Required; Length between 1 and 30

### Deleting a Class

`DELETE /api/class/{id}`

The authenticated user must be the owner of the class room.

Deleting a class room will also delete the Canvas History and Canvas Items. It will also remove students from the class.

### Duplicate a Class's layout

`POST /api/class/duplicate`

All of the Canvas Items will be duplicated from one class room to another.

Students of a class, or information about the class, will not be copied over.

**Parameters:**

`new_class_id`

Required; Integer; Owner of Class

`copied_class_id`

Required; Integer; Owner of Class

## Class Student

### Retrieving all students in a Class

`GET /api/class-student`

**Parameters:**

`class_id`

Required; Owner of Class

### Adding a student to a Class

`POST /api/class-student`

**Parameters:**

`class_id`

Required; Owner of Class

`student_id`

Required; Owner of Student

`ability_cap`

Must be "H", "M" or "L"

`current_attainment_level`

Must be "A*", "A", "B", "C", "D", "E", "F", "G" or "U"

`target_attainment_level`

Must be "A*", "A", "B", "C", "D", "E", "F", "G" or "U"

### Updating a Students information for a particular Class

`GET /api/class-student/{id}`

**Parameters:**

`ability_cap`

Must be "H", "M" or "L"

`current_attainment_level`

Must be "A*", "A", "B", "C", "D", "E", "F", "G" or "U"

`target_attainment_level`

Must be "A*", "A", "B", "C", "D", "E", "F", "G" or "U"

### Removing a student from a Class
`DELETE /api/class-student/{id}`

**Parameters:**

`class_id`

Required; Owner of Class

## Canvas Item

### Get all Canvas Items for a Class

`GET /api/canvas-item`

"soft_deleted_canvas_items" are Canvas Items that have been deleted, but still exist in the Canvas History and therefore could potentially be restored.

**Parameters:**

`class_id`

Required; Owner of Class

### Creating a new Canvas Item and place on board at position

`POST /api/canvas-item`

**Parameters:**

`class_id`

Required; Owner of Class

`canvas_item`

A Object, containing:

 1. item_id - The ID of the item (e.g. 1 for desk)
 2. student_id - The ID of the student if assigned
 3. position_x - X position of Canvas Item on Canvas
 4. position_y - Y position of Canvas Item on Canvas
 
### Updating the position of a Canvas Item, or assigning a student to a Canvas Item

`PUT /api/canvas-item/{id}`

**Parameters:**

`class_id`

Required; Owner of Class

A Object, containing:

 1. student_id - The ID of the student if assigned
 2. position_x - X position of Canvas Item on Canvas
 3. position_y - Y position of Canvas Item on Canvas
 
### Delete a Canvas Item from a Class Room

When deleting a Canvas Item, it will still be stored in the database. It is only fully deleted when it goes outside of the Canvas History.

`DELETE /api/canvas-item/{id}`

**Parameters:**

`class_id`

Required; Owner of Class

## Canvas History

### Get the Canvas History for a Class

`GET /api/canvas-history`

**Parameters:**

`class_id`

Required; Owner of Class

### Store a new piece of Canvas History and a new Canvas Action Undo Count

`POST /api/canvas-history`

**Parameters:**

`class_id`

Required; Owner of Class

`canvas_history`

Required; Must be "addition", "deletion" or "movement"

`canvas_action_undo_count`

Required; Integer