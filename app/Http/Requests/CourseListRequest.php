<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Queries\CourseListQuery;
use Illuminate\Foundation\Http\FormRequest;

class CourseListRequest extends FormRequest
{
    public function authorize():bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'array'],
            'category_id.*' => ['exists:categories,id'],
            'instruction_level_id' => ['nullable', 'array'],
            'instruction_level_id.*' => ['exists:instruction_levels,id'],
            'price_id' => ['nullable', 'array'],
            'sort_price' => ['nullable', 'in:asc,desc'],
        ];
    }

    public function getQuery(): CourseListQuery
    {
        return new CourseListQuery(
            $this->get('category_id'),
            $this->get('instruction_level_id'),
            $this->get('price_id'),
            $this->get('sort_price', 'asc')
        );
    }
}