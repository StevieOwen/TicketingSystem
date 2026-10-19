<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;

Route::get('/', function () {
    return redirect()-> route('login');
});

Route::middleware('auth')->group(function() {

    Route::controller(AdminController::class)->group(function(){
        Route::get('admin/overview','overview')->name('admin.overview');
        Route::get('admin/staffs/index','staffIndex')->name('admin.staffs_index');
        Route::post('admin/staffs/store','storeStaff')->name('admin.staffs_store');
        Route::patch('admin/staff/update/{user}','updateStaff')->name('admin.staffs_update');
        Route::delete('admin/staff/delete/{user}','staffDelete')->name('admin.staffs_delete');
        Route::get('admin/tickets/index','ticketIndex')->name('admin.tickets_index');
        Route::patch('admin/ticket/update/{ticket}','ticketUpdate')->name('admin.tickets_update');
        Route::get('admin/students/index','studentIndex')->name('admin.students_index');
        Route::patch('admin/students/update/{user}','studentUpdate')->name('admin.students_update');
        Route::get('admin/settings','settings')->name('admin.settings_logs');

    });
      
});

Route::middleware('auth')->group(function() {
    Route::controller(StudentController::class)->group(function(){
        Route::get('student/overview','overview')->name('students.overview');
        Route::post('student/create/ticket','createTicket')->name('students.tickets_create');
        Route::patch('student/update/ticket/{ticket}','updateTicket')->name('students.tickets_update');
        Route::patch('student/update/student/{user}','updateStudent')->name('students.students_update');
        Route::patch('student/updatepassword/student/{user}','updateStudentPassword')->name('students.student_password_update');

    });
});

Route::middleware('auth')->group(function() {
    Route::controller(StaffController::class)->group(function(){
        Route::get('staff/overview','overview')->name('staffs.overview');

        Route::patch('staff/ticket/{ticket}/update','updateTicket')->name('staffs.ticket.update');

    });
});