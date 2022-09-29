<?php

namespace PHPMaker2022\school;

// Page object
$TesAprovedList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_aproved: currentTable } });
var currentForm, currentPageID;
var ftes_aprovedlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_aprovedlist = new ew.Form("ftes_aprovedlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = ftes_aprovedlist;
    ftes_aprovedlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("ftes_aprovedlist");
});
var ftes_aprovedsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    ftes_aprovedsrch = new ew.Form("ftes_aprovedsrch", "list");
    currentSearchForm = ftes_aprovedsrch;

    // Dynamic selection lists

    // Filters
    ftes_aprovedsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("ftes_aprovedsrch");
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
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="ftes_aprovedsrch" id="ftes_aprovedsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="ftes_aprovedsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tes_aproved">
<div class="ew-extended-search container-fluid">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="ftes_aprovedsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="ftes_aprovedsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="ftes_aprovedsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="ftes_aprovedsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> tes_aproved">
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
<form name="ftes_aprovedlist" id="ftes_aprovedlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_aproved">
<div id="gmp_tes_aproved" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_tes_aprovedlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_tes_aproved_id" class="tes_aproved_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->resultAmountId->Visible) { // resultAmountId ?>
        <th data-name="resultAmountId" class="<?= $Page->resultAmountId->headerCellClass() ?>"><div id="elh_tes_aproved_resultAmountId" class="tes_aproved_resultAmountId"><?= $Page->renderFieldHeader($Page->resultAmountId) ?></div></th>
<?php } ?>
<?php if ($Page->federationId->Visible) { // federationId ?>
        <th data-name="federationId" class="<?= $Page->federationId->headerCellClass() ?>"><div id="elh_tes_aproved_federationId" class="tes_aproved_federationId"><?= $Page->renderFieldHeader($Page->federationId) ?></div></th>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <th data-name="schoolId" class="<?= $Page->schoolId->headerCellClass() ?>"><div id="elh_tes_aproved_schoolId" class="tes_aproved_schoolId"><?= $Page->renderFieldHeader($Page->schoolId) ?></div></th>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
        <th data-name="testId" class="<?= $Page->testId->headerCellClass() ?>"><div id="elh_tes_aproved_testId" class="tes_aproved_testId"><?= $Page->renderFieldHeader($Page->testId) ?></div></th>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
        <th data-name="memberId" class="<?= $Page->memberId->headerCellClass() ?>"><div id="elh_tes_aproved_memberId" class="tes_aproved_memberId"><?= $Page->renderFieldHeader($Page->memberId) ?></div></th>
<?php } ?>
<?php if ($Page->memberName->Visible) { // memberName ?>
        <th data-name="memberName" class="<?= $Page->memberName->headerCellClass() ?>"><div id="elh_tes_aproved_memberName" class="tes_aproved_memberName"><?= $Page->renderFieldHeader($Page->memberName) ?></div></th>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <th data-name="createUserId" class="<?= $Page->createUserId->headerCellClass() ?>"><div id="elh_tes_aproved_createUserId" class="tes_aproved_createUserId"><?= $Page->renderFieldHeader($Page->createUserId) ?></div></th>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <th data-name="createDate" class="<?= $Page->createDate->headerCellClass() ?>"><div id="elh_tes_aproved_createDate" class="tes_aproved_createDate"><?= $Page->renderFieldHeader($Page->createDate) ?></div></th>
<?php } ?>
<?php if ($Page->newRankId->Visible) { // newRankId ?>
        <th data-name="newRankId" class="<?= $Page->newRankId->headerCellClass() ?>"><div id="elh_tes_aproved_newRankId" class="tes_aproved_newRankId"><?= $Page->renderFieldHeader($Page->newRankId) ?></div></th>
<?php } ?>
<?php if ($Page->oldRankId->Visible) { // oldRankId ?>
        <th data-name="oldRankId" class="<?= $Page->oldRankId->headerCellClass() ?>"><div id="elh_tes_aproved_oldRankId" class="tes_aproved_oldRankId"><?= $Page->renderFieldHeader($Page->oldRankId) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_tes_aproved",
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
<span id="el<?= $Page->RowCount ?>_tes_aproved_id" class="el_tes_aproved_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->resultAmountId->Visible) { // resultAmountId ?>
        <td data-name="resultAmountId"<?= $Page->resultAmountId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_resultAmountId" class="el_tes_aproved_resultAmountId">
<span<?= $Page->resultAmountId->viewAttributes() ?>>
<?= $Page->resultAmountId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->federationId->Visible) { // federationId ?>
        <td data-name="federationId"<?= $Page->federationId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_federationId" class="el_tes_aproved_federationId">
<span<?= $Page->federationId->viewAttributes() ?>>
<?= $Page->federationId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->schoolId->Visible) { // schoolId ?>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_schoolId" class="el_tes_aproved_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->testId->Visible) { // testId ?>
        <td data-name="testId"<?= $Page->testId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_testId" class="el_tes_aproved_testId">
<span<?= $Page->testId->viewAttributes() ?>>
<?= $Page->testId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->memberId->Visible) { // memberId ?>
        <td data-name="memberId"<?= $Page->memberId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_memberId" class="el_tes_aproved_memberId">
<span<?= $Page->memberId->viewAttributes() ?>>
<?= $Page->memberId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->memberName->Visible) { // memberName ?>
        <td data-name="memberName"<?= $Page->memberName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_memberName" class="el_tes_aproved_memberName">
<span<?= $Page->memberName->viewAttributes() ?>>
<?= $Page->memberName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->createUserId->Visible) { // createUserId ?>
        <td data-name="createUserId"<?= $Page->createUserId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_createUserId" class="el_tes_aproved_createUserId">
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->createDate->Visible) { // createDate ?>
        <td data-name="createDate"<?= $Page->createDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_createDate" class="el_tes_aproved_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->newRankId->Visible) { // newRankId ?>
        <td data-name="newRankId"<?= $Page->newRankId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_newRankId" class="el_tes_aproved_newRankId">
<span<?= $Page->newRankId->viewAttributes() ?>>
<?= $Page->newRankId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->oldRankId->Visible) { // oldRankId ?>
        <td data-name="oldRankId"<?= $Page->oldRankId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_aproved_oldRankId" class="el_tes_aproved_oldRankId">
<span<?= $Page->oldRankId->viewAttributes() ?>>
<?= $Page->oldRankId->getViewValue() ?></span>
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
    ew.addEventHandlers("tes_aproved");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
