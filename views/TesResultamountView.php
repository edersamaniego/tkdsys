<?php

namespace PHPMaker2022\school;

// Page object
$TesResultamountView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_resultamount: currentTable } });
var currentForm, currentPageID;
var ftes_resultamountview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_resultamountview = new ew.Form("ftes_resultamountview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ftes_resultamountview;
    loadjs.done("ftes_resultamountview");
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
<form name="ftes_resultamountview" id="ftes_resultamountview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_resultamount">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_resultamount_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_tes_resultamount_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->federationId->Visible) { // federationId ?>
    <tr id="r_federationId"<?= $Page->federationId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_resultamount_federationId"><?= $Page->federationId->caption() ?></span></td>
        <td data-name="federationId"<?= $Page->federationId->cellAttributes() ?>>
<span id="el_tes_resultamount_federationId">
<span<?= $Page->federationId->viewAttributes() ?>>
<?= $Page->federationId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
    <tr id="r_schoolId"<?= $Page->schoolId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_resultamount_schoolId"><?= $Page->schoolId->caption() ?></span></td>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el_tes_resultamount_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
    <tr id="r_testId"<?= $Page->testId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_resultamount_testId"><?= $Page->testId->caption() ?></span></td>
        <td data-name="testId"<?= $Page->testId->cellAttributes() ?>>
<span id="el_tes_resultamount_testId">
<span<?= $Page->testId->viewAttributes() ?>>
<?= $Page->testId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sendingDate->Visible) { // sendingDate ?>
    <tr id="r_sendingDate"<?= $Page->sendingDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_resultamount_sendingDate"><?= $Page->sendingDate->caption() ?></span></td>
        <td data-name="sendingDate"<?= $Page->sendingDate->cellAttributes() ?>>
<span id="el_tes_resultamount_sendingDate">
<span<?= $Page->sendingDate->viewAttributes() ?>>
<?= $Page->sendingDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->paymentDate->Visible) { // paymentDate ?>
    <tr id="r_paymentDate"<?= $Page->paymentDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_resultamount_paymentDate"><?= $Page->paymentDate->caption() ?></span></td>
        <td data-name="paymentDate"<?= $Page->paymentDate->cellAttributes() ?>>
<span id="el_tes_resultamount_paymentDate">
<span<?= $Page->paymentDate->viewAttributes() ?>>
<?= $Page->paymentDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->printingDate->Visible) { // printingDate ?>
    <tr id="r_printingDate"<?= $Page->printingDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_resultamount_printingDate"><?= $Page->printingDate->caption() ?></span></td>
        <td data-name="printingDate"<?= $Page->printingDate->cellAttributes() ?>>
<span id="el_tes_resultamount_printingDate">
<span<?= $Page->printingDate->viewAttributes() ?>>
<?= $Page->printingDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->shippedDate->Visible) { // shippedDate ?>
    <tr id="r_shippedDate"<?= $Page->shippedDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_resultamount_shippedDate"><?= $Page->shippedDate->caption() ?></span></td>
        <td data-name="shippedDate"<?= $Page->shippedDate->cellAttributes() ?>>
<span id="el_tes_resultamount_shippedDate">
<span<?= $Page->shippedDate->viewAttributes() ?>>
<?= $Page->shippedDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
    <tr id="r_status"<?= $Page->status->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_resultamount_status"><?= $Page->status->caption() ?></span></td>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el_tes_resultamount_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
    <tr id="r_createUserId"<?= $Page->createUserId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_resultamount_createUserId"><?= $Page->createUserId->caption() ?></span></td>
        <td data-name="createUserId"<?= $Page->createUserId->cellAttributes() ?>>
<span id="el_tes_resultamount_createUserId">
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <tr id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_resultamount_createDate"><?= $Page->createDate->caption() ?></span></td>
        <td data-name="createDate"<?= $Page->createDate->cellAttributes() ?>>
<span id="el_tes_resultamount_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totalAmount->Visible) { // totalAmount ?>
    <tr id="r_totalAmount"<?= $Page->totalAmount->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_resultamount_totalAmount"><?= $Page->totalAmount->caption() ?></span></td>
        <td data-name="totalAmount"<?= $Page->totalAmount->cellAttributes() ?>>
<span id="el_tes_resultamount_totalAmount">
<span<?= $Page->totalAmount->viewAttributes() ?>>
<?= $Page->totalAmount->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->paymentId->Visible) { // paymentId ?>
    <tr id="r_paymentId"<?= $Page->paymentId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_resultamount_paymentId"><?= $Page->paymentId->caption() ?></span></td>
        <td data-name="paymentId"<?= $Page->paymentId->cellAttributes() ?>>
<span id="el_tes_resultamount_paymentId">
<span<?= $Page->paymentId->viewAttributes() ?>>
<?= $Page->paymentId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->totalValue->Visible) { // totalValue ?>
    <tr id="r_totalValue"<?= $Page->totalValue->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_tes_resultamount_totalValue"><?= $Page->totalValue->caption() ?></span></td>
        <td data-name="totalValue"<?= $Page->totalValue->cellAttributes() ?>>
<span id="el_tes_resultamount_totalValue">
<span<?= $Page->totalValue->viewAttributes() ?>>
<?= $Page->totalValue->getViewValue() ?></span>
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
