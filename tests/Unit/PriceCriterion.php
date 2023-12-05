<?php

namespace Tests\Unit;

use App\Queries\CourseListQuery;
use App\ValueObjects\Boundaries;
use PHPUnit\Framework\TestCase;

class PriceCriterion extends TestCase
{
    /** @dataProvider priceDataProvider */
    public function testItShouldCreateBoundaries(array $values): void
    {
        [$priceIds, $from, $to] = $values;

        // Given:
        $courseListQuery = new CourseListQuery(
            null,
            null,
            $priceIds
        );
        $priceCriterion = new \App\Repositories\Criteria\PriceCriterion($courseListQuery);

        // When:
        $boundaries = $priceCriterion->getPriceBoundaries($priceIds);

        // Then:
        $this->assertInstanceOf(Boundaries::class, $boundaries);
        $this->assertEquals($from, $boundaries->getFrom());
        $this->assertEquals($to, $boundaries->getTo());
    }

    public function priceDataProvider(): \Generator
    {
        yield [
            [['0-10', '30-50', 500], 0, null]
        ];
        yield [
            [['0-10', '30-50'], 0, 50]
        ];
        yield [
            [['0-10'], 0, 10]
        ];
        yield [
            [[500], 0, null]
        ];
        yield [
            [['10-100', '30-50'], 10, 100]
        ];
    }
}