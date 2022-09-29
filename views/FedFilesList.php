<?php

namespace PHPMaker2022\school;

// Page object
$FedFilesList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_files: currentTable } });
var currentForm, currentPageID;
var ffed_fileslist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_fileslist = new ew.Form("ffed_fileslist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = ffed_fileslist;
    ffed_fileslist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("ffed_fileslist");
});
var ffed_filessrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    ffed_filessrch = new ew.Form("ffed_filessrch", "list");
    currentSearchForm = ffed_filessrch;

    // Add fields
    var fields = currentTable.fields;
    ffed_filessrch.addFields([
        ["name", [], fields.name.isInvalid],
        ["thumbs", [], fields.thumbs.isInvalid],
        ["category", [], fields.category.isInvalid],
        ["type", [], fields.type.isInvalid]
    ]);

    // Validate form
    ffed_filessrch.validate = function () {
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
    ffed_filessrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_filessrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffed_filessrch.lists.category = <?= $Page->category->toClientList($Page) ?>;
    ffed_filessrch.lists.type = <?= $Page->type->toClientList($Page) ?>;

    // Filters
    ffed_filessrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("ffed_filessrch");
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
<form name="ffed_filessrch" id="ffed_filessrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="ffed_filessrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="fed_files">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->name->Visible) { // name ?>
<?php
if (!$Page->name->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_name" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->name->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_name" class="ew-search-caption ew-label"><?= $Page->name->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_name" id="z_name" value="LIKE">
</div>
        </div>
        <div id="el_fed_files_name" class="ew-search-field">
<input type="<?= $Page->name->getInputTextType() ?>" name="x_name" id="x_name" data-table="fed_files" data-field="x_name" value="<?= $Page->name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>"<?= $Page->name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage(false) ?></div>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->category->Visible) { // category ?>
<?php
if (!$Page->category->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_category" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->category->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->category->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_category" id="z_category" value="=">
</div>
        </div>
        <div id="el_fed_files_category" class="ew-search-field">
    <select
        id="x_category[]"
        name="x_category[]"
        class="form-select ew-select<?= $Page->category->isInvalidClass() ?>"
        data-select2-id="ffed_filessrch_x_category[]"
        data-table="fed_files"
        data-field="x_category"
        data-dropdown
        multiple
        size="1"
        data-value-separator="<?= $Page->category->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->category->getPlaceHolder()) ?>"
        <?= $Page->category->editAttributes() ?>>
        <?= $Page->category->selectOptionListHtml("x_category[]") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->category->getErrorMessage(false) ?></div>
<?= $Page->category->Lookup->getParamTag($Page, "p_x_category") ?>
<script>
loadjs.ready("ffed_filessrch", function() {
    var options = { name: "x_category[]", selectId: "ffed_filessrch_x_category[]" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.multiple = true;
    options.closeOnSelect = false;
    options.columns = el.dataset.repeatcolumn || 5;
    options.dropdown = !ew.IS_MOBILE && options.columns > 0; // Use custom dropdown
    el.dataset.dropdown = options.dropdown;
    if (options.dropdown) {
        options.dropdownAutoWidth = true;
        options.dropdownCssClass = "ew-select-dropdown ew-select-multiple fed_files-x_category-dropdown";
        if (options.columns > 1)
            options.dropdownCssClass += " ew-repeat-column";
    }
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_filessrch.lists.category.lookupOptions.length) {
        options.data = { id: "x_category[]", form: "ffed_filessrch" };
    } else {
        options.ajax = { id: "x_category[]", form: "ffed_filessrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_files.fields.category.selectOptions);
    ew.createSelect(options);
});
</script>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->type->Visible) { // type ?>
<?php
if (!$Page->type->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_type" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->type->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->type->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_type" id="z_type" value="=">
</div>
        </div>
        <div id="el_fed_files_type" class="ew-search-field">
    <select
        id="x_type[]"
        name="x_type[]"
        class="form-select ew-select<?= $Page->type->isInvalidClass() ?>"
        data-select2-id="ffed_filessrch_x_type[]"
        data-table="fed_files"
        data-field="x_type"
        data-dropdown
        multiple
        size="1"
        data-value-separator="<?= $Page->type->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->type->getPlaceHolder()) ?>"
        <?= $Page->type->editAttributes() ?>>
        <?= $Page->type->selectOptionListHtml("x_type[]") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->type->getErrorMessage(false) ?></div>
<?= $Page->type->Lookup->getParamTag($Page, "p_x_type") ?>
<script>
loadjs.ready("ffed_filessrch", function() {
    var options = { name: "x_type[]", selectId: "ffed_filessrch_x_type[]" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.multiple = true;
    options.closeOnSelect = false;
    options.columns = el.dataset.repeatcolumn || 5;
    options.dropdown = !ew.IS_MOBILE && options.columns > 0; // Use custom dropdown
    el.dataset.dropdown = options.dropdown;
    if (options.dropdown) {
        options.dropdownAutoWidth = true;
        options.dropdownCssClass = "ew-select-dropdown ew-select-multiple fed_files-x_type-dropdown";
        if (options.columns > 1)
            options.dropdownCssClass += " ew-repeat-column";
    }
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_filessrch.lists.type.lookupOptions.length) {
        options.data = { id: "x_type[]", form: "ffed_filessrch" };
    } else {
        options.ajax = { id: "x_type[]", form: "ffed_filessrch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_files.fields.type.selectOptions);
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="ffed_filessrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="ffed_filessrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="ffed_filessrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="ffed_filessrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<?= $this->fetch("FedFiles" . ucfirst($Page->MultiColumnLayout) . ".php", $GLOBALS); // Multi-column layout ?>
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
    ew.addEventHandlers("fed_files");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
