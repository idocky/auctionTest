<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Filters\QueryFilter;

class Lot extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'content'];

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'lots_categories',
            'lot_id',
            'category_id'
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
        $lot = new static;
        $lot->fill($fields);
        $lot->save();

        return $lot;
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
     * @return Lot
     */

    public static function findBySlug(string $slug)
    {
        return static::where('slug', $slug)->first();
    }

    /**
     * Fills the link between the lot and the categories.
     *
     * @param  array $ids
     */

    public function setCategories(array $ids)
    {
        if($ids == null){return;}

        $this->categories()->sync($ids);
    }

    /**
     * Gets categories titles separated by comma.
     *
     * @return string
     */

    public function getCategoriesTitles()
    {
        return (!$this->categories->isEmpty())
            ? implode(',', $this->categories->pluck('title')->all())
            : 'Без категории';
    }

    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        return $filter->apply($builder);
    }
}
