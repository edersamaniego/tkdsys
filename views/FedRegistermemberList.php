<?php

namespace PHPMaker2022\school;

// Page object
$FedRegistermemberList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_registermember: currentTable } });
var currentForm, currentPageID;
var ffed_registermemberlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_registermemberlist = new ew.Form("ffed_registermemberlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = ffed_registermemberlist;
    ffed_registermemberlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("ffed_registermemberlist");
});
</script>
<script>
ew.PREVIEW_SELECTOR = ".ew-preview-btn";
ew.PREVIEW_ROW = true;
ew.PREVIEW_SINGLE_ROW = false;
ew.ready("head", ew.PATH_BASE + "js/preview.min.js", "preview");
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fed_registermember">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="ffed_registermemberlist" id="ffed_registermemberlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_registermember">
<div id="gmp_fed_registermember" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_fed_registermemberlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_fed_registermember_id" class="fed_registermember_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
        <th data-name="memberId" class="<?= $Page->memberId->headerCellClass() ?>"><div id="elh_fed_registermember_memberId" class="fed_registermember_memberId"><?= $Page->renderFieldHeader($Page->memberId) ?></div></th>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <th data-name="schoolId" class="<?= $Page->schoolId->headerCellClass() ?>"><div id="elh_fed_registermember_schoolId" class="fed_registermember_schoolId"><?= $Page->renderFieldHeader($Page->schoolId) ?></div></th>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
        <th data-name="testId" class="<?= $Page->testId->headerCellClass() ?>"><div id="elh_fed_registermember_testId" class="fed_registermember_testId"><?= $Page->renderFieldHeader($Page->testId) ?></div></th>
<?php } ?>
<?php if ($Page->currentRankId->Visible) { // currentRankId ?>
        <th data-name="currentRankId" class="<?= $Page->currentRankId->headerCellClass() ?>"><div id="elh_fed_registermember_currentRankId" class="fed_registermember_currentRankId"><?= $Page->renderFieldHeader($Page->currentRankId) ?></div></th>
<?php } ?>
<?php if ($Page->registerType->Visible) { // registerType ?>
        <th data-name="registerType" class="<?= $Page->registerType->headerCellClass() ?>"><div id="elh_fed_registermember_registerType" class="fed_registermember_registerType"><?= $Page->renderFieldHeader($Page->registerType) ?></div></th>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <th data-name="createUserId" class="<?= $Page->createUserId->headerCellClass() ?>"><div id="elh_fed_registermember_createUserId" class="fed_registermember_createUserId"><?= $Page->renderFieldHeader($Page->createUserId) ?></div></th>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <th data-name="createDate" class="<?= $Page->createDate->headerCellClass() ?>"><div id="elh_fed_registermember_createDate" class="fed_registermember_createDate"><?= $Page->renderFieldHeader($Page->createDate) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif ($Page->isGridAdd() && !$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row attributes
        $Page->RowAttrs->merge([
            "data-rowindex" => $Page->RowCount,
            "id" => "r" . $Page->RowCount . "_fed_registermember",
            "data-rowtype" => $Page->RowType,
            "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Page->isAdd() && $Page->RowType == ROWTYPE_ADD || $Page->isEdit() && $Page->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Page->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_id" class="el_fed_registermember_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->memberId->Visible) { // memberId ?>
        <td data-name="memberId"<?= $Page->memberId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_memberId" class="el_fed_registermember_memberId">
<span<?= $Page->memberId->viewAttributes() ?>>
<?= $Page->memberId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->schoolId->Visible) { // schoolId ?>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_schoolId" class="el_fed_registermember_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->testId->Visible) { // testId ?>
        <td data-name="testId"<?= $Page->testId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_testId" class="el_fed_registermember_testId">
<span<?= $Page->testId->viewAttributes() ?>>
<?= $Page->testId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->currentRankId->Visible) { // currentRankId ?>
        <td data-name="currentRankId"<?= $Page->currentRankId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_currentRankId" class="el_fed_registermember_currentRankId">
<span<?= $Page->currentRankId->viewAttributes() ?>>
<?= $Page->currentRankId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->registerType->Visible) { // registerType ?>
        <td data-name="registerType"<?= $Page->registerType->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_registerType" class="el_fed_registermember_registerType">
<span<?= $Page->registerType->viewAttributes() ?>>
<?= $Page->registerType->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->createUserId->Visible) { // createUserId ?>
        <td data-name="createUserId"<?= $Page->createUserId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_createUserId" class="el_fed_registermember_createUserId">
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->createDate->Visible) { // createDate ?>
        <td data-name="createDate"<?= $Page->createDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_registermember_createDate" class="el_fed_registermember_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("fed_registermember");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
