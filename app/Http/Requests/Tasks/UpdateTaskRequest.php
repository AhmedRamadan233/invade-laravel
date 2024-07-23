<?php

namespace App\Http\Requests\Tasks;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $taskId = $this->input('id');
        return [
            'title' => 'required|string|max:255|unique:tasks,title,' . $taskId,
            'description' => 'required|string|max:255',
            'status' => 'required|in:pending,completed',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ];
    }
}
