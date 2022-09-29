<?php

namespace PHPMaker2022\school;

// Page object
$TesTestList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_test: currentTable } });
var currentForm, currentPageID;
var ftes_testlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_testlist = new ew.Form("ftes_testlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = ftes_testlist;
    ftes_testlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("ftes_testlist");
});
var ftes_testsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    ftes_testsrch = new ew.Form("ftes_testsrch", "list");
    currentSearchForm = ftes_testsrch;

    // Add fields
    var fields = currentTable.fields;
    ftes_testsrch.addFields([
        ["id", [], fields.id.isInvalid],
        ["description", [], fields.description.isInvalid],
        ["testCity", [], fields.testCity.isInvalid],
        ["martialartsId", [], fields.martialartsId.isInvalid],
        ["schoolId", [], fields.schoolId.isInvalid],
        ["testDate", [ew.Validators.datetime(fields.testDate.clientFormatPattern)], fields.testDate.isInvalid],
        ["y_testDate", [ew.Validators.between], false],
        ["testTime", [], fields.testTime.isInvalid],
        ["ceremonyDate", [], fields.ceremonyDate.isInvalid],
        ["certificateId", [], fields.certificateId.isInvalid]
    ]);

    // Validate form
    ftes_testsrch.validate = function () {
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
    ftes_testsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftes_testsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ftes_testsrch.lists.martialartsId = <?= $Page->martialartsId->toClientList($Page) ?>;

    // Filters
    ftes_testsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("ftes_testsrch");
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
<form name="ftes_testsrch" id="ftes_testsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="ftes_testsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="tes_test">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->description->Visible) { // description ?>
<?php
if (!$Page->description->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_description" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->description->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_description" class="ew-search-caption ew-label"><?= $Page->description->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_description" id="z_description" value="LIKE">
</div>
        </div>
        <div id="el_tes_test_description" class="ew-search-field">
<input type="<?= $Page->description->getInputTextType() ?>" name="x_description" id="x_description" data-table="tes_test" data-field="x_description" value="<?= $Page->description->EditValue ?>" maxlength="255" placeholder="<?= HtmlEncode($Page->description->getPlaceHolder()) ?>"<?= $Page->description->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->description->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->martialartsId->Visible) { // martialartsId ?>
<?php
if (!$Page->martialartsId->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_martialartsId" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->martialartsId->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_martialartsId" class="ew-search-caption ew-label"><?= $Page->martialartsId->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_martialartsId" id="z_martialartsId" value="=">
</div>
        </div>
        <div id="el_tes_test_martialartsId" class="ew-search-field">
    <select
        id="x_martialartsId"
        name="x_martialartsId"
        class="form-select ew-select<?= $Page->martialartsId->isInvalidClass() ?>"
        data-select2-id="ftes_testsrch_x_martialartsId"
        data-table="tes_test"
        data-field="x_martialartsId"
        data-value-separator="<?= $Page->martialartsId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->martialartsId->getPlaceHolder()) ?>"
        <?= $Page->martialartsId->editAttributes() ?>>
        <?= $Page->martialartsId->selectOptionListHtml("x_martialartsId") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->martialartsId->getErrorMessage(false) ?></div>
<?= $Page->martialartsId->Lookup->getParamTag($Page, "p_x_martialartsId") ?>
<script>
loadjs.ready("ftes_testsrch", function() {
    var options = { name: "x_martialartsId", selectId: "ftes_testsrch_x_martialartsId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_testsrch.lists.martialartsId.lookupOptions.length) {
        options.data = { id: "x_martialartsId", form: "ftes_testsrch" };
    } else {
        options.ajax = { id: "x_martialartsId", form: "ftes_testsrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_test.fields.martialartsId.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->testDate->Visible) { // testDate ?>
<?php
if (!$Page->testDate->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_testDate" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->testDate->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_testDate" class="ew-search-caption ew-label"><?= $Page->testDate->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_testDate" id="z_testDate" value="BETWEEN">
</div>
        </div>
        <div id="el_tes_test_testDate" class="ew-search-field">
<input type="<?= $Page->testDate->getInputTextType() ?>" name="x_testDate" id="x_testDate" data-table="tes_test" data-field="x_testDate" value="<?= $Page->testDate->EditValue ?>" placeholder="<?= HtmlEncode($Page->testDate->getPlaceHolder()) ?>"<?= $Page->testDate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->testDate->getErrorMessage(false) ?></div>
<?php if (!$Page->testDate->ReadOnly && !$Page->testDate->Disabled && !isset($Page->testDate->EditAttrs["readonly"]) && !isset($Page->testDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftes_testsrch", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem()
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                    next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i),
                    useTwentyfourHour: !!format.match(/H/)
                }
            },
            meta: {
                format
            }
        };
    ew.createDateTimePicker("ftes_testsrch", "x_testDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_tes_test_testDate" class="ew-search-field2">
<input type="<?= $Page->testDate->getInputTextType() ?>" name="y_testDate" id="y_testDate" data-table="tes_test" data-field="x_testDate" value="<?= $Page->testDate->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->testDate->getPlaceHolder()) ?>"<?= $Page->testDate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->testDate->getErrorMessage(false) ?></div>
<?php if (!$Page->testDate->ReadOnly && !$Page->testDate->Disabled && !isset($Page->testDate->EditAttrs["readonly"]) && !isset($Page->testDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ftes_testsrch", "datetimepicker"], function () {
    let format = "<?= DateFormat(0) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem()
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                    next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i),
                    useTwentyfourHour: !!format.match(/H/)
                }
            },
            meta: {
                format
            }
        };
    ew.createDateTimePicker("ftes_testsrch", "y_testDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="ftes_testsrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="ftes_testsrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="ftes_testsrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="ftes_testsrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> tes_test">
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
<form name="ftes_testlist" id="ftes_testlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_test">
<div id="gmp_tes_test" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_tes_testlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_tes_test_id" class="tes_test_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->description->Visible) { // description ?>
        <th data-name="description" class="<?= $Page->description->headerCellClass() ?>"><div id="elh_tes_test_description" class="tes_test_description"><?= $Page->renderFieldHeader($Page->description) ?></div></th>
<?php } ?>
<?php if ($Page->testCity->Visible) { // testCity ?>
        <th data-name="testCity" class="<?= $Page->testCity->headerCellClass() ?>"><div id="elh_tes_test_testCity" class="tes_test_testCity"><?= $Page->renderFieldHeader($Page->testCity) ?></div></th>
<?php } ?>
<?php if ($Page->martialartsId->Visible) { // martialartsId ?>
        <th data-name="martialartsId" class="<?= $Page->martialartsId->headerCellClass() ?>"><div id="elh_tes_test_martialartsId" class="tes_test_martialartsId"><?= $Page->renderFieldHeader($Page->martialartsId) ?></div></th>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <th data-name="schoolId" class="<?= $Page->schoolId->headerCellClass() ?>"><div id="elh_tes_test_schoolId" class="tes_test_schoolId"><?= $Page->renderFieldHeader($Page->schoolId) ?></div></th>
<?php } ?>
<?php if ($Page->testDate->Visible) { // testDate ?>
        <th data-name="testDate" class="<?= $Page->testDate->headerCellClass() ?>"><div id="elh_tes_test_testDate" class="tes_test_testDate"><?= $Page->renderFieldHeader($Page->testDate) ?></div></th>
<?php } ?>
<?php if ($Page->testTime->Visible) { // testTime ?>
        <th data-name="testTime" class="<?= $Page->testTime->headerCellClass() ?>"><div id="elh_tes_test_testTime" class="tes_test_testTime"><?= $Page->renderFieldHeader($Page->testTime) ?></div></th>
<?php } ?>
<?php if ($Page->ceremonyDate->Visible) { // ceremonyDate ?>
        <th data-name="ceremonyDate" class="<?= $Page->ceremonyDate->headerCellClass() ?>"><div id="elh_tes_test_ceremonyDate" class="tes_test_ceremonyDate"><?= $Page->renderFieldHeader($Page->ceremonyDate) ?></div></th>
<?php } ?>
<?php if ($Page->certificateId->Visible) { // certificateId ?>
        <th data-name="certificateId" class="<?= $Page->certificateId->headerCellClass() ?>"><div id="elh_tes_test_certificateId" class="tes_test_certificateId"><?= $Page->renderFieldHeader($Page->certificateId) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_tes_test",
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
<span id="el<?= $Page->RowCount ?>_tes_test_id" class="el_tes_test_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->description->Visible) { // description ?>
        <td data-name="description"<?= $Page->description->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_description" class="el_tes_test_description">
<span<?= $Page->description->viewAttributes() ?>>
<?= $Page->description->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->testCity->Visible) { // testCity ?>
        <td data-name="testCity"<?= $Page->testCity->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_testCity" class="el_tes_test_testCity">
<span<?= $Page->testCity->viewAttributes() ?>>
<?= $Page->testCity->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->martialartsId->Visible) { // martialartsId ?>
        <td data-name="martialartsId"<?= $Page->martialartsId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_martialartsId" class="el_tes_test_martialartsId">
<span<?= $Page->martialartsId->viewAttributes() ?>>
<?= $Page->martialartsId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->schoolId->Visible) { // schoolId ?>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_schoolId" class="el_tes_test_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->testDate->Visible) { // testDate ?>
        <td data-name="testDate"<?= $Page->testDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_testDate" class="el_tes_test_testDate">
<span<?= $Page->testDate->viewAttributes() ?>>
<?= $Page->testDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->testTime->Visible) { // testTime ?>
        <td data-name="testTime"<?= $Page->testTime->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_testTime" class="el_tes_test_testTime">
<span<?= $Page->testTime->viewAttributes() ?>>
<?= $Page->testTime->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->ceremonyDate->Visible) { // ceremonyDate ?>
        <td data-name="ceremonyDate"<?= $Page->ceremonyDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_ceremonyDate" class="el_tes_test_ceremonyDate">
<span<?= $Page->ceremonyDate->viewAttributes() ?>>
<?= $Page->ceremonyDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->certificateId->Visible) { // certificateId ?>
        <td data-name="certificateId"<?= $Page->certificateId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_test_certificateId" class="el_tes_test_certificateId">
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
    ew.addEventHandlers("tes_test");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
