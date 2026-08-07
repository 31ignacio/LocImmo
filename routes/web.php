<?php

use App\Http\Controllers\AppartementController;
use App\Http\Controllers\ContacteController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [UserAuthController::class, 'index'])->name('home');
Route::get('/validate-account/{email}', [UserAuthController::class, 'defineAccess']);
Route::post('/validate-account/{email}', [UserAuthController::class, 'submitDefineAccess'])->name('submitDefineAccess');


Route::get('forgot-password', [UserAuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [UserAuthController::class, 'changePassword'])->name('password.email');
Route::get('/validate-mail/{email}/{code}', [UserAuthController::class, 'defineAccessMail'])->name('change.mail');
Route::post('/validate-mail/{email}', [UserAuthController::class, 'submitDefineAccessMail'])->name('submitDefineAccessMail');

//Déconnexion
Route::get('/logout', [UserAuthController::class, 'handleLogout'])->name('user.logout');

//rechercher un appartement
Route::get('/search/appartements', [AppartementController::class, 'searchAppartement'])->name('search.appartement');

 //detail d'un appartement
    Route::get('appartement/detail/{appartement}', [AppartementController::class, 'appartementDetail'])->name('appartement.detail');
     Route::post('/appartement/reaction', [AppartementController::class, 'reaction'])->name('appartement.reaction');

Route::get('/newsletter/unsubscribe/{email}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// les route register et login doit etre appeler lorsque l'utilisateur n'est pas connecté

    Route::middleware(['guest'])->group(function () {

        // Inscription entreprise
        Route::get('/register', [UserAuthController::class, 'registerEntreprise'])->name('user.registerEntreprise');
        Route::post('register/Entreprise', [UserAuthController::class, 'handleEntrepriseRegister'])->name('handleEntrepriseRegister');

        //Connexion
        Route::get('/login', [UserAuthController::class, 'login'])->name('login');
        Route::post('/login', [UserAuthController::class, 'handleUserLogin'])->name('handleUserLogin'); 

    });

    Route::post('/newsletter', [NewsletterController::class, 'newsletter'])->name('newsletter');


    //contacte
    Route::get('/contacte', [ContacteController::class, 'contacte'])->name('contacte.create');
    Route::post('/contacte/admin', [ContacteController::class, 'store'])->name('contacte.store');


    //la liste de toutes les annonces
    Route::get('/annonce/all', [AppartementController::class, 'AnnonceAll'])->name('annonce.all');

Route::middleware(['auth'])->group(function () {

    

    //Appartement création
    Route::get('appartement/creer/new', [AppartementController::class, 'appartement'])->name('appartement');
    Route::post('/appartementStore', [AppartementController::class, 'appartementStore'])->name('appartement.store');

    //Modifier un appartement
    Route::get('/appartement/modifier/{appartement}', [AppartementController::class, 'update'])->name('appartement.mod');
    // Route::post('/appartement/{appartement}/update', [AppartementController::class, 'appartementUpdate'])->name('appartement.update');
   Route::match(['PUT', 'POST'], '/appartement/{id}/update', [AppartementController::class, 'appartementUpdate'])->name('appartement.update');
    //supprimer un appartement
    Route::delete('/appartements/{id}', [AppartementController::class, 'destroy'])->name('appartements.destroy');
    //liste appartement(tout)
    Route::get('appartement/liste', [AppartementController::class, 'index'])->name('appartement.index');
    
   
    Route::post('/appartement/mail', [AppartementController::class, 'mailProprietaire'])->name('appartement.mailProprietaire');
    // activer/desactiver une annonce
    Route::patch('/appartement/{id}/toggle-statut', [AppartementController::class, 'toggleStatut'])->name('appartement.toggleStatut');


    // Autoriser GET et POST pour le callback Kkiapay
    Route::match(['get', 'post'], '/paiement-success/{appartementId}', [AppartementController::class, 'paiementSuccess'])->name('paiement.success');



    // Profil
    Route::get('/entreprise/profil', [ProfilController::class, 'profilUser'])->name('user.profil');
    Route::post('/update/profil/{entreprise}', [ProfilController::class, 'updateProfil'])->name('profil.update');

    Route::post('/change-password', [ProfilController::class, 'update'])->name('password.update');

    //end

    //entreprise
    Route::get('/Entreprise/liste', [EntrepriseController::class, 'index'])->name('entreprise.liste');
    Route::get('/Entreprise/espace', [EntrepriseController::class, 'espace'])->name('entreprise.espace');
    Route::get('/entreprise/{id}', [EntrepriseController::class, 'show'])->name('entreprise.show');
    Route::put('/entreprise/{id}/activer', [EntrepriseController::class, 'activer'])->name('entreprise.activer');
    Route::put('/entreprise/{id}/desactiver', [EntrepriseController::class, 'desactiver'])->name('entreprise.desactiver');

    //end

});



