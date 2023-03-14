<?php

namespace App\Http\Requests;

use App\Traits\RulesStoreUser;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    use RulesStoreUser;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            ...$this->rulesUser(),
            ...$this->ruleIsIdUser()
        ];
    }
}
