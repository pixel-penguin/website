<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Invoice</title>
	
	<style>
		body{background: #333 !important}
		#invoice{max-width: 1024px; margin: auto; background: #FFF}
		
		@media print
{    
			.no-print, .no-print *
			{
				display: none !important;
			}
		}
		
		a{
			color: #000 !important
		}
		
		#invoice{
			padding: 30px;
		}

		.invoice {
			position: relative;
			background-color: #FFF;
			min-height: 680px;
			padding: 15px
		}

		.invoice header {
			padding: 10px 0;
			margin-bottom: 20px;
			border-bottom: 1px solid {{ env('WEBSITE_COLOR_1') }}
		}

		.invoice .company-details {
			text-align: right
		}

		.invoice .company-details .name {
			margin-top: 0;
			margin-bottom: 0
		}

		.invoice .contacts {
			margin-bottom: 20px
		}

		.invoice .invoice-to {
			text-align: left
		}

		.invoice .invoice-to .to {
			margin-top: 0;
			margin-bottom: 0
		}

		.invoice .invoice-details {
			text-align: right
		}

		.invoice .invoice-details .invoice-id {
			margin-top: 0;
			color: {{ env('WEBSITE_COLOR_1') }}
		}

		.invoice main {
			padding-bottom: 50px
		}

		.invoice main .thanks {
			margin-top: -100px;
			font-size: 2em;
			margin-bottom: 50px
		}

		.invoice main .notices {
			padding-left: 6px;
			border-left: 6px solid {{ env('WEBSITE_COLOR_1') }}
		}

		.invoice main .notices .notice {
			font-size: 1.2em
		}

		.invoice table {
			width: 100%;
			border-collapse: collapse;
			border-spacing: 0;
			margin-bottom: 20px
		}

		.invoice table td,.invoice table th {
			padding: 15px;
			background: #eee;
			border-bottom: 1px solid #fff
		}

		.invoice table th {
			white-space: nowrap;
			font-weight: 400;
			font-size: 16px
		}

		.invoice table td h3 {
			margin: 0;
			font-weight: 400;
			color: {{ env('WEBSITE_COLOR_1') }};
			font-size: 1.2em
		}

		.invoice table .qty,.invoice table .total,.invoice table .unit {
			text-align: right;
			font-size: 1.2em
		}

		.invoice table .no {
			color: #fff;
			font-size: 1.6em;
			background: {{ env('WEBSITE_COLOR_1') }}
		}

		.invoice table .unit {
			background: #ddd
		}

		.invoice table .total {
			background: {{ env('WEBSITE_COLOR_1') }};
			color: #fff
		}

		.invoice table tbody tr:last-child td {
			border: none
		}

		.invoice table tfoot td {
			background: 0 0;
			border-bottom: none;
			white-space: nowrap;
			text-align: right;
			padding: 10px 20px;
			font-size: 1.2em;
			border-top: 1px solid #aaa
		}

		.invoice table tfoot tr:first-child td {
			border-top: none
		}

		.invoice table tfoot tr:last-child td {
			color: {{ env('WEBSITE_COLOR_1') }};
			font-size: 1.4em;
			border-top: 1px solid {{ env('WEBSITE_COLOR_1') }}
		}

		.invoice table tfoot tr td:first-child {
			border: none
		}

		.invoice footer {
			width: 100%;
			text-align: center;
			color: #777;
			border-top: 1px solid #aaa;
			padding: 8px 0
		}

		@media print {
			.invoice {
				font-size: 11px!important;
				overflow: hidden!important
			}

			.invoice footer {
				position: absolute;
				bottom: 10px;
				page-break-after: always
			}

			.invoice>div:last-child {
				page-break-before: always
			}
		}
	</style>
</head>

