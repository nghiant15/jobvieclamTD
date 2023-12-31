<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SeoFormRequest extends Request
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
            'seo_title' => 'required',
            'seo_description' => 'required',
            'seo_keywords' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'seo_title.required' => 'Nhập Tiêu đề SEO/ Please enter SEO title.',
            'seo_description.required' => 'Nhập mô tả SEO/ Please enter SEO description.',
            'seo_keywords.required' => 'Nhập từ khóa SEO/ Please enter SEO keywords.',
        ];
    }

}
