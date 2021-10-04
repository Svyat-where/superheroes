<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nick_name' => 'required',
            'real_name' => 'required',
            'description' => 'required',
            'powers' => 'required',
            'phrase' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nick_name.reuired' => 'A nick_name is required for the post.',
            'real_name.required' => 'Please write down the real_name.',
            'description.required' => 'Please write down the description.',
            'powers.required' => 'Please write down the powers.',
            'phrase.required' => 'Please write down the phrase of the hero.',
        ];
    }
}
