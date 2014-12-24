<?php

    class DaliyReportPDF extends FPDF {
    
        public $date;
                
        function Header() {
            $this->SetFont('Arial', 'B', 15);
            $this->Ln(8);
            $this->Cell(50, 10, 'Reporte diario ('.$this->date.')');
            $this->Image('./img/pdfban.png', 100, 10, 100, 20);            
            $this->Ln(20);
        }
        
        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0, 10, utf8_decode('Pagina '.$this->PageNo().'/{nb}'), 0, 0, 'C');
        }
        
    }

?>