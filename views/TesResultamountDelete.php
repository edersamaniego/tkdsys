<?php

namespace PHPMaker2022\school;

// Page object
$TesResultamountDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_resultamount: currentTable } });
var currentForm, currentPageID;
var ftes_resultamountdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_resultamountdelete = new ew.Form("ftes_resultamountdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ftes_resultamountdelete;
    loadjs.done("ftes_resultamountdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ftes_resultamountdelete" id="ftes_resultamountdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_resultamount">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table table-bordered table-hover table-sm ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_tes_resultamount_id" class="tes_resultamount_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->federationId->Visible) { // federationId ?>
        <th class="<?= $Page->federationId->headerCellClass() ?>"><span id="elh_tes_resultamount_federationId" class="tes_resultamount_federationId"><?= $Page->federationId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <th class="<?= $Page->schoolId->headerCellClass() ?>"><span id="elh_tes_resultamount_schoolId" class="tes_resultamount_schoolId"><?= $Page->schoolId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
        <th class="<?= $Page->testId->headerCellClass() ?>"><span id="elh_tes_resultamount_testId" class="tes_resultamount_testId"><?= $Page->testId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sendingDate->Visible) { // sendingDate ?>
        <th class="<?= $Page->sendingDate->headerCellClass() ?>"><span id="elh_tes_resultamount_sendingDate" class="tes_resultamount_sendingDate"><?= $Page->sendingDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->paymentDate->Visible) { // paymentDate ?>
        <th class="<?= $Page->paymentDate->headerCellClass() ?>"><span id="elh_tes_resultamount_paymentDate" class="tes_resultamount_paymentDate"><?= $Page->paymentDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->printingDate->Visible) { // printingDate ?>
        <th class="<?= $Page->printingDate->headerCellClass() ?>"><span id="elh_tes_resultamount_printingDate" class="tes_resultamount_printingDate"><?= $Page->printingDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->shippedDate->Visible) { // shippedDate ?>
        <th class="<?= $Page->shippedDate->headerCellClass() ?>"><span id="elh_tes_resultamount_shippedDate" class="tes_resultamount_shippedDate"><?= $Page->shippedDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_tes_resultamount_status" class="tes_resultamount_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <th class="<?= $Page->createUserId->headerCellClass() ?>"><span id="elh_tes_resultamount_createUserId" class="tes_resultamount_createUserId"><?= $Page->createUserId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <th class="<?= $Page->createDate->headerCellClass() ?>"><span id="elh_tes_resultamount_createDate" class="tes_resultamount_createDate"><?= $Page->createDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totalAmount->Visible) { // totalAmount ?>
        <th class="<?= $Page->totalAmount->headerCellClass() ?>"><span id="elh_tes_resultamount_totalAmount" class="tes_resultamount_totalAmount"><?= $Page->totalAmount->caption() ?></span></th>
<?php } ?>
<?php if ($Page->paymentId->Visible) { // paymentId ?>
        <th class="<?= $Page->paymentId->headerCellClass() ?>"><span id="elh_tes_resultamount_paymentId" class="tes_resultamount_paymentId"><?= $Page->paymentId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->totalValue->Visible) { // totalValue ?>
        <th class="<?= $Page->totalValue->headerCellClass() ?>"><span id="elh_tes_resultamount_totalValue" class="tes_resultamount_totalValue"><?= $Page->totalValue->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_id" class="el_tes_resultamount_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->federationId->Visible) { // federationId ?>
        <td<?= $Page->federationId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_federationId" class="el_tes_resultamount_federationId">
<span<?= $Page->federationId->viewAttributes() ?>>
<?= $Page->federationId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <td<?= $Page->schoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_schoolId" class="el_tes_resultamount_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
        <td<?= $Page->testId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_testId" class="el_tes_resultamount_testId">
<span<?= $Page->testId->viewAttributes() ?>>
<?= $Page->testId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sendingDate->Visible) { // sendingDate ?>
        <td<?= $Page->sendingDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_sendingDate" class="el_tes_resultamount_sendingDate">
<span<?= $Page->sendingDate->viewAttributes() ?>>
<?= $Page->sendingDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->paymentDate->Visible) { // paymentDate ?>
        <td<?= $Page->paymentDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_paymentDate" class="el_tes_resultamount_paymentDate">
<span<?= $Page->paymentDate->viewAttributes() ?>>
<?= $Page->paymentDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->printingDate->Visible) { // printingDate ?>
        <td<?= $Page->printingDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_printingDate" class="el_tes_resultamount_printingDate">
<span<?= $Page->printingDate->viewAttributes() ?>>
<?= $Page->printingDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->shippedDate->Visible) { // shippedDate ?>
        <td<?= $Page->shippedDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_shippedDate" class="el_tes_resultamount_shippedDate">
<span<?= $Page->shippedDate->viewAttributes() ?>>
<?= $Page->shippedDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_status" class="el_tes_resultamount_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <td<?= $Page->createUserId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_createUserId" class="el_tes_resultamount_createUserId">
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <td<?= $Page->createDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_createDate" class="el_tes_resultamount_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totalAmount->Visible) { // totalAmount ?>
        <td<?= $Page->totalAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_totalAmount" class="el_tes_resultamount_totalAmount">
<span<?= $Page->totalAmount->viewAttributes() ?>>
<?= $Page->totalAmount->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->paymentId->Visible) { // paymentId ?>
        <td<?= $Page->paymentId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_paymentId" class="el_tes_resultamount_paymentId">
<span<?= $Page->paymentId->viewAttributes() ?>>
<?= $Page->paymentId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->totalValue->Visible) { // totalValue ?>
        <td<?= $Page->totalValue->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_totalValue" class="el_tes_resultamount_totalValue">
<span<?= $Page->totalValue->viewAttributes() ?>>
<?= $Page->totalValue->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
