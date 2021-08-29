<?php

namespace App\Http\Requests\Ad;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AdRequest
 * @package App\Http\Requests
 */
class StoreAdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'bail|required|min:1|max:255',
            'description' => 'bail|required|min:1|max:1023'
        ];
    }
}
