<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Menu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
  
    public $active;

    public function __construct($active)
    {
        //
        
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $list = $this->list();
        return view('components.menu', ['list' => $list, 
                                        'active' => $this->active]);
    }
    public function list(){
        return[
            [
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'icon'  => 'fa-solid fa-house-chimney'
            ],
            //[
              //  'label' => 'Movie',
                //'route' => 'dashboard.movies',
                //'icon'  => 'fa-solid fa-users-viewfinder'
            //],
            [
                'label' => 'Buku',
                'route' => 'dashboard.books',
                'icon'  => 'fa-solid fa-book-bookmark'
            ],
            [
                'label' => 'KategoriBuku',
                'route' => 'dashboard.kategoribuku',
                'icon'  => 'fa-solid fa-book-bookmark'
            ],
            [
                'label' => 'Peminjaman',
                'route' => 'dashboard.peminjaman',
                'icon'  => 'fa-solid fa-handshake-simple'
            ],
            [
                'label' => 'Pengembalian',
                'route' => 'dashboard.pengembalian',
                'icon'  => 'fa-solid fa-hand-holding-hand'
            ],
            [
                'label' => 'Users',
                'route' => 'dashboard.users',
                'icon'  => 'fa-solid fa-users-line'
            ]
         ];
    }
    public function isActive($label){
        return $label === $this->active;
    }
}