<?php
    // Retrieve 4 parameters from helper.php
    require_once '../config/helper.php';
    
    // Step 2: Connect PHP app with database
    // Object-oriented method
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Step 3: SQL statement
    $sql = "SELECT * FROM payrecu WHERE payid = '" . $_GET['payid'] . "'";
    
    // Step 4: Run SQL query
    if ($result = $conn->query($sql)) {
        // Step 5: Generate PDF invoice
        require_once('../TCPDF/tcpdf.php');
        
        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Company Name');
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('Invoice');
        
        // Set default font
        $pdf->SetFont('times', '', 12);
        
        // Add a page
        $pdf->AddPage();
        
        // Display data on PDF
        while ($row = $result->fetch_assoc()) {
            // Set font
            $pdf->SetFont('times', 'B', 14);
            $pdf->Cell(0, 10, 'Invoice', 0, 1);
            
            // Set font
            $pdf->SetFont('times', '', 12);
            
            $pdf->Cell(40, 10, 'Product:', 0, 0);
            $pdf->Cell(50, 10, $row['product'], 0, 1);
            
            $pdf->Cell(40, 10, 'Quantity:', 0, 0);
            $pdf->Cell(50, 10, $row['quantity'], 0, 1);
            
            $pdf->Cell(40, 10, 'Total Price:', 0, 0);
            $pdf->Cell(50, 10, $row['totalPrice'], 0, 1);
            
            $pdf->Cell(40, 10, 'Date:', 0, 0);
            $pdf->Cell(50, 10, $row['date'], 0, 1);
            
            $pdf->Cell(40, 10, 'Status:', 0, 0);
            if ($row['status'] == 'successful') {
                $pdf->SetTextColor(0, 128, 0); // Green color
            } else {
                $pdf->SetTextColor(255, 0, 0); // Red color
            }
            $pdf->Cell(50, 10, $row['status'], 0, 1);
            $pdf->SetTextColor(0, 0, 0); // Reset text color to black
        }
        
        // Close result set
        $result->free();
        
        // Output PDF
        $pdf->Output('invoice.pdf', 'D'); // D means force download
    } else {
        echo "Error: " . $conn->error;
    }
    