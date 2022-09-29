<?php

namespace PHPMaker2022\school;

// Page object
$FinAccountspayableList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_accountspayable: currentTable } });
var currentForm, currentPageID;
var ffin_accountspayablelist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_accountspayablelist = new ew.Form("ffin_accountspayablelist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = ffin_accountspayablelist;
    ffin_accountspayablelist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("ffin_accountspayablelist");
});
var ffin_accountspayablesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    ffin_accountspayablesrch = new ew.Form("ffin_accountspayablesrch", "list");
    currentSearchForm = ffin_accountspayablesrch;

    // Add fields
    var fields = currentTable.fields;
    ffin_accountspayablesrch.addFields([
        ["id", [], fields.id.isInvalid],
        ["departamentId", [], fields.departamentId.isInvalid],
        ["historic", [], fields.historic.isInvalid],
        ["issue", [ew.Validators.datetime(fields.issue.clientFormatPattern)], fields.issue.isInvalid],
        ["due", [ew.Validators.datetime(fields.due.clientFormatPattern)], fields.due.isInvalid],
        ["value", [], fields.value.isInvalid],
        ["status", [], fields.status.isInvalid],
        ["amountPaid", [], fields.amountPaid.isInvalid],
        ["creditorsId", [], fields.creditorsId.isInvalid],
        ["typeId", [], fields.typeId.isInvalid],
        ["licenseId", [], fields.licenseId.isInvalid]
    ]);

    // Validate form
    ffin_accountspayablesrch.validate = function () {
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
    ffin_accountspayablesrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_accountspayablesrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_accountspayablesrch.lists.departamentId = <?= $Page->departamentId->toClientList($Page) ?>;

    // Filters
    ffin_accountspayablesrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("ffin_accountspayablesrch");
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
<form name="ffin_accountspayablesrch" id="ffin_accountspayablesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="ffin_accountspayablesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="fin_accountspayable">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->departamentId->Visible) { // departamentId ?>
<?php
if (!$Page->departamentId->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_departamentId" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->departamentId->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_departamentId" class="ew-search-caption ew-label"><?= $Page->departamentId->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_departamentId" id="z_departamentId" value="=">
</div>
        </div>
        <div id="el_fin_accountspayable_departamentId" class="ew-search-field">
    <select
        id="x_departamentId"
        name="x_departamentId"
        class="form-select ew-select<?= $Page->departamentId->isInvalidClass() ?>"
        data-select2-id="ffin_accountspayablesrch_x_departamentId"
        data-table="fin_accountspayable"
        data-field="x_departamentId"
        data-value-separator="<?= $Page->departamentId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->departamentId->getPlaceHolder()) ?>"
        <?= $Page->departamentId->editAttributes() ?>>
        <?= $Page->departamentId->selectOptionListHtml("x_departamentId") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->departamentId->getErrorMessage(false) ?></div>
<?= $Page->departamentId->Lookup->getParamTag($Page, "p_x_departamentId") ?>
<script>
loadjs.ready("ffin_accountspayablesrch", function() {
    var options = { name: "x_departamentId", selectId: "ffin_accountspayablesrch_x_departamentId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_accountspayablesrch.lists.departamentId.lookupOptions.length) {
        options.data = { id: "x_departamentId", form: "ffin_accountspayablesrch" };
    } else {
        options.ajax = { id: "x_departamentId", form: "ffin_accountspayablesrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_accountspayable.fields.departamentId.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->historic->Visible) { // historic ?>
<?php
if (!$Page->historic->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_historic" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->historic->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_historic" class="ew-search-caption ew-label"><?= $Page->historic->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_historic" id="z_historic" value="LIKE">
</div>
        </div>
        <div id="el_fin_accountspayable_historic" class="ew-search-field">
<input type="<?= $Page->historic->getInputTextType() ?>" name="x_historic" id="x_historic" data-table="fin_accountspayable" data-field="x_historic" value="<?= $Page->historic->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->historic->getPlaceHolder()) ?>"<?= $Page->historic->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->historic->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->issue->Visible) { // issue ?>
<?php
if (!$Page->issue->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_issue" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->issue->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_issue" class="ew-search-caption ew-label"><?= $Page->issue->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase(">=") ?>
<input type="hidden" name="z_issue" id="z_issue" value="&gt;=">
</div>
        </div>
        <div id="el_fin_accountspayable_issue" class="ew-search-field">
<input type="<?= $Page->issue->getInputTextType() ?>" name="x_issue" id="x_issue" data-table="fin_accountspayable" data-field="x_issue" value="<?= $Page->issue->EditValue ?>" placeholder="<?= HtmlEncode($Page->issue->getPlaceHolder()) ?>"<?= $Page->issue->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->issue->getErrorMessage(false) ?></div>
<?php if (!$Page->issue->ReadOnly && !$Page->issue->Disabled && !isset($Page->issue->EditAttrs["readonly"]) && !isset($Page->issue->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffin_accountspayablesrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_accountspayablesrch", "x_issue", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->due->Visible) { // due ?>
<?php
if (!$Page->due->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_due" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->due->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_due" class="ew-search-caption ew-label"><?= $Page->due->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("<=") ?>
<input type="hidden" name="z_due" id="z_due" value="&lt;=">
</div>
        </div>
        <div id="el_fin_accountspayable_due" class="ew-search-field">
<input type="<?= $Page->due->getInputTextType() ?>" name="x_due" id="x_due" data-table="fin_accountspayable" data-field="x_due" value="<?= $Page->due->EditValue ?>" placeholder="<?= HtmlEncode($Page->due->getPlaceHolder()) ?>"<?= $Page->due->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->due->getErrorMessage(false) ?></div>
<?php if (!$Page->due->ReadOnly && !$Page->due->Disabled && !isset($Page->due->EditAttrs["readonly"]) && !isset($Page->due->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffin_accountspayablesrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_accountspayablesrch", "x_due", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="ffin_accountspayablesrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="ffin_accountspayablesrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="ffin_accountspayablesrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="ffin_accountspayablesrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fin_accountspayable">
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
<form name="ffin_accountspayablelist" id="ffin_accountspayablelist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_accountspayable">
<div id="gmp_fin_accountspayable" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_fin_accountspayablelist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_fin_accountspayable_id" class="fin_accountspayable_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->departamentId->Visible) { // departamentId ?>
        <th data-name="departamentId" class="<?= $Page->departamentId->headerCellClass() ?>"><div id="elh_fin_accountspayable_departamentId" class="fin_accountspayable_departamentId"><?= $Page->renderFieldHeader($Page->departamentId) ?></div></th>
<?php } ?>
<?php if ($Page->historic->Visible) { // historic ?>
        <th data-name="historic" class="<?= $Page->historic->headerCellClass() ?>"><div id="elh_fin_accountspayable_historic" class="fin_accountspayable_historic"><?= $Page->renderFieldHeader($Page->historic) ?></div></th>
<?php } ?>
<?php if ($Page->issue->Visible) { // issue ?>
        <th data-name="issue" class="<?= $Page->issue->headerCellClass() ?>"><div id="elh_fin_accountspayable_issue" class="fin_accountspayable_issue"><?= $Page->renderFieldHeader($Page->issue) ?></div></th>
<?php } ?>
<?php if ($Page->due->Visible) { // due ?>
        <th data-name="due" class="<?= $Page->due->headerCellClass() ?>"><div id="elh_fin_accountspayable_due" class="fin_accountspayable_due"><?= $Page->renderFieldHeader($Page->due) ?></div></th>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
        <th data-name="value" class="<?= $Page->value->headerCellClass() ?>"><div id="elh_fin_accountspayable_value" class="fin_accountspayable_value"><?= $Page->renderFieldHeader($Page->value) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_fin_accountspayable_status" class="fin_accountspayable_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->amountPaid->Visible) { // amountPaid ?>
        <th data-name="amountPaid" class="<?= $Page->amountPaid->headerCellClass() ?>"><div id="elh_fin_accountspayable_amountPaid" class="fin_accountspayable_amountPaid"><?= $Page->renderFieldHeader($Page->amountPaid) ?></div></th>
<?php } ?>
<?php if ($Page->creditorsId->Visible) { // creditorsId ?>
        <th data-name="creditorsId" class="<?= $Page->creditorsId->headerCellClass() ?>"><div id="elh_fin_accountspayable_creditorsId" class="fin_accountspayable_creditorsId"><?= $Page->renderFieldHeader($Page->creditorsId) ?></div></th>
<?php } ?>
<?php if ($Page->typeId->Visible) { // typeId ?>
        <th data-name="typeId" class="<?= $Page->typeId->headerCellClass() ?>"><div id="elh_fin_accountspayable_typeId" class="fin_accountspayable_typeId"><?= $Page->renderFieldHeader($Page->typeId) ?></div></th>
<?php } ?>
<?php if ($Page->licenseId->Visible) { // licenseId ?>
        <th data-name="licenseId" class="<?= $Page->licenseId->headerCellClass() ?>"><div id="elh_fin_accountspayable_licenseId" class="fin_accountspayable_licenseId"><?= $Page->renderFieldHeader($Page->licenseId) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_fin_accountspayable",
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
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_id" class="el_fin_accountspayable_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->departamentId->Visible) { // departamentId ?>
        <td data-name="departamentId"<?= $Page->departamentId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_departamentId" class="el_fin_accountspayable_departamentId">
<span<?= $Page->departamentId->viewAttributes() ?>>
<?= $Page->departamentId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->historic->Visible) { // historic ?>
        <td data-name="historic"<?= $Page->historic->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_historic" class="el_fin_accountspayable_historic">
<span<?= $Page->historic->viewAttributes() ?>>
<?= $Page->historic->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->issue->Visible) { // issue ?>
        <td data-name="issue"<?= $Page->issue->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_issue" class="el_fin_accountspayable_issue">
<span<?= $Page->issue->viewAttributes() ?>>
<?= $Page->issue->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->due->Visible) { // due ?>
        <td data-name="due"<?= $Page->due->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_due" class="el_fin_accountspayable_due">
<span<?= $Page->due->viewAttributes() ?>>
<?= $Page->due->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->value->Visible) { // value ?>
        <td data-name="value"<?= $Page->value->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_value" class="el_fin_accountspayable_value">
<span<?= $Page->value->viewAttributes() ?>>
<?= $Page->value->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_status" class="el_fin_accountspayable_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->amountPaid->Visible) { // amountPaid ?>
        <td data-name="amountPaid"<?= $Page->amountPaid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_amountPaid" class="el_fin_accountspayable_amountPaid">
<span<?= $Page->amountPaid->viewAttributes() ?>>
<?= $Page->amountPaid->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->creditorsId->Visible) { // creditorsId ?>
        <td data-name="creditorsId"<?= $Page->creditorsId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_creditorsId" class="el_fin_accountspayable_creditorsId">
<span<?= $Page->creditorsId->viewAttributes() ?>>
<?= $Page->creditorsId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->typeId->Visible) { // typeId ?>
        <td data-name="typeId"<?= $Page->typeId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_typeId" class="el_fin_accountspayable_typeId">
<span<?= $Page->typeId->viewAttributes() ?>>
<?= $Page->typeId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->licenseId->Visible) { // licenseId ?>
        <td data-name="licenseId"<?= $Page->licenseId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountspayable_licenseId" class="el_fin_accountspayable_licenseId">
<span<?= $Page->licenseId->viewAttributes() ?>>
<?= $Page->licenseId->getViewValue() ?></span>
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
    ew.addEventHandlers("fin_accountspayable");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
