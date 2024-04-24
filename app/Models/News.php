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
    public function getCategorieNameAttribute(): string
    {
        return $this->categorie->name;
    }
    protected $appends = [
        'categorie_name'
    ];
    protected $hidden = [
        'categorie_id',
        'categorie',
        "created_at",
        "updated_at"
    ];

    static public function GetData()
    {
        return self::where('date_expiration', '>=', now())
            ->orderBy('date_start', 'desc')->with('categorie')->paginate(10);
    }
}
