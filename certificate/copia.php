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
require_once '../plugins/fpdf/fpdf.php';

/**
 * Esse arquivo é utilizado para imprimir os certificados de cada aluno, 
 * O usuário clica no botão Imprimir certificados na lista de exames
 * e esse arquivo é invocado.
 * O arquivo para imprimir certificados separadamente se chama: certifcate.php
 */

date_default_timezone_set('America/Sao_Paulo');

//require('plugins/PHPMailer/class.phpmailer.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $members = ExecuteRows('SELECT * FROM view_certificate_data WHERE testId = ' . $id . ' ');

    if (!empty($members)) { // veriricando a variável importante
        $pdf = new \fPDF();
        $pdf->SetTitle('Generating Files, please wait...');
        foreach ($members as $data) {
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
            $instructorLastName = $data['instructorLastName'];
            $auxiliarName       = $data['auxiliarName'];
            $auxiliarLastName   = $data['auxiliarLastName'];
            $ceremonyDate       = $data['ceremonyDate'];
            $city               = $data['city'];
            $uf                 = $data['uf'];

            // --------- Variáveis que podem vir de um banco de dados por exemplo ----- //
            $texto1 = utf8_decode($enterprise);
            $texto2 = utf8_decode("Se graduou no exame " . $description . " \n Realizado em " . $testDate . " com carga horária total de " . $testTime . ".");

            //$texto3 = utf8_decode("" . $city . ", " . utf8_encode(strftime('%d de %B de %Y', strtotime($ceremonyDate))));

        $texto3 = utf8_decode(" ".$city.", " . utf8_encode(strftime('%d de %B de %Y', strtotime($ceremonyDate))));


            // Orientação Landing Page ///
            $pdf->AddPage('L');

            $pdf->SetLineWidth(1.5);


            // desenha a imagem do certificado
            $pdf->Image('blankcert.jpg', 0, 0, 300, 'jpg'); // 4° parâmetro extremamente importante

            // opacidade total
            //$pdf->SetAlpha(1);

            // Mostrar o nome
            $pdf->SetFont('Arial', '', 30); // Tipo de fonte e tamanho
            $pdf->SetXY(0, 65); // posição
            $pdf->MultiCell(297, 12, $name, '', 'C', 0); // Tamanho width e height da célula/div do conteúdo

            // Mostrar o corpo
            $pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
            $tamanho = $pdf->GetStringWidth($texto3);
            $pdf->SetXY(0, 90); // posição
            $pdf->MultiCell(297, 10, $texto2, 0, 'C', 0); // Tamanho width e height da célula/div do conteúdo

            // Mostrar o novo ranking
            $pdf->SetFont('Arial', '', 15); // Tipo de fonte e tamanho
            $tamanho = $pdf->GetStringWidth($nextRanking);
            $pdf->SetXY(0, 120);
            $pdf->MultiCell(297, 10, "Novo Ranking " . $nextRanking, 0, 'C', 0); // Tamanho width e height da célula/div do conteúdo
            //297


            // Mostrar a data e a cidade no canto inferior esquerdo
        $pdf->SetFont('Arial', '', 10); // Tipo de fonte e tamanho
        $pdf->SetXY(4.5, 176); // posição
        $pdf->MultiCell(120, 10, $texto3, '', 'C', 0); // Tamanho width e height da célula/div do conteúdo

            // Mostrar o instrutor no canto inferior direito
            $pdf->SetFont('Arial', '', 10); // Tipo de fonte e tamanho
            $pdf->SetXY(180, 176); // posição
            $instructorFullName = $instructorName . " " . $instructorLastName;
            $pdf->MultiCell(95, 10, $instructorFullName, '', 'C', 0); // Tamanho width e height da célula/div do conteúdo

            //$pdfdoc = $pdf->Output('', 'S');



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
        }
        $pdf->Output();
    }
}
