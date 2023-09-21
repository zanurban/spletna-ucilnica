<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentsSubjectController;
use App\Http\Controllers\AssignmentSubmissionController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('layout');
})->name('home');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'login'], function () {
    /**
     * Log in and log out routes
     */
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.create');
});

Route::group(['middleware' => 'admin'], function () {
    /**
     * Admin routes
     */

    Route::prefix('admin')->group(function () {

        /**
         * Routes for manipulating subject data
         */
        Route::prefix('/subject')->group(function () {
            Route::get('/list', [SubjectController::class, 'list'])->name('subject.list');
            Route::get('/new', [SubjectController::class, 'showForm'])->name('subject.create');
            Route::post('/new', [SubjectController::class, 'save'])->name('subject.create');
            Route::get('/edit/{subjectId}', [SubjectController::class, 'showForm'])->name('subject.update');
            Route::put('/edit/{subjectId}', [SubjectController::class, 'update'])->name('subject.update');
            Route::delete('/delete/{subjectId}', [SubjectController::class, 'delete'])->name('subject.delete');
        });


        /**
         * Routes for manipulating teacher data
         */
        Route::prefix('/teacher')->group(function () {
            Route::get('/new', [TeachersController::class, 'showForm'])->name('teacher.create');
            Route::get('/list', [TeachersController::class, 'list'])->name('teacher.list');
            Route::post('/new', [TeachersController::class, 'save'])->name('teacher.create');
            Route::get('/edit/{teacherId}', [TeachersController::class, 'showForm'])->name('teacher.update');
            Route::put('/edit/{teacherId}', [TeachersController::class, 'update'])->name('teacher.update');
            Route::delete('/delete/{teacherId}', [TeachersController::class, 'delete'])->name('teacher.delete');
        });

        /**
         * Routes for manipulating student data
         */
        Route::prefix('/student')->group(function () {
            Route::get('/new', [StudentsController::class, 'showForm'])->name('student.create');
            Route::get('/list', [StudentsController::class, 'list'])->name('student.list');
            Route::post('/new', [StudentsController::class, 'save'])->name('student.create');
            Route::get('/edit/{studentId}', [StudentsController::class, 'showForm'])->name('student.update');
            Route::put('/edit/{studentId}', [StudentsController::class, 'update'])->name('student.update');
            Route::delete('/delete/{studentId}', [StudentsController::class, 'delete'])->name('student.delete');
        });
    });
});

Route::group(['middleware' => 'tch'], function () {
    /**
     * Teacher routes
     */
    Route::prefix('teacher')->group(function () {

        /**
         * Routes for manipulating with material
         */
        Route::prefix('/classroom')->group(function () {
            Route::get('/list', [MaterialsController::class, 'listSubjects'])->name('subject_material.list');

            Route::prefix('/{subjectId}')->group(function () {
                Route::get('/list', [MaterialsController::class, 'list'])->name('classroom.list');

                /**
                 * Routes for manipulating assignments and downloading submissions
                 */
                Route::prefix('/assignment')->group(function () {
                    Route::get('/new', [AssignmentsController::class, 'showForm'])->name('assignment.create');
                    Route::post('/new', [AssignmentsController::class, 'save'])->name('assignment.create');
                    Route::get('/edit/{assignmentId}', [AssignmentsController::class, 'showForm'])->name('assignment.update');
                    Route::put('/edit/{assignmentId}', [AssignmentsController::class, 'update'])->name('assignment.update');
                    Route::delete('/delete/{assignmentId}', [AssignmentsController::class, 'delete'])->name('assignment.delete');

                    Route::get('/download', [AssignmentsController::class, 'downloadAllSubmissions'])->name('assignment.downloadAll');
                    Route::get('/download/{studentId}', [AssignmentsController::class, 'downloadStudentsSubmission'])->name('assignment.downloadSpecific');
                });

                Route::prefix('/material')->group(function () {
                    Route::get('/new', [MaterialsController::class, 'showForm'])->name('material.create');
                    Route::post('/new', [MaterialsController::class, 'save'])->name('material.create');
                    Route::get('/edit/{materialId}', [MaterialsController::class, 'showForm'])->name('material.update');
                    Route::put('/edit/{materialId}', [MaterialsController::class, 'update'])->name('material.update');
                    Route::delete('/delete/{materialId}', [MaterialsController::class, 'delete'])->name('material.delete');
                });
            });
        });
    });
});

Route::group(['middleware' => 'usr'], function () {
    /**
     * Student routes
     */
    Route::prefix('student')->group(function () {

        /**
         * Routes for manipulating profile
         */
        Route::prefix('/profile')->group(function () {
            Route::get('/new', [ProfileController::class, 'showForm'])->name('profile.create');
            Route::post('/new', [ProfileController::class, 'save'])->name('profile.create');
            Route::get('/edit/{studentId}', [ProfileController::class, 'showForm'])->name('profile.update');
            Route::put('/edit/{studentId}', [ProfileController::class, 'update'])->name('profile.update');
            //Route::delete('/delete/{studentId}', [ProfileController::class, 'delete'])->name('profile.delete');
            //TODO: check if deletion of profile is possible
        });

        /**
         * Routes for accessing subject and submitting assignments
         */
        Route::prefix('/subject')->group(function () {
            Route::get('/{subjectId}', [StudentsSubjectController::class, 'showForm'])->name('subject.display');

            Route::prefix('/{subjectId}/assignment')->group(function () {
                Route::get('/{assignmentId}', [AssignmentSubmissionController::class, 'showAssigment'])->name('assigment.show');
                Route::post('/{assignmentId}', [AssignmentSubmissionController::class, 'submit'])->name('assigment.submit');
                Route::put('/{assignmentId}', [AssignmentSubmissionController::class, 'resubmit'])->name('assigment.resubmit');
                Route::delete('/delete/{assignmentId}', [AssignmentSubmissionController::class, 'delete'])->name('assigment.delete');
            });
        });
    });
});
