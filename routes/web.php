<?php

use App\Exports\ClientsContinentBaseExport;
use App\Exports\ClientsExport;
use App\Exports\ClientsSelectedContinentBaseExport;
use App\Exports\ClientsSelectedIndustryBaseExport;
use App\Exports\EmployeeAssetsExport;
use App\Http\Controllers\Backend\ClientReportController;
use App\Http\Controllers\Backend\DownloadController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\MailController;
use App\Mail\ClientOnBoardMail;
use App\Services\GoogleCalendarService;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return "will clear the all cached!";
});

Route::get('file', [FileController::class, 'index'])->name('file');
Route::post('file', [FileController::class, 'store'])->name('file.store');

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

// Publicly accessible routes
Route::get('/storage/app/employee/{filename}', function ($filename) {
    $path = storage_path("app/employee/{$filename}");

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});

/**
 * Visiting Card
 */
Route::get('visiting-card/{company?}/{card?}', [CronController::class, 'getVisitingCardDetails']);// view employee visiting card details via company base
Route::get('download-contact/{id?}', [CronController::class, 'downloadContact']);

/**
 * Excel Download
 */
Route::get('export-clients', function () {
    return Excel::download(new ClientsContinentBaseExport(), date('dmYHis').'-clients.xlsx');
})->name('export-clients');

Route::get('export-clients-continent-base', function ( Request $request ) {
    return Excel::download(new ClientsSelectedContinentBaseExport( $request ), date('dmYHis').'-clients.xlsx');
})->name('export-clients-continent-base');

Route::get('searh-clients-continent-base', [ClientReportController::class, 'clientSelectedContinentBaseSearch']);

Route::get('export-clients-industry-base', function ( Request $request ) {
    return Excel::download(new ClientsSelectedIndustryBaseExport( $request ), date('dmYHis').'-industry.xlsx');
})->name('export-clients-industry-base');

Route::get('searh-clients-industry-base', [ClientReportController::class, 'clientSelectedIndustryBaseSearch']);

Route::get('export-employee-asset-data', function () {
    return Excel::download(new EmployeeAssetsExport(), date('dmYHis').'-employee-assets-data.xlsx');
})->name('export-employee-asset-data');

Route::get('export-clients/{id?}/{name?}/{country?}', function ( $id, $name, $downloadType ) {
    return Excel::download(new ClientsExport( $id, $name, $downloadType ), $name.' clients data.xlsx');
})->name('export-clients');

Route::post('/corporate-email-download-csv', [DownloadController::class, 'downloadCorporateEmailCSV']);// download corporate email as csv file format
Route::get('/corporate-email-view-pdf', [DownloadController::class, 'viewCorporateEmailPDF']);// view corporate email as pdf file format
Route::get('/company-view-pdf', [DownloadController::class, 'viewCompanyPDF']);// view company as pdf file format
Route::get('/department-view-pdf', [DownloadController::class, 'viewDepartmentPDF']);// view department as pdf file format
Route::post('/personal-client-meeting-download-csv', [DownloadController::class, 'downloadClientMeetingCSV']);// download client meeting as csv file format
Route::get('/personal-client-meeting-view-pdf', [DownloadController::class, 'viewClientMeetingPDF']);// view client meeting as pdf file format
Route::post('/company-meeting-download-csv', [DownloadController::class, 'downloadCompanyMeetingCSV']);// download company meeting as csv file format
Route::get('/company-meeting-view-pdf', [DownloadController::class, 'viewCompanyMeetingPDF']);// view company meeting as pdf file format

/**
 * Crons Mails
 */
Route::get('send-employee-registration-mail', [MailController::class, 'sendEmployeeRegistrationMail'] );
Route::any('complete-register/{id?}', [MailController::class, 'completeEmployeeRegistration'] )->name('complete-register');
Route::any('thank-you', [MailController::class, 'thankYou'] )->name('thank-you');
Route::any('google-calender-connected', function(){
    return view('google-calender-connected');
});

Route::get('send-employee-auth-access-mail', [MailController::class, 'sendEmployeeAuthAccessMail'] );
Route::any('client-schedule-reminder-notes-mail', [MailController::class, 'sendClientReminderNoteNotificationMail'] );
Route::any('leave-notification-mail', [MailController::class, 'sendNewLeaveApplicationMail'] );
Route::get('client-personal-meeting-to-admin-mail', [MailController::class, 'sendPersonalMeetingAdminMail'] );
Route::get('company-meeting-to-admin-mail', [MailController::class, 'sendCompanyMeetingAdminMail'] );

/**
 * Flush data table
 */
Route::get('clear-employee-data', [CronController::class, 'clearEmployeeDatabaseHistory'] );
Route::get('clear-client-data', [CronController::class, 'clearClientDatabaseHistory'] );
Route::get('delete-storage-emplty-directory', [CronController::class, 'deleteEmptyFolders'] );
Route::get('remove-framework-session-files', [CronController::class, 'removeOldFrameworkSessionFiles']);

/**
 * Backup Controller
 */
Route::get('full-database-backup', [BackupController::class, 'getFullDatabaseBackup'] );

/**
 * FaceIO
 */
Route::get('/faceio', function () {
    return view('faceio');
});

Route::post('/faceio-callback', function (Illuminate\Http\Request $request) {
    // Handle the authenticated user data here
    $userData = $request->all();

    // Perform actions like user verification or logging
    return response()->json(['message' => 'Data received', 'data' => $userData]);
});

/**
 * Google Console related APIs
 */
Route::get('/create-event', function( GoogleCalendarService $calendarService ){
    return $calendarService->createGoogleCalendarEvent();
});
Route::get('google-calender-auth', [GoogleController::class, 'redirectToGoogleCalenderAuth']);
Route::get('google-calender-callback', [GoogleController::class, 'handleGoogleCalenderCallback']);

/**
 * Temp Routes
 */
Route::get('add-religion', [CronController::class, 'addReligion'] );
Route::get('update-continent', [CronController::class, 'updateContinent'] );
Route::get('update-country', [CronController::class, 'updateCountry'] );
Route::get('update-state', [CronController::class, 'updateState'] );
Route::get('update-city', [CronController::class, 'updateCity'] );
Route::get('update-business-type', [CronController::class, 'updateBusinessType'] );
Route::get('update-induxtry-color', [CronController::class, 'updateIndustryHexCode'] );

Route::get('update-company', [CronController::class, 'updateCompany'] );
Route::get('update-department', [CronController::class, 'updateDepartment'] );
Route::get('store-client-data', [CronController::class, 'storeClientRandomData'] );
Route::get('get-admin-menu', [CronController::class, 'getAdminMenu'] );
Route::get('clone-permission', [CronController::class, 'clonePermission'] );
Route::get('clone-role-permission', [CronController::class, 'cloneRolePermission'] );
Route::get('update-client-email', [CronController::class, 'updateClientEmail'] );
Route::get('send-tmp-mail', [CronController::class, 'sendTempMail'] );
Route::get('prism-ai', [CronController::class, 'prismAI'] );

Route::get( 'send-client-on-board-mail', function(){
    $data = [
        'name' => 'Gautam Kakadiya',
        'subject' => 'Welcome to Our Devotion Group!'
    ];

    Mail::to( "gk@mailinator.com" )->send( new ClientOnBoardMail( $data ) );
} );
