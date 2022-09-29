<?php

namespace PHPMaker2022\school;

// Page object
$FedApplicationschoolDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_applicationschool: currentTable } });
var currentForm, currentPageID;
var ffed_applicationschooldelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_applicationschooldelete = new ew.Form("ffed_applicationschooldelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffed_applicationschooldelete;
    loadjs.done("ffed_applicationschooldelete");
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
<form name="ffed_applicationschooldelete" id="ffed_applicationschooldelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_applicationschool">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fed_applicationschool_id" class="fed_applicationschool_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->school->Visible) { // school ?>
        <th class="<?= $Page->school->headerCellClass() ?>"><span id="elh_fed_applicationschool_school" class="fed_applicationschool_school"><?= $Page->school->caption() ?></span></th>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
        <th class="<?= $Page->countryId->headerCellClass() ?>"><span id="elh_fed_applicationschool_countryId" class="fed_applicationschool_countryId"><?= $Page->countryId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->UFId->Visible) { // UFId ?>
        <th class="<?= $Page->UFId->headerCellClass() ?>"><span id="elh_fed_applicationschool_UFId" class="fed_applicationschool_UFId"><?= $Page->UFId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->cityId->Visible) { // cityId ?>
        <th class="<?= $Page->cityId->headerCellClass() ?>"><span id="elh_fed_applicationschool_cityId" class="fed_applicationschool_cityId"><?= $Page->cityId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->logo->Visible) { // logo ?>
        <th class="<?= $Page->logo->headerCellClass() ?>"><span id="elh_fed_applicationschool_logo" class="fed_applicationschool_logo"><?= $Page->logo->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fed_applicationschool_id" class="el_fed_applicationschool_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->school->Visible) { // school ?>
        <td<?= $Page->school->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_applicationschool_school" class="el_fed_applicationschool_school">
<span<?= $Page->school->viewAttributes() ?>>
<?= $Page->school->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
        <td<?= $Page->countryId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_applicationschool_countryId" class="el_fed_applicationschool_countryId">
<span<?= $Page->countryId->viewAttributes() ?>>
<?= $Page->countryId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->UFId->Visible) { // UFId ?>
        <td<?= $Page->UFId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_applicationschool_UFId" class="el_fed_applicationschool_UFId">
<span<?= $Page->UFId->viewAttributes() ?>>
<?= $Page->UFId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->cityId->Visible) { // cityId ?>
        <td<?= $Page->cityId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_applicationschool_cityId" class="el_fed_applicationschool_cityId">
<span<?= $Page->cityId->viewAttributes() ?>>
<?= $Page->cityId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->logo->Visible) { // logo ?>
        <td<?= $Page->logo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_applicationschool_logo" class="el_fed_applicationschool_logo">
<span>
<?= GetFileViewTag($Page->logo, $Page->logo->getViewValue(), false) ?>
</span>
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
