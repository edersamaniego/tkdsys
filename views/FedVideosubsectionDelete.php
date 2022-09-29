<?php

namespace PHPMaker2022\school;

// Page object
$FedVideosubsectionDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_videosubsection: currentTable } });
var currentForm, currentPageID;
var ffed_videosubsectiondelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_videosubsectiondelete = new ew.Form("ffed_videosubsectiondelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffed_videosubsectiondelete;
    loadjs.done("ffed_videosubsectiondelete");
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
<form name="ffed_videosubsectiondelete" id="ffed_videosubsectiondelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_videosubsection">
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
        <th class="<?= $Page->section->headerCellClass() ?>"><span id="elh_fed_videosubsection_section" class="fed_videosubsection_section"><?= $Page->section->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subsection->Visible) { // subsection ?>
        <th class="<?= $Page->subsection->headerCellClass() ?>"><span id="elh_fed_videosubsection_subsection" class="fed_videosubsection_subsection"><?= $Page->subsection->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subsectionBr->Visible) { // subsectionBr ?>
        <th class="<?= $Page->subsectionBr->headerCellClass() ?>"><span id="elh_fed_videosubsection_subsectionBr" class="fed_videosubsection_subsectionBr"><?= $Page->subsectionBr->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subsectionSp->Visible) { // subsectionSp ?>
        <th class="<?= $Page->subsectionSp->headerCellClass() ?>"><span id="elh_fed_videosubsection_subsectionSp" class="fed_videosubsection_subsectionSp"><?= $Page->subsectionSp->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_fed_videosubsection_section" class="el_fed_videosubsection_section">
<span<?= $Page->section->viewAttributes() ?>>
<?= $Page->section->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subsection->Visible) { // subsection ?>
        <td<?= $Page->subsection->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_videosubsection_subsection" class="el_fed_videosubsection_subsection">
<span<?= $Page->subsection->viewAttributes() ?>>
<?= $Page->subsection->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subsectionBr->Visible) { // subsectionBr ?>
        <td<?= $Page->subsectionBr->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_videosubsection_subsectionBr" class="el_fed_videosubsection_subsectionBr">
<span<?= $Page->subsectionBr->viewAttributes() ?>>
<?= $Page->subsectionBr->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subsectionSp->Visible) { // subsectionSp ?>
        <td<?= $Page->subsectionSp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_videosubsection_subsectionSp" class="el_fed_videosubsection_subsectionSp">
<span<?= $Page->subsectionSp->viewAttributes() ?>>
<?= $Page->subsectionSp->getViewValue() ?></span>
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
