<?php

namespace PHPMaker2022\school;

// Page object
$FinEmployeeDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_employee: currentTable } });
var currentForm, currentPageID;
var ffin_employeedelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_employeedelete = new ew.Form("ffin_employeedelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffin_employeedelete;
    loadjs.done("ffin_employeedelete");
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
<form name="ffin_employeedelete" id="ffin_employeedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_employee">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fin_employee_id" class="fin_employee_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uniqueId->Visible) { // uniqueId ?>
        <th class="<?= $Page->uniqueId->headerCellClass() ?>"><span id="elh_fin_employee_uniqueId" class="fin_employee_uniqueId"><?= $Page->uniqueId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_fin_employee_name" class="fin_employee_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->middlename->Visible) { // middlename ?>
        <th class="<?= $Page->middlename->headerCellClass() ?>"><span id="elh_fin_employee_middlename" class="fin_employee_middlename"><?= $Page->middlename->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lastname->Visible) { // lastname ?>
        <th class="<?= $Page->lastname->headerCellClass() ?>"><span id="elh_fin_employee_lastname" class="fin_employee_lastname"><?= $Page->lastname->caption() ?></span></th>
<?php } ?>
<?php if ($Page->country->Visible) { // country ?>
        <th class="<?= $Page->country->headerCellClass() ?>"><span id="elh_fin_employee_country" class="fin_employee_country"><?= $Page->country->caption() ?></span></th>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
        <th class="<?= $Page->state->headerCellClass() ?>"><span id="elh_fin_employee_state" class="fin_employee_state"><?= $Page->state->caption() ?></span></th>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
        <th class="<?= $Page->city->headerCellClass() ?>"><span id="elh_fin_employee_city" class="fin_employee_city"><?= $Page->city->caption() ?></span></th>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
        <th class="<?= $Page->address->headerCellClass() ?>"><span id="elh_fin_employee_address" class="fin_employee_address"><?= $Page->address->caption() ?></span></th>
<?php } ?>
<?php if ($Page->neighborhood->Visible) { // neighborhood ?>
        <th class="<?= $Page->neighborhood->headerCellClass() ?>"><span id="elh_fin_employee_neighborhood" class="fin_employee_neighborhood"><?= $Page->neighborhood->caption() ?></span></th>
<?php } ?>
<?php if ($Page->zipcode->Visible) { // zipcode ?>
        <th class="<?= $Page->zipcode->headerCellClass() ?>"><span id="elh_fin_employee_zipcode" class="fin_employee_zipcode"><?= $Page->zipcode->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fin_employee_id" class="el_fin_employee_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uniqueId->Visible) { // uniqueId ?>
        <td<?= $Page->uniqueId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_employee_uniqueId" class="el_fin_employee_uniqueId">
<span<?= $Page->uniqueId->viewAttributes() ?>>
<?= $Page->uniqueId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td<?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_employee_name" class="el_fin_employee_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->middlename->Visible) { // middlename ?>
        <td<?= $Page->middlename->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_employee_middlename" class="el_fin_employee_middlename">
<span<?= $Page->middlename->viewAttributes() ?>>
<?= $Page->middlename->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lastname->Visible) { // lastname ?>
        <td<?= $Page->lastname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_employee_lastname" class="el_fin_employee_lastname">
<span<?= $Page->lastname->viewAttributes() ?>>
<?= $Page->lastname->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->country->Visible) { // country ?>
        <td<?= $Page->country->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_employee_country" class="el_fin_employee_country">
<span<?= $Page->country->viewAttributes() ?>>
<?= $Page->country->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->state->Visible) { // state ?>
        <td<?= $Page->state->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_employee_state" class="el_fin_employee_state">
<span<?= $Page->state->viewAttributes() ?>>
<?= $Page->state->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
        <td<?= $Page->city->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_employee_city" class="el_fin_employee_city">
<span<?= $Page->city->viewAttributes() ?>>
<?= $Page->city->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->address->Visible) { // address ?>
        <td<?= $Page->address->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_employee_address" class="el_fin_employee_address">
<span<?= $Page->address->viewAttributes() ?>>
<?= $Page->address->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->neighborhood->Visible) { // neighborhood ?>
        <td<?= $Page->neighborhood->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_employee_neighborhood" class="el_fin_employee_neighborhood">
<span<?= $Page->neighborhood->viewAttributes() ?>>
<?= $Page->neighborhood->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->zipcode->Visible) { // zipcode ?>
        <td<?= $Page->zipcode->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_employee_zipcode" class="el_fin_employee_zipcode">
<span<?= $Page->zipcode->viewAttributes() ?>>
<?= $Page->zipcode->getViewValue() ?></span>
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
