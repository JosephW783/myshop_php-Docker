<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use TCPDF;

require 'vendor/autoload.php';

function invia_email_conferma($email_destinatario, $dati_ordine) {
    
    // Crea il pdf dell'ordine
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Conferma Ordine', 0, 1, 'C');

    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Dettagli Ordine', 0 ,1);
    $pdf->Cell(0, 10, 'Email: ' . htmlspecialchars($dati_ordine['email'], ENT_QUOTES, 'UTF-8'), 0, 1);
    $pdf->Cell(0, 10, 'Totale: €' . number_format($dati_ordine['totale'], 2, ',', '.'), 0, 1);

    $pdf->Ln(10);
    $pdf->Cell(0, 10, 'Articoli Ordinati:', 0, 1);
    foreach ($dati_ordine['carrello'] as $articolo) {
        $pdf->Cell(0, 10, $articolo['quantita'] . ' x ' . htmlspecialchars($articolo['nome'], ENT_QUOTES, 'UTF-8') . ' - €' . number_format($articolo['prezzo'], 2, ',', '.'), 0, 1);
    }
    $pdf_output = $pdf->Output('ordine.pdf', 'S'); // Salva il PDF in una variabile (come stringa)

    // avvio php mailer
    $mail = new PHPMailer(true);
    
    try{
        // impostazioni del server
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP(); // invio tramite SMTP
        $mail->Host = 'smtp.example.com';
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = 'secret';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port =465;

    } catch (Exception $e) {
        // In caso di errore
        error_log('Errore nell\'invio della email: ' . $mail->ErrorInfo);
    }
        
} 
