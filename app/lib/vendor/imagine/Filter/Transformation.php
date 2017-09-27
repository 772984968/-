<?php

/*
 * This file is part of the Imagine package.
 *
 * (c) Bulat Shakirzyanov <mallluhuct@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace lib\vendor\imagine\Filter;

use lib\vendor\imagine\Exception\InvalidArgumentException;
use lib\vendor\imagine\Filter\Basic\ApplyMask;
use lib\vendor\imagine\Filter\Basic\Copy;
use lib\vendor\imagine\Filter\Basic\Crop;
use lib\vendor\imagine\Filter\Basic\Fill;
use lib\vendor\imagine\Filter\Basic\FlipVertically;
use lib\vendor\imagine\Filter\Basic\FlipHorizontally;
use lib\vendor\imagine\Filter\Basic\Paste;
use lib\vendor\imagine\Filter\Basic\Resize;
use lib\vendor\imagine\Filter\Basic\Rotate;
use lib\vendor\imagine\Filter\Basic\Save;
use lib\vendor\imagine\Filter\Basic\Show;
use lib\vendor\imagine\Filter\Basic\Strip;
use lib\vendor\imagine\Filter\Basic\Thumbnail;
use lib\vendor\imagine\Image\ImageInterface;
use lib\vendor\imagine\Image\ImagineInterface;
use lib\vendor\imagine\Image\BoxInterface;
use lib\vendor\imagine\Image\Color;
use lib\vendor\imagine\Image\Fill\FillInterface;
use lib\vendor\imagine\Image\ManipulatorInterface;
use lib\vendor\imagine\Image\PointInterface;

/**
 * A transformation filter
 */
final class Transformation implements FilterInterface, ManipulatorInterface
{
    /**
     * @var array
     */
    private $filters = array();

    /**
     * An ImagineInterface instance.
     *
     * @var ImagineInterface
     */
    private $imagine;

    /**
     * Class constructor.
     *
     * @param ImagineInterface $imagine An ImagineInterface instance
     */
    public function __construct(ImagineInterface $imagine = null)
    {
        $this->imagine = $imagine;
    }

    /**
     * Applies a given FilterInterface onto given ImageInterface and returns
     * modified ImageInterface
     *
     * @param ImageInterface  $image
     * @param FilterInterface $filter
     *
     * @return ImageInterface
     * @throws InvalidArgumentException
     */
    public function applyFilter(ImageInterface $image, FilterInterface $filter)
    {
        if ($filter instanceof ImagineAware) {
            if ($this->imagine === null) {
                throw new InvalidArgumentException(sprintf(
                    'In order to use %s pass an Imagine\Image\ImagineInterface instance '.
                    'to Transformation constructor', get_class($filter)
                ));
            }
            $filter->setImagine($this->imagine);
        }

        return $filter->apply($image);
    }

    /**
     * {@inheritdoc}
     */
    public function apply(ImageInterface $image)
    {
        return array_reduce(
            $this->filters,
            array($this, 'applyFilter'),
            $image
        );
    }

    /**
     * {@inheritdoc}
     */
    public function copy()
    {
        return $this->add(new Copy());
    }

    /**
     * {@inheritdoc}
     */
    public function crop(PointInterface $start, BoxInterface $size)
    {
        return $this->add(new Crop($start, $size));
    }

    /**
     * {@inheritdoc}
     */
    public function flipHorizontally()
    {
        return $this->add(new FlipHorizontally());
    }

    /**
     * {@inheritdoc}
     */
    public function flipVertically()
    {
        return $this->add(new FlipVertically());
    }

    /**
     * {@inheritdoc}
     */
    public function strip()
    {
        return $this->add(new Strip());
    }

    /**
     * {@inheritdoc}
     */
    public function paste(ImageInterface $image, PointInterface $start)
    {
        return $this->add(new Paste($image, $start));
    }

    /**
     * {@inheritdoc}
     */
    public function applyMask(ImageInterface $mask)
    {
        return $this->add(new ApplyMask($mask));
    }

    /**
     * {@inheritdoc}
     */
    public function fill(FillInterface $fill)
    {
        return $this->add(new Fill($fill));
    }

    /**
     * {@inheritdoc}
     */
    public function resize(BoxInterface $size, $filter = ImageInterface::FILTER_UNDEFINED)
    {
        return $this->add(new Resize($size, $filter));
    }

    /**
     * {@inheritdoc}
     */
    public function rotate($angle, Color $background = null)
    {
        return $this->add(new Rotate($angle, $background));
    }

    /**
     * {@inheritdoc}
     */
    public function save($path, array $options = array())
    {
        return $this->add(new Save($path, $options));
    }

    /**
     * {@inheritdoc}
     */
    public function show($format, array $options = array())
    {
        return $this->add(new Show($format, $options));
    }

    /**
     * {@inheritdoc}
     */
    public function thumbnail(BoxInterface $size, $mode = ImageInterface::THUMBNAIL_INSET)
    {
        return $this->add(new Thumbnail($size, $mode));
    }

    /**
     * Registers a given FilterInterface in an internal array of filters for
     * later application to an instance of ImageInterface
     *
     * @param FilterInterface $filter
     *
     * @return Transformation
     */
    public function add(FilterInterface $filter)
    {
        $this->filters[] = $filter;

        return $this;
    }
}
