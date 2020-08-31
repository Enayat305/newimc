<?php

Route::group(['middleware' => ['web', 'authh', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu'], 'namespace' => 'Modules\Essentials\Http\Controllers'], function () {
    Route::group(['prefix' => 'essentials'], function () {
        
        Route::get('/install', 'InstallController@index');
        Route::get('/install/update', 'InstallController@update');
        Route::get('/install/uninstall', 'InstallController@uninstall');
        
        Route::get('/', 'EssentialsController@index');

        //document controller
        Route::resource('document', 'DocumentController')->only(['index', 'store', 'destroy', 'show']);
        Route::get('document/download/{id}', 'DocumentController@download');

        //document share controller
        Route::resource('document-share', 'DocumentShareController')->only(['edit', 'update']);

        //todo controller
        Route::resource('todo', 'ToDoController');

        Route::post('todo/add-comment', 'ToDoController@addComment');
        Route::get('todo/delete-comment/{id}', 'ToDoController@deleteComment');
        Route::get('todo/delete-document/{id}', 'ToDoController@deleteDocument');
        Route::post('todo/upload-document', 'ToDoController@uploadDocument');

        //reminder controller
        Route::resource('reminder', 'ReminderController')->only(['index', 'store', 'edit', 'update', 'destroy', 'show']);

        //message controller
        Route::get('get-new-messages', 'EssentialsMessageController@getNewMessages');
        Route::resource('messages', 'EssentialsMessageController')->only(['index', 'store','destroy']);

        //Allowance and deduction controller
        Route::resource('allowance-deduction', 'EssentialsAllowanceAndDeductionController');
    });

    Route::group(['prefix' => 'hrm'], function () {
        Route::resource('/leave-type', 'EssentialsLeaveTypeController');
        Route::resource('/leave', 'EssentialsLeaveController');
        Route::post('/change-status', 'EssentialsLeaveController@changeStatus');
        Route::get('/leave/activity/{id}', 'EssentialsLeaveController@activity');
        Route::get('/user-leave-summary', 'EssentialsLeaveController@getUserLeaveSummary');

        Route::get('/settings', 'EssentialsSettingsController@edit');
        Route::post('/settings', 'EssentialsSettingsController@update');

        Route::post('/import-attendance', 'AttendanceController@importAttendance');
        Route::resource('/attendance', 'AttendanceController');
        Route::post('/clock-in-clock-out', 'AttendanceController@clockInClockOut');

        Route::post('/validate-clock-in-clock-out', 'AttendanceController@validateClockInClockOut');

        Route::get('/get-attendance-by-shift', 'AttendanceController@getAttendanceByShift');
        Route::get('/get-attendance-by-date', 'AttendanceController@getAttendanceByDate');
        Route::get('/get-attendance-row/{user_id}', 'AttendanceController@getAttendanceRow');

        Route::get(
            '/user-attendance-summary',
            'AttendanceController@getUserAttendanceSummary'
        );

        Route::resource('/payroll', 'PayrollController');
        Route::resource('/holiday', 'EssentialsHolidayController');

        Route::get('/shift/assign-users/{shift_id}', 'ShiftController@getAssignUsers');
        Route::post('/shift/assign-users', 'ShiftController@postAssignUsers');
        Route::resource('/shift', 'ShiftController');
    });
});
