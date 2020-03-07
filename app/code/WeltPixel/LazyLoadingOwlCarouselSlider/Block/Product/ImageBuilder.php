<?php
namespace WeltPixel\LazyLoadingOwlCarouselSlider\Block\Product;


use Magento\Catalog\Helper\ImageFactory as HelperFactory;

class ImageBuilder extends \Magento\Catalog\Block\Product\ImageBuilder
{

    /**
     * @var \WeltPixel\OwlCarouselSlider\Helper\Custom
     */
    protected $owlHelperCustom;

    /**
     * @var \WeltPixel\LazyLoading\Helper\Data
     */
    protected $lazyLoadingHelper;

    /**
     * @param HelperFactory $helperFactory
     * @param \Magento\Catalog\Block\Product\ImageFactory $imageFactory
     * @param \WeltPixel\OwlCarouselSlider\Helper\Custom $owlHelperCustom
     * @param \WeltPixel\LazyLoading\Helper\Data $lazyLoadingHelper
     */
    public function __construct(
        HelperFactory $helperFactory,
        \Magento\Catalog\Block\Product\ImageFactory $imageFactory,
        \WeltPixel\OwlCarouselSlider\Helper\Custom $owlHelperCustom,
        \WeltPixel\LazyLoading\Helper\Data $lazyLoadingHelper
    ) {
        $this->owlHelperCustom = $owlHelperCustom;
        $this->lazyLoadingHelper = $lazyLoadingHelper;
        parent::__construct($helperFactory, $imageFactory);
    }


    /**
     * Create image block
     *
     * @return \Magento\Catalog\Block\Product\Image
     */
    public function create()
    {
        if (!$this->isLazyLoadEnabled() && !$this->lazyLoadingHelper->isEnabled()) {
            return parent::create();
        }

        /** @var \Magento\Catalog\Helper\Image $helper */
        $helper = $this->helperFactory->create()
            ->init($this->product, $this->imageId);

        $template = $helper->getFrame()
            ? 'WeltPixel_LazyLoadingOwlCarouselSlider::product/image.phtml'
            : 'WeltPixel_LazyLoadingOwlCarouselSlider::product/image_with_borders.phtml';

        $data['data']['template'] = $template;

        $imagesize = $helper->getResizedImageInfo();

        $data = [
            'data' => [
                'template' => $template,
                'image_url' => $helper->getUrl(),
                'width' => $helper->getWidth(),
                'height' => $helper->getHeight(),
                'label' => $helper->getLabel(),
                'ratio' =>  $this->getRatio($helper),
                'custom_attributes' => $this->getCustomAttributes(),
                'resized_image_width' => !empty($imagesize[0]) ? $imagesize[0] : $helper->getWidth(),
                'resized_image_height' => !empty($imagesize[1]) ? $imagesize[1] : $helper->getHeight(),
            ],
        ];


        if ($this->isLazyLoadEnabled()) {
            $data['data']['lazy_load'] = true;
        }
        if ($this->isOwlCarouselEnabled()) {
            $data['data']['owlcarousel'] = true;
        }


        return $this->imageFactory->create($data);
    }

    /**
     * @return bool
     */
    protected function isLazyLoadEnabled() {
        foreach ($this->attributes as $name => $value) {
            if ($name == 'weltpixel_lazyLoad') {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    protected function isOwlCarouselEnabled() {
        foreach ($this->attributes as $name => $value) {
            if ($name == 'weltpixel_owlcarousel') {
                return true;
            }
        }

        return false;
    }

    /**
     * Retrieve image custom attributes for HTML element
     *
     * @return string
     */
    protected function getCustomAttributes()
    {
        $result = [];
        foreach ($this->attributes as $name => $value) {
            if (in_array($name, ['weltpixel_lazyLoad', 'weltpixel_owlcarousel'])) continue;
            $result[] = $name . '="' . $value . '"';
        }
        return !empty($result) ? implode(' ', $result) : '';
    }

}