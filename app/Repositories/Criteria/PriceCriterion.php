<?php

namespace App\Repositories\Criteria;

use App\Queries\CourseListQuery;
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

        $price_count = count($this->courseListQuery->getPriceIds());
        $is_greater_500 = false;
        // echo $price_count;exit;
        foreach ($this->courseListQuery->getPriceIds() as $p => $price) {
            $p++;
            $price_split = explode('-', $price);

            if($price_count == 1)
            {
                $from = $price_split[0];
                if($price == 500)
                {
                    $is_greater_500 = true;
                }
                else
                {
                    $to = $price_split[1];
                }

            }
            elseif($p==1)
            {
                $from = $price_split[0];
            }
            elseif($p==$price_count)
            {

                if($price == 500)
                {
                    $is_greater_500 = true;
                }
                else
                {
                    $to = $price_split[1];
                }

            }

        }
        $query->where('courses.price', '>=', $from);
        if(!$is_greater_500)
        {
            $query->where('courses.price', '<=', $to);
        }

        return $query;
    }
}