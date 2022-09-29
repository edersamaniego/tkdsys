<?php

namespace PHPMaker2022\school;

// Page object
$FinAccountspayableDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_accountspayable: currentTable } });
var currentForm, currentPageID;
var ffin_accountspayabledelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_accountspayabledelete = new ew.Form("ffin_accountspayabledelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffin_accountspayabledelete;
    loadjs.done("ffin_accountspayabledelete");
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
<form name="ffin_accountspayabledelete" id="ffin_accountspayabledelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_accountspayable">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fin_accountspayable_id" class="fin_accountspayable_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->departamentId->Visible) { // departamentId ?>
        <th class="<?= $Page->departamentId->headerCellClass() ?>"><span id="elh_fin_accountspayable_departamentId" class="fin_accountspayable_departamentId"><?= $Page->departamentId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->historic->Visible) { // historic ?>
        <th class="<?= $Page->historic->headerCellClass() ?>"><span id="elh_fin_accountspayable_historic" class="fin_accountspayable_historic"><?= $Page->historic->caption() ?></span></th>
<?php } ?>
<?php if ($Page->issue->Visible) { // issue ?>
        <th class="<?= $Page->issue->headerCellClass() ?>"><span id="elh_fin_accountspayable_issue" class="fin_accountspayable_issue"><?= $Page->issue->caption() ?></span></th>
<?php } ?>
<?php if ($Page->due->Visible) { // due ?>
        <th class="<?= $Page->due->headerCellClass() ?>"><span id="elh_fin_accountspayable_due" class="fin_accountspayable_due"><?= $Page->due->caption() ?></span></th>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
        <th class="<?= $Page->value->headerCellClass() ?>"><span id="elh_fin_accountspayable_value" class="fin_accountspayable_value"><?= $Page->value->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_fin_accountspayable_status" class="fin_accountspayable_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->amountPaid->Visible) { // amountPaid ?>
        <th class="<?= $Page->amountPaid->headerCellClass() ?>"><span id="elh_fin_accountspayable_amountPaid" class="fin_accountspayable_amountPaid"><?= $Page->amountPaid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->creditorsId->Visible) { // creditorsId ?>
        <th class="<?= $Page->creditorsId->headerCellClass() ?>"><span id="elh_fin_accountspayable_creditorsId" class="fin_accountspayable_creditorsId"><?= $Page->creditorsId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->typeId->Visible) { // typeId ?>
        <th class="<?= $Page->typeId->headerCellClass() ?>"><span id="elh_fin_accountspayable_typeId" class="fin_accountspayable_typeId"><?= $Page->typeId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->licenseId->Visible) { // licenseId ?>
        <th class="<?= $Page->licenseId->headerCellClass() ?>"><span id="elh_fin_accountspayable_licenseId" class="fin_accountspayable_licenseId"><?= $Page->licenseId->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_id" class="el_fin_accountspayable_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->departamentId->Visible) { // departamentId ?>
        <td<?= $Page->departamentId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_departamentId" class="el_fin_accountspayable_departamentId">
<span<?= $Page->departamentId->viewAttributes() ?>>
<?= $Page->departamentId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->historic->Visible) { // historic ?>
        <td<?= $Page->historic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_historic" class="el_fin_accountspayable_historic">
<span<?= $Page->historic->viewAttributes() ?>>
<?= $Page->historic->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->issue->Visible) { // issue ?>
        <td<?= $Page->issue->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_issue" class="el_fin_accountspayable_issue">
<span<?= $Page->issue->viewAttributes() ?>>
<?= $Page->issue->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->due->Visible) { // due ?>
        <td<?= $Page->due->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_due" class="el_fin_accountspayable_due">
<span<?= $Page->due->viewAttributes() ?>>
<?= $Page->due->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
        <td<?= $Page->value->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_value" class="el_fin_accountspayable_value">
<span<?= $Page->value->viewAttributes() ?>>
<?= $Page->value->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_status" class="el_fin_accountspayable_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->amountPaid->Visible) { // amountPaid ?>
        <td<?= $Page->amountPaid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_amountPaid" class="el_fin_accountspayable_amountPaid">
<span<?= $Page->amountPaid->viewAttributes() ?>>
<?= $Page->amountPaid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->creditorsId->Visible) { // creditorsId ?>
        <td<?= $Page->creditorsId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_creditorsId" class="el_fin_accountspayable_creditorsId">
<span<?= $Page->creditorsId->viewAttributes() ?>>
<?= $Page->creditorsId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->typeId->Visible) { // typeId ?>
        <td<?= $Page->typeId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_typeId" class="el_fin_accountspayable_typeId">
<span<?= $Page->typeId->viewAttributes() ?>>
<?= $Page->typeId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->licenseId->Visible) { // licenseId ?>
        <td<?= $Page->licenseId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_licenseId" class="el_fin_accountspayable_licenseId">
<span<?= $Page->licenseId->viewAttributes() ?>>
<?= $Page->licenseId->getViewValue() ?></span>
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
