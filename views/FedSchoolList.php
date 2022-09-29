<?php

namespace PHPMaker2022\school;

// Page object
$FedSchoolList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_school: currentTable } });
var currentForm, currentPageID;
var ffed_schoollist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_schoollist = new ew.Form("ffed_schoollist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = ffed_schoollist;
    ffed_schoollist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("ffed_schoollist");
});
var ffed_schoolsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    ffed_schoolsrch = new ew.Form("ffed_schoolsrch", "list");
    currentSearchForm = ffed_schoolsrch;

    // Add fields
    var fields = currentTable.fields;
    ffed_schoolsrch.addFields([
        ["id", [], fields.id.isInvalid],
        ["masterSchoolId", [], fields.masterSchoolId.isInvalid],
        ["school", [], fields.school.isInvalid],
        ["countryId", [], fields.countryId.isInvalid],
        ["cityId", [], fields.cityId.isInvalid],
        ["owner", [], fields.owner.isInvalid],
        ["applicationId", [], fields.applicationId.isInvalid],
        ["isheadquarter", [], fields.isheadquarter.isInvalid]
    ]);

    // Validate form
    ffed_schoolsrch.validate = function () {
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
    ffed_schoolsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_schoolsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffed_schoolsrch.lists.masterSchoolId = <?= $Page->masterSchoolId->toClientList($Page) ?>;

    // Filters
    ffed_schoolsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("ffed_schoolsrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "fed_applicationschool") {
    if ($Page->MasterRecordExists) {
        include_once "views/FedApplicationschoolMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="ffed_schoolsrch" id="ffed_schoolsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="ffed_schoolsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="fed_school">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->masterSchoolId->Visible) { // masterSchoolId ?>
<?php
if (!$Page->masterSchoolId->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_masterSchoolId" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->masterSchoolId->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_masterSchoolId" class="ew-search-caption ew-label"><?= $Page->masterSchoolId->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_masterSchoolId" id="z_masterSchoolId" value="=">
</div>
        </div>
        <div id="el_fed_school_masterSchoolId" class="ew-search-field">
    <select
        id="x_masterSchoolId"
        name="x_masterSchoolId"
        class="form-select ew-select<?= $Page->masterSchoolId->isInvalidClass() ?>"
        data-select2-id="ffed_schoolsrch_x_masterSchoolId"
        data-table="fed_school"
        data-field="x_masterSchoolId"
        data-value-separator="<?= $Page->masterSchoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->masterSchoolId->getPlaceHolder()) ?>"
        <?= $Page->masterSchoolId->editAttributes() ?>>
        <?= $Page->masterSchoolId->selectOptionListHtml("x_masterSchoolId") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->masterSchoolId->getErrorMessage(false) ?></div>
<?= $Page->masterSchoolId->Lookup->getParamTag($Page, "p_x_masterSchoolId") ?>
<script>
loadjs.ready("ffed_schoolsrch", function() {
    var options = { name: "x_masterSchoolId", selectId: "ffed_schoolsrch_x_masterSchoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schoolsrch.lists.masterSchoolId.lookupOptions.length) {
        options.data = { id: "x_masterSchoolId", form: "ffed_schoolsrch" };
    } else {
        options.ajax = { id: "x_masterSchoolId", form: "ffed_schoolsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.masterSchoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
</div><!-- /.row -->
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="ffed_schoolsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="ffed_schoolsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="ffed_schoolsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="ffed_schoolsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fed_school">
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
<form name="ffed_schoollist" id="ffed_schoollist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_school">
<?php if ($Page->getCurrentMasterTable() == "fed_applicationschool" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fed_applicationschool">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->applicationId->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_fed_school" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_fed_schoollist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_fed_school_id" class="fed_school_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->masterSchoolId->Visible) { // masterSchoolId ?>
        <th data-name="masterSchoolId" class="<?= $Page->masterSchoolId->headerCellClass() ?>"><div id="elh_fed_school_masterSchoolId" class="fed_school_masterSchoolId"><?= $Page->renderFieldHeader($Page->masterSchoolId) ?></div></th>
<?php } ?>
<?php if ($Page->school->Visible) { // school ?>
        <th data-name="school" class="<?= $Page->school->headerCellClass() ?>"><div id="elh_fed_school_school" class="fed_school_school"><?= $Page->renderFieldHeader($Page->school) ?></div></th>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
        <th data-name="countryId" class="<?= $Page->countryId->headerCellClass() ?>"><div id="elh_fed_school_countryId" class="fed_school_countryId"><?= $Page->renderFieldHeader($Page->countryId) ?></div></th>
<?php } ?>
<?php if ($Page->cityId->Visible) { // cityId ?>
        <th data-name="cityId" class="<?= $Page->cityId->headerCellClass() ?>"><div id="elh_fed_school_cityId" class="fed_school_cityId"><?= $Page->renderFieldHeader($Page->cityId) ?></div></th>
<?php } ?>
<?php if ($Page->owner->Visible) { // owner ?>
        <th data-name="owner" class="<?= $Page->owner->headerCellClass() ?>"><div id="elh_fed_school_owner" class="fed_school_owner"><?= $Page->renderFieldHeader($Page->owner) ?></div></th>
<?php } ?>
<?php if ($Page->applicationId->Visible) { // applicationId ?>
        <th data-name="applicationId" class="<?= $Page->applicationId->headerCellClass() ?>"><div id="elh_fed_school_applicationId" class="fed_school_applicationId"><?= $Page->renderFieldHeader($Page->applicationId) ?></div></th>
<?php } ?>
<?php if ($Page->isheadquarter->Visible) { // isheadquarter ?>
        <th data-name="isheadquarter" class="<?= $Page->isheadquarter->headerCellClass() ?>"><div id="elh_fed_school_isheadquarter" class="fed_school_isheadquarter"><?= $Page->renderFieldHeader($Page->isheadquarter) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_fed_school",
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
<span id="el<?= $Page->RowCount ?>_fed_school_id" class="el_fed_school_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->masterSchoolId->Visible) { // masterSchoolId ?>
        <td data-name="masterSchoolId"<?= $Page->masterSchoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_school_masterSchoolId" class="el_fed_school_masterSchoolId">
<span<?= $Page->masterSchoolId->viewAttributes() ?>>
<?= $Page->masterSchoolId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->school->Visible) { // school ?>
        <td data-name="school"<?= $Page->school->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_school_school" class="el_fed_school_school">
<span<?= $Page->school->viewAttributes() ?>>
<?= $Page->school->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->countryId->Visible) { // countryId ?>
        <td data-name="countryId"<?= $Page->countryId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_school_countryId" class="el_fed_school_countryId">
<span<?= $Page->countryId->viewAttributes() ?>>
<?= $Page->countryId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->cityId->Visible) { // cityId ?>
        <td data-name="cityId"<?= $Page->cityId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_school_cityId" class="el_fed_school_cityId">
<span<?= $Page->cityId->viewAttributes() ?>>
<?= $Page->cityId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->owner->Visible) { // owner ?>
        <td data-name="owner"<?= $Page->owner->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_school_owner" class="el_fed_school_owner">
<span<?= $Page->owner->viewAttributes() ?>>
<?= $Page->owner->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->applicationId->Visible) { // applicationId ?>
        <td data-name="applicationId"<?= $Page->applicationId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_school_applicationId" class="el_fed_school_applicationId">
<span<?= $Page->applicationId->viewAttributes() ?>>
<?= $Page->applicationId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->isheadquarter->Visible) { // isheadquarter ?>
        <td data-name="isheadquarter"<?= $Page->isheadquarter->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_school_isheadquarter" class="el_fed_school_isheadquarter">
<span<?= $Page->isheadquarter->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_isheadquarter_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->isheadquarter->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->isheadquarter->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_isheadquarter_<?= $Page->RowCount ?>"></label>
</div></span>
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
    ew.addEventHandlers("fed_school");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
