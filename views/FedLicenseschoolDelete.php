<?php

namespace PHPMaker2022\school;

// Page object
$FedLicenseschoolDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_licenseschool: currentTable } });
var currentForm, currentPageID;
var ffed_licenseschooldelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_licenseschooldelete = new ew.Form("ffed_licenseschooldelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffed_licenseschooldelete;
    loadjs.done("ffed_licenseschooldelete");
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
<form name="ffed_licenseschooldelete" id="ffed_licenseschooldelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_licenseschool">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fed_licenseschool_id" class="fed_licenseschool_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->application->Visible) { // application ?>
        <th class="<?= $Page->application->headerCellClass() ?>"><span id="elh_fed_licenseschool_application" class="fed_licenseschool_application"><?= $Page->application->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dateLicense->Visible) { // dateLicense ?>
        <th class="<?= $Page->dateLicense->headerCellClass() ?>"><span id="elh_fed_licenseschool_dateLicense" class="fed_licenseschool_dateLicense"><?= $Page->dateLicense->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dateStart->Visible) { // dateStart ?>
        <th class="<?= $Page->dateStart->headerCellClass() ?>"><span id="elh_fed_licenseschool_dateStart" class="fed_licenseschool_dateStart"><?= $Page->dateStart->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dateFinish->Visible) { // dateFinish ?>
        <th class="<?= $Page->dateFinish->headerCellClass() ?>"><span id="elh_fed_licenseschool_dateFinish" class="fed_licenseschool_dateFinish"><?= $Page->dateFinish->caption() ?></span></th>
<?php } ?>
<?php if ($Page->schooltype->Visible) { // schooltype ?>
        <th class="<?= $Page->schooltype->headerCellClass() ?>"><span id="elh_fed_licenseschool_schooltype" class="fed_licenseschool_schooltype"><?= $Page->schooltype->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fed_licenseschool_id" class="el_fed_licenseschool_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->application->Visible) { // application ?>
        <td<?= $Page->application->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_licenseschool_application" class="el_fed_licenseschool_application">
<span<?= $Page->application->viewAttributes() ?>>
<?= $Page->application->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dateLicense->Visible) { // dateLicense ?>
        <td<?= $Page->dateLicense->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_licenseschool_dateLicense" class="el_fed_licenseschool_dateLicense">
<span<?= $Page->dateLicense->viewAttributes() ?>>
<?= $Page->dateLicense->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dateStart->Visible) { // dateStart ?>
        <td<?= $Page->dateStart->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_licenseschool_dateStart" class="el_fed_licenseschool_dateStart">
<span<?= $Page->dateStart->viewAttributes() ?>>
<?= $Page->dateStart->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dateFinish->Visible) { // dateFinish ?>
        <td<?= $Page->dateFinish->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_licenseschool_dateFinish" class="el_fed_licenseschool_dateFinish">
<span<?= $Page->dateFinish->viewAttributes() ?>>
<?= $Page->dateFinish->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->schooltype->Visible) { // schooltype ?>
        <td<?= $Page->schooltype->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_licenseschool_schooltype" class="el_fed_licenseschool_schooltype">
<span<?= $Page->schooltype->viewAttributes() ?>>
<?= $Page->schooltype->getViewValue() ?></span>
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
