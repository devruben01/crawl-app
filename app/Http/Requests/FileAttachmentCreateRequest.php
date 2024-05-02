<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="File attachment create request",
 *      description="File attachment create request body data",
 *      type="object",
 *      required={"file_name"}
 * )
 *
 * @SuppressWarnings(PHPMD)
 */

class FileAttachmentCreateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'image' => 'required|image'
        ];
    }
}
