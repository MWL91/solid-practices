<?php
declare(strict_types=1);

namespace App\Queries;

final class CourseListQuery
{
    private ?array $categoryIds;
    private ?array $instructionLevelIds;
    private ?string $price_id;
    private string $sort;

    public function __construct(
        ?array $categoryIds,
        ?array $instructionLevelIds,
        ?string $price_id,
        string $sort = 'asc'
    )
    {
        $this->categoryIds = $categoryIds;
        $this->instructionLevelIds = $instructionLevelIds;
        $this->price_id = $price_id;
        $this->sort = $sort;
    }

    public function getCategoryIds(): ?array
    {
        return $this->categoryIds;
    }

    public function getInstructionLevelIds(): ?array
    {
        return $this->instructionLevelIds;
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