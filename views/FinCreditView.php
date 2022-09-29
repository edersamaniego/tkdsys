<?php

namespace PHPMaker2022\school;

// Page object
$FinCreditView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_credit: currentTable } });
var currentForm, currentPageID;
var ffin_creditview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_creditview = new ew.Form("ffin_creditview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ffin_creditview;
    loadjs.done("ffin_creditview");
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
<form name="ffin_creditview" id="ffin_creditview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_credit">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_credit_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_fin_credit_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->accountId->Visible) { // accountId ?>
    <tr id="r_accountId"<?= $Page->accountId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_credit_accountId"><?= $Page->accountId->caption() ?></span></td>
        <td data-name="accountId"<?= $Page->accountId->cellAttributes() ?>>
<span id="el_fin_credit_accountId">
<span<?= $Page->accountId->viewAttributes() ?>>
<?= $Page->accountId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dueDate->Visible) { // dueDate ?>
    <tr id="r_dueDate"<?= $Page->dueDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_credit_dueDate"><?= $Page->dueDate->caption() ?></span></td>
        <td data-name="dueDate"<?= $Page->dueDate->cellAttributes() ?>>
<span id="el_fin_credit_dueDate">
<span<?= $Page->dueDate->viewAttributes() ?>>
<?= $Page->dueDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
    <tr id="r_value"<?= $Page->value->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_credit_value"><?= $Page->value->caption() ?></span></td>
        <td data-name="value"<?= $Page->value->cellAttributes() ?>>
<span id="el_fin_credit_value">
<span<?= $Page->value->viewAttributes() ?>>
<?= $Page->value->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->paymentMethod->Visible) { // paymentMethod ?>
    <tr id="r_paymentMethod"<?= $Page->paymentMethod->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_credit_paymentMethod"><?= $Page->paymentMethod->caption() ?></span></td>
        <td data-name="paymentMethod"<?= $Page->paymentMethod->cellAttributes() ?>>
<span id="el_fin_credit_paymentMethod">
<span<?= $Page->paymentMethod->viewAttributes() ?>>
<?= $Page->paymentMethod->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->checkingAccountId->Visible) { // checkingAccountId ?>
    <tr id="r_checkingAccountId"<?= $Page->checkingAccountId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_credit_checkingAccountId"><?= $Page->checkingAccountId->caption() ?></span></td>
        <td data-name="checkingAccountId"<?= $Page->checkingAccountId->cellAttributes() ?>>
<span id="el_fin_credit_checkingAccountId">
<span<?= $Page->checkingAccountId->viewAttributes() ?>>
<?= $Page->checkingAccountId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->obs->Visible) { // obs ?>
    <tr id="r_obs"<?= $Page->obs->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_credit_obs"><?= $Page->obs->caption() ?></span></td>
        <td data-name="obs"<?= $Page->obs->cellAttributes() ?>>
<span id="el_fin_credit_obs">
<span<?= $Page->obs->viewAttributes() ?>>
<?= $Page->obs->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_userId->Visible) { // userId ?>
    <tr id="r__userId"<?= $Page->_userId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_credit__userId"><?= $Page->_userId->caption() ?></span></td>
        <td data-name="_userId"<?= $Page->_userId->cellAttributes() ?>>
<span id="el_fin_credit__userId">
<span<?= $Page->_userId->viewAttributes() ?>>
<?= $Page->_userId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_register->Visible) { // register ?>
    <tr id="r__register"<?= $Page->_register->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_credit__register"><?= $Page->_register->caption() ?></span></td>
        <td data-name="_register"<?= $Page->_register->cellAttributes() ?>>
<span id="el_fin_credit__register">
<span<?= $Page->_register->viewAttributes() ?>>
<?= $Page->_register->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lastUpdate->Visible) { // lastUpdate ?>
    <tr id="r_lastUpdate"<?= $Page->lastUpdate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_credit_lastUpdate"><?= $Page->lastUpdate->caption() ?></span></td>
        <td data-name="lastUpdate"<?= $Page->lastUpdate->cellAttributes() ?>>
<span id="el_fin_credit_lastUpdate">
<span<?= $Page->lastUpdate->viewAttributes() ?>>
<?= $Page->lastUpdate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lastUser->Visible) { // lastUser ?>
    <tr id="r_lastUser"<?= $Page->lastUser->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_credit_lastUser"><?= $Page->lastUser->caption() ?></span></td>
        <td data-name="lastUser"<?= $Page->lastUser->cellAttributes() ?>>
<span id="el_fin_credit_lastUser">
<span<?= $Page->lastUser->viewAttributes() ?>>
<?= $Page->lastUser->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <tr id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_credit_schoolId"><?= $Page->schoolId->caption() ?></span></td>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_fin_credit_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->masterSchoolId->Visible) { // masterSchoolId ?>
    <tr id="r_masterSchoolId"<?= $Page->masterSchoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fin_credit_masterSchoolId"><?= $Page->masterSchoolId->caption() ?></span></td>
        <td data-name="masterSchoolId"<?= $Page->masterSchoolId->cellAttributes() ?>>
<span id="el_fin_credit_masterSchoolId">
<span<?= $Page->masterSchoolId->viewAttributes() ?>>
<?= $Page->masterSchoolId->getViewValue() ?></span>
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
