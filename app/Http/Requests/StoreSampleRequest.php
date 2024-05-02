<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      required={
 *     "title",
 *     "image",
 *   },
 *     properties={
 *         @OA\Property(property="title", type="string", example="Sample title"),
 *         @OA\Property(property="description", type="string", example="Sample description"),
 *         @OA\Property(property="image",type="string", format="binary"),
 *     }
 * )
 */
class StoreSampleRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image',
        ];
    }
}
