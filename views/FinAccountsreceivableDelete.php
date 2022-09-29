<?php

namespace PHPMaker2022\school;

// Page object
$FinAccountsreceivableDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_accountsreceivable: currentTable } });
var currentForm, currentPageID;
var ffin_accountsreceivabledelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_accountsreceivabledelete = new ew.Form("ffin_accountsreceivabledelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffin_accountsreceivabledelete;
    loadjs.done("ffin_accountsreceivabledelete");
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
<form name="ffin_accountsreceivabledelete" id="ffin_accountsreceivabledelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_accountsreceivable">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fin_accountsreceivable_id" class="fin_accountsreceivable_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->issue->Visible) { // issue ?>
        <th class="<?= $Page->issue->headerCellClass() ?>"><span id="elh_fin_accountsreceivable_issue" class="fin_accountsreceivable_issue"><?= $Page->issue->caption() ?></span></th>
<?php } ?>
<?php if ($Page->due->Visible) { // due ?>
        <th class="<?= $Page->due->headerCellClass() ?>"><span id="elh_fin_accountsreceivable_due" class="fin_accountsreceivable_due"><?= $Page->due->caption() ?></span></th>
<?php } ?>
<?php if ($Page->income->Visible) { // income ?>
        <th class="<?= $Page->income->headerCellClass() ?>"><span id="elh_fin_accountsreceivable_income" class="fin_accountsreceivable_income"><?= $Page->income->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_fin_accountsreceivable_status" class="fin_accountsreceivable_status"><?= $Page->status->caption() ?></span></th>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
        <th class="<?= $Page->value->headerCellClass() ?>"><span id="elh_fin_accountsreceivable_value" class="fin_accountsreceivable_value"><?= $Page->value->caption() ?></span></th>
<?php } ?>
<?php if ($Page->orderId->Visible) { // orderId ?>
        <th class="<?= $Page->orderId->headerCellClass() ?>"><span id="elh_fin_accountsreceivable_orderId" class="fin_accountsreceivable_orderId"><?= $Page->orderId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->balance->Visible) { // balance ?>
        <th class="<?= $Page->balance->headerCellClass() ?>"><span id="elh_fin_accountsreceivable_balance" class="fin_accountsreceivable_balance"><?= $Page->balance->caption() ?></span></th>
<?php } ?>
<?php if ($Page->debtorId->Visible) { // debtorId ?>
        <th class="<?= $Page->debtorId->headerCellClass() ?>"><span id="elh_fin_accountsreceivable_debtorId" class="fin_accountsreceivable_debtorId"><?= $Page->debtorId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->licenseId->Visible) { // licenseId ?>
        <th class="<?= $Page->licenseId->headerCellClass() ?>"><span id="elh_fin_accountsreceivable_licenseId" class="fin_accountsreceivable_licenseId"><?= $Page->licenseId->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_id" class="el_fin_accountsreceivable_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->issue->Visible) { // issue ?>
        <td<?= $Page->issue->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_issue" class="el_fin_accountsreceivable_issue">
<span<?= $Page->issue->viewAttributes() ?>>
<?= $Page->issue->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->due->Visible) { // due ?>
        <td<?= $Page->due->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_due" class="el_fin_accountsreceivable_due">
<span<?= $Page->due->viewAttributes() ?>>
<?= $Page->due->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->income->Visible) { // income ?>
        <td<?= $Page->income->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_income" class="el_fin_accountsreceivable_income">
<span<?= $Page->income->viewAttributes() ?>>
<?= $Page->income->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_status" class="el_fin_accountsreceivable_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
        <td<?= $Page->value->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_value" class="el_fin_accountsreceivable_value">
<span<?= $Page->value->viewAttributes() ?>>
<?= $Page->value->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->orderId->Visible) { // orderId ?>
        <td<?= $Page->orderId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_orderId" class="el_fin_accountsreceivable_orderId">
<span<?= $Page->orderId->viewAttributes() ?>>
<?= $Page->orderId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->balance->Visible) { // balance ?>
        <td<?= $Page->balance->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_balance" class="el_fin_accountsreceivable_balance">
<span<?= $Page->balance->viewAttributes() ?>>
<?= $Page->balance->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->debtorId->Visible) { // debtorId ?>
        <td<?= $Page->debtorId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_debtorId" class="el_fin_accountsreceivable_debtorId">
<span<?= $Page->debtorId->viewAttributes() ?>>
<?= $Page->debtorId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->licenseId->Visible) { // licenseId ?>
        <td<?= $Page->licenseId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_licenseId" class="el_fin_accountsreceivable_licenseId">
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
