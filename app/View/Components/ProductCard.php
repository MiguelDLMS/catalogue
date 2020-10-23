<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductCard extends Component
{
    /**
     * The product's ID.
     *
     * @var int $productID
     */
    public $productID;

    /**
     * The product's name.
     *
     * @var string $productName
     */
    public $productName;

    /**
     * The product's description.
     *
     * @var string $productDescription
     */
    public $productDescription;

    /**
     * The name of the product´s image to display.
     *
     * @var string $imageName
     */
    public $imageName;

    /**
     * Create the component instance.
     *
     * @param int $productID
     * @param  string  $productName
     * @param  string  $productDescription
     * @param  string  $imageName
     * @return void
     */
    public function __construct($productID, $productName, $productDescription, $imageName)
    {
        $this->productID = $productID;
        $this->productName = $productName;
        $this->productDescription = $productDescription;
        $this->imageName = $imageName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.product-card');
    }
}
