<?php

namespace PHPMaker2022\school;

// Page object
$TesCertificateView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_certificate: currentTable } });
var currentForm, currentPageID;
var ftes_certificateview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_certificateview = new ew.Form("ftes_certificateview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ftes_certificateview;
    loadjs.done("ftes_certificateview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<?php } ?>
<form name="ftes_certificateview" id="ftes_certificateview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_certificate">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_tes_certificate_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
    <tr id="r_description"<?= $Page->description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_description"><?= $Page->description->caption() ?></span></td>
        <td data-name="description"<?= $Page->description->cellAttributes() ?>>
<span id="el_tes_certificate_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->background->Visible) { // background ?>
    <tr id="r_background"<?= $Page->background->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_background"><?= $Page->background->caption() ?></span></td>
        <td data-name="background"<?= $Page->background->cellAttributes() ?>>
<span id="el_tes_certificate_background">
<span>
<?= GetFileViewTag($Page->background, $Page->background->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_title->Visible) { // title ?>
    <tr id="r__title"<?= $Page->_title->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate__title"><?= $Page->_title->caption() ?></span></td>
        <td data-name="_title"<?= $Page->_title->cellAttributes() ?>>
<span id="el_tes_certificate__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titlePosX->Visible) { // titlePosX ?>
    <tr id="r_titlePosX"<?= $Page->titlePosX->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_titlePosX"><?= $Page->titlePosX->caption() ?></span></td>
        <td data-name="titlePosX"<?= $Page->titlePosX->cellAttributes() ?>>
<span id="el_tes_certificate_titlePosX">
<span<?= $Page->titlePosX->viewAttributes() ?>>
<?= $Page->titlePosX->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titlePosY->Visible) { // titlePosY ?>
    <tr id="r_titlePosY"<?= $Page->titlePosY->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_titlePosY"><?= $Page->titlePosY->caption() ?></span></td>
        <td data-name="titlePosY"<?= $Page->titlePosY->cellAttributes() ?>>
<span id="el_tes_certificate_titlePosY">
<span<?= $Page->titlePosY->viewAttributes() ?>>
<?= $Page->titlePosY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titleFont->Visible) { // titleFont ?>
    <tr id="r_titleFont"<?= $Page->titleFont->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_titleFont"><?= $Page->titleFont->caption() ?></span></td>
        <td data-name="titleFont"<?= $Page->titleFont->cellAttributes() ?>>
<span id="el_tes_certificate_titleFont">
<span<?= $Page->titleFont->viewAttributes() ?>>
<?= $Page->titleFont->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titleFontSize->Visible) { // titleFontSize ?>
    <tr id="r_titleFontSize"<?= $Page->titleFontSize->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_titleFontSize"><?= $Page->titleFontSize->caption() ?></span></td>
        <td data-name="titleFontSize"<?= $Page->titleFontSize->cellAttributes() ?>>
<span id="el_tes_certificate_titleFontSize">
<span<?= $Page->titleFontSize->viewAttributes() ?>>
<?= $Page->titleFontSize->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->titleAlign->Visible) { // titleAlign ?>
    <tr id="r_titleAlign"<?= $Page->titleAlign->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_titleAlign"><?= $Page->titleAlign->caption() ?></span></td>
        <td data-name="titleAlign"<?= $Page->titleAlign->cellAttributes() ?>>
<span id="el_tes_certificate_titleAlign">
<span<?= $Page->titleAlign->viewAttributes() ?>>
<?= $Page->titleAlign->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->text01->Visible) { // text01 ?>
    <tr id="r_text01"<?= $Page->text01->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_text01"><?= $Page->text01->caption() ?></span></td>
        <td data-name="text01"<?= $Page->text01->cellAttributes() ?>>
<span id="el_tes_certificate_text01">
<span<?= $Page->text01->viewAttributes() ?>>
<?= $Page->text01->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->txt01PosX->Visible) { // txt01PosX ?>
    <tr id="r_txt01PosX"<?= $Page->txt01PosX->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_txt01PosX"><?= $Page->txt01PosX->caption() ?></span></td>
        <td data-name="txt01PosX"<?= $Page->txt01PosX->cellAttributes() ?>>
<span id="el_tes_certificate_txt01PosX">
<span<?= $Page->txt01PosX->viewAttributes() ?>>
<?= $Page->txt01PosX->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->txt01PosY->Visible) { // txt01PosY ?>
    <tr id="r_txt01PosY"<?= $Page->txt01PosY->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_txt01PosY"><?= $Page->txt01PosY->caption() ?></span></td>
        <td data-name="txt01PosY"<?= $Page->txt01PosY->cellAttributes() ?>>
<span id="el_tes_certificate_txt01PosY">
<span<?= $Page->txt01PosY->viewAttributes() ?>>
<?= $Page->txt01PosY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->text02->Visible) { // text02 ?>
    <tr id="r_text02"<?= $Page->text02->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_text02"><?= $Page->text02->caption() ?></span></td>
        <td data-name="text02"<?= $Page->text02->cellAttributes() ?>>
<span id="el_tes_certificate_text02">
<span<?= $Page->text02->viewAttributes() ?>>
<?= $Page->text02->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->txt02PosX->Visible) { // txt02PosX ?>
    <tr id="r_txt02PosX"<?= $Page->txt02PosX->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_txt02PosX"><?= $Page->txt02PosX->caption() ?></span></td>
        <td data-name="txt02PosX"<?= $Page->txt02PosX->cellAttributes() ?>>
<span id="el_tes_certificate_txt02PosX">
<span<?= $Page->txt02PosX->viewAttributes() ?>>
<?= $Page->txt02PosX->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->txt02PosY->Visible) { // txt02PosY ?>
    <tr id="r_txt02PosY"<?= $Page->txt02PosY->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_txt02PosY"><?= $Page->txt02PosY->caption() ?></span></td>
        <td data-name="txt02PosY"<?= $Page->txt02PosY->cellAttributes() ?>>
<span id="el_tes_certificate_txt02PosY">
<span<?= $Page->txt02PosY->viewAttributes() ?>>
<?= $Page->txt02PosY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->textFont->Visible) { // textFont ?>
    <tr id="r_textFont"<?= $Page->textFont->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_textFont"><?= $Page->textFont->caption() ?></span></td>
        <td data-name="textFont"<?= $Page->textFont->cellAttributes() ?>>
<span id="el_tes_certificate_textFont">
<span<?= $Page->textFont->viewAttributes() ?>>
<?= $Page->textFont->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->textSize->Visible) { // textSize ?>
    <tr id="r_textSize"<?= $Page->textSize->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_textSize"><?= $Page->textSize->caption() ?></span></td>
        <td data-name="textSize"<?= $Page->textSize->cellAttributes() ?>>
<span id="el_tes_certificate_textSize">
<span<?= $Page->textSize->viewAttributes() ?>>
<?= $Page->textSize->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->studentFont->Visible) { // studentFont ?>
    <tr id="r_studentFont"<?= $Page->studentFont->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_studentFont"><?= $Page->studentFont->caption() ?></span></td>
        <td data-name="studentFont"<?= $Page->studentFont->cellAttributes() ?>>
<span id="el_tes_certificate_studentFont">
<span<?= $Page->studentFont->viewAttributes() ?>>
<?= $Page->studentFont->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->studentSize->Visible) { // studentSize ?>
    <tr id="r_studentSize"<?= $Page->studentSize->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_studentSize"><?= $Page->studentSize->caption() ?></span></td>
        <td data-name="studentSize"<?= $Page->studentSize->cellAttributes() ?>>
<span id="el_tes_certificate_studentSize">
<span<?= $Page->studentSize->viewAttributes() ?>>
<?= $Page->studentSize->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->studentPosX->Visible) { // studentPosX ?>
    <tr id="r_studentPosX"<?= $Page->studentPosX->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_studentPosX"><?= $Page->studentPosX->caption() ?></span></td>
        <td data-name="studentPosX"<?= $Page->studentPosX->cellAttributes() ?>>
<span id="el_tes_certificate_studentPosX">
<span<?= $Page->studentPosX->viewAttributes() ?>>
<?= $Page->studentPosX->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->studentPosY->Visible) { // studentPosY ?>
    <tr id="r_studentPosY"<?= $Page->studentPosY->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_studentPosY"><?= $Page->studentPosY->caption() ?></span></td>
        <td data-name="studentPosY"<?= $Page->studentPosY->cellAttributes() ?>>
<span id="el_tes_certificate_studentPosY">
<span<?= $Page->studentPosY->viewAttributes() ?>>
<?= $Page->studentPosY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->instructorFont->Visible) { // instructorFont ?>
    <tr id="r_instructorFont"<?= $Page->instructorFont->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_instructorFont"><?= $Page->instructorFont->caption() ?></span></td>
        <td data-name="instructorFont"<?= $Page->instructorFont->cellAttributes() ?>>
<span id="el_tes_certificate_instructorFont">
<span<?= $Page->instructorFont->viewAttributes() ?>>
<?= $Page->instructorFont->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->instructorSize->Visible) { // instructorSize ?>
    <tr id="r_instructorSize"<?= $Page->instructorSize->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_instructorSize"><?= $Page->instructorSize->caption() ?></span></td>
        <td data-name="instructorSize"<?= $Page->instructorSize->cellAttributes() ?>>
<span id="el_tes_certificate_instructorSize">
<span<?= $Page->instructorSize->viewAttributes() ?>>
<?= $Page->instructorSize->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->instructorPosX->Visible) { // instructorPosX ?>
    <tr id="r_instructorPosX"<?= $Page->instructorPosX->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_instructorPosX"><?= $Page->instructorPosX->caption() ?></span></td>
        <td data-name="instructorPosX"<?= $Page->instructorPosX->cellAttributes() ?>>
<span id="el_tes_certificate_instructorPosX">
<span<?= $Page->instructorPosX->viewAttributes() ?>>
<?= $Page->instructorPosX->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->instructorPosY->Visible) { // instructorPosY ?>
    <tr id="r_instructorPosY"<?= $Page->instructorPosY->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_instructorPosY"><?= $Page->instructorPosY->caption() ?></span></td>
        <td data-name="instructorPosY"<?= $Page->instructorPosY->cellAttributes() ?>>
<span id="el_tes_certificate_instructorPosY">
<span<?= $Page->instructorPosY->viewAttributes() ?>>
<?= $Page->instructorPosY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->assistantPosX->Visible) { // assistantPosX ?>
    <tr id="r_assistantPosX"<?= $Page->assistantPosX->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_assistantPosX"><?= $Page->assistantPosX->caption() ?></span></td>
        <td data-name="assistantPosX"<?= $Page->assistantPosX->cellAttributes() ?>>
<span id="el_tes_certificate_assistantPosX">
<span<?= $Page->assistantPosX->viewAttributes() ?>>
<?= $Page->assistantPosX->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->assistantPosY->Visible) { // assistantPosY ?>
    <tr id="r_assistantPosY"<?= $Page->assistantPosY->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_assistantPosY"><?= $Page->assistantPosY->caption() ?></span></td>
        <td data-name="assistantPosY"<?= $Page->assistantPosY->cellAttributes() ?>>
<span id="el_tes_certificate_assistantPosY">
<span<?= $Page->assistantPosY->viewAttributes() ?>>
<?= $Page->assistantPosY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <tr id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_schoolId"><?= $Page->schoolId->caption() ?></span></td>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_tes_certificate_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->orientation->Visible) { // orientation ?>
    <tr id="r_orientation"<?= $Page->orientation->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_orientation"><?= $Page->orientation->caption() ?></span></td>
        <td data-name="orientation"<?= $Page->orientation->cellAttributes() ?>>
<span id="el_tes_certificate_orientation">
<span<?= $Page->orientation->viewAttributes() ?>>
<?= $Page->orientation->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->size->Visible) { // size ?>
    <tr id="r_size"<?= $Page->size->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_size"><?= $Page->size->caption() ?></span></td>
        <td data-name="size"<?= $Page->size->cellAttributes() ?>>
<span id="el_tes_certificate_size">
<span<?= $Page->size->viewAttributes() ?>>
<?= $Page->size->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->martialArtId->Visible) { // martialArtId ?>
    <tr id="r_martialArtId"<?= $Page->martialArtId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_certificate_martialArtId"><?= $Page->martialArtId->caption() ?></span></td>
        <td data-name="martialArtId"<?= $Page->martialArtId->cellAttributes() ?>>
<span id="el_tes_certificate_martialArtId">
<span<?= $Page->martialArtId->viewAttributes() ?>>
<?= $Page->martialArtId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
