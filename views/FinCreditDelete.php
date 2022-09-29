<?php

namespace PHPMaker2022\school;

// Page object
$FinCreditDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_credit: currentTable } });
var currentForm, currentPageID;
var ffin_creditdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_creditdelete = new ew.Form("ffin_creditdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffin_creditdelete;
    loadjs.done("ffin_creditdelete");
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
<form name="ffin_creditdelete" id="ffin_creditdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_credit">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fin_credit_id" class="fin_credit_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dueDate->Visible) { // dueDate ?>
        <th class="<?= $Page->dueDate->headerCellClass() ?>"><span id="elh_fin_credit_dueDate" class="fin_credit_dueDate"><?= $Page->dueDate->caption() ?></span></th>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
        <th class="<?= $Page->value->headerCellClass() ?>"><span id="elh_fin_credit_value" class="fin_credit_value"><?= $Page->value->caption() ?></span></th>
<?php } ?>
<?php if ($Page->paymentMethod->Visible) { // paymentMethod ?>
        <th class="<?= $Page->paymentMethod->headerCellClass() ?>"><span id="elh_fin_credit_paymentMethod" class="fin_credit_paymentMethod"><?= $Page->paymentMethod->caption() ?></span></th>
<?php } ?>
<?php if ($Page->checkingAccountId->Visible) { // checkingAccountId ?>
        <th class="<?= $Page->checkingAccountId->headerCellClass() ?>"><span id="elh_fin_credit_checkingAccountId" class="fin_credit_checkingAccountId"><?= $Page->checkingAccountId->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fin_credit_id" class="el_fin_credit_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dueDate->Visible) { // dueDate ?>
        <td<?= $Page->dueDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_credit_dueDate" class="el_fin_credit_dueDate">
<span<?= $Page->dueDate->viewAttributes() ?>>
<?= $Page->dueDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
        <td<?= $Page->value->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_credit_value" class="el_fin_credit_value">
<span<?= $Page->value->viewAttributes() ?>>
<?= $Page->value->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->paymentMethod->Visible) { // paymentMethod ?>
        <td<?= $Page->paymentMethod->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_credit_paymentMethod" class="el_fin_credit_paymentMethod">
<span<?= $Page->paymentMethod->viewAttributes() ?>>
<?= $Page->paymentMethod->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->checkingAccountId->Visible) { // checkingAccountId ?>
        <td<?= $Page->checkingAccountId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_credit_checkingAccountId" class="el_fin_credit_checkingAccountId">
<span<?= $Page->checkingAccountId->viewAttributes() ?>>
<?= $Page->checkingAccountId->getViewValue() ?></span>
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
