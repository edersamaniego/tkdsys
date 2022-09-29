<?php

namespace PHPMaker2022\school;

// Page object
$TesTestJudgeList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_test_judge: currentTable } });
var currentForm, currentPageID;
var ftes_test_judgelist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_test_judgelist = new ew.Form("ftes_test_judgelist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = ftes_test_judgelist;
    ftes_test_judgelist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("ftes_test_judgelist");
});
var ftes_test_judgesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    ftes_test_judgesrch = new ew.Form("ftes_test_judgesrch", "list");
    currentSearchForm = ftes_test_judgesrch;

    // Dynamic selection lists

    // Filters
    ftes_test_judgesrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("ftes_test_judgesrch");
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
<form name="ftes_test_judgesrch" id="ftes_test_judgesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="ftes_test_judgesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tes_test_judge">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="ftes_test_judgesrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="ftes_test_judgesrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="ftes_test_judgesrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="ftes_test_judgesrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> tes_test_judge">
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
<form name="ftes_test_judgelist" id="ftes_test_judgelist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_test_judge">
<div id="gmp_tes_test_judge" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_tes_test_judgelist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_tes_test_judge_id" class="tes_test_judge_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->judgeMemberId->Visible) { // judgeMemberId ?>
        <th data-name="judgeMemberId" class="<?= $Page->judgeMemberId->headerCellClass() ?>"><div id="elh_tes_test_judge_judgeMemberId" class="tes_test_judge_judgeMemberId"><?= $Page->renderFieldHeader($Page->judgeMemberId) ?></div></th>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
        <th data-name="testId" class="<?= $Page->testId->headerCellClass() ?>"><div id="elh_tes_test_judge_testId" class="tes_test_judge_testId"><?= $Page->renderFieldHeader($Page->testId) ?></div></th>
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
        <th data-name="rankId" class="<?= $Page->rankId->headerCellClass() ?>"><div id="elh_tes_test_judge_rankId" class="tes_test_judge_rankId"><?= $Page->renderFieldHeader($Page->rankId) ?></div></th>
<?php } ?>
<?php if ($Page->instructorRegister->Visible) { // instructorRegister ?>
        <th data-name="instructorRegister" class="<?= $Page->instructorRegister->headerCellClass() ?>"><div id="elh_tes_test_judge_instructorRegister" class="tes_test_judge_instructorRegister"><?= $Page->renderFieldHeader($Page->instructorRegister) ?></div></th>
<?php } ?>
<?php if ($Page->federationRegister->Visible) { // federationRegister ?>
        <th data-name="federationRegister" class="<?= $Page->federationRegister->headerCellClass() ?>"><div id="elh_tes_test_judge_federationRegister" class="tes_test_judge_federationRegister"><?= $Page->renderFieldHeader($Page->federationRegister) ?></div></th>
<?php } ?>
<?php if ($Page->memberCityId->Visible) { // memberCityId ?>
        <th data-name="memberCityId" class="<?= $Page->memberCityId->headerCellClass() ?>"><div id="elh_tes_test_judge_memberCityId" class="tes_test_judge_memberCityId"><?= $Page->renderFieldHeader($Page->memberCityId) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_tes_test_judge",
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
<span id="el<?= $Page->RowCount ?>_tes_test_judge_id" class="el_tes_test_judge_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->judgeMemberId->Visible) { // judgeMemberId ?>
        <td data-name="judgeMemberId"<?= $Page->judgeMemberId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_judge_judgeMemberId" class="el_tes_test_judge_judgeMemberId">
<span<?= $Page->judgeMemberId->viewAttributes() ?>>
<?= $Page->judgeMemberId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->testId->Visible) { // testId ?>
        <td data-name="testId"<?= $Page->testId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_judge_testId" class="el_tes_test_judge_testId">
<span<?= $Page->testId->viewAttributes() ?>>
<?= $Page->testId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->rankId->Visible) { // rankId ?>
        <td data-name="rankId"<?= $Page->rankId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_judge_rankId" class="el_tes_test_judge_rankId">
<span<?= $Page->rankId->viewAttributes() ?>>
<?= $Page->rankId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->instructorRegister->Visible) { // instructorRegister ?>
        <td data-name="instructorRegister"<?= $Page->instructorRegister->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_judge_instructorRegister" class="el_tes_test_judge_instructorRegister">
<span<?= $Page->instructorRegister->viewAttributes() ?>>
<?= $Page->instructorRegister->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->federationRegister->Visible) { // federationRegister ?>
        <td data-name="federationRegister"<?= $Page->federationRegister->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_judge_federationRegister" class="el_tes_test_judge_federationRegister">
<span<?= $Page->federationRegister->viewAttributes() ?>>
<?= $Page->federationRegister->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->memberCityId->Visible) { // memberCityId ?>
        <td data-name="memberCityId"<?= $Page->memberCityId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_judge_memberCityId" class="el_tes_test_judge_memberCityId">
<span<?= $Page->memberCityId->viewAttributes() ?>>
<?= $Page->memberCityId->getViewValue() ?></span>
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
    ew.addEventHandlers("tes_test_judge");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
