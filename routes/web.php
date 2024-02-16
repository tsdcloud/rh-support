<?php

use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DeOperation;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SanctionController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use App\Jobs\TestJob;
use App\Models\DemandeExplication;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\Return_;

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

require __DIR__.'/auth.php';
Route::middleware(['auth', 'entity'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('test-job', function(){
        TestJob::dispatch();

        return "chargement de la page reussie";
    });

    Route::prefix('de')->group(function () {
        Route::get('create', [DeOperation::class, 'create'])->name('de.create');
        Route::get('transfered', [DeOperation::class, 'de_transfered'])->name('de.transfered');
        Route::get('inprocess', [DeOperation::class, 'de_inprocess'])->name('de.inprocess');
        Route::get('underproposal', [DeOperation::class, 'de_underproposal'])->name('de.underproposal');
        Route::post('store', [DeOperation::class, 'store'])->name('de.store');

        Route::get('alreadyanswered', [DeOperation::class, 'de_alreadyanswered'])->name('de.alreadyanswered');
        Route::get('alreadyanswered/ontime', [DeOperation::class, 'de_alreadyanswered_ontime'])->name('de.alreadyanswered.ontime');
        Route::get('alreadyanswered/late', [DeOperation::class, 'de_alreadyanswered_late'])->name('de.alreadyanswered.late');

        Route::get('notanswered', [DeOperation::class, 'de_notanswered'])->name('de.notanswered');
        Route::get('notanswered/ontime', [DeOperation::class, 'de_notanswered_ontime'])->name('de.notanswered.ontime');
        Route::get('notanswered/late', [DeOperation::class, 'de_notanswered_late'])->name('de.notanswered.late');

        Route::get('reponse/supplementaire', [DeOperation::class, 'de_repondre_supplementaire'])->name('de.repondre.supplementaire');
        Route::get('underdecision', [DeOperation::class, 'de_underdecision'])->name('de.underdecision');
        Route::get('undernote', [DeOperation::class, 'de_undernote'])->name('de.undernote');
        Route::get('archived', [DeOperation::class, 'de_archived'])->name('de.archived');
        Route::get('show/{demande}', [DeOperation::class, 'show'])->name('de.show');
        Route::put('answered/{demande}', [DeOperation::class, 'de_answered'])->name('de.answered');
        Route::post('answered/{demande}', [DeOperation::class, 'de_answered_supplementaire'])->name('de.answered.supplementaire');
        Route::put('form_reponse_supplementaire/{reponse_supplementaire}', [DeOperation::class, 'de_form_reponse_supplementaire'])->name('de.answered.form_reponse_supplementaire');
        Route::post('history/export/{user}', [DeOperation::class, 'de_history_export'])->name('de.history.export');

        
    });

    Route::prefix('sanctions')->group(function () {
        Route::get('history', [SanctionController::class, 'history'])->name('sanctions.history');
        Route::post('history/add', [SanctionController::class, 'history_add'])->name('sanctions.history.add');
        Route::get('history/show/{user}', [SanctionController::class, 'show'])->name('sanctions.history.show');
        Route::post('proposition/{user}', [SanctionController::class, 'proposition'])->name('sanctions.proposition');
        Route::post('decision/{user}', [SanctionController::class, 'decision'])->name('sanctions.decision');
        Route::post('decision/note/{user}', [SanctionController::class, 'decision_note'])->name('sanctions.decision.note');
    });

    Route::prefix('motifs')->group(function(){
        Route::get('de', [ConfigurationController::class, 'motifs'])->name('motifs.de.index');
        Route::post('de/store', [ConfigurationController::class, 'motifs_store'])->name('motifs.de.store');
        Route::put('de/update/{motif}', [ConfigurationController::class, 'motifs_update'])->name('motifs.de.update');

        Route::get('sanction', [ConfigurationController::class, 'sanction'])->name('motifs.sanction.index');
        Route::post('sanction/store', [ConfigurationController::class, 'sanction_store'])->name('motifs.sanction.store');
        Route::put('sanction/update/{motif}', [ConfigurationController::class, 'sanction_update'])->name('motifs.sanction.update');
    });

    Route::prefix('users')->group(function(){
        Route::get('/', [UserController::class, 'index'])->middleware('isadmin')->name('users.index');
        Route::post('store', [UserController::class, 'store'])->name('users.store');
        Route::put('update/{user}', [UserController::class, 'update'])->name('users.update');
        Route::post('destroy/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('profil/{id}', [UserController::class, 'profil'])->name('profil');
        Route::get('show/{user}', [UserController::class, 'show'])->middleware('isadmin')->name('users.show');
        Route::get('import-get', [UserController::class, 'import_get'])->name('users.import.get');
        Route::get('export-get', [UserController::class, 'export'])->name('users.export');
        Route::post('import-get', [UserController::class, 'import_store'])->name('users.import.store');
        Route::put('update/fonction/{fonction}', [UserController::class, 'update_function'])->name('users.update.fonction');
        Route::post('store/privilege/{user}', [UserController::class, 'store_privilege'])->name('users.store.privilege');
        Route::put('update/privilege/{user}', [UserController::class, 'update_privilege'])->name('users.update.privilege');
        Route::post('remove/privilege/{user}', [UserController::class, 'remove_privilege'])->name('users.remove_privilege');
    });

    Route::prefix('statistics')->group(function(){
        Route::get('explanation_demand', [StatisticsController::class, 'explanation_demand'])->name('statistics.explanation_demand');
        Route::post('explanation_demand/store', [StatisticsController::class, 'explanation_demand_store'])->name('statistics.explanation_demand.store');
        Route::post('explanation_specific_demand/store', [StatisticsController::class, 'explanation_specific_demand'])->name('statistics.explanation_specific_demand.store');

        Route::get('rh', [StatisticsController::class, 'statistics_rh'])->name('statistics.rh');
    });

    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('logs');

    Route::get('test-generation-pdf', [SanctionController::class, 'test_generation_pdf']);
});
