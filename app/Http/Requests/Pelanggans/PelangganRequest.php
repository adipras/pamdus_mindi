<?php

namespace App\Http\Requests\Pelanggans;

use Illuminate\Foundation\Http\FormRequest;

class PelangganRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }
    /**
     * Define validation rules to store method for resource creation
     *
     * @return array
     */
    public function createRules(): array
    {
        return [
            'no_meteran' => 'required|string|max:191|unique:pelanggans',
            'nama' => 'required|string|max:191',
            'nik' => 'required|string|max:16',
            'address' => 'required|string|max:1000',
            // 'photo' => 'sometimes|files',
        ];
    }

    /**
     * Define validation rules to update method for resource update
     *
     * @return array
     */
    public function updateRules(): array
    {
        return [
            'no_meteran' => 'sometimes|string|max:191|unique:pelanggans,no_meteran,' . $this->get('id'),
            'nama' => 'sometimes|string|max:191',
            'nik' => 'sometimes|string|max:16',
            'address' => 'sometimes|string|max:1000',
            // 'photo' => 'sometimes|files',
        ];
    }
}
