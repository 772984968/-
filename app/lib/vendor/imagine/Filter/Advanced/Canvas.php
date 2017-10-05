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
use lib\vendor\imagine\Image\ImageInterface;
use lib\vendor\imagine\Image\BoxInterface;
use lib\vendor\imagine\Image\Point;
use lib\vendor\imagine\Image\PointInterface;
use lib\vendor\imagine\Image\Color;
use lib\vendor\imagine\Image\ImagineInterface;

/**
 * A canvas filter
 */
class Canvas implements FilterInterface
{
    /**
     * @var BoxInterface
     */
    private $size;

    /**
     * @var PointInterface
     */
    private $placement;

    /**
     * @var Color
     */
    private $background;

    /**
     * @var ImagineInterface
     */
    private $imagine;

    /**
     * Constructs Canvas filter with given width and height and the placement of the current image
     * inside the new canvas
     *
     * @param ImagineInterface $imagine
     * @param BoxInterface     $size
     * @param PointInterface   $placement
     * @param Color            $background
     */
    public function __construct(ImagineInterface $imagine, BoxInterface $size, PointInterface $placement = null, Color $background = null)
    {
        $this->imagine = $imagine;
        $this->size = $size;
        $this->placement = $placement ?: new Point(0, 0);
        $this->background = $background;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(ImageInterface $image)
    {
        $canvas = $this->imagine->create($this->size, $this->background);
        $canvas->paste($image, $this->placement);

        return $canvas;
    }
}
