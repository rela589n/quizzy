<?php


namespace App\Lib\Traits;


trait SlugScope
{
    protected $slug = 'uri_alias';

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereSlug($query, $slug)
    {
        return $query->where($this->slug, '=', $slug);
    }
}
