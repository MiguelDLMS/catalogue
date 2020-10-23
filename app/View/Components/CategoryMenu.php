<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class CategoryMenu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $categories = DB::table('CATEGORIES')
                        ->select('ID_Category', 'Name', 'Description')
                        ->get();

        return view('components.category-menu', [
            'categories' => $categories
        ]);
    }
}
