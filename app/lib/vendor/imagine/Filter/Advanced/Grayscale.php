<?php

/*
 * This file is part of the Imagine package.
 *
 * (c) Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace lib\vendor\imagine\Filter\Advanced;

use lib\vendor\imagine\Filter\FilterInterface;
use lib\vendor\imagine\Image\Color;
use lib\vendor\imagine\Image\ImageInterface;
use lib\vendor\imagine\Image\Point;

/**
 * The Grayscale filter calculates the gray-value based on RGB.
 */
class Grayscale extends OnPixelBased implements FilterInterface
{
    public function __construct()
    {
        parent::__construct(function (ImageInterface $image, Point $point) {
            $color = $image->getColorAt($point);
            $gray  = min(255, round(($color->getRed() + $color->getBlue() + $color->getGreen())/3));

            $image->draw()->dot($point, new Color(array(
                'red'   => $gray,
                'green' => $gray,
                'blue'  => $gray
            )));
        });
    }
}
