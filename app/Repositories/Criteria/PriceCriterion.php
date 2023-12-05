<?php

namespace App\Repositories\Criteria;

use App\Queries\CourseListQuery;
use App\ValueObjects\Boundaries;
use Illuminate\Database\Query\Builder;

class PriceCriterion implements CourseListCriterion
{
    private CourseListQuery $courseListQuery;

    /**
     * PriceCriterion constructor.
     */
    public function __construct(CourseListQuery $courseListQuery)
    {
        $this->courseListQuery = $courseListQuery;
    }

    public function shouldApplyToList(): bool
    {
        return $this->courseListQuery->getPriceIds() !== null;
    }

    public function applyToListBuilder(Builder $query): Builder
    {
        $boundaries = $this->getPriceBoundaries($this->courseListQuery->getPriceIds());

        $query->where('courses.price', '>=', $boundaries->getFrom());
        if($boundaries->getTo() !== null)
        {
            $query->where('courses.price', '<=', $boundaries->getTo());
        }

        return $query;
    }

    public function getPriceBoundaries(?array $priceList): Boundaries
    {
        $from = null;
        $to = null;
        foreach($priceList as $price)
        {
            if(is_int($price)) {
                $to = null;
                continue;
            }

            [$currentFrom, $currentTo] = explode('-', $price);
            if($from === null) {
                $from = $currentFrom;
                $to = $currentTo;
            }

            if($from>=$currentFrom) {
                $from = $currentFrom;
            }

            if($to<=$currentTo) {
                $to = $currentTo;
            }
        }

        return new Boundaries($from ?? 0, $to ?? null);
    }
}