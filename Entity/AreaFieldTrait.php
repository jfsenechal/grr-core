<?php
/**
 * This file is part of sf5 application
 * @author jfsenechal <jfsenechal@gmail.com>
 * @date 21/11/19
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Grr\Core\Entity;

use Doctrine\ORM\Mapping as ORM;

trait AreaFieldTrait
{
    /**
     * @var AreaInterface
     * @ORM\ManyToOne(targetEntity="Grr\Core\Entity\AreaInterface", inversedBy="rooms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $area;

    public function getArea(): ?AreaInterface
    {
        return $this->area;
    }

    public function setArea(?AreaInterface $area): self
    {
        $this->area = $area;

        return $this;
    }

}