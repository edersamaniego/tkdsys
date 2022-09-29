<?php

namespace PHPMaker2022\school;

use PHPMaker2022\school\{UserProfile, Language, AdvancedSecurity, Timer, HttpErrorHandler};

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

    $data = ExecuteRow('SELECT * FROM view_certificate_data WHERE memberId = ' . $id . ' and testId = ' . $testId . '');

    if (!empty($data)) { // veriricando se existe os dados do membro na view


        $certificateId = isset($data['certificateId']) ? $data['certificateId'] : -1;

        $certificate = ExecuteRow("SELECT * FROM tes_certificate WHERE id = " . $certificateId . "");

        if (isset($certificate) && !empty($certificate)) {

            // --------- Variáveis do Formulário ----- //
            $email              = "edersamaniego@gmail.com";
            $name               = $data['name'] . ' ' . $data['lastName'];
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

            $pdf = new \tFPDF();

            $pdf->SetTitle('[' . $name . '] Generating File, please wait...');

            // captando os dados do certificado


            $text01 = utf8_decode($certificate['text01']);

            $text02 = utf8_decode($certificate['text02'] . utf8_encode(strftime(' %B %d,  %Y', strtotime($testDate))));

            $background = isset($certificate['background']) ? $certificate['background'] : "blankcert.jpg"; // caso não esteja salvo no banco, usar imagem padrão

            // desenha a imagem do certificado

            //fontes
            $txtFontFamily = $certificate['textFont'];
            $studentFont = $certificate['studentFont'];
            $instructorFont = $certificate['instructorFont'];
            $instructorSize = $certificate['instructorSize'];
            $textSize = $certificate['textSize'];
            $rankSizeDiff = 3; // diferença do tamanho da fonte entre o nome e o ranking


            // var_dump($certificate['orientation']);
            // die();

            $pdf->AddPage($certificate['orientation'], $certificate['size']);

            $pdf->SetLineWidth(1.5);

            // Letter: 280
            // A4: 300
            $w = 0;

            switch($certificate['size']){
                case 'A4':
                    $w = 300;
                    break;
                case 'Letter':
                    $w = 280;
                    break;
                default:
                    $w = 0;
                    break;
            }

            $pdf->Image('bgs/' . $background, 0, 0, $w, 'jpg'); // 4° parâmetro extremamente importante
            //calcula a celula de acordo com o tamanho do papel
            $cellsize = $w;
            // opacidade total
            //$pdf->SetAlpha(1);

            // Mostrar o nome

            //$pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
            //$pdf->SetFont('DejaVu', '', 14);

            $pdf->SetFont($studentFont, '', $certificate['studentSize']); // Tipo de fonte e tamanho
            $pdf->SetXY($certificate['studentPosX'], $certificate['studentPosY']); // posição
            $pdf->MultiCell($cellsize, 10, utf8_decode(mb_strtoupper($name)), '', 'C', 0); // Tamanho width e height da célula/div do conteúdo

            // Mostrar o corpo
            $pdf->SetFont($txtFontFamily, '', $textSize); // Tipo de fonte e tamanho
            $pdf->SetXY($certificate['txt01PosX'], $certificate['txt01PosY']); // posição
            $pdf->MultiCell($cellsize, 10, $text01, 0, 'C', 0); // Tamanho width e height da célula/div do conteúdo


            //verifica se é um midTerm
                if (strpos($nextRanking, 'BLACK BELT') == true) {
                    $nextRanking=' ' ;
                }
                
            // Mostrar o novo ranking
            // utiliza a posição do texto 1 como referência.
            $pdf->SetFont($txtFontFamily, 'B', $textSize + 3); // Tipo de fonte e tamanho
            $tamanho = $pdf->GetStringWidth($nextRanking);
            $pdf->SetXY($certificate['txt01PosX'], $certificate['txt01PosY']+30);
            $pdf->MultiCell($cellsize, 10, $nextRanking, 0, 'C', 0); // Tamanho width e height da célula/div do conteúdo
            //297


            // Mostrar o texto 2 e a data e a cidade no centro
            $pdf->SetFont($txtFontFamily, '', $textSize); // Tipo de fonte e tamanho
            $pdf->SetXY($certificate['txt02PosX'], $certificate['txt02PosY']);
            $pdf->MultiCell($cellsize, 10, utf8_decode($text02), '', 'C', 0);

            // Mostrar o instrutor no canto inferior esquerdo
            $pdf->SetFont($instructorFont, 'B', $instructorSize); // Tipo de fonte e tamanho
            $pdf->SetXY($certificate['instructorPosX'], $certificate['instructorPosY']); // posição
            $instructorFullName = $instructorName . " " . $instructorLastName;
            $pdf->MultiCell(120, 10, utf8_decode($instructorFullName), '', 'C', 0); // Tamanho width e height da célula/div do conteúdo


            // Mostrar o ranking do instrutor no canto inferior esquerdo
            $pdf->SetFont($instructorFont, '', $instructorSize - $rankSizeDiff ); // Tipo de fonte e tamanho
            $pdf->SetXY($certificate['instructorPosX'], $certificate['instructorPosY']+8); // posição
            $pdf->MultiCell(120, 4, utf8_decode($instructorRanking), '', 'C', 0); // Tamanho width e height da célula/div do conteúdo

            // Mostrar o auxiliar no canto inferior direito
            $pdf->SetFont($instructorFont, 'B', $instructorSize); // Tipo de fonte e tamanho são as mesmas que a do instrutor
            $pdf->SetXY($certificate['assistantPosX'], $certificate['assistantPosY']); // posição
            $auxiliarFullName = $auxiliarName . " " . $auxiliarLastName;
            $pdf->MultiCell(113, 10, utf8_decode($auxiliarFullName), '', 'C', 0); // Tamanho width e height da célula/div do conteúdo

            // Mostrar o ranking do auxiliar no canto inferior direito
            $pdf->SetFont($instructorFont, '', $instructorSize - $rankSizeDiff); // Tipo de fonte e tamanho
            $pdf->SetXY($certificate['assistantPosX'], $certificate['assistantPosY']+8); // posição
            $pdf->MultiCell(113, 4, utf8_decode($auxiliarRanking), '', 'C', 0); // Tamanho width e height da célula/div do conteúdo

            

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
        echo "Error: This test does not have a certificate vinculated to it<br/>";
        echo "<a href='/TesTestList'>back to test list</a>";
    }
    echo "Error: Maybe this student is not aproved and whith his test in paid status. Please check these details and try to print the certificate again. <br/>";
    echo "<a href='/TesTestList'>back to test list</a>";
}
