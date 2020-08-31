<?php


namespace App\Lib\Traits;


use Illuminate\Database\Eloquent\Builder;

trait SlugScope
{
    protected string $slug = 'uri_alias';

    /**
     * @param  Builder  $query
     * @param  string  $slug
     * @return Builder
     */
    public function scopeWhereSlug($query, $slug)
    {
        return $query->where($this->slug, '=', $slug);
    }
}
