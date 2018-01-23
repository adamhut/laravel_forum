<?php 
namespace App;

use App\Reputation;

trait HasReputation
{
    /**
     * Clear User Reputation
     *
     * @return void
     */
    public function clearReputation()
    {
        //$this->reputation = 0;

        //$this->save();
    }

    /**
     * Award reputtion points to the model
     *
     * @param string $type
     * 
     */
    public function gainReputation($type)
    {
        //$this->increment('reputation',config("council.reputation.{$type}"));
        //dd($type);
        $this->reputation()->create([
            'type' => $type,
            'points' => config("council.reputation.{$type}"),
        ]);
    }

    /**
     * Reduce reputation points for the model.
     *
     * @param  string $type
     */
    public function loseReputation($type)
    {
        //$this->decrement('reputation', config("council.reputation.{$type}"));
        $this->reputation()->create([
            'type' => $type,
            'points' => config("council.reputation.{$type}") * -1,
        ]);
    }

    public function reputation()
    {
      
        return $this->hasMany(Reputation::class);
    }

    public function getPointsAttribute()
    {
        return $this->reputation->sum('points');
    }

}