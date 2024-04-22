<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'parent_id'
    ];
    public function children()
    {
        return $this->hasMany(Categorie::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Categorie::class, 'parent_id', 'id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'categorie_id');
    }
    public function scopeDescendants($query, $categoryId)
    {
        return $query->where('id', $categoryId)->with('children', 'children.children');
    }

    public static function getNewsByCategory($categoryName)
    {
        $category = self::where('name', $categoryName)->with('children')->first();

        if (!$category) {
            return null;
        }

        $descendantCategoryIds = $category->getDescendantCategoryIds();

        $descendantCategoryIds[] = $category->id;

        $news = News::whereIn('categorie_id', $descendantCategoryIds)
            ->paginate(10);

        return $news;
    }
    protected function getDescendantCategoryIds()
    {
        $descendantIds = [];

        foreach ($this->children as $child) {
            $descendantIds[] = $child->id;
            $descendantIds = array_merge($descendantIds, $child->getDescendantCategoryIds());
        }

        return $descendantIds;
    }
}
