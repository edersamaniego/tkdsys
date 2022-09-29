<?php

namespace PHPMaker2022\school;

// Page object
$ViewTestAprovedsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { view_test_aproveds: currentTable } });
var currentForm, currentPageID;
var fview_test_aprovedslist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fview_test_aprovedslist = new ew.Form("fview_test_aprovedslist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fview_test_aprovedslist;
    fview_test_aprovedslist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("fview_test_aprovedslist");
});
var fview_test_aprovedssrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fview_test_aprovedssrch = new ew.Form("fview_test_aprovedssrch", "list");
    currentSearchForm = fview_test_aprovedssrch;

    // Add fields
    var fields = currentTable.fields;
    fview_test_aprovedssrch.addFields([
        ["id", [], fields.id.isInvalid],
        ["memberId", [ew.Validators.integer], fields.memberId.isInvalid],
        ["nextRankId", [], fields.nextRankId.isInvalid],
        ["memberAge", [], fields.memberAge.isInvalid],
        ["renew", [], fields.renew.isInvalid],
        ["memberDOB", [], fields.memberDOB.isInvalid]
    ]);

    // Validate form
    fview_test_aprovedssrch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm();

        // Validate fields
        if (!this.validateFields())
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    fview_test_aprovedssrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fview_test_aprovedssrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fview_test_aprovedssrch.lists.memberId = <?= $Page->memberId->toClientList($Page) ?>;
    fview_test_aprovedssrch.lists.nextRankId = <?= $Page->nextRankId->toClientList($Page) ?>;
    fview_test_aprovedssrch.lists.renew = <?= $Page->renew->toClientList($Page) ?>;

    // Filters
    fview_test_aprovedssrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fview_test_aprovedssrch");
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
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "tes_test") {
    if ($Page->MasterRecordExists) {
        include_once "views/TesTestMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fview_test_aprovedssrch" id="fview_test_aprovedssrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fview_test_aprovedssrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="view_test_aproveds">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->memberId->Visible) { // memberId ?>
<?php
if (!$Page->memberId->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_memberId" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->memberId->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->memberId->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_memberId" id="z_memberId" value="=">
</div>
        </div>
        <div id="el_view_test_aproveds_memberId" class="ew-search-field">
<?php
$onchange = $Page->memberId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->memberId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->memberId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x_memberId" class="ew-auto-suggest">
    <input type="<?= $Page->memberId->getInputTextType() ?>" class="form-control" name="sv_x_memberId" id="sv_x_memberId" value="<?= RemoveHtml($Page->memberId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->memberId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->memberId->getPlaceHolder()) ?>"<?= $Page->memberId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="view_test_aproveds" data-field="x_memberId" data-input="sv_x_memberId" data-value-separator="<?= $Page->memberId->displayValueSeparatorAttribute() ?>" name="x_memberId" id="x_memberId" value="<?= HtmlEncode($Page->memberId->AdvancedSearch->SearchValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Page->memberId->getErrorMessage(false) ?></div>
<script>
loadjs.ready("fview_test_aprovedssrch", function() {
    fview_test_aprovedssrch.createAutoSuggest(Object.assign({"id":"x_memberId","forceSelect":false}, ew.vars.tables.view_test_aproveds.fields.memberId.autoSuggestOptions));
});
</script>
<?= $Page->memberId->Lookup->getParamTag($Page, "p_x_memberId") ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->nextRankId->Visible) { // nextRankId ?>
<?php
if (!$Page->nextRankId->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_nextRankId" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->nextRankId->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_nextRankId" class="ew-search-caption ew-label"><?= $Page->nextRankId->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_nextRankId" id="z_nextRankId" value="=">
</div>
        </div>
        <div id="el_view_test_aproveds_nextRankId" class="ew-search-field">
    <select
        id="x_nextRankId"
        name="x_nextRankId"
        class="form-select ew-select<?= $Page->nextRankId->isInvalidClass() ?>"
        data-select2-id="fview_test_aprovedssrch_x_nextRankId"
        data-table="view_test_aproveds"
        data-field="x_nextRankId"
        data-value-separator="<?= $Page->nextRankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->nextRankId->getPlaceHolder()) ?>"
        <?= $Page->nextRankId->editAttributes() ?>>
        <?= $Page->nextRankId->selectOptionListHtml("x_nextRankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->nextRankId->getErrorMessage(false) ?></div>
<?= $Page->nextRankId->Lookup->getParamTag($Page, "p_x_nextRankId") ?>
<script>
loadjs.ready("fview_test_aprovedssrch", function() {
    var options = { name: "x_nextRankId", selectId: "fview_test_aprovedssrch_x_nextRankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_test_aprovedssrch.lists.nextRankId.lookupOptions.length) {
        options.data = { id: "x_nextRankId", form: "fview_test_aprovedssrch" };
    } else {
        options.ajax = { id: "x_nextRankId", form: "fview_test_aprovedssrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_test_aproveds.fields.nextRankId.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->renew->Visible) { // renew ?>
<?php
if (!$Page->renew->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_renew" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->renew->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->renew->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_renew" id="z_renew" value="=">
</div>
        </div>
        <div id="el_view_test_aproveds_renew" class="ew-search-field">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->renew->isInvalidClass() ?>" data-table="view_test_aproveds" data-field="x_renew" name="x_renew[]" id="x_renew_298001" value="1"<?= ConvertToBool($Page->renew->AdvancedSearch->SearchValue) ? " checked" : "" ?><?= $Page->renew->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->renew->getErrorMessage(false) ?></div>
</div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->SearchColumnCount > 0) { ?>
   <div class="col-sm-auto mb-3">
       <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
   </div>
<?php } ?>
</div><!-- /.row -->
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> view_test_aproveds">
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
<form name="fview_test_aprovedslist" id="fview_test_aprovedslist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="view_test_aproveds">
<?php if ($Page->getCurrentMasterTable() == "tes_test" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="tes_test">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->testId->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_view_test_aproveds" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_view_test_aprovedslist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_view_test_aproveds_id" class="view_test_aproveds_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
        <th data-name="memberId" class="<?= $Page->memberId->headerCellClass() ?>"><div id="elh_view_test_aproveds_memberId" class="view_test_aproveds_memberId"><?= $Page->renderFieldHeader($Page->memberId) ?></div></th>
<?php } ?>
<?php if ($Page->nextRankId->Visible) { // nextRankId ?>
        <th data-name="nextRankId" class="<?= $Page->nextRankId->headerCellClass() ?>"><div id="elh_view_test_aproveds_nextRankId" class="view_test_aproveds_nextRankId"><?= $Page->renderFieldHeader($Page->nextRankId) ?></div></th>
<?php } ?>
<?php if ($Page->memberAge->Visible) { // memberAge ?>
        <th data-name="memberAge" class="<?= $Page->memberAge->headerCellClass() ?>"><div id="elh_view_test_aproveds_memberAge" class="view_test_aproveds_memberAge"><?= $Page->renderFieldHeader($Page->memberAge) ?></div></th>
<?php } ?>
<?php if ($Page->renew->Visible) { // renew ?>
        <th data-name="renew" class="<?= $Page->renew->headerCellClass() ?>"><div id="elh_view_test_aproveds_renew" class="view_test_aproveds_renew"><?= $Page->renderFieldHeader($Page->renew) ?></div></th>
<?php } ?>
<?php if ($Page->memberDOB->Visible) { // memberDOB ?>
        <th data-name="memberDOB" class="<?= $Page->memberDOB->headerCellClass() ?>"><div id="elh_view_test_aproveds_memberDOB" class="view_test_aproveds_memberDOB"><?= $Page->renderFieldHeader($Page->memberDOB) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_view_test_aproveds",
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
<span id="el<?= $Page->RowCount ?>_view_test_aproveds_id" class="el_view_test_aproveds_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->memberId->Visible) { // memberId ?>
        <td data-name="memberId"<?= $Page->memberId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_test_aproveds_memberId" class="el_view_test_aproveds_memberId">
<span<?= $Page->memberId->viewAttributes() ?>>
<?php if (!EmptyString($Page->memberId->getViewValue()) && $Page->memberId->linkAttributes() != "") { ?>
<a<?= $Page->memberId->linkAttributes() ?>><?= $Page->memberId->getViewValue() ?></a>
<?php } else { ?>
<?= $Page->memberId->getViewValue() ?>
<?php } ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nextRankId->Visible) { // nextRankId ?>
        <td data-name="nextRankId"<?= $Page->nextRankId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_test_aproveds_nextRankId" class="el_view_test_aproveds_nextRankId">
<span<?= $Page->nextRankId->viewAttributes() ?>>
<?= $Page->nextRankId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->memberAge->Visible) { // memberAge ?>
        <td data-name="memberAge"<?= $Page->memberAge->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_test_aproveds_memberAge" class="el_view_test_aproveds_memberAge">
<span<?= $Page->memberAge->viewAttributes() ?>>
<?= $Page->memberAge->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->renew->Visible) { // renew ?>
        <td data-name="renew"<?= $Page->renew->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_test_aproveds_renew" class="el_view_test_aproveds_renew">
<span<?= $Page->renew->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_renew_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->renew->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->renew->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_renew_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->memberDOB->Visible) { // memberDOB ?>
        <td data-name="memberDOB"<?= $Page->memberDOB->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_view_test_aproveds_memberDOB" class="el_view_test_aproveds_memberDOB">
<span<?= $Page->memberDOB->viewAttributes() ?>>
<?= $Page->memberDOB->getViewValue() ?></span>
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
    ew.addEventHandlers("view_test_aproveds");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
