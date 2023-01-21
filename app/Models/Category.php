<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title'];

    public function lots()
    {
        return $this->belongsToMany(
            Lot::class,
            'lots_categories',
            'category_id',
            'lot_id'
        );
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function add($fields)
    {
        $category = new static;
        $category->fill($fields);
        $category->save();

        return $category;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        $this->delete();
    }

    /**
     * Fills the link between the lot and the categories.
     *
     * @param  string $slug
     * @return Category
     */

    public static function findBySlug(string $slug)
    {
        return static::where('slug', $slug)->first();
    }

}
