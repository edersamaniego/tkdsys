<?php

namespace PHPMaker2022\school;

// Page object
$ConfSchooltypeDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_schooltype: currentTable } });
var currentForm, currentPageID;
var fconf_schooltypedelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_schooltypedelete = new ew.Form("fconf_schooltypedelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fconf_schooltypedelete;
    loadjs.done("fconf_schooltypedelete");
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
<form name="fconf_schooltypedelete" id="fconf_schooltypedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_schooltype">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_conf_schooltype_id" class="conf_schooltype_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->typeBr->Visible) { // typeBr ?>
        <th class="<?= $Page->typeBr->headerCellClass() ?>"><span id="elh_conf_schooltype_typeBr" class="conf_schooltype_typeBr"><?= $Page->typeBr->caption() ?></span></th>
<?php } ?>
<?php if ($Page->typeEs->Visible) { // typeEs ?>
        <th class="<?= $Page->typeEs->headerCellClass() ?>"><span id="elh_conf_schooltype_typeEs" class="conf_schooltype_typeEs"><?= $Page->typeEs->caption() ?></span></th>
<?php } ?>
<?php if ($Page->typeEn->Visible) { // typeEn ?>
        <th class="<?= $Page->typeEn->headerCellClass() ?>"><span id="elh_conf_schooltype_typeEn" class="conf_schooltype_typeEn"><?= $Page->typeEn->caption() ?></span></th>
<?php } ?>
<?php if ($Page->licensevalue->Visible) { // licensevalue ?>
        <th class="<?= $Page->licensevalue->headerCellClass() ?>"><span id="elh_conf_schooltype_licensevalue" class="conf_schooltype_licensevalue"><?= $Page->licensevalue->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_default->Visible) { // default ?>
        <th class="<?= $Page->_default->headerCellClass() ?>"><span id="elh_conf_schooltype__default" class="conf_schooltype__default"><?= $Page->_default->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_conf_schooltype_id" class="el_conf_schooltype_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->typeBr->Visible) { // typeBr ?>
        <td<?= $Page->typeBr->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_schooltype_typeBr" class="el_conf_schooltype_typeBr">
<span<?= $Page->typeBr->viewAttributes() ?>>
<?= $Page->typeBr->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->typeEs->Visible) { // typeEs ?>
        <td<?= $Page->typeEs->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_schooltype_typeEs" class="el_conf_schooltype_typeEs">
<span<?= $Page->typeEs->viewAttributes() ?>>
<?= $Page->typeEs->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->typeEn->Visible) { // typeEn ?>
        <td<?= $Page->typeEn->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_schooltype_typeEn" class="el_conf_schooltype_typeEn">
<span<?= $Page->typeEn->viewAttributes() ?>>
<?= $Page->typeEn->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->licensevalue->Visible) { // licensevalue ?>
        <td<?= $Page->licensevalue->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_schooltype_licensevalue" class="el_conf_schooltype_licensevalue">
<span<?= $Page->licensevalue->viewAttributes() ?>>
<?= $Page->licensevalue->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_default->Visible) { // default ?>
        <td<?= $Page->_default->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_conf_schooltype__default" class="el_conf_schooltype__default">
<span<?= $Page->_default->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x__default_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->_default->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->_default->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x__default_<?= $Page->RowCount ?>"></label>
</div></span>
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
