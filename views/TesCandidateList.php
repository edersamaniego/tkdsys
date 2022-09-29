<?php

namespace PHPMaker2022\school;

// Page object
$TesCandidateList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_candidate: currentTable } });
var currentForm, currentPageID;
var ftes_candidatelist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_candidatelist = new ew.Form("ftes_candidatelist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = ftes_candidatelist;
    ftes_candidatelist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";

    // Add fields
    var fields = currentTable.fields;
    ftes_candidatelist.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["memberId", [fields.memberId.visible && fields.memberId.required ? ew.Validators.required(fields.memberId.caption) : null, ew.Validators.integer], fields.memberId.isInvalid],
        ["rankId", [fields.rankId.visible && fields.rankId.required ? ew.Validators.required(fields.rankId.caption) : null], fields.rankId.isInvalid],
        ["testNominated", [fields.testNominated.visible && fields.testNominated.required ? ew.Validators.required(fields.testNominated.caption) : null], fields.testNominated.isInvalid],
        ["testPaid", [fields.testPaid.visible && fields.testPaid.required ? ew.Validators.required(fields.testPaid.caption) : null], fields.testPaid.isInvalid],
        ["result", [fields.result.visible && fields.result.required ? ew.Validators.required(fields.result.caption) : null], fields.result.isInvalid],
        ["nextRankId", [fields.nextRankId.visible && fields.nextRankId.required ? ew.Validators.required(fields.nextRankId.caption) : null], fields.nextRankId.isInvalid],
        ["memberAge", [fields.memberAge.visible && fields.memberAge.required ? ew.Validators.required(fields.memberAge.caption) : null, ew.Validators.integer], fields.memberAge.isInvalid]
    ]);

    // Check empty row
    ftes_candidatelist.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["memberId",false],["rankId",false],["testNominated[]",true],["testPaid[]",true],["result[]",true],["nextRankId",false],["memberAge",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    ftes_candidatelist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftes_candidatelist.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ftes_candidatelist.lists.memberId = <?= $Page->memberId->toClientList($Page) ?>;
    ftes_candidatelist.lists.rankId = <?= $Page->rankId->toClientList($Page) ?>;
    ftes_candidatelist.lists.testNominated = <?= $Page->testNominated->toClientList($Page) ?>;
    ftes_candidatelist.lists.testPaid = <?= $Page->testPaid->toClientList($Page) ?>;
    ftes_candidatelist.lists.result = <?= $Page->result->toClientList($Page) ?>;
    ftes_candidatelist.lists.nextRankId = <?= $Page->nextRankId->toClientList($Page) ?>;
    loadjs.done("ftes_candidatelist");
});
var ftes_candidatesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    ftes_candidatesrch = new ew.Form("ftes_candidatesrch", "list");
    currentSearchForm = ftes_candidatesrch;

    // Add fields
    var fields = currentTable.fields;
    ftes_candidatesrch.addFields([
        ["id", [], fields.id.isInvalid],
        ["memberId", [ew.Validators.integer], fields.memberId.isInvalid],
        ["rankId", [], fields.rankId.isInvalid],
        ["testNominated", [], fields.testNominated.isInvalid],
        ["testPaid", [], fields.testPaid.isInvalid],
        ["result", [], fields.result.isInvalid],
        ["nextRankId", [], fields.nextRankId.isInvalid],
        ["memberAge", [ew.Validators.integer], fields.memberAge.isInvalid]
    ]);

    // Validate form
    ftes_candidatesrch.validate = function () {
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
    ftes_candidatesrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftes_candidatesrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ftes_candidatesrch.lists.memberId = <?= $Page->memberId->toClientList($Page) ?>;
    ftes_candidatesrch.lists.rankId = <?= $Page->rankId->toClientList($Page) ?>;
    ftes_candidatesrch.lists.testPaid = <?= $Page->testPaid->toClientList($Page) ?>;
    ftes_candidatesrch.lists.result = <?= $Page->result->toClientList($Page) ?>;

    // Filters
    ftes_candidatesrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("ftes_candidatesrch");
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
<form name="ftes_candidatesrch" id="ftes_candidatesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="ftes_candidatesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tes_candidate">
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
        <div id="el_tes_candidate_memberId" class="ew-search-field">
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
<selection-list hidden class="form-control" data-table="tes_candidate" data-field="x_memberId" data-input="sv_x_memberId" data-value-separator="<?= $Page->memberId->displayValueSeparatorAttribute() ?>" name="x_memberId" id="x_memberId" value="<?= HtmlEncode($Page->memberId->AdvancedSearch->SearchValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Page->memberId->getErrorMessage(false) ?></div>
<script>
loadjs.ready("ftes_candidatesrch", function() {
    ftes_candidatesrch.createAutoSuggest(Object.assign({"id":"x_memberId","forceSelect":true}, ew.vars.tables.tes_candidate.fields.memberId.autoSuggestOptions));
});
</script>
<?= $Page->memberId->Lookup->getParamTag($Page, "p_x_memberId") ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
<?php
if (!$Page->rankId->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_rankId" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->rankId->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_rankId" class="ew-search-caption ew-label"><?= $Page->rankId->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_rankId" id="z_rankId" value="=">
</div>
        </div>
        <div id="el_tes_candidate_rankId" class="ew-search-field">
    <select
        id="x_rankId"
        name="x_rankId"
        class="form-select ew-select<?= $Page->rankId->isInvalidClass() ?>"
        data-select2-id="ftes_candidatesrch_x_rankId"
        data-table="tes_candidate"
        data-field="x_rankId"
        data-value-separator="<?= $Page->rankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->rankId->getPlaceHolder()) ?>"
        <?= $Page->rankId->editAttributes() ?>>
        <?= $Page->rankId->selectOptionListHtml("x_rankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->rankId->getErrorMessage(false) ?></div>
<?= $Page->rankId->Lookup->getParamTag($Page, "p_x_rankId") ?>
<script>
loadjs.ready("ftes_candidatesrch", function() {
    var options = { name: "x_rankId", selectId: "ftes_candidatesrch_x_rankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_candidatesrch.lists.rankId.lookupOptions.length) {
        options.data = { id: "x_rankId", form: "ftes_candidatesrch" };
    } else {
        options.ajax = { id: "x_rankId", form: "ftes_candidatesrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_candidate.fields.rankId.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->testPaid->Visible) { // testPaid ?>
<?php
if (!$Page->testPaid->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_testPaid" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->testPaid->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->testPaid->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_testPaid" id="z_testPaid" value="=">
</div>
        </div>
        <div id="el_tes_candidate_testPaid" class="ew-search-field">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->testPaid->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_testPaid" name="x_testPaid[]" id="x_testPaid_492772" value="1"<?= ConvertToBool($Page->testPaid->AdvancedSearch->SearchValue) ? " checked" : "" ?><?= $Page->testPaid->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->testPaid->getErrorMessage(false) ?></div>
</div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->result->Visible) { // result ?>
<?php
if (!$Page->result->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_result" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->result->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->result->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_result" id="z_result" value="=">
</div>
        </div>
        <div id="el_tes_candidate_result" class="ew-search-field">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->result->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_result" name="x_result[]" id="x_result_793875" value="1"<?= ConvertToBool($Page->result->AdvancedSearch->SearchValue) ? " checked" : "" ?><?= $Page->result->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->result->getErrorMessage(false) ?></div>
</div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->memberAge->Visible) { // memberAge ?>
<?php
if (!$Page->memberAge->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_memberAge" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->memberAge->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_memberAge" class="ew-search-caption ew-label"><?= $Page->memberAge->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_memberAge" id="z_memberAge" value="=">
</div>
        </div>
        <div id="el_tes_candidate_memberAge" class="ew-search-field">
<input type="<?= $Page->memberAge->getInputTextType() ?>" name="x_memberAge" id="x_memberAge" data-table="tes_candidate" data-field="x_memberAge" value="<?= $Page->memberAge->EditValue ?>" size="4" placeholder="<?= HtmlEncode($Page->memberAge->getPlaceHolder()) ?>"<?= $Page->memberAge->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->memberAge->getErrorMessage(false) ?></div>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> tes_candidate">
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
<form name="ftes_candidatelist" id="ftes_candidatelist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_candidate">
<?php if ($Page->getCurrentMasterTable() == "tes_test" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="tes_test">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->testId->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_tes_candidate" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_tes_candidatelist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_tes_candidate_id" class="tes_candidate_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->memberId->Visible) { // memberId ?>
        <th data-name="memberId" class="<?= $Page->memberId->headerCellClass() ?>"><div id="elh_tes_candidate_memberId" class="tes_candidate_memberId"><?= $Page->renderFieldHeader($Page->memberId) ?></div></th>
<?php } ?>
<?php if ($Page->rankId->Visible) { // rankId ?>
        <th data-name="rankId" class="<?= $Page->rankId->headerCellClass() ?>"><div id="elh_tes_candidate_rankId" class="tes_candidate_rankId"><?= $Page->renderFieldHeader($Page->rankId) ?></div></th>
<?php } ?>
<?php if ($Page->testNominated->Visible) { // testNominated ?>
        <th data-name="testNominated" class="<?= $Page->testNominated->headerCellClass() ?>"><div id="elh_tes_candidate_testNominated" class="tes_candidate_testNominated"><?= $Page->renderFieldHeader($Page->testNominated) ?></div></th>
<?php } ?>
<?php if ($Page->testPaid->Visible) { // testPaid ?>
        <th data-name="testPaid" class="<?= $Page->testPaid->headerCellClass() ?>"><div id="elh_tes_candidate_testPaid" class="tes_candidate_testPaid"><?= $Page->renderFieldHeader($Page->testPaid) ?></div></th>
<?php } ?>
<?php if ($Page->result->Visible) { // result ?>
        <th data-name="result" class="<?= $Page->result->headerCellClass() ?>"><div id="elh_tes_candidate_result" class="tes_candidate_result"><?= $Page->renderFieldHeader($Page->result) ?></div></th>
<?php } ?>
<?php if ($Page->nextRankId->Visible) { // nextRankId ?>
        <th data-name="nextRankId" class="<?= $Page->nextRankId->headerCellClass() ?>"><div id="elh_tes_candidate_nextRankId" class="tes_candidate_nextRankId"><?= $Page->renderFieldHeader($Page->nextRankId) ?></div></th>
<?php } ?>
<?php if ($Page->memberAge->Visible) { // memberAge ?>
        <th data-name="memberAge" class="<?= $Page->memberAge->headerCellClass() ?>"><div id="elh_tes_candidate_memberAge" class="tes_candidate_memberAge"><?= $Page->renderFieldHeader($Page->memberAge) ?></div></th>
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

// Restore number of post back records
if ($CurrentForm && ($Page->isConfirm() || $Page->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Page->FormKeyCountName) && ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm())) {
        $Page->KeyCount = $CurrentForm->getValue($Page->FormKeyCountName);
        $Page->StopRecord = $Page->StartRecord + $Page->KeyCount - 1;
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
$Page->EditRowCount = 0;
if ($Page->isEdit()) {
    $Page->RowIndex = 1;
}
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;
        if ($Page->isAdd() || $Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm()) {
            $Page->RowIndex++;
            $CurrentForm->Index = $Page->RowIndex;
            if ($CurrentForm->hasValue($Page->FormActionName) && ($Page->isConfirm() || $Page->EventCancelled)) {
                $Page->RowAction = strval($CurrentForm->getValue($Page->FormActionName));
            } elseif ($Page->isGridAdd()) {
                $Page->RowAction = "insert";
            } else {
                $Page->RowAction = "";
            }
        }

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
        if ($Page->isGridAdd()) { // Grid add
            $Page->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Page->isGridAdd() && $Page->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->isEdit()) {
            if ($Page->checkInlineEditKey() && $Page->EditRowCount == 0) { // Inline edit
                $Page->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Page->isGridEdit()) { // Grid edit
            if ($Page->EventCancelled) {
                $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
            }
            if ($Page->RowAction == "insert") {
                $Page->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Page->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Page->isEdit() && $Page->RowType == ROWTYPE_EDIT && $Page->EventCancelled) { // Update failed
            $CurrentForm->Index = 1;
            $Page->restoreFormValues(); // Restore form values
        }
        if ($Page->isGridEdit() && ($Page->RowType == ROWTYPE_EDIT || $Page->RowType == ROWTYPE_ADD) && $Page->EventCancelled) { // Update failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->RowType == ROWTYPE_EDIT) { // Edit row
            $Page->EditRowCount++;
        }

        // Set up row attributes
        $Page->RowAttrs->merge([
            "data-rowindex" => $Page->RowCount,
            "id" => "r" . $Page->RowCount . "_tes_candidate",
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

        // Skip delete row / empty row for confirm page
        if (
            $Page->RowAction != "delete" &&
            $Page->RowAction != "insertdelete" &&
            !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())
        ) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_id" class="el_tes_candidate_id"></span>
<input type="hidden" data-table="tes_candidate" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_id" class="el_tes_candidate_id">
<span<?= $Page->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id->getDisplayValue($Page->id->EditValue))) ?>"></span>
<input type="hidden" data-table="tes_candidate" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_id" class="el_tes_candidate_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="tes_candidate" data-field="x_id" data-hidden="1" name="x<?= $Page->RowIndex ?>_id" id="x<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->memberId->Visible) { // memberId ?>
        <td data-name="memberId"<?= $Page->memberId->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_memberId" class="el_tes_candidate_memberId">
<?php
$onchange = $Page->memberId->EditAttrs->prepend("onchange", "ew.autoFill(this);");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->memberId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->memberId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Page->RowIndex ?>_memberId" class="ew-auto-suggest">
    <input type="<?= $Page->memberId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_memberId" id="sv_x<?= $Page->RowIndex ?>_memberId" value="<?= RemoveHtml($Page->memberId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->memberId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->memberId->getPlaceHolder()) ?>"<?= $Page->memberId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="tes_candidate" data-field="x_memberId" data-input="sv_x<?= $Page->RowIndex ?>_memberId" data-value-separator="<?= $Page->memberId->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_memberId" id="x<?= $Page->RowIndex ?>_memberId" value="<?= HtmlEncode($Page->memberId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Page->memberId->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_candidatelist", function() {
    ftes_candidatelist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_memberId","forceSelect":true}, ew.vars.tables.tes_candidate.fields.memberId.autoSuggestOptions));
});
</script>
<?= $Page->memberId->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_memberId") ?>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_memberId" data-hidden="1" name="o<?= $Page->RowIndex ?>_memberId" id="o<?= $Page->RowIndex ?>_memberId" value="<?= HtmlEncode($Page->memberId->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_memberId" class="el_tes_candidate_memberId">
<?php
$onchange = $Page->memberId->EditAttrs->prepend("onchange", "ew.autoFill(this);");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->memberId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->memberId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Page->RowIndex ?>_memberId" class="ew-auto-suggest">
    <input type="<?= $Page->memberId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_memberId" id="sv_x<?= $Page->RowIndex ?>_memberId" value="<?= RemoveHtml($Page->memberId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->memberId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->memberId->getPlaceHolder()) ?>"<?= $Page->memberId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="tes_candidate" data-field="x_memberId" data-input="sv_x<?= $Page->RowIndex ?>_memberId" data-value-separator="<?= $Page->memberId->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_memberId" id="x<?= $Page->RowIndex ?>_memberId" value="<?= HtmlEncode($Page->memberId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Page->memberId->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_candidatelist", function() {
    ftes_candidatelist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_memberId","forceSelect":true}, ew.vars.tables.tes_candidate.fields.memberId.autoSuggestOptions));
});
</script>
<?= $Page->memberId->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_memberId") ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_memberId" class="el_tes_candidate_memberId">
<span<?= $Page->memberId->viewAttributes() ?>>
<?= $Page->memberId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->rankId->Visible) { // rankId ?>
        <td data-name="rankId"<?= $Page->rankId->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_rankId" class="el_tes_candidate_rankId">
<?php $Page->rankId->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_rankId"
        name="x<?= $Page->RowIndex ?>_rankId"
        class="form-select ew-select<?= $Page->rankId->isInvalidClass() ?>"
        data-select2-id="ftes_candidatelist_x<?= $Page->RowIndex ?>_rankId"
        data-table="tes_candidate"
        data-field="x_rankId"
        data-value-separator="<?= $Page->rankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->rankId->getPlaceHolder()) ?>"
        <?= $Page->rankId->editAttributes() ?>>
        <?= $Page->rankId->selectOptionListHtml("x{$Page->RowIndex}_rankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->rankId->getErrorMessage() ?></div>
<?= $Page->rankId->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_rankId") ?>
<script>
loadjs.ready("ftes_candidatelist", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_rankId", selectId: "ftes_candidatelist_x<?= $Page->RowIndex ?>_rankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_candidatelist.lists.rankId.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_rankId", form: "ftes_candidatelist" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_rankId", form: "ftes_candidatelist", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_candidate.fields.rankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_rankId" data-hidden="1" name="o<?= $Page->RowIndex ?>_rankId" id="o<?= $Page->RowIndex ?>_rankId" value="<?= HtmlEncode($Page->rankId->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_rankId" class="el_tes_candidate_rankId">
<?php $Page->rankId->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_rankId"
        name="x<?= $Page->RowIndex ?>_rankId"
        class="form-select ew-select<?= $Page->rankId->isInvalidClass() ?>"
        data-select2-id="ftes_candidatelist_x<?= $Page->RowIndex ?>_rankId"
        data-table="tes_candidate"
        data-field="x_rankId"
        data-value-separator="<?= $Page->rankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->rankId->getPlaceHolder()) ?>"
        <?= $Page->rankId->editAttributes() ?>>
        <?= $Page->rankId->selectOptionListHtml("x{$Page->RowIndex}_rankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->rankId->getErrorMessage() ?></div>
<?= $Page->rankId->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_rankId") ?>
<script>
loadjs.ready("ftes_candidatelist", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_rankId", selectId: "ftes_candidatelist_x<?= $Page->RowIndex ?>_rankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_candidatelist.lists.rankId.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_rankId", form: "ftes_candidatelist" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_rankId", form: "ftes_candidatelist", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_candidate.fields.rankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_rankId" class="el_tes_candidate_rankId">
<span<?= $Page->rankId->viewAttributes() ?>>
<?= $Page->rankId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->testNominated->Visible) { // testNominated ?>
        <td data-name="testNominated"<?= $Page->testNominated->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_testNominated" class="el_tes_candidate_testNominated">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->testNominated->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_testNominated" name="x<?= $Page->RowIndex ?>_testNominated[]" id="x<?= $Page->RowIndex ?>_testNominated_813570" value="1"<?= ConvertToBool($Page->testNominated->CurrentValue) ? " checked" : "" ?><?= $Page->testNominated->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->testNominated->getErrorMessage() ?></div>
</div>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_testNominated" data-hidden="1" name="o<?= $Page->RowIndex ?>_testNominated[]" id="o<?= $Page->RowIndex ?>_testNominated[]" value="<?= HtmlEncode($Page->testNominated->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_testNominated" class="el_tes_candidate_testNominated">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->testNominated->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_testNominated" name="x<?= $Page->RowIndex ?>_testNominated[]" id="x<?= $Page->RowIndex ?>_testNominated_559566" value="1"<?= ConvertToBool($Page->testNominated->CurrentValue) ? " checked" : "" ?><?= $Page->testNominated->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->testNominated->getErrorMessage() ?></div>
</div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_testNominated" class="el_tes_candidate_testNominated">
<span<?= $Page->testNominated->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_testNominated_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->testNominated->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->testNominated->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_testNominated_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->testPaid->Visible) { // testPaid ?>
        <td data-name="testPaid"<?= $Page->testPaid->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_testPaid" class="el_tes_candidate_testPaid">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->testPaid->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_testPaid" name="x<?= $Page->RowIndex ?>_testPaid[]" id="x<?= $Page->RowIndex ?>_testPaid_889052" value="1"<?= ConvertToBool($Page->testPaid->CurrentValue) ? " checked" : "" ?><?= $Page->testPaid->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->testPaid->getErrorMessage() ?></div>
</div>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_testPaid" data-hidden="1" name="o<?= $Page->RowIndex ?>_testPaid[]" id="o<?= $Page->RowIndex ?>_testPaid[]" value="<?= HtmlEncode($Page->testPaid->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_testPaid" class="el_tes_candidate_testPaid">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->testPaid->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_testPaid" name="x<?= $Page->RowIndex ?>_testPaid[]" id="x<?= $Page->RowIndex ?>_testPaid_138413" value="1"<?= ConvertToBool($Page->testPaid->CurrentValue) ? " checked" : "" ?><?= $Page->testPaid->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->testPaid->getErrorMessage() ?></div>
</div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_testPaid" class="el_tes_candidate_testPaid">
<span<?= $Page->testPaid->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_testPaid_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->testPaid->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->testPaid->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_testPaid_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->result->Visible) { // result ?>
        <td data-name="result"<?= $Page->result->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_result" class="el_tes_candidate_result">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->result->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_result" name="x<?= $Page->RowIndex ?>_result[]" id="x<?= $Page->RowIndex ?>_result_493913" value="1"<?= ConvertToBool($Page->result->CurrentValue) ? " checked" : "" ?><?= $Page->result->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->result->getErrorMessage() ?></div>
</div>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_result" data-hidden="1" name="o<?= $Page->RowIndex ?>_result[]" id="o<?= $Page->RowIndex ?>_result[]" value="<?= HtmlEncode($Page->result->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_result" class="el_tes_candidate_result">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->result->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_result" name="x<?= $Page->RowIndex ?>_result[]" id="x<?= $Page->RowIndex ?>_result_831753" value="1"<?= ConvertToBool($Page->result->CurrentValue) ? " checked" : "" ?><?= $Page->result->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->result->getErrorMessage() ?></div>
</div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_result" class="el_tes_candidate_result">
<span<?= $Page->result->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_result_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->result->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->result->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_result_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->nextRankId->Visible) { // nextRankId ?>
        <td data-name="nextRankId"<?= $Page->nextRankId->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_nextRankId" class="el_tes_candidate_nextRankId">
    <select
        id="x<?= $Page->RowIndex ?>_nextRankId"
        name="x<?= $Page->RowIndex ?>_nextRankId"
        class="form-select ew-select<?= $Page->nextRankId->isInvalidClass() ?>"
        data-select2-id="ftes_candidatelist_x<?= $Page->RowIndex ?>_nextRankId"
        data-table="tes_candidate"
        data-field="x_nextRankId"
        data-value-separator="<?= $Page->nextRankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->nextRankId->getPlaceHolder()) ?>"
        <?= $Page->nextRankId->editAttributes() ?>>
        <?= $Page->nextRankId->selectOptionListHtml("x{$Page->RowIndex}_nextRankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->nextRankId->getErrorMessage() ?></div>
<?= $Page->nextRankId->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_nextRankId") ?>
<script>
loadjs.ready("ftes_candidatelist", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_nextRankId", selectId: "ftes_candidatelist_x<?= $Page->RowIndex ?>_nextRankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_candidatelist.lists.nextRankId.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_nextRankId", form: "ftes_candidatelist" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_nextRankId", form: "ftes_candidatelist", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_candidate.fields.nextRankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_nextRankId" data-hidden="1" name="o<?= $Page->RowIndex ?>_nextRankId" id="o<?= $Page->RowIndex ?>_nextRankId" value="<?= HtmlEncode($Page->nextRankId->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_nextRankId" class="el_tes_candidate_nextRankId">
    <select
        id="x<?= $Page->RowIndex ?>_nextRankId"
        name="x<?= $Page->RowIndex ?>_nextRankId"
        class="form-select ew-select<?= $Page->nextRankId->isInvalidClass() ?>"
        data-select2-id="ftes_candidatelist_x<?= $Page->RowIndex ?>_nextRankId"
        data-table="tes_candidate"
        data-field="x_nextRankId"
        data-value-separator="<?= $Page->nextRankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->nextRankId->getPlaceHolder()) ?>"
        <?= $Page->nextRankId->editAttributes() ?>>
        <?= $Page->nextRankId->selectOptionListHtml("x{$Page->RowIndex}_nextRankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->nextRankId->getErrorMessage() ?></div>
<?= $Page->nextRankId->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_nextRankId") ?>
<script>
loadjs.ready("ftes_candidatelist", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_nextRankId", selectId: "ftes_candidatelist_x<?= $Page->RowIndex ?>_nextRankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_candidatelist.lists.nextRankId.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_nextRankId", form: "ftes_candidatelist" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_nextRankId", form: "ftes_candidatelist", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_candidate.fields.nextRankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_nextRankId" class="el_tes_candidate_nextRankId">
<span<?= $Page->nextRankId->viewAttributes() ?>>
<?= $Page->nextRankId->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->memberAge->Visible) { // memberAge ?>
        <td data-name="memberAge"<?= $Page->memberAge->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_memberAge" class="el_tes_candidate_memberAge">
<input type="<?= $Page->memberAge->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_memberAge" id="x<?= $Page->RowIndex ?>_memberAge" data-table="tes_candidate" data-field="x_memberAge" value="<?= $Page->memberAge->EditValue ?>" size="4" placeholder="<?= HtmlEncode($Page->memberAge->getPlaceHolder()) ?>"<?= $Page->memberAge->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->memberAge->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_memberAge" data-hidden="1" name="o<?= $Page->RowIndex ?>_memberAge" id="o<?= $Page->RowIndex ?>_memberAge" value="<?= HtmlEncode($Page->memberAge->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_memberAge" class="el_tes_candidate_memberAge">
<input type="<?= $Page->memberAge->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_memberAge" id="x<?= $Page->RowIndex ?>_memberAge" data-table="tes_candidate" data-field="x_memberAge" value="<?= $Page->memberAge->EditValue ?>" size="4" placeholder="<?= HtmlEncode($Page->memberAge->getPlaceHolder()) ?>"<?= $Page->memberAge->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->memberAge->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_tes_candidate_memberAge" class="el_tes_candidate_memberAge">
<span<?= $Page->memberAge->viewAttributes() ?>>
<?= $Page->memberAge->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["ftes_candidatelist","load"], () => ftes_candidatelist.updateLists(<?= $Page->RowIndex ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Page->isGridAdd())
        if (!$Page->Recordset->EOF) {
            $Page->Recordset->moveNext();
        }
}
?>
<?php
if ($Page->isGridAdd() || $Page->isGridEdit()) {
    $Page->RowIndex = '$rowindex$';
    $Page->loadRowValues();

    // Set row properties
    $Page->resetAttributes();
    $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_tes_candidate", "data-rowtype" => ROWTYPE_ADD]);
    $Page->RowAttrs->appendClass("ew-template");

    // Reset previous form error if any
    $Page->resetFormError();

    // Render row
    $Page->RowType = ROWTYPE_ADD;
    $Page->renderRow();

    // Render list options
    $Page->renderListOptions();
    $Page->StartRowCount = 0;
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowIndex);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id">
<span id="el$rowindex$_tes_candidate_id" class="el_tes_candidate_id"></span>
<input type="hidden" data-table="tes_candidate" data-field="x_id" data-hidden="1" name="o<?= $Page->RowIndex ?>_id" id="o<?= $Page->RowIndex ?>_id" value="<?= HtmlEncode($Page->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->memberId->Visible) { // memberId ?>
        <td data-name="memberId">
<span id="el$rowindex$_tes_candidate_memberId" class="el_tes_candidate_memberId">
<?php
$onchange = $Page->memberId->EditAttrs->prepend("onchange", "ew.autoFill(this);");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Page->memberId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Page->memberId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Page->RowIndex ?>_memberId" class="ew-auto-suggest">
    <input type="<?= $Page->memberId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Page->RowIndex ?>_memberId" id="sv_x<?= $Page->RowIndex ?>_memberId" value="<?= RemoveHtml($Page->memberId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Page->memberId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Page->memberId->getPlaceHolder()) ?>"<?= $Page->memberId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="tes_candidate" data-field="x_memberId" data-input="sv_x<?= $Page->RowIndex ?>_memberId" data-value-separator="<?= $Page->memberId->displayValueSeparatorAttribute() ?>" name="x<?= $Page->RowIndex ?>_memberId" id="x<?= $Page->RowIndex ?>_memberId" value="<?= HtmlEncode($Page->memberId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Page->memberId->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_candidatelist", function() {
    ftes_candidatelist.createAutoSuggest(Object.assign({"id":"x<?= $Page->RowIndex ?>_memberId","forceSelect":true}, ew.vars.tables.tes_candidate.fields.memberId.autoSuggestOptions));
});
</script>
<?= $Page->memberId->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_memberId") ?>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_memberId" data-hidden="1" name="o<?= $Page->RowIndex ?>_memberId" id="o<?= $Page->RowIndex ?>_memberId" value="<?= HtmlEncode($Page->memberId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->rankId->Visible) { // rankId ?>
        <td data-name="rankId">
<span id="el$rowindex$_tes_candidate_rankId" class="el_tes_candidate_rankId">
<?php $Page->rankId->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Page->RowIndex ?>_rankId"
        name="x<?= $Page->RowIndex ?>_rankId"
        class="form-select ew-select<?= $Page->rankId->isInvalidClass() ?>"
        data-select2-id="ftes_candidatelist_x<?= $Page->RowIndex ?>_rankId"
        data-table="tes_candidate"
        data-field="x_rankId"
        data-value-separator="<?= $Page->rankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->rankId->getPlaceHolder()) ?>"
        <?= $Page->rankId->editAttributes() ?>>
        <?= $Page->rankId->selectOptionListHtml("x{$Page->RowIndex}_rankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->rankId->getErrorMessage() ?></div>
<?= $Page->rankId->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_rankId") ?>
<script>
loadjs.ready("ftes_candidatelist", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_rankId", selectId: "ftes_candidatelist_x<?= $Page->RowIndex ?>_rankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_candidatelist.lists.rankId.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_rankId", form: "ftes_candidatelist" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_rankId", form: "ftes_candidatelist", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_candidate.fields.rankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_rankId" data-hidden="1" name="o<?= $Page->RowIndex ?>_rankId" id="o<?= $Page->RowIndex ?>_rankId" value="<?= HtmlEncode($Page->rankId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->testNominated->Visible) { // testNominated ?>
        <td data-name="testNominated">
<span id="el$rowindex$_tes_candidate_testNominated" class="el_tes_candidate_testNominated">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->testNominated->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_testNominated" name="x<?= $Page->RowIndex ?>_testNominated[]" id="x<?= $Page->RowIndex ?>_testNominated_110504" value="1"<?= ConvertToBool($Page->testNominated->CurrentValue) ? " checked" : "" ?><?= $Page->testNominated->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->testNominated->getErrorMessage() ?></div>
</div>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_testNominated" data-hidden="1" name="o<?= $Page->RowIndex ?>_testNominated[]" id="o<?= $Page->RowIndex ?>_testNominated[]" value="<?= HtmlEncode($Page->testNominated->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->testPaid->Visible) { // testPaid ?>
        <td data-name="testPaid">
<span id="el$rowindex$_tes_candidate_testPaid" class="el_tes_candidate_testPaid">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->testPaid->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_testPaid" name="x<?= $Page->RowIndex ?>_testPaid[]" id="x<?= $Page->RowIndex ?>_testPaid_678605" value="1"<?= ConvertToBool($Page->testPaid->CurrentValue) ? " checked" : "" ?><?= $Page->testPaid->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->testPaid->getErrorMessage() ?></div>
</div>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_testPaid" data-hidden="1" name="o<?= $Page->RowIndex ?>_testPaid[]" id="o<?= $Page->RowIndex ?>_testPaid[]" value="<?= HtmlEncode($Page->testPaid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->result->Visible) { // result ?>
        <td data-name="result">
<span id="el$rowindex$_tes_candidate_result" class="el_tes_candidate_result">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->result->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_result" name="x<?= $Page->RowIndex ?>_result[]" id="x<?= $Page->RowIndex ?>_result_426809" value="1"<?= ConvertToBool($Page->result->CurrentValue) ? " checked" : "" ?><?= $Page->result->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Page->result->getErrorMessage() ?></div>
</div>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_result" data-hidden="1" name="o<?= $Page->RowIndex ?>_result[]" id="o<?= $Page->RowIndex ?>_result[]" value="<?= HtmlEncode($Page->result->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->nextRankId->Visible) { // nextRankId ?>
        <td data-name="nextRankId">
<span id="el$rowindex$_tes_candidate_nextRankId" class="el_tes_candidate_nextRankId">
    <select
        id="x<?= $Page->RowIndex ?>_nextRankId"
        name="x<?= $Page->RowIndex ?>_nextRankId"
        class="form-select ew-select<?= $Page->nextRankId->isInvalidClass() ?>"
        data-select2-id="ftes_candidatelist_x<?= $Page->RowIndex ?>_nextRankId"
        data-table="tes_candidate"
        data-field="x_nextRankId"
        data-value-separator="<?= $Page->nextRankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->nextRankId->getPlaceHolder()) ?>"
        <?= $Page->nextRankId->editAttributes() ?>>
        <?= $Page->nextRankId->selectOptionListHtml("x{$Page->RowIndex}_nextRankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->nextRankId->getErrorMessage() ?></div>
<?= $Page->nextRankId->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_nextRankId") ?>
<script>
loadjs.ready("ftes_candidatelist", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_nextRankId", selectId: "ftes_candidatelist_x<?= $Page->RowIndex ?>_nextRankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_candidatelist.lists.nextRankId.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_nextRankId", form: "ftes_candidatelist" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_nextRankId", form: "ftes_candidatelist", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_candidate.fields.nextRankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_nextRankId" data-hidden="1" name="o<?= $Page->RowIndex ?>_nextRankId" id="o<?= $Page->RowIndex ?>_nextRankId" value="<?= HtmlEncode($Page->nextRankId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->memberAge->Visible) { // memberAge ?>
        <td data-name="memberAge">
<span id="el$rowindex$_tes_candidate_memberAge" class="el_tes_candidate_memberAge">
<input type="<?= $Page->memberAge->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_memberAge" id="x<?= $Page->RowIndex ?>_memberAge" data-table="tes_candidate" data-field="x_memberAge" value="<?= $Page->memberAge->EditValue ?>" size="4" placeholder="<?= HtmlEncode($Page->memberAge->getPlaceHolder()) ?>"<?= $Page->memberAge->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->memberAge->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_memberAge" data-hidden="1" name="o<?= $Page->RowIndex ?>_memberAge" id="o<?= $Page->RowIndex ?>_memberAge" value="<?= HtmlEncode($Page->memberAge->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["ftes_candidatelist","load"], () => ftes_candidatelist.updateLists(<?= $Page->RowIndex ?>, true));
</script>
    </tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isEdit()) { ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php } ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
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
    ew.addEventHandlers("tes_candidate");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
