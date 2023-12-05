<?php
declare(strict_types=1);

namespace App\Queries;

final class CourseListQuery
{
    private ?array $categoryIds;
    private ?array $instructionLevelIds;
    private ?array $priceIds;
    private string $sort;

    private int $paginateCount;

    public function __construct(
        ?array $categoryIds,
        ?array $instructionLevelIds,
        ?array $priceIds,
        string $sort = 'asc',
        int $paginateCount = 9
    )
    {
        $this->categoryIds = $categoryIds;
        $this->instructionLevelIds = $instructionLevelIds;
        $this->priceIds = $priceIds;
        $this->sort = $sort;
        $this->paginateCount = $paginateCount;
    }

    public function getCategoryIds(): ?array
    {
        return $this->categoryIds;
    }

    public function getInstructionLevelIds(): ?array
    {
        return $this->instructionLevelIds;
    }

    public function getPriceIds(): ?array
    {
        return $this->priceIds;
    }

    public function getSort(): string
    {
        return $this->sort;
    }

    public function getPaginateCount(): int
    {
        return $this->paginateCount;
    }

}