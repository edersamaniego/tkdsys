<?php

namespace PHPMaker2022\school;

// Page object
$SchoolModalityDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { school_modality: currentTable } });
var currentForm, currentPageID;
var fschool_modalitydelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_modalitydelete = new ew.Form("fschool_modalitydelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fschool_modalitydelete;
    loadjs.done("fschool_modalitydelete");
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
<form name="fschool_modalitydelete" id="fschool_modalitydelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="school_modality">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_school_modality_id" class="school_modality_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <th class="<?= $Page->schoolId->headerCellClass() ?>"><span id="elh_school_modality_schoolId" class="school_modality_schoolId"><?= $Page->schoolId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->martialArtId->Visible) { // martialArtId ?>
        <th class="<?= $Page->martialArtId->headerCellClass() ?>"><span id="elh_school_modality_martialArtId" class="school_modality_martialArtId"><?= $Page->martialArtId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nameBR->Visible) { // nameBR ?>
        <th class="<?= $Page->nameBR->headerCellClass() ?>"><span id="elh_school_modality_nameBR" class="school_modality_nameBR"><?= $Page->nameBR->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nameES->Visible) { // nameES ?>
        <th class="<?= $Page->nameES->headerCellClass() ?>"><span id="elh_school_modality_nameES" class="school_modality_nameES"><?= $Page->nameES->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nameEN->Visible) { // nameEN ?>
        <th class="<?= $Page->nameEN->headerCellClass() ?>"><span id="elh_school_modality_nameEN" class="school_modality_nameEN"><?= $Page->nameEN->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_school_modality_id" class="el_school_modality_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <td<?= $Page->schoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_modality_schoolId" class="el_school_modality_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->martialArtId->Visible) { // martialArtId ?>
        <td<?= $Page->martialArtId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_modality_martialArtId" class="el_school_modality_martialArtId">
<span<?= $Page->martialArtId->viewAttributes() ?>>
<?= $Page->martialArtId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nameBR->Visible) { // nameBR ?>
        <td<?= $Page->nameBR->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_modality_nameBR" class="el_school_modality_nameBR">
<span<?= $Page->nameBR->viewAttributes() ?>>
<?= $Page->nameBR->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nameES->Visible) { // nameES ?>
        <td<?= $Page->nameES->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_modality_nameES" class="el_school_modality_nameES">
<span<?= $Page->nameES->viewAttributes() ?>>
<?= $Page->nameES->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nameEN->Visible) { // nameEN ?>
        <td<?= $Page->nameEN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_school_modality_nameEN" class="el_school_modality_nameEN">
<span<?= $Page->nameEN->viewAttributes() ?>>
<?= $Page->nameEN->getViewValue() ?></span>
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
