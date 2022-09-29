<?php

namespace PHPMaker2022\school;

// Page object
$ConfTesttypeDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_testtype: currentTable } });
var currentForm, currentPageID;
var fconf_testtypedelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_testtypedelete = new ew.Form("fconf_testtypedelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fconf_testtypedelete;
    loadjs.done("fconf_testtypedelete");
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
<form name="fconf_testtypedelete" id="fconf_testtypedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_testtype">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_conf_testtype_id" class="conf_testtype_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->testType->Visible) { // testType ?>
        <th class="<?= $Page->testType->headerCellClass() ?>"><span id="elh_conf_testtype_testType" class="conf_testtype_testType"><?= $Page->testType->caption() ?></span></th>
<?php } ?>
<?php if ($Page->testTypeEN->Visible) { // testTypeEN ?>
        <th class="<?= $Page->testTypeEN->headerCellClass() ?>"><span id="elh_conf_testtype_testTypeEN" class="conf_testtype_testTypeEN"><?= $Page->testTypeEN->caption() ?></span></th>
<?php } ?>
<?php if ($Page->testTypeES->Visible) { // testTypeES ?>
        <th class="<?= $Page->testTypeES->headerCellClass() ?>"><span id="elh_conf_testtype_testTypeES" class="conf_testtype_testTypeES"><?= $Page->testTypeES->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_conf_testtype_id" class="el_conf_testtype_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->testType->Visible) { // testType ?>
        <td<?= $Page->testType->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_testtype_testType" class="el_conf_testtype_testType">
<span<?= $Page->testType->viewAttributes() ?>>
<?= $Page->testType->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->testTypeEN->Visible) { // testTypeEN ?>
        <td<?= $Page->testTypeEN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_testtype_testTypeEN" class="el_conf_testtype_testTypeEN">
<span<?= $Page->testTypeEN->viewAttributes() ?>>
<?= $Page->testTypeEN->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->testTypeES->Visible) { // testTypeES ?>
        <td<?= $Page->testTypeES->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_testtype_testTypeES" class="el_conf_testtype_testTypeES">
<span<?= $Page->testTypeES->viewAttributes() ?>>
<?= $Page->testTypeES->getViewValue() ?></span>
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
