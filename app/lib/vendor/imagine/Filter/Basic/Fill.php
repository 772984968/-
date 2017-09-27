<?php

/*
 * This file is part of the Imagine package.
 *
 * (c) Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace lib\vendor\imagine\Filter\Basic;

use lib\vendor\imagine\Filter\FilterInterface;
use lib\vendor\imagine\Image\Fill\FillInterface;
use lib\vendor\imagine\Image\ImageInterface;

/**
 * A fill filter
 */
class Fill implements FilterInterface
{
    /**
     * @var FillInterface
     */
    private $fill;

    /**
     * @param FillInterface $fill
     */
    public function __construct(FillInterface $fill)
    {
        $this->fill = $fill;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(ImageInterface $image)
    {
        return $image->fill($this->fill);
    }
}
