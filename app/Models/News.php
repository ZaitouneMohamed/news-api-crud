<?php

namespace App\Models;

use App\Models\Scopes\NonExpireNewsScoope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $fillable = ['title', 'content', 'categorie_id', 'date_start', 'date_expiration'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
    // public function getCategorieNameAttribute(): ?string
    // {
    //     // Check if the 'categorie' relationship is loaded and not null
    //     if ($this->categorie) {
    //         return $this->categorie->name;
    //     }

    //     return null; // Return null if the 'categorie' relationship is not loaded or is null
    // }
    // protected $appends = [
    //     'categorie_name'
    // ];
    // protected $hidden = [
    //     'categorie_id',
    //     'categorie',
    //     "created_at",
    //     "updated_at"
    // ];

    protected static function booted(): void
    {
        static::addGlobalScope(new NonExpireNewsScoope);
    }
}