<body>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->

	<!--Author      : @arboshiki-->
	<div id="invoice">

		<div class="toolbar hidden-print no-print">
			
			<div class="text-right">
				<button class="btn @if($sale->payment_status == 'Pending') btn-danger @else btn-success @endif }}"><i class="fa fa-print"></i> PAYMENT STATUS: {{ $sale->payment_status }}</button>
				<button class="btn @if($sale->delivery_status == 'Pending') btn-danger @else btn-success @endif }}"><i class="fa fa-print"></i> DELIVERY STATUS: {{ $sale->delivery_status }}</button>
				<button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
				<!--<button class="btn btn-info"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>-->
			</div>
			<hr>
		</div>
		<div class="invoice overflow-auto">
			<div style="min-width: 600px">
				<header>
					<div class="row">
						<div class="col">
							<a>
								<img src="https://res.cloudinary.com/pixel-penguin/image/upload/c_limit,h_200,w_400/v1/{{ env('LOGO_IMAGE_NAME') }}.png" data-holder-rendered="true" />
							</a>
						</div>
						<div class="col company-details">
							<h2 class="name">
								<a>
									{{ env('APP_NAME') }}
								</a>
							</h2>
							<div>{{ env('WEBSITE_DETAIL_ADDRESS') }}</div>
							<div>{{ env('MIX_WEBSITE_DETAIL_PHONE') }}</div>
							<div>{{ env('MIX_WEBSITE_DETAIL_EMAIL') }}</div>
						</div>
					</div>
				</header>
				<main>
					<div class="row contacts">
						<div class="col invoice-to">
							<div class="text-gray-light">INVOICE TO:</div>
							<h2 class="to">{{ $sale->user->name }}</h2>
							<div class="address">{{ $sale->shippingDetail->street_address_1 }}, {{ $sale->shippingDetail->street_address_2 }}, {{ $sale->shippingDetail->city->name }}, {{ $sale->shippingDetail->country->name }}</div>
							<div class="email"><a href="mailto:{{ $sale->user->email }}">{{ $sale->user->email }}</a></div>
						</div>
						<div class="col invoice-details">
							<h1 class="invoice-id">INVOICE</h1>
							<div class="date">Reference: {{ $sale->reference_code }}</div>
							<!--<div class="date">Due Date: 30/10/2018</div>-->
							<div class="date">Date of Invoice: {{ $sale->created_at }}</div>
						</div>
					</div>
					<table border="0" cellspacing="0" cellpadding="0">
						<thead>
							<tr>
								<th>#</th>
								<th>Code</th>
								<th class="text-left">DESCRIPTION</th>
								<th class="text-right">PRICE</th>
								<th class="text-right">QUANTITY</th>
								<th class="text-right">TOTAL</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$count = 1;
							
								$total = 0;
							?>
							@foreach($sale->products as $product)
							<tr>
								<td class="no">{{ $count }}</td>
								<td class="no">{{ $product->product_code }}</td>
								<td class="text-left">
									<h3>
										<a target="_blank" href="/product/{{ $product->productPrice->product->link_name }}">
										{{ $product->productPrice->name }}
										</a>
									</h3>
								  
								</td>
								<td class="unit">N${{ $product->price }}</td>
								<td class="qty">{{ $product->quantity }}</td>
								<td class="total">N${{ $product->price * $product->quantity }}</td>
							</tr>
							<?php 
								$count++;
							
								$total += $product->price * $product->quantity;
							?>
							@endforeach
							
							
							
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2"></td>
								<td colspan="2">Shipping type: {{ $sale->shippingMethod->name }}</td>
								<td>N${{ $sale->sale_shipping_price }}</td>
							</tr>
							<tr>
								<td colspan="2"></td>
								<td colspan="2">SUBTOTAL</td>
								<td>N${{ $total * ((100-15) / 100) }}</td>
							</tr>
							<tr>
								<td colspan="2"></td>
								<td colspan="2">TAX 15%</td>
								<td>N${{ $total * ((100-85) / 100) }}</td>
							</tr>
							<tr>
								<td colspan="2"></td>
								<td colspan="2">GRAND TOTAL</td>
								<td>N${{ $total }}</td>
							</tr>
						</tfoot>
					</table>
					<div class="thanks">Thank you!</div>
					<div class="notices">
						<div>NOTICE:</div>
						<div class="notice">{!! env('INVOICE_NOTICE') !!}</div>
					</div>
				</main>
				<footer>
					Invoice was automatically generated through the website
				</footer>
			</div>
			<!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
			<div></div>
		</div>
	</div>
	<script>
		$(document).ready(function(){
			 $('#printInvoice').click(function(){
				Popup($('.invoice')[0].outerHTML);
				function Popup(data) 
				{
					window.print();
					return true;
				}
			});
		});
	</script>
</body>
</html>