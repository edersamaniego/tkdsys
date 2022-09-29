<?php

namespace PHPMaker2022\school;

// Page object
$FedLicenseschoolList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_licenseschool: currentTable } });
var currentForm, currentPageID;
var ffed_licenseschoollist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_licenseschoollist = new ew.Form("ffed_licenseschoollist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = ffed_licenseschoollist;
    ffed_licenseschoollist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("ffed_licenseschoollist");
});
var ffed_licenseschoolsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    ffed_licenseschoolsrch = new ew.Form("ffed_licenseschoolsrch", "list");
    currentSearchForm = ffed_licenseschoolsrch;

    // Add fields
    var fields = currentTable.fields;
    ffed_licenseschoolsrch.addFields([
        ["id", [], fields.id.isInvalid],
        ["application", [], fields.application.isInvalid],
        ["dateLicense", [ew.Validators.datetime(fields.dateLicense.clientFormatPattern)], fields.dateLicense.isInvalid],
        ["y_dateLicense", [ew.Validators.between], false],
        ["dateStart", [ew.Validators.datetime(fields.dateStart.clientFormatPattern)], fields.dateStart.isInvalid],
        ["y_dateStart", [ew.Validators.between], false],
        ["dateFinish", [ew.Validators.datetime(fields.dateFinish.clientFormatPattern)], fields.dateFinish.isInvalid],
        ["y_dateFinish", [ew.Validators.between], false],
        ["schooltype", [], fields.schooltype.isInvalid]
    ]);

    // Validate form
    ffed_licenseschoolsrch.validate = function () {
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
    ffed_licenseschoolsrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_licenseschoolsrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists

    // Filters
    ffed_licenseschoolsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("ffed_licenseschoolsrch");
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
<form name="ffed_licenseschoolsrch" id="ffed_licenseschoolsrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="ffed_licenseschoolsrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="fed_licenseschool">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->dateLicense->Visible) { // dateLicense ?>
<?php
if (!$Page->dateLicense->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_dateLicense" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->dateLicense->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_dateLicense" class="ew-search-caption ew-label"><?= $Page->dateLicense->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_dateLicense" id="z_dateLicense" value="BETWEEN">
</div>
        </div>
        <div id="el_fed_licenseschool_dateLicense" class="ew-search-field">
<input type="<?= $Page->dateLicense->getInputTextType() ?>" name="x_dateLicense" id="x_dateLicense" data-table="fed_licenseschool" data-field="x_dateLicense" value="<?= $Page->dateLicense->EditValue ?>" placeholder="<?= HtmlEncode($Page->dateLicense->getPlaceHolder()) ?>"<?= $Page->dateLicense->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dateLicense->getErrorMessage(false) ?></div>
<?php if (!$Page->dateLicense->ReadOnly && !$Page->dateLicense->Disabled && !isset($Page->dateLicense->EditAttrs["readonly"]) && !isset($Page->dateLicense->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolsrch", "x_dateLicense", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_fed_licenseschool_dateLicense" class="ew-search-field2">
<input type="<?= $Page->dateLicense->getInputTextType() ?>" name="y_dateLicense" id="y_dateLicense" data-table="fed_licenseschool" data-field="x_dateLicense" value="<?= $Page->dateLicense->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->dateLicense->getPlaceHolder()) ?>"<?= $Page->dateLicense->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dateLicense->getErrorMessage(false) ?></div>
<?php if (!$Page->dateLicense->ReadOnly && !$Page->dateLicense->Disabled && !isset($Page->dateLicense->EditAttrs["readonly"]) && !isset($Page->dateLicense->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolsrch", "y_dateLicense", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->dateStart->Visible) { // dateStart ?>
<?php
if (!$Page->dateStart->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_dateStart" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->dateStart->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_dateStart" class="ew-search-caption ew-label"><?= $Page->dateStart->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_dateStart" id="z_dateStart" value="BETWEEN">
</div>
        </div>
        <div id="el_fed_licenseschool_dateStart" class="ew-search-field">
<input type="<?= $Page->dateStart->getInputTextType() ?>" name="x_dateStart" id="x_dateStart" data-table="fed_licenseschool" data-field="x_dateStart" value="<?= $Page->dateStart->EditValue ?>" placeholder="<?= HtmlEncode($Page->dateStart->getPlaceHolder()) ?>"<?= $Page->dateStart->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dateStart->getErrorMessage(false) ?></div>
<?php if (!$Page->dateStart->ReadOnly && !$Page->dateStart->Disabled && !isset($Page->dateStart->EditAttrs["readonly"]) && !isset($Page->dateStart->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolsrch", "x_dateStart", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_fed_licenseschool_dateStart" class="ew-search-field2">
<input type="<?= $Page->dateStart->getInputTextType() ?>" name="y_dateStart" id="y_dateStart" data-table="fed_licenseschool" data-field="x_dateStart" value="<?= $Page->dateStart->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->dateStart->getPlaceHolder()) ?>"<?= $Page->dateStart->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dateStart->getErrorMessage(false) ?></div>
<?php if (!$Page->dateStart->ReadOnly && !$Page->dateStart->Disabled && !isset($Page->dateStart->EditAttrs["readonly"]) && !isset($Page->dateStart->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolsrch", "y_dateStart", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->dateFinish->Visible) { // dateFinish ?>
<?php
if (!$Page->dateFinish->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_dateFinish" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->dateFinish->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_dateFinish" class="ew-search-caption ew-label"><?= $Page->dateFinish->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("BETWEEN") ?>
<input type="hidden" name="z_dateFinish" id="z_dateFinish" value="BETWEEN">
</div>
        </div>
        <div id="el_fed_licenseschool_dateFinish" class="ew-search-field">
<input type="<?= $Page->dateFinish->getInputTextType() ?>" name="x_dateFinish" id="x_dateFinish" data-table="fed_licenseschool" data-field="x_dateFinish" value="<?= $Page->dateFinish->EditValue ?>" placeholder="<?= HtmlEncode($Page->dateFinish->getPlaceHolder()) ?>"<?= $Page->dateFinish->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dateFinish->getErrorMessage(false) ?></div>
<?php if (!$Page->dateFinish->ReadOnly && !$Page->dateFinish->Disabled && !isset($Page->dateFinish->EditAttrs["readonly"]) && !isset($Page->dateFinish->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolsrch", "x_dateFinish", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
        <div class="d-flex my-1 my-sm-0">
            <div class="ew-search-and"><label><?= $Language->phrase("AND") ?></label></div>
        </div><!-- /.ew-search-field -->
        <div id="el2_fed_licenseschool_dateFinish" class="ew-search-field2">
<input type="<?= $Page->dateFinish->getInputTextType() ?>" name="y_dateFinish" id="y_dateFinish" data-table="fed_licenseschool" data-field="x_dateFinish" value="<?= $Page->dateFinish->EditValue2 ?>" placeholder="<?= HtmlEncode($Page->dateFinish->getPlaceHolder()) ?>"<?= $Page->dateFinish->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->dateFinish->getErrorMessage(false) ?></div>
<?php if (!$Page->dateFinish->ReadOnly && !$Page->dateFinish->Disabled && !isset($Page->dateFinish->EditAttrs["readonly"]) && !isset($Page->dateFinish->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolsrch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolsrch", "y_dateFinish", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</div>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fed_licenseschool">
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
<form name="ffed_licenseschoollist" id="ffed_licenseschoollist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_licenseschool">
<?php if ($Page->getCurrentMasterTable() == "fed_applicationschool" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fed_applicationschool">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->application->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_fed_licenseschool" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_fed_licenseschoollist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_fed_licenseschool_id" class="fed_licenseschool_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->application->Visible) { // application ?>
        <th data-name="application" class="<?= $Page->application->headerCellClass() ?>"><div id="elh_fed_licenseschool_application" class="fed_licenseschool_application"><?= $Page->renderFieldHeader($Page->application) ?></div></th>
<?php } ?>
<?php if ($Page->dateLicense->Visible) { // dateLicense ?>
        <th data-name="dateLicense" class="<?= $Page->dateLicense->headerCellClass() ?>"><div id="elh_fed_licenseschool_dateLicense" class="fed_licenseschool_dateLicense"><?= $Page->renderFieldHeader($Page->dateLicense) ?></div></th>
<?php } ?>
<?php if ($Page->dateStart->Visible) { // dateStart ?>
        <th data-name="dateStart" class="<?= $Page->dateStart->headerCellClass() ?>"><div id="elh_fed_licenseschool_dateStart" class="fed_licenseschool_dateStart"><?= $Page->renderFieldHeader($Page->dateStart) ?></div></th>
<?php } ?>
<?php if ($Page->dateFinish->Visible) { // dateFinish ?>
        <th data-name="dateFinish" class="<?= $Page->dateFinish->headerCellClass() ?>"><div id="elh_fed_licenseschool_dateFinish" class="fed_licenseschool_dateFinish"><?= $Page->renderFieldHeader($Page->dateFinish) ?></div></th>
<?php } ?>
<?php if ($Page->schooltype->Visible) { // schooltype ?>
        <th data-name="schooltype" class="<?= $Page->schooltype->headerCellClass() ?>"><div id="elh_fed_licenseschool_schooltype" class="fed_licenseschool_schooltype"><?= $Page->renderFieldHeader($Page->schooltype) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_fed_licenseschool",
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
<span id="el<?= $Page->RowCount ?>_fed_licenseschool_id" class="el_fed_licenseschool_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->application->Visible) { // application ?>
        <td data-name="application"<?= $Page->application->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_licenseschool_application" class="el_fed_licenseschool_application">
<span<?= $Page->application->viewAttributes() ?>>
<?= $Page->application->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dateLicense->Visible) { // dateLicense ?>
        <td data-name="dateLicense"<?= $Page->dateLicense->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_licenseschool_dateLicense" class="el_fed_licenseschool_dateLicense">
<span<?= $Page->dateLicense->viewAttributes() ?>>
<?= $Page->dateLicense->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dateStart->Visible) { // dateStart ?>
        <td data-name="dateStart"<?= $Page->dateStart->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_licenseschool_dateStart" class="el_fed_licenseschool_dateStart">
<span<?= $Page->dateStart->viewAttributes() ?>>
<?= $Page->dateStart->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dateFinish->Visible) { // dateFinish ?>
        <td data-name="dateFinish"<?= $Page->dateFinish->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_licenseschool_dateFinish" class="el_fed_licenseschool_dateFinish">
<span<?= $Page->dateFinish->viewAttributes() ?>>
<?= $Page->dateFinish->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->schooltype->Visible) { // schooltype ?>
        <td data-name="schooltype"<?= $Page->schooltype->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_licenseschool_schooltype" class="el_fed_licenseschool_schooltype">
<span<?= $Page->schooltype->viewAttributes() ?>>
<?= $Page->schooltype->getViewValue() ?></span>
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
    ew.addEventHandlers("fed_licenseschool");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
