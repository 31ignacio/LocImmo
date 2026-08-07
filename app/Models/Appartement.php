<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Appartement extends Model
{
    use HasFactory;
 
    // On liste explicitement les fillable pour éviter les surprises
    protected $fillable = [
        'type', 'categorie', 'duree',
        'departement', 'commune', 'quartier',
        'surface', 'nombrePieces','salleBain',
        'disponible_date',
        'meuble', 'collocation', 'packing',
        'clime', 'wifi', 'securite', 'terasse', 'cuisine', 'entretien',
        'prix', 'negociable', 'caution',
        'description', 'images',
        'statut', 'views', 'transactionId',
        'entreprise_id','latitude', 'longitude',
        'nombreSalon', 'nombreChambre', 'nombreSalleBain',
        'sanitaire', 'proprio_vit', 'compteur_perso',
        'video','dislikes','likes','surface_salon','surface_cuisine','surface_chambre','surface_sdb','surface_bureau','compteur_eau','compteur_elec','titre_foncier'
    ];
 
    protected $casts = [
        'statut'     => 'boolean',
        'surface'    => 'float',
        'prix'       => 'float',
        'views'      => 'integer',
        'disponible_date' => 'date',
        'latitude'       => 'float',
        'longitude'      => 'float',
    ];
 
    /* ── Relation : appartient à une entreprise ── */
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_id');
    }
 
    /* ── Accessor : tableau d'images ── */
    public function getImagesArrayAttribute(): array
    {
        return $this->images ? explode('|', $this->images) : [];
    }
 
    /* ── Accessor : première image ── */
    public function getFirstImageAttribute(): string
    {
        $imgs = $this->images_array;
        return $imgs[0] ?? 'images/no-image.jpg';
    }

     /**
     * Annonces visibles (statut = 0).
     * Utilisation : Appartement::visible()->get()
     */
    public function scopeVisible($query)
    {
        return $query->where('statut', 0);
    }
 
    /**
     * Annonces masquées par l'IA (statut = 1).
     * Utilisation : Appartement::masque()->get()  (côté admin)
     */
    public function scopeMasque($query)
    {
        return $query->where('statut', 1);
    }
 
    /* ─── Accesseurs pratiques ─── */
 
    /**
     * Indique si l'annonce est visible publiquement.
     */
    public function getIsVisibleAttribute(): bool
    {
        return $this->statut === 0;
    }
 
    /**
     * Indique si l'annonce a été masquée par la modération IA.
     */
    public function getIsMasqueAttribute(): bool
    {
        return $this->statut === 1;
    }
}
 