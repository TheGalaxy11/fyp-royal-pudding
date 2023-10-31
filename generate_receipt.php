<?php
require('fpdf/fpdf.php'); // Include the FPDF library

// Your code to fetch order details from the database

// Create a new PDF document
$pdf = new FPDF();
$pdf->AddPage();

// Set font for the receipt
$pdf->SetFont('Arial', 'B', 16);

// Title
$pdf->Cell(0, 10, 'Payment Receipt', 0, 1, 'C');

// Customer and order details
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Order Date: ' . $order_date, 0, 1);
$pdf->Cell(0, 10, 'Customer Name: ' . $customer_name, 0, 1);
$pdf->Cell(0, 10, 'Order ID: ' . $order_id, 0, 1);

// Add more details as needed

// Output the PDF as a file or to the browser
// You can use a unique filename or order ID as the file name
$filename = 'receipt_' . $order_id . '.pdf';

// Save the PDF content to a variable instead of directly outputting it
$pdfContent = $pdf->Output($filename, 'S'); // 'S' to return as a string

// Close the PDF
$pdf->Close();