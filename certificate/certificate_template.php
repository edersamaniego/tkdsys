<?php

namespace PHPMaker2021\school;

use PHPMaker2021\school\{UserProfile, Language, AdvancedSecurity, Timer, HttpErrorHandler};

global $RELATIVE_PATH;

// Auto load
require_once "../vendor/autoload.php";
require_once "../src/constants.php";
require_once "../src/config.php";
require_once "../src/phpfn.php";
require_once "../src/userfn.php";
//require_once '../plugins/fpdf/fpdf.php';
require_once '../plugins/fpdf/tfpdf.php';

/**
 * Esse arquivo é utilizado para imprimir os certificados de cada aluno, 
 * O usuário clica no botão Imprimir certificado deste aluno na lista de aprovados
 * e esse arquivo é invocado.
 * O arquivo para imprimir em lote os certificados se chama: bulk_certificates.php
 */

date_default_timezone_set('America/Sao_Paulo');

//require('plugins/PHPMailer/class.phpmailer.php');

if (isset($_GET['id']) && isset($_GET['testId'])) {
    
    $id = $_GET['id'];
    $testId = $_GET['testId'];

    $data = ExecuteRow('SELECT * FROM view_certificate_data WHERE memberId = ' . $id . ' and testId = '.$testId.'');

    if (!empty($data)) { // veriricando a variável importante
         
         
        $certificateId = isset($data['certificateId']) ? $data['certificateId'] : -1 ;
        
        
        $certificate = ExecuteRow("SELECT * FROM tes_certificate WHERE id = " . $certificateId . "");   
    

        if (isset($certificate) && !empty($certificate)) {
            
            // --------- Variáveis do Formulário ----- //
            $email    = "edersamaniego@gmail.com";
            $name     = $data['name'] . ' ' . $data['lastName'];

            $enterprise         = "MAS";
            $actualRanking      = $data['actual'];
            $nextRanking        = $data['next'];
            $memberAge          = $data['memberAge'];
            $memberDOB          = $data['memberDOB'];
            $description        = $data['description'];
            $testDate           = $data['testDate'];
            $testTime           = $data['testTime'];
            $instructorName     = $data['instructorName'];
            $instructorRanking  = $data['instructorRanking'];
            $instructorLastName = $data['instructorLastName'];
            $auxiliarName       = $data['auxiliarName'];
            $auxiliarRanking    = $data['auxiliarRanking'];
            $auxiliarLastName   = $data['auxiliarLastName'];
            $ceremonyDate       = $data['ceremonyDate'];
            $city               = $data['city'];
            $uf                 = $data['uf'];

            // --------- Variáveis que podem vir de um banco de dados por exemplo ----- //
            $texto1 = utf8_decode($enterprise);
            $texto2 = utf8_decode("is a dedicated student of Martial Arts, through hours of perseverance and training \n has gained and exhibited the knowledge and skills necessary for rank advancement,\n and is hereby awarded the rank of");
            //  $texto2 = utf8_decode("Se graduou no exame " . $description . " \n Realizado em " . $testDate . " com carga horária total de " . $testTime . ".");

            //$texto3 = utf8_decode("" . $city . ", " . utf8_encode(strftime('%d de %B de %Y', strtotime($ceremonyDate))));
            $texto3 = utf8_decode("through the MAS promotional testing held \n on this " . utf8_encode(strftime(' %B %d,  %Y', strtotime($ceremonyDate))));

            $pdf = new \tFPDF();

            $pdf->SetTitle('[' . $name . '] Generating File, please wait...');

            // captando os dados do certificado

            $background = isset($certificate['background']) ? $certificate['background'] : "blankcert.jpg"; // caso não esteja salvo no banco, usar imagem padrão


            // desenha a imagem do certificado

            // Orientação Landing Page ///
            $pdf->AddPage('L');

            $pdf->SetLineWidth(1.5);

            $pdf->Image('bgs/' . $background, 0, 0, 300, 'jpg'); // 4° parâmetro extremamente importante

            // opacidade total
            //$pdf->SetAlpha(1);

            // Mostrar o nome
            $pdf->SetFont('Arial', '', 30); // Tipo de fonte e tamanho
            $pdf->SetXY(0, 65); // posição
            $pdf->MultiCell(297, 10, utf8_decode(mb_strtoupper($name)), '', 'C', 0); // Tamanho width e height da célula/div do conteúdo

            // Mostrar o corpo
            $pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
            $tamanho = $pdf->GetStringWidth($texto3);
            $pdf->SetXY(0, 80); // posição
            $pdf->MultiCell(297, 10, $texto2, 0, 'C', 0); // Tamanho width e height da célula/div do conteúdo

            // Mostrar o novo ranking
            $pdf->SetFont('Arial', '', 18); // Tipo de fonte e tamanho
            $tamanho = $pdf->GetStringWidth($nextRanking);
            $pdf->SetXY(0, 110);
            $pdf->MultiCell(297, 10, $nextRanking, 0, 'C', 0); // Tamanho width e height da célula/div do conteúdo
            //297


            // Mostrar a data e a cidade no centro
            $pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
            $pdf->SetXY(0, 120);
            $pdf->MultiCell(297, 10, utf8_decode($texto3), '', 'C', 0);
            //$pdf->SetXY(4.5, 176); // posição
            // $pdf->MultiCell(120, 10, $texto3, '', 'C', 0); // Tamanho width e height da célula/div do conteúdo

            // Mostrar o auxiliar no canto inferior direito
            $pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
            $pdf->SetXY(180, 177); // posição
            $auxiliarFullName = $auxiliarName . " " . $auxiliarLastName;
            $pdf->MultiCell(95, 10, utf8_decode($auxiliarFullName), '', 'C', 0); // Tamanho width e height da célula/div do conteúdo

            // Mostrar o ranking do auxiliar no canto inferior direito
            $pdf->SetFont('Arial', '', 9); // Tipo de fonte e tamanho
            $pdf->SetXY(169, 185); // posição
            $pdf->MultiCell(120, 4, utf8_decode($auxiliarRanking), '', 'C', 0); // Tamanho width e height da célula/div do conteúdo

            // Mostrar o instrutor no canto inferior esquerdo
            $pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
            $pdf->SetXY(4.5, 177); // posição
            $instructorFullName = $instructorName . " " . $instructorLastName;
            $pdf->MultiCell(120, 10, utf8_decode($instructorFullName), '', 'C', 0); // Tamanho width e height da célula/div do conteúdo


            // Mostrar o ranking do instrutor no canto inferior esquerdo
            $pdf->SetFont('Arial', '', 9); // Tipo de fonte e tamanho
            $pdf->SetXY(4.5, 185); // posição
            $pdf->MultiCell(120, 4, utf8_decode($instructorRanking), '', 'C', 0); // Tamanho width e height da célula/div do conteúdo

            $pdfdoc = $pdf->Output('', 'S');



            // ******** Agora vai enviar o e-mail pro usuário contendo o anexo
            // ******** e também mostrar na tela para caso o e-mail não chegar
            /*
            $subject = 'Seu Certificado do Workshop';
            $messageBody = "Olá $name<br><br>É com grande prazer que entregamos o seu certificado.<br>Ele está em anexo nesse e-mail.<br><br>Atenciosamente,<br>Lincoln Borges<br><a href='http://www.lnborges.com.br'>http://www.lnborges.com.br</a>";
            
            
            $mail = new PHPMailer();
            $mail->SetFrom("certificado@lnborges.com.br", "Certificado");
            $mail->Subject    = $subject;
            $mail->MsgHTML(utf8_decode($messageBody));	
            $mail->AddAddress($email); 
            $mail->addStringAttachment($pdfdoc, 'certificado.pdf');
            $mail->Send();
            */

            $pdf->Output();
        }
        echo "Error: this test does not have a certificate vinculated to it<br/>";
        echo "<a href='/TesTestList'>back to test list</a>";
    }
}
