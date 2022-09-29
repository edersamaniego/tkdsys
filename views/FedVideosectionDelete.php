<?php

namespace PHPMaker2022\school;

// Page object
$FedVideosectionDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_videosection: currentTable } });
var currentForm, currentPageID;
var ffed_videosectiondelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_videosectiondelete = new ew.Form("ffed_videosectiondelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffed_videosectiondelete;
    loadjs.done("ffed_videosectiondelete");
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
<form name="ffed_videosectiondelete" id="ffed_videosectiondelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_videosection">
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
<?php if ($Page->section->Visible) { // section ?>
        <th class="<?= $Page->section->headerCellClass() ?>"><span id="elh_fed_videosection_section" class="fed_videosection_section"><?= $Page->section->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sectionBr->Visible) { // sectionBr ?>
        <th class="<?= $Page->sectionBr->headerCellClass() ?>"><span id="elh_fed_videosection_sectionBr" class="fed_videosection_sectionBr"><?= $Page->sectionBr->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sectionSp->Visible) { // sectionSp ?>
        <th class="<?= $Page->sectionSp->headerCellClass() ?>"><span id="elh_fed_videosection_sectionSp" class="fed_videosection_sectionSp"><?= $Page->sectionSp->caption() ?></span></th>
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
<?php if ($Page->section->Visible) { // section ?>
        <td<?= $Page->section->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_videosection_section" class="el_fed_videosection_section">
<span<?= $Page->section->viewAttributes() ?>>
<?= $Page->section->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sectionBr->Visible) { // sectionBr ?>
        <td<?= $Page->sectionBr->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_videosection_sectionBr" class="el_fed_videosection_sectionBr">
<span<?= $Page->sectionBr->viewAttributes() ?>>
<?= $Page->sectionBr->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sectionSp->Visible) { // sectionSp ?>
        <td<?= $Page->sectionSp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_videosection_sectionSp" class="el_fed_videosection_sectionSp">
<span<?= $Page->sectionSp->viewAttributes() ?>>
<?= $Page->sectionSp->getViewValue() ?></span>
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
