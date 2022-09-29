<?php

namespace PHPMaker2022\school;

// Page object
$FedVideoDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_video: currentTable } });
var currentForm, currentPageID;
var ffed_videodelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_videodelete = new ew.Form("ffed_videodelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffed_videodelete;
    loadjs.done("ffed_videodelete");
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
<form name="ffed_videodelete" id="ffed_videodelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_video">
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
<?php if ($Page->_title->Visible) { // title ?>
        <th class="<?= $Page->_title->headerCellClass() ?>"><span id="elh_fed_video__title" class="fed_video__title"><?= $Page->_title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->URL->Visible) { // URL ?>
        <th class="<?= $Page->URL->headerCellClass() ?>"><span id="elh_fed_video_URL" class="fed_video_URL"><?= $Page->URL->caption() ?></span></th>
<?php } ?>
<?php if ($Page->section->Visible) { // section ?>
        <th class="<?= $Page->section->headerCellClass() ?>"><span id="elh_fed_video_section" class="fed_video_section"><?= $Page->section->caption() ?></span></th>
<?php } ?>
<?php if ($Page->subsection->Visible) { // subsection ?>
        <th class="<?= $Page->subsection->headerCellClass() ?>"><span id="elh_fed_video_subsection" class="fed_video_subsection"><?= $Page->subsection->caption() ?></span></th>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <th class="<?= $Page->createDate->headerCellClass() ?>"><span id="elh_fed_video_createDate" class="fed_video_createDate"><?= $Page->createDate->caption() ?></span></th>
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
<?php if ($Page->_title->Visible) { // title ?>
        <td<?= $Page->_title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_video__title" class="el_fed_video__title">
<span<?= $Page->_title->viewAttributes() ?>>
<?= $Page->_title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->URL->Visible) { // URL ?>
        <td<?= $Page->URL->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_video_URL" class="el_fed_video_URL">
<span><iframe src="https://player.vimeo.com/video/<?= CurrentPage()->URL->CurrentValue ?>" width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->section->Visible) { // section ?>
        <td<?= $Page->section->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_video_section" class="el_fed_video_section">
<span<?= $Page->section->viewAttributes() ?>>
<?= $Page->section->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->subsection->Visible) { // subsection ?>
        <td<?= $Page->subsection->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_video_subsection" class="el_fed_video_subsection">
<span<?= $Page->subsection->viewAttributes() ?>>
<?= $Page->subsection->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <td<?= $Page->createDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_video_createDate" class="el_fed_video_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
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
