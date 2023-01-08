<?php

namespace App;

use App\Cart\Item;
use App\Cart\ShoppingCart;
use App\Customer\Customer;
use App\Order\Order;
use App\Invoice\TextInvoice;
use App\Invoice\PDFInvoice;
use App\Payments\CashOnDelivery;
use App\Payments\CreditCardPayment;
use App\Payments\PaypalPayment;

class Application
{
	public static function run()
	{
		$cart = new ShoppingCart();
		$pencil= new Item('School','Very Premium Pencil', 10000);
		
		$cart->addItem($pencil, 1);


		$customer = new Customer('Caloy', 'Orange St.', 'caloy0714@gmail.com');

		$order = new Order($customer, $cart);

		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
		$textInvoice = new TextInvoice($order);
		$order->setInvoiceGenerator($textInvoice);
		$order->generate();

		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
		$pdfInvoice = new PDFInvoice($order);
		$order->setInvoiceGenerator($pdfInvoice);
		$order->generate();

		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
		$creditCard = new CreditCardPayment('Caloy', '5432-1234-1231-3234', '300', '12/24');
		$order->setPaymentMethod($creditCard);
		$order->pay();

		echo "\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n";
		$cod = new CashOnDeliveryStrategy($customer);
		$order->setPaymentMethod($cod);
		$order->pay();

	}
}