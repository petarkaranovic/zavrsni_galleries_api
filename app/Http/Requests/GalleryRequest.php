<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
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
        $galleryId=$this->method()=='PUT' ? $this->route()->parameters['gallery']->id : null;
        return [
            'title'=>'required|min:2|max:255',
            'description'=>'max:1000',
            'images'=>'min:1',
            'images.*.url'=>['regex:/^(http)?s?:?(\/\/[^\']*\.(?:png|jpg|jpeg))/']
        ];
    }
}