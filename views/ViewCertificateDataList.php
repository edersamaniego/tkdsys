<?php

namespace PHPMaker2022\school;

// Page object
$ViewCertificateDataList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_certificate_data: currentTable } });
var currentForm, currentPageID;
var fview_certificate_datalist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fview_certificate_datalist = new ew.Form("fview_certificate_datalist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fview_certificate_datalist;
    fview_certificate_datalist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fview_certificate_datalist");
});
var fview_certificate_datasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fview_certificate_datasrch = new ew.Form("fview_certificate_datasrch", "list");
    currentSearchForm = fview_certificate_datasrch;

    // Dynamic selection lists

    // Filters
    fview_certificate_datasrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fview_certificate_datasrch");
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
<form name="fview_certificate_datasrch" id="fview_certificate_datasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fview_certificate_datasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="view_certificate_data">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fview_certificate_datasrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fview_certificate_datasrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fview_certificate_datasrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fview_certificate_datasrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> view_certificate_data">
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
<form name="fview_certificate_datalist" id="fview_certificate_datalist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_certificate_data">
<div id="gmp_view_certificate_data" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_view_certificate_datalist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->testId->Visible) { // testId ?>
        <th data-name="testId" class="<?= $Page->testId->headerCellClass() ?>"><div id="elh_view_certificate_data_testId" class="view_certificate_data_testId"><?= $Page->renderFieldHeader($Page->testId) ?></div></th>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
        <th data-name="memberId" class="<?= $Page->memberId->headerCellClass() ?>"><div id="elh_view_certificate_data_memberId" class="view_certificate_data_memberId"><?= $Page->renderFieldHeader($Page->memberId) ?></div></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Page->name->headerCellClass() ?>"><div id="elh_view_certificate_data_name" class="view_certificate_data_name"><?= $Page->renderFieldHeader($Page->name) ?></div></th>
<?php } ?>
<?php if ($Page->lastName->Visible) { // lastName ?>
        <th data-name="lastName" class="<?= $Page->lastName->headerCellClass() ?>"><div id="elh_view_certificate_data_lastName" class="view_certificate_data_lastName"><?= $Page->renderFieldHeader($Page->lastName) ?></div></th>
<?php } ?>
<?php if ($Page->actual->Visible) { // actual ?>
        <th data-name="actual" class="<?= $Page->actual->headerCellClass() ?>"><div id="elh_view_certificate_data_actual" class="view_certificate_data_actual"><?= $Page->renderFieldHeader($Page->actual) ?></div></th>
<?php } ?>
<?php if ($Page->next->Visible) { // next ?>
        <th data-name="next" class="<?= $Page->next->headerCellClass() ?>"><div id="elh_view_certificate_data_next" class="view_certificate_data_next"><?= $Page->renderFieldHeader($Page->next) ?></div></th>
<?php } ?>
<?php if ($Page->memberAge->Visible) { // memberAge ?>
        <th data-name="memberAge" class="<?= $Page->memberAge->headerCellClass() ?>"><div id="elh_view_certificate_data_memberAge" class="view_certificate_data_memberAge"><?= $Page->renderFieldHeader($Page->memberAge) ?></div></th>
<?php } ?>
<?php if ($Page->memberDOB->Visible) { // memberDOB ?>
        <th data-name="memberDOB" class="<?= $Page->memberDOB->headerCellClass() ?>"><div id="elh_view_certificate_data_memberDOB" class="view_certificate_data_memberDOB"><?= $Page->renderFieldHeader($Page->memberDOB) ?></div></th>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <th data-name="description" class="<?= $Page->description->headerCellClass() ?>"><div id="elh_view_certificate_data_description" class="view_certificate_data_description"><?= $Page->renderFieldHeader($Page->description) ?></div></th>
<?php } ?>
<?php if ($Page->instructorName->Visible) { // instructorName ?>
        <th data-name="instructorName" class="<?= $Page->instructorName->headerCellClass() ?>"><div id="elh_view_certificate_data_instructorName" class="view_certificate_data_instructorName"><?= $Page->renderFieldHeader($Page->instructorName) ?></div></th>
<?php } ?>
<?php if ($Page->instructorLastName->Visible) { // instructorLastName ?>
        <th data-name="instructorLastName" class="<?= $Page->instructorLastName->headerCellClass() ?>"><div id="elh_view_certificate_data_instructorLastName" class="view_certificate_data_instructorLastName"><?= $Page->renderFieldHeader($Page->instructorLastName) ?></div></th>
<?php } ?>
<?php if ($Page->auxiliarName->Visible) { // auxiliarName ?>
        <th data-name="auxiliarName" class="<?= $Page->auxiliarName->headerCellClass() ?>"><div id="elh_view_certificate_data_auxiliarName" class="view_certificate_data_auxiliarName"><?= $Page->renderFieldHeader($Page->auxiliarName) ?></div></th>
<?php } ?>
<?php if ($Page->auxiliarLastName->Visible) { // auxiliarLastName ?>
        <th data-name="auxiliarLastName" class="<?= $Page->auxiliarLastName->headerCellClass() ?>"><div id="elh_view_certificate_data_auxiliarLastName" class="view_certificate_data_auxiliarLastName"><?= $Page->renderFieldHeader($Page->auxiliarLastName) ?></div></th>
<?php } ?>
<?php if ($Page->testDate->Visible) { // testDate ?>
        <th data-name="testDate" class="<?= $Page->testDate->headerCellClass() ?>"><div id="elh_view_certificate_data_testDate" class="view_certificate_data_testDate"><?= $Page->renderFieldHeader($Page->testDate) ?></div></th>
<?php } ?>
<?php if ($Page->testTime->Visible) { // testTime ?>
        <th data-name="testTime" class="<?= $Page->testTime->headerCellClass() ?>"><div id="elh_view_certificate_data_testTime" class="view_certificate_data_testTime"><?= $Page->renderFieldHeader($Page->testTime) ?></div></th>
<?php } ?>
<?php if ($Page->ceremonyDate->Visible) { // ceremonyDate ?>
        <th data-name="ceremonyDate" class="<?= $Page->ceremonyDate->headerCellClass() ?>"><div id="elh_view_certificate_data_ceremonyDate" class="view_certificate_data_ceremonyDate"><?= $Page->renderFieldHeader($Page->ceremonyDate) ?></div></th>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
        <th data-name="city" class="<?= $Page->city->headerCellClass() ?>"><div id="elh_view_certificate_data_city" class="view_certificate_data_city"><?= $Page->renderFieldHeader($Page->city) ?></div></th>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
        <th data-name="uf" class="<?= $Page->uf->headerCellClass() ?>"><div id="elh_view_certificate_data_uf" class="view_certificate_data_uf"><?= $Page->renderFieldHeader($Page->uf) ?></div></th>
<?php } ?>
<?php if ($Page->instructorRanking->Visible) { // instructorRanking ?>
        <th data-name="instructorRanking" class="<?= $Page->instructorRanking->headerCellClass() ?>"><div id="elh_view_certificate_data_instructorRanking" class="view_certificate_data_instructorRanking"><?= $Page->renderFieldHeader($Page->instructorRanking) ?></div></th>
<?php } ?>
<?php if ($Page->auxiliarRanking->Visible) { // auxiliarRanking ?>
        <th data-name="auxiliarRanking" class="<?= $Page->auxiliarRanking->headerCellClass() ?>"><div id="elh_view_certificate_data_auxiliarRanking" class="view_certificate_data_auxiliarRanking"><?= $Page->renderFieldHeader($Page->auxiliarRanking) ?></div></th>
<?php } ?>
<?php if ($Page->certificateId->Visible) { // certificateId ?>
        <th data-name="certificateId" class="<?= $Page->certificateId->headerCellClass() ?>"><div id="elh_view_certificate_data_certificateId" class="view_certificate_data_certificateId"><?= $Page->renderFieldHeader($Page->certificateId) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_view_certificate_data",
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
    <?php if ($Page->testId->Visible) { // testId ?>
        <td data-name="testId"<?= $Page->testId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_testId" class="el_view_certificate_data_testId">
<span<?= $Page->testId->viewAttributes() ?>>
<?= $Page->testId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->memberId->Visible) { // memberId ?>
        <td data-name="memberId"<?= $Page->memberId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_memberId" class="el_view_certificate_data_memberId">
<span<?= $Page->memberId->viewAttributes() ?>>
<?= $Page->memberId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->name->Visible) { // name ?>
        <td data-name="name"<?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_name" class="el_view_certificate_data_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lastName->Visible) { // lastName ?>
        <td data-name="lastName"<?= $Page->lastName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_lastName" class="el_view_certificate_data_lastName">
<span<?= $Page->lastName->viewAttributes() ?>>
<?= $Page->lastName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->actual->Visible) { // actual ?>
        <td data-name="actual"<?= $Page->actual->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_actual" class="el_view_certificate_data_actual">
<span<?= $Page->actual->viewAttributes() ?>>
<?= $Page->actual->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->next->Visible) { // next ?>
        <td data-name="next"<?= $Page->next->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_next" class="el_view_certificate_data_next">
<span<?= $Page->next->viewAttributes() ?>>
<?= $Page->next->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->memberAge->Visible) { // memberAge ?>
        <td data-name="memberAge"<?= $Page->memberAge->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_memberAge" class="el_view_certificate_data_memberAge">
<span<?= $Page->memberAge->viewAttributes() ?>>
<?= $Page->memberAge->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->memberDOB->Visible) { // memberDOB ?>
        <td data-name="memberDOB"<?= $Page->memberDOB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_memberDOB" class="el_view_certificate_data_memberDOB">
<span<?= $Page->memberDOB->viewAttributes() ?>>
<?= $Page->memberDOB->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->description->Visible) { // description ?>
        <td data-name="description"<?= $Page->description->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_description" class="el_view_certificate_data_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->instructorName->Visible) { // instructorName ?>
        <td data-name="instructorName"<?= $Page->instructorName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_instructorName" class="el_view_certificate_data_instructorName">
<span<?= $Page->instructorName->viewAttributes() ?>>
<?= $Page->instructorName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->instructorLastName->Visible) { // instructorLastName ?>
        <td data-name="instructorLastName"<?= $Page->instructorLastName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_instructorLastName" class="el_view_certificate_data_instructorLastName">
<span<?= $Page->instructorLastName->viewAttributes() ?>>
<?= $Page->instructorLastName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->auxiliarName->Visible) { // auxiliarName ?>
        <td data-name="auxiliarName"<?= $Page->auxiliarName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_auxiliarName" class="el_view_certificate_data_auxiliarName">
<span<?= $Page->auxiliarName->viewAttributes() ?>>
<?= $Page->auxiliarName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->auxiliarLastName->Visible) { // auxiliarLastName ?>
        <td data-name="auxiliarLastName"<?= $Page->auxiliarLastName->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_auxiliarLastName" class="el_view_certificate_data_auxiliarLastName">
<span<?= $Page->auxiliarLastName->viewAttributes() ?>>
<?= $Page->auxiliarLastName->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->testDate->Visible) { // testDate ?>
        <td data-name="testDate"<?= $Page->testDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_testDate" class="el_view_certificate_data_testDate">
<span<?= $Page->testDate->viewAttributes() ?>>
<?= $Page->testDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->testTime->Visible) { // testTime ?>
        <td data-name="testTime"<?= $Page->testTime->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_testTime" class="el_view_certificate_data_testTime">
<span<?= $Page->testTime->viewAttributes() ?>>
<?= $Page->testTime->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ceremonyDate->Visible) { // ceremonyDate ?>
        <td data-name="ceremonyDate"<?= $Page->ceremonyDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_ceremonyDate" class="el_view_certificate_data_ceremonyDate">
<span<?= $Page->ceremonyDate->viewAttributes() ?>>
<?= $Page->ceremonyDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->city->Visible) { // city ?>
        <td data-name="city"<?= $Page->city->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_city" class="el_view_certificate_data_city">
<span<?= $Page->city->viewAttributes() ?>>
<?= $Page->city->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->uf->Visible) { // uf ?>
        <td data-name="uf"<?= $Page->uf->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_uf" class="el_view_certificate_data_uf">
<span<?= $Page->uf->viewAttributes() ?>>
<?= $Page->uf->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->instructorRanking->Visible) { // instructorRanking ?>
        <td data-name="instructorRanking"<?= $Page->instructorRanking->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_instructorRanking" class="el_view_certificate_data_instructorRanking">
<span<?= $Page->instructorRanking->viewAttributes() ?>>
<?= $Page->instructorRanking->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->auxiliarRanking->Visible) { // auxiliarRanking ?>
        <td data-name="auxiliarRanking"<?= $Page->auxiliarRanking->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_auxiliarRanking" class="el_view_certificate_data_auxiliarRanking">
<span<?= $Page->auxiliarRanking->viewAttributes() ?>>
<?= $Page->auxiliarRanking->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->certificateId->Visible) { // certificateId ?>
        <td data-name="certificateId"<?= $Page->certificateId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_certificate_data_certificateId" class="el_view_certificate_data_certificateId">
<span<?= $Page->certificateId->viewAttributes() ?>>
<?= $Page->certificateId->getViewValue() ?></span>
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
    ew.addEventHandlers("view_certificate_data");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
