<?php

namespace PHPMaker2022\school;

// Page object
$FinAccountsreceivableView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_accountsreceivable: currentTable } });
var currentForm, currentPageID;
var ffin_accountsreceivableview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_accountsreceivableview = new ew.Form("ffin_accountsreceivableview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ffin_accountsreceivableview;
    loadjs.done("ffin_accountsreceivableview");
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
<form name="ffin_accountsreceivableview" id="ffin_accountsreceivableview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_accountsreceivable">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->issue->Visible) { // issue ?>
    <tr id="r_issue"<?= $Page->issue->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_issue"><?= $Page->issue->caption() ?></span></td>
        <td data-name="issue"<?= $Page->issue->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_issue">
<span<?= $Page->issue->viewAttributes() ?>>
<?= $Page->issue->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->due->Visible) { // due ?>
    <tr id="r_due"<?= $Page->due->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_due"><?= $Page->due->caption() ?></span></td>
        <td data-name="due"<?= $Page->due->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_due">
<span<?= $Page->due->viewAttributes() ?>>
<?= $Page->due->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->historic->Visible) { // historic ?>
    <tr id="r_historic"<?= $Page->historic->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_historic"><?= $Page->historic->caption() ?></span></td>
        <td data-name="historic"<?= $Page->historic->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_historic">
<span<?= $Page->historic->viewAttributes() ?>>
<?= $Page->historic->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->income->Visible) { // income ?>
    <tr id="r_income"<?= $Page->income->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_income"><?= $Page->income->caption() ?></span></td>
        <td data-name="income"<?= $Page->income->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_income">
<span<?= $Page->income->viewAttributes() ?>>
<?= $Page->income->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <tr id="r_value"<?= $Page->value->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_value"><?= $Page->value->caption() ?></span></td>
        <td data-name="value"<?= $Page->value->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_value">
<span<?= $Page->value->viewAttributes() ?>>
<?= $Page->value->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->orderId->Visible) { // orderId ?>
    <tr id="r_orderId"<?= $Page->orderId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_orderId"><?= $Page->orderId->caption() ?></span></td>
        <td data-name="orderId"<?= $Page->orderId->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_orderId">
<span<?= $Page->orderId->viewAttributes() ?>>
<?= $Page->orderId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->balance->Visible) { // balance ?>
    <tr id="r_balance"<?= $Page->balance->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_balance"><?= $Page->balance->caption() ?></span></td>
        <td data-name="balance"<?= $Page->balance->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_balance">
<span<?= $Page->balance->viewAttributes() ?>>
<?= $Page->balance->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_userId->Visible) { // userId ?>
    <tr id="r__userId"<?= $Page->_userId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable__userId"><?= $Page->_userId->caption() ?></span></td>
        <td data-name="_userId"<?= $Page->_userId->cellAttributes() ?>>
<span id="el_fin_accountsreceivable__userId">
<span<?= $Page->_userId->viewAttributes() ?>>
<?= $Page->_userId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->debtorId->Visible) { // debtorId ?>
    <tr id="r_debtorId"<?= $Page->debtorId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_debtorId"><?= $Page->debtorId->caption() ?></span></td>
        <td data-name="debtorId"<?= $Page->debtorId->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_debtorId">
<span<?= $Page->debtorId->viewAttributes() ?>>
<?= $Page->debtorId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->accountFather->Visible) { // accountFather ?>
    <tr id="r_accountFather"<?= $Page->accountFather->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_accountFather"><?= $Page->accountFather->caption() ?></span></td>
        <td data-name="accountFather"<?= $Page->accountFather->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_accountFather">
<span<?= $Page->accountFather->viewAttributes() ?>>
<?= $Page->accountFather->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <tr id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_schoolId"><?= $Page->schoolId->caption() ?></span></td>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lastUserId->Visible) { // lastUserId ?>
    <tr id="r_lastUserId"<?= $Page->lastUserId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_lastUserId"><?= $Page->lastUserId->caption() ?></span></td>
        <td data-name="lastUserId"<?= $Page->lastUserId->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_lastUserId">
<span<?= $Page->lastUserId->viewAttributes() ?>>
<?= $Page->lastUserId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_register->Visible) { // register ?>
    <tr id="r__register"<?= $Page->_register->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable__register"><?= $Page->_register->caption() ?></span></td>
        <td data-name="_register"<?= $Page->_register->cellAttributes() ?>>
<span id="el_fin_accountsreceivable__register">
<span<?= $Page->_register->viewAttributes() ?>>
<?= $Page->_register->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lastUpdate->Visible) { // lastUpdate ?>
    <tr id="r_lastUpdate"<?= $Page->lastUpdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_lastUpdate"><?= $Page->lastUpdate->caption() ?></span></td>
        <td data-name="lastUpdate"<?= $Page->lastUpdate->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_lastUpdate">
<span<?= $Page->lastUpdate->viewAttributes() ?>>
<?= $Page->lastUpdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->licenseId->Visible) { // licenseId ?>
    <tr id="r_licenseId"<?= $Page->licenseId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_accountsreceivable_licenseId"><?= $Page->licenseId->caption() ?></span></td>
        <td data-name="licenseId"<?= $Page->licenseId->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_licenseId">
<span<?= $Page->licenseId->viewAttributes() ?>>
<?= $Page->licenseId->getViewValue() ?></span>
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
