<?php

namespace PHPMaker2022\school;

// Page object
$TesCertificateDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_certificate: currentTable } });
var currentForm, currentPageID;
var ftes_certificatedelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_certificatedelete = new ew.Form("ftes_certificatedelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ftes_certificatedelete;
    loadjs.done("ftes_certificatedelete");
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
<form name="ftes_certificatedelete" id="ftes_certificatedelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_certificate">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_tes_certificate_id" class="tes_certificate_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <th class="<?= $Page->description->headerCellClass() ?>"><span id="elh_tes_certificate_description" class="tes_certificate_description"><?= $Page->description->caption() ?></span></th>
<?php } ?>
<?php if ($Page->background->Visible) { // background ?>
        <th class="<?= $Page->background->headerCellClass() ?>"><span id="elh_tes_certificate_background" class="tes_certificate_background"><?= $Page->background->caption() ?></span></th>
<?php } ?>
<?php if ($Page->orientation->Visible) { // orientation ?>
        <th class="<?= $Page->orientation->headerCellClass() ?>"><span id="elh_tes_certificate_orientation" class="tes_certificate_orientation"><?= $Page->orientation->caption() ?></span></th>
<?php } ?>
<?php if ($Page->size->Visible) { // size ?>
        <th class="<?= $Page->size->headerCellClass() ?>"><span id="elh_tes_certificate_size" class="tes_certificate_size"><?= $Page->size->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_tes_certificate_id" class="el_tes_certificate_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <td<?= $Page->description->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_certificate_description" class="el_tes_certificate_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->background->Visible) { // background ?>
        <td<?= $Page->background->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_certificate_background" class="el_tes_certificate_background">
<span>
<?= GetFileViewTag($Page->background, $Page->background->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->orientation->Visible) { // orientation ?>
        <td<?= $Page->orientation->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_certificate_orientation" class="el_tes_certificate_orientation">
<span<?= $Page->orientation->viewAttributes() ?>>
<?= $Page->orientation->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->size->Visible) { // size ?>
        <td<?= $Page->size->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_certificate_size" class="el_tes_certificate_size">
<span<?= $Page->size->viewAttributes() ?>>
<?= $Page->size->getViewValue() ?></span>
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
