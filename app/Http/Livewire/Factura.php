<?php

namespace App\Http\Livewire;

use Facturapi\Facturapi;
use Livewire\Component;

class Factura extends Component
{
    public function create()
    {
        $facturapi = new Facturapi('sk_test_0w48olmaJpVqd3BZXnGmPkWdZY1RWgMAnQjbPzeO5y');

        $invoice = array(
            "customer"     => "YOUR_CUSTOMER_ID",
            "items"        => array(
                array(
                    "quantity" => 1, // Optional. Defaults to 1.
                    "product"  => "YOUR_PRODUCT_ID" // You can also pass a product object instead
                ),
                array(
                    "quantity" => 2,
                    "product"  => array(
                        "description" => "Guitarra",
                        "product_key" => "01234567",
                        "price"       => 420.69,
                        "sku"         => "ABC4567"
                    )
                ) // Add as many products as you want to include in your invoice
            ),
            "payment_form" => \Facturapi\PaymentForm::EFECTIVO,
            "folio_number" => "581",
            "series"       => "F"
        );

        $facturapi->Invoices->create($invoice);
    }
    public function render()
    {
        return view('livewire.factura');
    }
}
