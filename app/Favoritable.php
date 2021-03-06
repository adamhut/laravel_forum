<?php

namespace App;

trait Favoritable
{
    protected static function bootFavoritable()
    {
        static::deleting(function ($model) {
            $model->favorites->each(function ($favorite) {
                $favorite->delete();
            });
        });
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        //$reply->favorites()->create(['user_id' => auth()->id()]);
        $attributes = ['user_id' => auth()->id()];
        //$attributes = ['user_id' => $this->user_id];
        if (! $this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function unfavorite()
    {
        //$reply->favorites()->create(['user_id' => auth()->id()]);
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()
            ->where($attributes)
            ->get()
            ->each(function ($favorite) {
                $favorite->delete();
            });

        //or
        /*
        $this->favorites()->where($attributes)->get()->each->delete();
        });

        */
    }

    public function isFavorited()
    {
        //return $this->favorites()->where('user_id',auth()->id())->exists();
        return (bool) $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        //return $this->favorites()->where('user_id',auth()->id())->exists();
        return $this->favorites->count();
    }
}
