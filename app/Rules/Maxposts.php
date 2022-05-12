<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Post;

class Maxposts implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    protected $numOfPosts;

    public function __construct($numOfPosts)
    {
        $this->numOfPosts = $numOfPosts;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Post::where($attribute,$value)->get()->count() <= $this->numOfPosts;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "A user can't have more than $this->numOfPosts posts";
    }
}
