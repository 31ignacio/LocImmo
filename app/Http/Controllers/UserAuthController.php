<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitDefineAccessRequest;
use App\Mail\ApresInscriptionMail;
use App\Mail\ActiverInscriptionMail;
use App\Mail\ModifierPasswordMail;
use App\Mail\PasswordForget;
use App\Models\Appartement;
use App\Models\Entreprise;
use App\Models\ResetCodePassword;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserAuthController extends Controller
{
    /**
     * Mon accueil
    */
   public function index()
{
    // Les 8 dernières annonces actives
    $appartements = Appartement::query()
        ->where('statut', 1)
        ->latest('id')
        ->limit(8)
        ->get();

    return view('auth.users.index', compact('appartements'));
}

    /**
     * Mon login
    */
    public function login(){

        return view('auth.users.login');
    }


    public function registerUser(){

        return view('auth.users.registerUser');
    }

    /**
     * S'identifier
    */
    public function handleUserLogin(Request $request){

        $request->validate([
            'email'=>'required|exists:users,email',
            'password'=>'required|min:6'
        ], [
            'email.required'=>'Votre email est requis',
            'email.exists'=>'Cette adresse mail n\'est pas reconnu', 
            'password.required'=>'Le mot de passe est requis',
            'password.min'=> 'Le mot de passe est incorrect'
        ]);

        try {
            // Vérifier les informations d'identification de l'utilisateur
            $credentials = $request->only('email', 'password');
            
            // Rechercher l'utilisateur par son email
            $user = User::where('email', $request->email)->first();
            
            // Vérifier si l'utilisateur existe
            if (!$user) {
                // Informer l'utilisateur que les informations de connexion sont incorrectes
                return redirect()->back()->with('error', 'Informations de connexion incorrectes.');
            }
        
            // Vérifier si le compte de l'utilisateur est actif
            if (!$user->estActive) {
                // Informer l'utilisateur que son compte est désactivé
                return redirect()->back()->with('error', 'Votre compte est désactivé. Veuillez contacter l\'administrateur.');
            }
        
            // Authentifier l'utilisateur
            if (auth()->attempt($credentials)) {
                // Rediriger vers la page d'accueil
                return redirect('/Entreprise/espace');
            } else {
                // Informer l'utilisateur que les informations de connexion sont incorrectes
                return redirect()->back()->with('error', 'Informations de connexion incorrectes.');
            }
        } catch (Exception $e) {
            // Gérer les exceptions
        }
        
        
    }


    /**
     * Affiche la page inscription proprietaire
    */
    public function registerEntreprise(){

        return view('auth.users.registerEntreprise');
    }

    /**
     * Enregistrer un proprietaire
    */
    public function handleEntrepriseRegister(Request $request)
    {
        $validated = $request->validate([
            'nom'          => 'required|string|max:150',
            'prenom'       => 'required|string|max:150',
            'ville'        => 'required|string|max:150',
            'quatier'      => 'required|string|max:150',
            'telephone'    => 'required|string|min:8|max:20',
            'email'        => 'required|email|unique:users,email',
            'profil'       => 'required|string',
        ], [
            'nom.required'        => 'Votre nom est requis',
            'prenom.required'     => 'Votre prénom est requis',
            'ville.required'      => 'La ville est requise',
            'quatier.required'    => 'Le quartier est requis',
            'telephone.required'  => 'Le numéro de téléphone est requis',
            'email.required'      => 'Votre email est requis',
            'email.unique'        => 'Cette adresse mail est déjà prise',
            'profil.required'     => 'Le profil est requis',
        ]);

        $code = str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        try {
            DB::transaction(function () use ($validated, $code) {

                $user = User::create([
                    'name'      => trim($validated['nom'] . ' ' . $validated['prenom']),
                    'email'     => $validated['email'],
                    'telephone' => $validated['telephone'],
                    'role_id'   => 2,
                    'estActive' => 0,
                ]);

                Entreprise::create([
                    'nom'         => $validated['nom'],
                    'prenom'      => $validated['prenom'],
                    'ville'       => $validated['ville'],
                    'quatier'     => $validated['quatier'],
                    'profil'      => $validated['profil'],
                    'telephone'   => $validated['telephone'],
                    'user_id'     => $user->id,
                ]);

                ResetCodePassword::updateOrCreate(
                    ['email' => $validated['email']],
                    ['code' => $code]
                );
            });

        } catch (\Throwable $e) {
            report($e);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue. Veuillez réessayer plus tard.');
        }

        // Envoi du mail OBLIGATOIRE après inscription réussie
        try {
            Mail::to($validated['email'])->send(
                new ActiverInscriptionMail($code, $validated['email'], $validated['prenom'])
            );
        } catch (\Throwable $e) {
            report($e);

            // Le compte existe déjà en base à ce stade,
            // on informe l'utilisateur mais on ne peut pas "annuler" l'inscription
            return redirect()->route('home')
                ->with('error', 'Compte créé, mais l’e-mail n’a pas pu être envoyé. Contactez le support.');
        }

        return redirect()->route('home')
            ->with('success', 'Compte créé ! Vérifiez votre e-mail pour activer votre compte.');
    }
    /**
     * Deconnexion
     */
    public function handleLogout(){

        Auth::logout();
        return redirect('/');
    }

    /**
     * Validate account(Apres inscription)
     */
    public function defineAccess($email){

        //1- S'assurer que l'email existe vraiment
        $checkUserExist= User::where('email', $email)->first();
        //2- S'il existe
        if($checkUserExist){
            return view('auth.users.validate-account', compact('email'));
        }else{
        //Si le mail n'existe pas
            return redirect()->route('home');
        }
    }

    /**
     * Ce qui suit apres validate account
     */
    public function submitDefineAccess(SubmitDefineAccessRequest $request){

        try {
            //code...
            $user= User::where('email', $request->email)->first();
            if($user){
                $user->password= Hash::make($request->password);
                $user->email_verified_at= Carbon::now();
                $user->estActive=1;
                $user->update(); 

                //supprimer le code de la table apres confirmation de son compte
                if($user){
                    ResetCodePassword::where('email', $user->email)->delete();
                }
                Mail::to($user->email)->send(new ApresInscriptionMail($user));
                // Mail::to($user->email)->queue(new ApresInscriptionMail($user));

                return redirect()->route('handleUserLogin')->with('success', 'Vos accès ont été correctement définis');
            }else{
                //404
            }
        } catch (Exception $e) {
            dd($e);
        }
    }

    /**
     * Affiche le formulaire de mot de passe oublié
     */
    public function showLinkRequestForm(){

        return view('auth.users.passwordForget');
    }

    /**
     * Renitialiser mot de passe (envoi de mail au user)
     */
    public function changePassword(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Votre email est requis',
            'email.email'    => 'Adresse email invalide',
        ]);

        // Vérifier si l'utilisateur existe
        $user = User::where('email', $request->email)->first();
       

        if (! $user) {
            return back()->with('error', 'Aucun compte associé à cette adresse email');
        }

        try {
            // Supprimer les anciens codes
            ResetCodePassword::where('email', $user->email)->delete();
            
            // Générer le code
            $code = rand(1000, 9999);
            // Sauvegarder le code
             ResetCodePassword::create([
                'email' => $user->email,
                'code'  => $code,
            ]);

            // Envoyer le mail
            Mail::to($user->email)->send(new PasswordForget($code, $user->email, $user->name));
            // Mail::to($user->email)->queue(new PasswordForget($code, $user->email, $user->name));

            return redirect()
                ->route('home')
                ->with('success', 'Un e-mail de réinitialisation vous a été envoyé.');

        } catch (\Throwable $e) {

            report($e); // Log l’erreur (important en prod)

            return back()->with(
                'error',
                'Une erreur est survenue lors de l’envoi de l’e-mail. Veuillez réessayer.'
            );
        }
    }

    /**http://127.0.0.1:8000/#heroCarousel
     * Formulaire pour definir les nouveaux accès apres renitialisation du mot de passe
     */
    public function defineAccessMail($email,$code){
        //1- S'assurer que l'email existe vraiment
        $checkUserExist= User::where('email', $email)->first();
        //2- S'il existe
        if($checkUserExist){
            return view('auth.users.validate-mail', compact('email','code'));
        }else{
        //Si le mail n'existe pas
            return redirect()->route('home');
        }
    }

    /**
     * Definir les nouveaux accès de renitialisation de mot de passe
     */
    public function submitDefineAccessMail(Request  $request)
    {
        $request->validate([
            'password' => 'required|min:6|same:confirme_password',
            'confirme_password'=>'required|same:password',
            'code'=>'required|exists:reset_code_passwords,code',

        ], [
            'code.required'=>'Le code est requis.',
            'code.exists'=>'Ce mail est expiré. Merci de revenir à l’accueil',
            'password.required'=>'Le mot de passe es requis.',
            'password.min'=> 'Le mot de passe doit être supérieur à cinq (05) caractères.',
            'confirme_password'=> 'Confirmer mot de passe.',
            'password.same'=>'Les mots de passe ne correspondent pas.',
            'confirme_password.same'=>'Les mots de passe ne correspondent pas.',
            
        ]);

        try {
            //code...
            $user= User::where('email', $request->email)->first();
           
            if($user){
                $user->password= Hash::make($request->password);
                $user->email_verified_at= Carbon::now();
                $user->update(); 

                //supprimer le code de la table apres confirmation de son compte
                if($user){
                    ResetCodePassword::where('email', $user->email)->delete();
                }
                
                Mail::to($user->email)->send(new ModifierPasswordMail($user));
                // Mail::to($user->email)->queue(new ModifierPasswordMail($user));

                return redirect()->route('handleUserLogin')->with('success', 'Vos accès ont été correctement définis');
            }else{
                //404
            }
        } catch (Exception $e) {
            
            return back()->with(
                'error',
                'Une erreur est survenue. Veuillez réessayer.'
            );
        }
    }

}
