<?php

namespace App\Http\Livewire\Components;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartSale extends Component
{
    protected $listeners = ['render' => 'render'];

    public function removeItem($rowID)
    {
        Cart::remove($rowID);
        $this->emit('render');
    }

    public function render()
    {
        return view('livewire.components.cart-sale');
    }
}
