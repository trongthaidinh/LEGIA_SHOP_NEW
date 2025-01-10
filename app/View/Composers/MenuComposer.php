<?php

namespace App\View\Composers;

use App\Http\Controllers\Frontend\MenuController;
use Illuminate\View\View;

class MenuComposer
{
    protected $menuController;

    public function __construct(MenuController $menuController)
    {
        $this->menuController = $menuController;
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $view->with('menuItems', $this->menuController->getMainMenu());
    }
}
