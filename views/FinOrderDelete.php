<?php

namespace PHPMaker2022\school;

// Page object
$FinOrderDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_order: currentTable } });
var currentForm, currentPageID;
var ffin_orderdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_orderdelete = new ew.Form("ffin_orderdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffin_orderdelete;
    loadjs.done("ffin_orderdelete");
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
<form name="ffin_orderdelete" id="ffin_orderdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_order">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fin_order_id" class="fin_order_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->discountId->Visible) { // discountId ?>
        <th class="<?= $Page->discountId->headerCellClass() ?>"><span id="elh_fin_order_discountId" class="fin_order_discountId"><?= $Page->discountId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <th class="<?= $Page->date->headerCellClass() ?>"><span id="elh_fin_order_date" class="fin_order_date"><?= $Page->date->caption() ?></span></th>
<?php } ?>
<?php if ($Page->due->Visible) { // due ?>
        <th class="<?= $Page->due->headerCellClass() ?>"><span id="elh_fin_order_due" class="fin_order_due"><?= $Page->due->caption() ?></span></th>
<?php } ?>
<?php if ($Page->debtor->Visible) { // debtor ?>
        <th class="<?= $Page->debtor->headerCellClass() ?>"><span id="elh_fin_order_debtor" class="fin_order_debtor"><?= $Page->debtor->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fin_order_id" class="el_fin_order_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->discountId->Visible) { // discountId ?>
        <td<?= $Page->discountId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_order_discountId" class="el_fin_order_discountId">
<span<?= $Page->discountId->viewAttributes() ?>>
<?= $Page->discountId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->date->Visible) { // date ?>
        <td<?= $Page->date->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_order_date" class="el_fin_order_date">
<span<?= $Page->date->viewAttributes() ?>>
<?= $Page->date->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->due->Visible) { // due ?>
        <td<?= $Page->due->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_order_due" class="el_fin_order_due">
<span<?= $Page->due->viewAttributes() ?>>
<?= $Page->due->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->debtor->Visible) { // debtor ?>
        <td<?= $Page->debtor->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_order_debtor" class="el_fin_order_debtor">
<span<?= $Page->debtor->viewAttributes() ?>>
<?= $Page->debtor->getViewValue() ?></span>
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
