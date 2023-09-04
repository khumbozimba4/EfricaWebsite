<?php

namespace App\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Validations {

    /**
     * Validate the input data for storing a new Article.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validateArticleStore($request)
    {
        $validator = Validator::make($request->all(), [
			'title' => 'required',
			'photo_url' => 'required',
			'content' => 'required',
			'published_at' => 'required',

        ]);

        return $validator;
    }


    /**
     * Validate the input data for storing a new Service.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validateServiceStore($request)
    {
        $validator = Validator::make($request->all(), [
			'title' => 'required',
			'description' => 'required',
			'icon' => 'required',

        ]);

        return $validator;
    }


    /**
     * Validate the input data for storing a new Setting.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validateSettingStore($request)
    {
        $validator = Validator::make($request->all(), [
			'key' => 'required',
			'value' => 'required',

        ]);

        return $validator;
    }


    /**
     * Validate the input data for storing a new User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validateUserStore($request)
    {
        $validator = Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required',
			'password' => 'required',

        ]);

        return $validator;
    }



}