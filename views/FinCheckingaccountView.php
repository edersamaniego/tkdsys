<?php

namespace PHPMaker2022\school;

// Page object
$FinCheckingaccountView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_checkingaccount: currentTable } });
var currentForm, currentPageID;
var ffin_checkingaccountview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_checkingaccountview = new ew.Form("ffin_checkingaccountview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ffin_checkingaccountview;
    loadjs.done("ffin_checkingaccountview");
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
<form name="ffin_checkingaccountview" id="ffin_checkingaccountview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_checkingaccount">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_checkingaccount_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_fin_checkingaccount_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bank->Visible) { // bank ?>
    <tr id="r_bank"<?= $Page->bank->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_checkingaccount_bank"><?= $Page->bank->caption() ?></span></td>
        <td data-name="bank"<?= $Page->bank->cellAttributes() ?>>
<span id="el_fin_checkingaccount_bank">
<span<?= $Page->bank->viewAttributes() ?>>
<?= $Page->bank->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->responsable->Visible) { // responsable ?>
    <tr id="r_responsable"<?= $Page->responsable->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_checkingaccount_responsable"><?= $Page->responsable->caption() ?></span></td>
        <td data-name="responsable"<?= $Page->responsable->cellAttributes() ?>>
<span id="el_fin_checkingaccount_responsable">
<span<?= $Page->responsable->viewAttributes() ?>>
<?= $Page->responsable->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->balance->Visible) { // balance ?>
    <tr id="r_balance"<?= $Page->balance->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_checkingaccount_balance"><?= $Page->balance->caption() ?></span></td>
        <td data-name="balance"<?= $Page->balance->cellAttributes() ?>>
<span id="el_fin_checkingaccount_balance">
<span<?= $Page->balance->viewAttributes() ?>>
<?= $Page->balance->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_checkingaccount_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_fin_checkingaccount_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->telephone->Visible) { // telephone ?>
    <tr id="r_telephone"<?= $Page->telephone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_checkingaccount_telephone"><?= $Page->telephone->caption() ?></span></td>
        <td data-name="telephone"<?= $Page->telephone->cellAttributes() ?>>
<span id="el_fin_checkingaccount_telephone">
<span<?= $Page->telephone->viewAttributes() ?>>
<?= $Page->telephone->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_userId->Visible) { // userId ?>
    <tr id="r__userId"<?= $Page->_userId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_checkingaccount__userId"><?= $Page->_userId->caption() ?></span></td>
        <td data-name="_userId"<?= $Page->_userId->cellAttributes() ?>>
<span id="el_fin_checkingaccount__userId">
<span<?= $Page->_userId->viewAttributes() ?>>
<?= $Page->_userId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <tr id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_checkingaccount_schoolId"><?= $Page->schoolId->caption() ?></span></td>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_fin_checkingaccount_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->masterSchoolId->Visible) { // masterSchoolId ?>
    <tr id="r_masterSchoolId"<?= $Page->masterSchoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_checkingaccount_masterSchoolId"><?= $Page->masterSchoolId->caption() ?></span></td>
        <td data-name="masterSchoolId"<?= $Page->masterSchoolId->cellAttributes() ?>>
<span id="el_fin_checkingaccount_masterSchoolId">
<span<?= $Page->masterSchoolId->viewAttributes() ?>>
<?= $Page->masterSchoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->organizationId->Visible) { // organizationId ?>
    <tr id="r_organizationId"<?= $Page->organizationId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_checkingaccount_organizationId"><?= $Page->organizationId->caption() ?></span></td>
        <td data-name="organizationId"<?= $Page->organizationId->cellAttributes() ?>>
<span id="el_fin_checkingaccount_organizationId">
<span<?= $Page->organizationId->viewAttributes() ?>>
<?= $Page->organizationId->getViewValue() ?></span>
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
<?php
    if (in_array("fin_debit", explode(",", $Page->getCurrentDetailTable())) && $fin_debit->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fin_debit", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FinDebitGrid.php" ?>
<?php } ?>
<?php
    if (in_array("fin_credit", explode(",", $Page->getCurrentDetailTable())) && $fin_credit->DetailView) {
?>
<?php if ($Page->getCurrentDetailTable() != "") { ?>
<h4 class="ew-detail-caption"><?= $Language->tablePhrase("fin_credit", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "FinCreditGrid.php" ?>
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
