<?php
/**
 * This file is part of GrrSf application.
 *
 * @author jfsenechal <jfsenechal@gmail.com>
 * @date 6/10/19
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Grr\Core\Tests\Validator;

use DateTime;
use Grr\Core\Factory\DurationFactory;
use Grr\GrrBundle\Entry\Validator\DurationValidator;
use PHPUnit\Framework\TestCase;

class TTest extends TestCase
{
    public function testValidatorUser(): void
    {
        $factory = new DurationFactory();
        $begin = new DateTime();
        $end = new DateTime();
        $end->modify('+3 hours');

        $duration = $factory->createFromDates($begin, $end);

        $validator = new DurationValidator();
        $datas = ['1'];

        $this->assertCount(1, $datas);
        //todo

//        $errors = $validator->validate($duration);
        //      $this->assertEquals(0, count($errors));
    }
}
