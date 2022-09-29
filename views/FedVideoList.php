<?php

namespace PHPMaker2022\school;

// Page object
$FedVideoList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_video: currentTable } });
var currentForm, currentPageID;
var ffed_videolist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_videolist = new ew.Form("ffed_videolist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = ffed_videolist;
    ffed_videolist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("ffed_videolist");
});
var ffed_videosrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    ffed_videosrch = new ew.Form("ffed_videosrch", "list");
    currentSearchForm = ffed_videosrch;

    // Add fields
    var fields = currentTable.fields;
    ffed_videosrch.addFields([
        ["_title", [], fields._title.isInvalid],
        ["URL", [], fields.URL.isInvalid],
        ["section", [], fields.section.isInvalid],
        ["subsection", [], fields.subsection.isInvalid],
        ["createDate", [], fields.createDate.isInvalid]
    ]);

    // Validate form
    ffed_videosrch.validate = function () {
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
    ffed_videosrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_videosrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffed_videosrch.lists.section = <?= $Page->section->toClientList($Page) ?>;
    ffed_videosrch.lists.subsection = <?= $Page->subsection->toClientList($Page) ?>;

    // Filters
    ffed_videosrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("ffed_videosrch");
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
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "fed_videosection") {
    if ($Page->MasterRecordExists) {
        include_once "views/FedVideosectionMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "fed_videosubsection") {
    if ($Page->MasterRecordExists) {
        include_once "views/FedVideosubsectionMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="ffed_videosrch" id="ffed_videosrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="ffed_videosrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="fed_video">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->section->Visible) { // section ?>
<?php
if (!$Page->section->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_section" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->section->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->section->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_section" id="z_section" value="=">
</div>
        </div>
        <div id="el_fed_video_section" class="ew-search-field">
<template id="tp_x_section">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fed_video" data-field="x_section" name="x_section" id="x_section"<?= $Page->section->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_section" class="ew-item-list"></div>
<?php $Page->section->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
<selection-list hidden
    id="x_section"
    name="x_section"
    value="<?= HtmlEncode($Page->section->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_section"
    data-bs-target="dsl_x_section"
    data-repeatcolumn="5"
    class="form-control<?= $Page->section->isInvalidClass() ?>"
    data-table="fed_video"
    data-field="x_section"
    data-value-separator="<?= $Page->section->displayValueSeparatorAttribute() ?>"
    <?= $Page->section->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->section->getErrorMessage(false) ?></div>
<?= $Page->section->Lookup->getParamTag($Page, "p_x_section") ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->subsection->Visible) { // subsection ?>
<?php
if (!$Page->subsection->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_subsection" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->subsection->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label class="ew-search-caption ew-label"><?= $Page->subsection->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_subsection" id="z_subsection" value="=">
</div>
        </div>
        <div id="el_fed_video_subsection" class="ew-search-field">
<template id="tp_x_subsection">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fed_video" data-field="x_subsection" name="x_subsection" id="x_subsection"<?= $Page->subsection->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_subsection" class="ew-item-list"></div>
<selection-list hidden
    id="x_subsection"
    name="x_subsection"
    value="<?= HtmlEncode($Page->subsection->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_subsection"
    data-bs-target="dsl_x_subsection"
    data-repeatcolumn="5"
    class="form-control<?= $Page->subsection->isInvalidClass() ?>"
    data-table="fed_video"
    data-field="x_subsection"
    data-value-separator="<?= $Page->subsection->displayValueSeparatorAttribute() ?>"
    <?= $Page->subsection->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->subsection->getErrorMessage(false) ?></div>
<?= $Page->subsection->Lookup->getParamTag($Page, "p_x_subsection") ?>
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="ffed_videosrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="ffed_videosrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="ffed_videosrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="ffed_videosrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<?= $this->fetch("FedVideo" . ucfirst($Page->MultiColumnLayout) . ".php", $GLOBALS); // Multi-column layout ?>
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
    ew.addEventHandlers("fed_video");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
