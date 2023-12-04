<?php
declare(strict_types=1);

namespace App\Queries;

final class CourseListQuery
{
    private ?int $category_id;
    private ?int $instruction_level_id;
    private ?string $price_id;
    private string $sort;

    public function __construct(
        ?int $category_id,
        ?int $instruction_level_id,
        ?string $price_id,
        string $sort = 'asc'
    )
    {
        $this->category_id = $category_id;
        $this->instruction_level_id = $instruction_level_id;
        $this->price_id = $price_id;
        $this->sort = $sort;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function getInstructionLevelId(): ?int
    {
        return $this->instruction_level_id;
    }

    public function getPriceId(): ?string
    {
        return $this->price_id;
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }


}