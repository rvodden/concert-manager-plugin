<?php

namespace uk\org\brentso\concertmanagement\admin;

use uk\org\brentso\concertmanagement\common;

class AdminMenu 
{
    protected $loader;

    protected $page_title;
    protected $menu_title;
    protected $capability;
    protected $menu_slug;
    protected $callback;
    protected $icon_url;
    protected $position;

    function __construct(
        common\Loader $loader,
        string $page_title,
        string $menu_title,
        string $capability,
        string $menu_slug,
        $callback = '',
        string $icon_url = '',
        int $position = null
    ) {
        $this->loader = $loader;
        $this->page_title = $page_title;
        $this->menu_title = $menu_title;
        $this->capability = $capability;
        $this->menu_slug = $menu_slug;
        $this->callback = $callback;
        $this->icon_url = $icon_url;
        $this->position = $position;

        $loader->addAction('admin_menu', $this, 'addMenu');
    }

    function addMenu() : void {
        add_menu_page(
            $this->page_title,
            $this->menu_title,
            $this->capability,
            $this->menu_slug,
            $this->callback,
            $this->icon_url,
            $this->position,
        );
    }
    
    function getSlug() : string {
        return $this->menu_slug;
    }
}
