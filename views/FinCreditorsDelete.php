<?php

namespace PHPMaker2022\school;

// Page object
$FinCreditorsDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_creditors: currentTable } });
var currentForm, currentPageID;
var ffin_creditorsdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_creditorsdelete = new ew.Form("ffin_creditorsdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffin_creditorsdelete;
    loadjs.done("ffin_creditorsdelete");
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
<form name="ffin_creditorsdelete" id="ffin_creditorsdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_creditors">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fin_creditors_id" class="fin_creditors_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <th class="<?= $Page->schoolId->headerCellClass() ?>"><span id="elh_fin_creditors_schoolId" class="fin_creditors_schoolId"><?= $Page->schoolId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->creditor->Visible) { // creditor ?>
        <th class="<?= $Page->creditor->headerCellClass() ?>"><span id="elh_fin_creditors_creditor" class="fin_creditors_creditor"><?= $Page->creditor->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uniqueCode->Visible) { // uniqueCode ?>
        <th class="<?= $Page->uniqueCode->headerCellClass() ?>"><span id="elh_fin_creditors_uniqueCode" class="fin_creditors_uniqueCode"><?= $Page->uniqueCode->caption() ?></span></th>
<?php } ?>
<?php if ($Page->IDcode->Visible) { // IDcode ?>
        <th class="<?= $Page->IDcode->headerCellClass() ?>"><span id="elh_fin_creditors_IDcode" class="fin_creditors_IDcode"><?= $Page->IDcode->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fin_creditors_id" class="el_fin_creditors_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <td<?= $Page->schoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_creditors_schoolId" class="el_fin_creditors_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->creditor->Visible) { // creditor ?>
        <td<?= $Page->creditor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_creditors_creditor" class="el_fin_creditors_creditor">
<span<?= $Page->creditor->viewAttributes() ?>>
<?= $Page->creditor->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uniqueCode->Visible) { // uniqueCode ?>
        <td<?= $Page->uniqueCode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_creditors_uniqueCode" class="el_fin_creditors_uniqueCode">
<span<?= $Page->uniqueCode->viewAttributes() ?>>
<?= $Page->uniqueCode->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->IDcode->Visible) { // IDcode ?>
        <td<?= $Page->IDcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_creditors_IDcode" class="el_fin_creditors_IDcode">
<span<?= $Page->IDcode->viewAttributes() ?>>
<?= $Page->IDcode->getViewValue() ?></span>
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
