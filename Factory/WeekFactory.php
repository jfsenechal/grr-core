<?php
/**
 * This file is part of GrrSf application.
 *
 * @author jfsenechal <jfsenechal@gmail.com>
 * @date 23/10/19
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Grr\Core\Factory;

use Grr\Core\I18n\LocalHelper;
use Grr\Core\Model\Week;

class WeekFactory
{
    /**
     * @var LocalHelper
     */
    private $localHelper;

    public function __construct(LocalHelper $localHelper)
    {
        $this->localHelper = $localHelper;
    }

    public function create(int $year, int $week): Week
    {
        return Week::create($year, $week, $this->localHelper->getDefaultLocal());
    }
}