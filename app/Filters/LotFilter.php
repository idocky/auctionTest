<?php

namespace App\Filters;

class LotFilter extends QueryFilter
{

    public function categories($cat_slug = null)
    {
        return $this->builder->whereHas('categories', function ($query) use ($cat_slug){
            $query->whereIn('categories.slug', $cat_slug);

        });
    }

}
