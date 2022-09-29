<?php

namespace PHPMaker2022\school;

// Page object
$FinCheckingaccountDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_checkingaccount: currentTable } });
var currentForm, currentPageID;
var ffin_checkingaccountdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_checkingaccountdelete = new ew.Form("ffin_checkingaccountdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffin_checkingaccountdelete;
    loadjs.done("ffin_checkingaccountdelete");
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
<form name="ffin_checkingaccountdelete" id="ffin_checkingaccountdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_checkingaccount">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fin_checkingaccount_id" class="fin_checkingaccount_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bank->Visible) { // bank ?>
        <th class="<?= $Page->bank->headerCellClass() ?>"><span id="elh_fin_checkingaccount_bank" class="fin_checkingaccount_bank"><?= $Page->bank->caption() ?></span></th>
<?php } ?>
<?php if ($Page->responsable->Visible) { // responsable ?>
        <th class="<?= $Page->responsable->headerCellClass() ?>"><span id="elh_fin_checkingaccount_responsable" class="fin_checkingaccount_responsable"><?= $Page->responsable->caption() ?></span></th>
<?php } ?>
<?php if ($Page->balance->Visible) { // balance ?>
        <th class="<?= $Page->balance->headerCellClass() ?>"><span id="elh_fin_checkingaccount_balance" class="fin_checkingaccount_balance"><?= $Page->balance->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fin_checkingaccount_id" class="el_fin_checkingaccount_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bank->Visible) { // bank ?>
        <td<?= $Page->bank->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_checkingaccount_bank" class="el_fin_checkingaccount_bank">
<span<?= $Page->bank->viewAttributes() ?>>
<?= $Page->bank->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->responsable->Visible) { // responsable ?>
        <td<?= $Page->responsable->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_checkingaccount_responsable" class="el_fin_checkingaccount_responsable">
<span<?= $Page->responsable->viewAttributes() ?>>
<?= $Page->responsable->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->balance->Visible) { // balance ?>
        <td<?= $Page->balance->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_checkingaccount_balance" class="el_fin_checkingaccount_balance">
<span<?= $Page->balance->viewAttributes() ?>>
<?= $Page->balance->getViewValue() ?></span>
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
