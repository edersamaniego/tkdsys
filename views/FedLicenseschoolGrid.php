<?php

namespace PHPMaker2022\school;

// Set up and run Grid object
$Grid = Container("FedLicenseschoolGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var ffed_licenseschoolgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_licenseschoolgrid = new ew.Form("ffed_licenseschoolgrid", "grid");
    ffed_licenseschoolgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { fed_licenseschool: currentTable } });
    var fields = currentTable.fields;
    ffed_licenseschoolgrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["application", [fields.application.visible && fields.application.required ? ew.Validators.required(fields.application.caption) : null, ew.Validators.integer], fields.application.isInvalid],
        ["dateLicense", [fields.dateLicense.visible && fields.dateLicense.required ? ew.Validators.required(fields.dateLicense.caption) : null, ew.Validators.datetime(fields.dateLicense.clientFormatPattern)], fields.dateLicense.isInvalid],
        ["dateStart", [fields.dateStart.visible && fields.dateStart.required ? ew.Validators.required(fields.dateStart.caption) : null, ew.Validators.datetime(fields.dateStart.clientFormatPattern)], fields.dateStart.isInvalid],
        ["dateFinish", [fields.dateFinish.visible && fields.dateFinish.required ? ew.Validators.required(fields.dateFinish.caption) : null, ew.Validators.datetime(fields.dateFinish.clientFormatPattern)], fields.dateFinish.isInvalid],
        ["schooltype", [fields.schooltype.visible && fields.schooltype.required ? ew.Validators.required(fields.schooltype.caption) : null], fields.schooltype.isInvalid]
    ]);

    // Check empty row
    ffed_licenseschoolgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["application",false],["dateLicense",false],["dateStart",false],["dateFinish",false],["schooltype",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    ffed_licenseschoolgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_licenseschoolgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffed_licenseschoolgrid.lists.application = <?= $Grid->application->toClientList($Grid) ?>;
    ffed_licenseschoolgrid.lists.schooltype = <?= $Grid->schooltype->toClientList($Grid) ?>;
    loadjs.done("ffed_licenseschoolgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fed_licenseschool">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="ffed_licenseschoolgrid" class="ew-form ew-list-form">
<div id="gmp_fed_licenseschool" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_fed_licenseschoolgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_fed_licenseschool_id" class="fed_licenseschool_id"><?= $Grid->renderFieldHeader($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->application->Visible) { // application ?>
        <th data-name="application" class="<?= $Grid->application->headerCellClass() ?>"><div id="elh_fed_licenseschool_application" class="fed_licenseschool_application"><?= $Grid->renderFieldHeader($Grid->application) ?></div></th>
<?php } ?>
<?php if ($Grid->dateLicense->Visible) { // dateLicense ?>
        <th data-name="dateLicense" class="<?= $Grid->dateLicense->headerCellClass() ?>"><div id="elh_fed_licenseschool_dateLicense" class="fed_licenseschool_dateLicense"><?= $Grid->renderFieldHeader($Grid->dateLicense) ?></div></th>
<?php } ?>
<?php if ($Grid->dateStart->Visible) { // dateStart ?>
        <th data-name="dateStart" class="<?= $Grid->dateStart->headerCellClass() ?>"><div id="elh_fed_licenseschool_dateStart" class="fed_licenseschool_dateStart"><?= $Grid->renderFieldHeader($Grid->dateStart) ?></div></th>
<?php } ?>
<?php if ($Grid->dateFinish->Visible) { // dateFinish ?>
        <th data-name="dateFinish" class="<?= $Grid->dateFinish->headerCellClass() ?>"><div id="elh_fed_licenseschool_dateFinish" class="fed_licenseschool_dateFinish"><?= $Grid->renderFieldHeader($Grid->dateFinish) ?></div></th>
<?php } ?>
<?php if ($Grid->schooltype->Visible) { // schooltype ?>
        <th data-name="schooltype" class="<?= $Grid->schooltype->headerCellClass() ?>"><div id="elh_fed_licenseschool_schooltype" class="fed_licenseschool_schooltype"><?= $Grid->renderFieldHeader($Grid->schooltype) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
$Grid->StartRecord = 1;
$Grid->StopRecord = $Grid->TotalRecords; // Show all records

// Restore number of post back records
if ($CurrentForm && ($Grid->isConfirm() || $Grid->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Grid->FormKeyCountName) && ($Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm())) {
        $Grid->KeyCount = $CurrentForm->getValue($Grid->FormKeyCountName);
        $Grid->StopRecord = $Grid->StartRecord + $Grid->KeyCount - 1;
    }
}
$Grid->RecordCount = $Grid->StartRecord - 1;
if ($Grid->Recordset && !$Grid->Recordset->EOF) {
    // Nothing to do
} elseif ($Grid->isGridAdd() && !$Grid->AllowAddDeleteRow && $Grid->StopRecord == 0) {
    $Grid->StopRecord = $Grid->GridAddRowCount;
}

// Initialize aggregate
$Grid->RowType = ROWTYPE_AGGREGATEINIT;
$Grid->resetAttributes();
$Grid->renderRow();
while ($Grid->RecordCount < $Grid->StopRecord) {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->RowCount++;
        if ($Grid->isAdd() || $Grid->isGridAdd() || $Grid->isGridEdit() || $Grid->isConfirm()) {
            $Grid->RowIndex++;
            $CurrentForm->Index = $Grid->RowIndex;
            if ($CurrentForm->hasValue($Grid->FormActionName) && ($Grid->isConfirm() || $Grid->EventCancelled)) {
                $Grid->RowAction = strval($CurrentForm->getValue($Grid->FormActionName));
            } elseif ($Grid->isGridAdd()) {
                $Grid->RowAction = "insert";
            } else {
                $Grid->RowAction = "";
            }
        }

        // Set up key count
        $Grid->KeyCount = $Grid->RowIndex;

        // Init row class and style
        $Grid->resetAttributes();
        $Grid->CssClass = "";
        if ($Grid->isGridAdd()) {
            if ($Grid->CurrentMode == "copy") {
                $Grid->loadRowValues($Grid->Recordset); // Load row values
                $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
            } else {
                $Grid->loadRowValues(); // Load default values
                $Grid->OldKey = "";
            }
        } else {
            $Grid->loadRowValues($Grid->Recordset); // Load row values
            $Grid->OldKey = $Grid->getKey(true); // Get from CurrentValue
        }
        $Grid->setKey($Grid->OldKey);
        $Grid->RowType = ROWTYPE_VIEW; // Render view
        if ($Grid->isGridAdd()) { // Grid add
            $Grid->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Grid->isGridAdd() && $Grid->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->isGridEdit()) { // Grid edit
            if ($Grid->EventCancelled) {
                $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
            }
            if ($Grid->RowAction == "insert") {
                $Grid->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Grid->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Grid->isGridEdit() && ($Grid->RowType == ROWTYPE_EDIT || $Grid->RowType == ROWTYPE_ADD) && $Grid->EventCancelled) { // Update failed
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }
        if ($Grid->RowType == ROWTYPE_EDIT) { // Edit row
            $Grid->EditRowCount++;
        }
        if ($Grid->isConfirm()) { // Confirm row
            $Grid->restoreCurrentRowFormValues($Grid->RowIndex); // Restore form values
        }

        // Set up row attributes
        $Grid->RowAttrs->merge([
            "data-rowindex" => $Grid->RowCount,
            "id" => "r" . $Grid->RowCount . "_fed_licenseschool",
            "data-rowtype" => $Grid->RowType,
            "class" => ($Grid->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Grid->isAdd() && $Grid->RowType == ROWTYPE_ADD || $Grid->isEdit() && $Grid->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Grid->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Grid->renderRow();

        // Render list options
        $Grid->renderListOptions();

        // Skip delete row / empty row for confirm page
        if (
            $Page->RowAction != "delete" &&
            $Page->RowAction != "insertdelete" &&
            !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())
        ) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->id->Visible) { // id ?>
        <td data-name="id"<?= $Grid->id->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_id" class="el_fed_licenseschool_id"></span>
<input type="hidden" data-table="fed_licenseschool" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_id" class="el_fed_licenseschool_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fed_licenseschool" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_id" class="el_fed_licenseschool_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_licenseschool" data-field="x_id" data-hidden="1" name="ffed_licenseschoolgrid$x<?= $Grid->RowIndex ?>_id" id="ffed_licenseschoolgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="fed_licenseschool" data-field="x_id" data-hidden="1" name="ffed_licenseschoolgrid$o<?= $Grid->RowIndex ?>_id" id="ffed_licenseschoolgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="fed_licenseschool" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->application->Visible) { // application ?>
        <td data-name="application"<?= $Grid->application->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->application->getSessionValue() != "") { ?>
<span<?= $Grid->application->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->application->getDisplayValue($Grid->application->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_application" name="x<?= $Grid->RowIndex ?>_application" value="<?= HtmlEncode($Grid->application->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_application" class="el_fed_licenseschool_application">
<?php
$onchange = $Grid->application->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->application->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->application->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_application" class="ew-auto-suggest">
    <input type="<?= $Grid->application->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_application" id="sv_x<?= $Grid->RowIndex ?>_application" value="<?= RemoveHtml($Grid->application->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->application->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->application->getPlaceHolder()) ?>"<?= $Grid->application->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="fed_licenseschool" data-field="x_application" data-input="sv_x<?= $Grid->RowIndex ?>_application" data-value-separator="<?= $Grid->application->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_application" id="x<?= $Grid->RowIndex ?>_application" value="<?= HtmlEncode($Grid->application->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->application->getErrorMessage() ?></div>
<script>
loadjs.ready("ffed_licenseschoolgrid", function() {
    ffed_licenseschoolgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_application","forceSelect":false}, ew.vars.tables.fed_licenseschool.fields.application.autoSuggestOptions));
});
</script>
<?= $Grid->application->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_application") ?>
</span>
<?php } ?>
<input type="hidden" data-table="fed_licenseschool" data-field="x_application" data-hidden="1" name="o<?= $Grid->RowIndex ?>_application" id="o<?= $Grid->RowIndex ?>_application" value="<?= HtmlEncode($Grid->application->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->application->getSessionValue() != "") { ?>
<span<?= $Grid->application->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->application->getDisplayValue($Grid->application->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_application" name="x<?= $Grid->RowIndex ?>_application" value="<?= HtmlEncode($Grid->application->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_application" class="el_fed_licenseschool_application">
<?php
$onchange = $Grid->application->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->application->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->application->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_application" class="ew-auto-suggest">
    <input type="<?= $Grid->application->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_application" id="sv_x<?= $Grid->RowIndex ?>_application" value="<?= RemoveHtml($Grid->application->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->application->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->application->getPlaceHolder()) ?>"<?= $Grid->application->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="fed_licenseschool" data-field="x_application" data-input="sv_x<?= $Grid->RowIndex ?>_application" data-value-separator="<?= $Grid->application->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_application" id="x<?= $Grid->RowIndex ?>_application" value="<?= HtmlEncode($Grid->application->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->application->getErrorMessage() ?></div>
<script>
loadjs.ready("ffed_licenseschoolgrid", function() {
    ffed_licenseschoolgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_application","forceSelect":false}, ew.vars.tables.fed_licenseschool.fields.application.autoSuggestOptions));
});
</script>
<?= $Grid->application->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_application") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_application" class="el_fed_licenseschool_application">
<span<?= $Grid->application->viewAttributes() ?>>
<?= $Grid->application->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_licenseschool" data-field="x_application" data-hidden="1" name="ffed_licenseschoolgrid$x<?= $Grid->RowIndex ?>_application" id="ffed_licenseschoolgrid$x<?= $Grid->RowIndex ?>_application" value="<?= HtmlEncode($Grid->application->FormValue) ?>">
<input type="hidden" data-table="fed_licenseschool" data-field="x_application" data-hidden="1" name="ffed_licenseschoolgrid$o<?= $Grid->RowIndex ?>_application" id="ffed_licenseschoolgrid$o<?= $Grid->RowIndex ?>_application" value="<?= HtmlEncode($Grid->application->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->dateLicense->Visible) { // dateLicense ?>
        <td data-name="dateLicense"<?= $Grid->dateLicense->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_dateLicense" class="el_fed_licenseschool_dateLicense">
<input type="<?= $Grid->dateLicense->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dateLicense" id="x<?= $Grid->RowIndex ?>_dateLicense" data-table="fed_licenseschool" data-field="x_dateLicense" value="<?= $Grid->dateLicense->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dateLicense->getPlaceHolder()) ?>"<?= $Grid->dateLicense->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dateLicense->getErrorMessage() ?></div>
<?php if (!$Grid->dateLicense->ReadOnly && !$Grid->dateLicense->Disabled && !isset($Grid->dateLicense->EditAttrs["readonly"]) && !isset($Grid->dateLicense->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolgrid", "x<?= $Grid->RowIndex ?>_dateLicense", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateLicense" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dateLicense" id="o<?= $Grid->RowIndex ?>_dateLicense" value="<?= HtmlEncode($Grid->dateLicense->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_dateLicense" class="el_fed_licenseschool_dateLicense">
<input type="<?= $Grid->dateLicense->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dateLicense" id="x<?= $Grid->RowIndex ?>_dateLicense" data-table="fed_licenseschool" data-field="x_dateLicense" value="<?= $Grid->dateLicense->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dateLicense->getPlaceHolder()) ?>"<?= $Grid->dateLicense->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dateLicense->getErrorMessage() ?></div>
<?php if (!$Grid->dateLicense->ReadOnly && !$Grid->dateLicense->Disabled && !isset($Grid->dateLicense->EditAttrs["readonly"]) && !isset($Grid->dateLicense->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolgrid", "x<?= $Grid->RowIndex ?>_dateLicense", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_dateLicense" class="el_fed_licenseschool_dateLicense">
<span<?= $Grid->dateLicense->viewAttributes() ?>>
<?= $Grid->dateLicense->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateLicense" data-hidden="1" name="ffed_licenseschoolgrid$x<?= $Grid->RowIndex ?>_dateLicense" id="ffed_licenseschoolgrid$x<?= $Grid->RowIndex ?>_dateLicense" value="<?= HtmlEncode($Grid->dateLicense->FormValue) ?>">
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateLicense" data-hidden="1" name="ffed_licenseschoolgrid$o<?= $Grid->RowIndex ?>_dateLicense" id="ffed_licenseschoolgrid$o<?= $Grid->RowIndex ?>_dateLicense" value="<?= HtmlEncode($Grid->dateLicense->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->dateStart->Visible) { // dateStart ?>
        <td data-name="dateStart"<?= $Grid->dateStart->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_dateStart" class="el_fed_licenseschool_dateStart">
<input type="<?= $Grid->dateStart->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dateStart" id="x<?= $Grid->RowIndex ?>_dateStart" data-table="fed_licenseschool" data-field="x_dateStart" value="<?= $Grid->dateStart->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dateStart->getPlaceHolder()) ?>"<?= $Grid->dateStart->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dateStart->getErrorMessage() ?></div>
<?php if (!$Grid->dateStart->ReadOnly && !$Grid->dateStart->Disabled && !isset($Grid->dateStart->EditAttrs["readonly"]) && !isset($Grid->dateStart->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolgrid", "x<?= $Grid->RowIndex ?>_dateStart", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateStart" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dateStart" id="o<?= $Grid->RowIndex ?>_dateStart" value="<?= HtmlEncode($Grid->dateStart->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_dateStart" class="el_fed_licenseschool_dateStart">
<input type="<?= $Grid->dateStart->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dateStart" id="x<?= $Grid->RowIndex ?>_dateStart" data-table="fed_licenseschool" data-field="x_dateStart" value="<?= $Grid->dateStart->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dateStart->getPlaceHolder()) ?>"<?= $Grid->dateStart->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dateStart->getErrorMessage() ?></div>
<?php if (!$Grid->dateStart->ReadOnly && !$Grid->dateStart->Disabled && !isset($Grid->dateStart->EditAttrs["readonly"]) && !isset($Grid->dateStart->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolgrid", "x<?= $Grid->RowIndex ?>_dateStart", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_dateStart" class="el_fed_licenseschool_dateStart">
<span<?= $Grid->dateStart->viewAttributes() ?>>
<?= $Grid->dateStart->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateStart" data-hidden="1" name="ffed_licenseschoolgrid$x<?= $Grid->RowIndex ?>_dateStart" id="ffed_licenseschoolgrid$x<?= $Grid->RowIndex ?>_dateStart" value="<?= HtmlEncode($Grid->dateStart->FormValue) ?>">
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateStart" data-hidden="1" name="ffed_licenseschoolgrid$o<?= $Grid->RowIndex ?>_dateStart" id="ffed_licenseschoolgrid$o<?= $Grid->RowIndex ?>_dateStart" value="<?= HtmlEncode($Grid->dateStart->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->dateFinish->Visible) { // dateFinish ?>
        <td data-name="dateFinish"<?= $Grid->dateFinish->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_dateFinish" class="el_fed_licenseschool_dateFinish">
<input type="<?= $Grid->dateFinish->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dateFinish" id="x<?= $Grid->RowIndex ?>_dateFinish" data-table="fed_licenseschool" data-field="x_dateFinish" value="<?= $Grid->dateFinish->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dateFinish->getPlaceHolder()) ?>"<?= $Grid->dateFinish->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dateFinish->getErrorMessage() ?></div>
<?php if (!$Grid->dateFinish->ReadOnly && !$Grid->dateFinish->Disabled && !isset($Grid->dateFinish->EditAttrs["readonly"]) && !isset($Grid->dateFinish->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolgrid", "x<?= $Grid->RowIndex ?>_dateFinish", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateFinish" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dateFinish" id="o<?= $Grid->RowIndex ?>_dateFinish" value="<?= HtmlEncode($Grid->dateFinish->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_dateFinish" class="el_fed_licenseschool_dateFinish">
<input type="<?= $Grid->dateFinish->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dateFinish" id="x<?= $Grid->RowIndex ?>_dateFinish" data-table="fed_licenseschool" data-field="x_dateFinish" value="<?= $Grid->dateFinish->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dateFinish->getPlaceHolder()) ?>"<?= $Grid->dateFinish->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dateFinish->getErrorMessage() ?></div>
<?php if (!$Grid->dateFinish->ReadOnly && !$Grid->dateFinish->Disabled && !isset($Grid->dateFinish->EditAttrs["readonly"]) && !isset($Grid->dateFinish->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolgrid", "x<?= $Grid->RowIndex ?>_dateFinish", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_dateFinish" class="el_fed_licenseschool_dateFinish">
<span<?= $Grid->dateFinish->viewAttributes() ?>>
<?= $Grid->dateFinish->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateFinish" data-hidden="1" name="ffed_licenseschoolgrid$x<?= $Grid->RowIndex ?>_dateFinish" id="ffed_licenseschoolgrid$x<?= $Grid->RowIndex ?>_dateFinish" value="<?= HtmlEncode($Grid->dateFinish->FormValue) ?>">
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateFinish" data-hidden="1" name="ffed_licenseschoolgrid$o<?= $Grid->RowIndex ?>_dateFinish" id="ffed_licenseschoolgrid$o<?= $Grid->RowIndex ?>_dateFinish" value="<?= HtmlEncode($Grid->dateFinish->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->schooltype->Visible) { // schooltype ?>
        <td data-name="schooltype"<?= $Grid->schooltype->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_schooltype" class="el_fed_licenseschool_schooltype">
    <select
        id="x<?= $Grid->RowIndex ?>_schooltype"
        name="x<?= $Grid->RowIndex ?>_schooltype"
        class="form-select ew-select<?= $Grid->schooltype->isInvalidClass() ?>"
        data-select2-id="ffed_licenseschoolgrid_x<?= $Grid->RowIndex ?>_schooltype"
        data-table="fed_licenseschool"
        data-field="x_schooltype"
        data-value-separator="<?= $Grid->schooltype->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->schooltype->getPlaceHolder()) ?>"
        <?= $Grid->schooltype->editAttributes() ?>>
        <?= $Grid->schooltype->selectOptionListHtml("x{$Grid->RowIndex}_schooltype") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->schooltype->getErrorMessage() ?></div>
<?= $Grid->schooltype->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schooltype") ?>
<script>
loadjs.ready("ffed_licenseschoolgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_schooltype", selectId: "ffed_licenseschoolgrid_x<?= $Grid->RowIndex ?>_schooltype" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_licenseschoolgrid.lists.schooltype.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_schooltype", form: "ffed_licenseschoolgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_schooltype", form: "ffed_licenseschoolgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_licenseschool.fields.schooltype.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="fed_licenseschool" data-field="x_schooltype" data-hidden="1" name="o<?= $Grid->RowIndex ?>_schooltype" id="o<?= $Grid->RowIndex ?>_schooltype" value="<?= HtmlEncode($Grid->schooltype->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_schooltype" class="el_fed_licenseschool_schooltype">
    <select
        id="x<?= $Grid->RowIndex ?>_schooltype"
        name="x<?= $Grid->RowIndex ?>_schooltype"
        class="form-select ew-select<?= $Grid->schooltype->isInvalidClass() ?>"
        data-select2-id="ffed_licenseschoolgrid_x<?= $Grid->RowIndex ?>_schooltype"
        data-table="fed_licenseschool"
        data-field="x_schooltype"
        data-value-separator="<?= $Grid->schooltype->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->schooltype->getPlaceHolder()) ?>"
        <?= $Grid->schooltype->editAttributes() ?>>
        <?= $Grid->schooltype->selectOptionListHtml("x{$Grid->RowIndex}_schooltype") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->schooltype->getErrorMessage() ?></div>
<?= $Grid->schooltype->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schooltype") ?>
<script>
loadjs.ready("ffed_licenseschoolgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_schooltype", selectId: "ffed_licenseschoolgrid_x<?= $Grid->RowIndex ?>_schooltype" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_licenseschoolgrid.lists.schooltype.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_schooltype", form: "ffed_licenseschoolgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_schooltype", form: "ffed_licenseschoolgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_licenseschool.fields.schooltype.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_licenseschool_schooltype" class="el_fed_licenseschool_schooltype">
<span<?= $Grid->schooltype->viewAttributes() ?>>
<?= $Grid->schooltype->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_licenseschool" data-field="x_schooltype" data-hidden="1" name="ffed_licenseschoolgrid$x<?= $Grid->RowIndex ?>_schooltype" id="ffed_licenseschoolgrid$x<?= $Grid->RowIndex ?>_schooltype" value="<?= HtmlEncode($Grid->schooltype->FormValue) ?>">
<input type="hidden" data-table="fed_licenseschool" data-field="x_schooltype" data-hidden="1" name="ffed_licenseschoolgrid$o<?= $Grid->RowIndex ?>_schooltype" id="ffed_licenseschoolgrid$o<?= $Grid->RowIndex ?>_schooltype" value="<?= HtmlEncode($Grid->schooltype->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["ffed_licenseschoolgrid","load"], () => ffed_licenseschoolgrid.updateLists(<?= $Grid->RowIndex ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy")
        if (!$Grid->Recordset->EOF) {
            $Grid->Recordset->moveNext();
        }
}
?>
<?php
if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy" || $Grid->CurrentMode == "edit") {
    $Grid->RowIndex = '$rowindex$';
    $Grid->loadRowValues();

    // Set row properties
    $Grid->resetAttributes();
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_fed_licenseschool", "data-rowtype" => ROWTYPE_ADD]);
    $Grid->RowAttrs->appendClass("ew-template");

    // Reset previous form error if any
    $Grid->resetFormError();

    // Render row
    $Grid->RowType = ROWTYPE_ADD;
    $Grid->renderRow();

    // Render list options
    $Grid->renderListOptions();
    $Grid->StartRowCount = 0;
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowIndex);
?>
    <?php if ($Grid->id->Visible) { // id ?>
        <td data-name="id">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_licenseschool_id" class="el_fed_licenseschool_id"></span>
<?php } else { ?>
<span id="el$rowindex$_fed_licenseschool_id" class="el_fed_licenseschool_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_licenseschool" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_licenseschool" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->application->Visible) { // application ?>
        <td data-name="application">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->application->getSessionValue() != "") { ?>
<span<?= $Grid->application->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->application->getDisplayValue($Grid->application->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_application" name="x<?= $Grid->RowIndex ?>_application" value="<?= HtmlEncode($Grid->application->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_fed_licenseschool_application" class="el_fed_licenseschool_application">
<?php
$onchange = $Grid->application->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->application->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->application->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_application" class="ew-auto-suggest">
    <input type="<?= $Grid->application->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_application" id="sv_x<?= $Grid->RowIndex ?>_application" value="<?= RemoveHtml($Grid->application->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->application->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->application->getPlaceHolder()) ?>"<?= $Grid->application->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="fed_licenseschool" data-field="x_application" data-input="sv_x<?= $Grid->RowIndex ?>_application" data-value-separator="<?= $Grid->application->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_application" id="x<?= $Grid->RowIndex ?>_application" value="<?= HtmlEncode($Grid->application->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->application->getErrorMessage() ?></div>
<script>
loadjs.ready("ffed_licenseschoolgrid", function() {
    ffed_licenseschoolgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_application","forceSelect":false}, ew.vars.tables.fed_licenseschool.fields.application.autoSuggestOptions));
});
</script>
<?= $Grid->application->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_application") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_fed_licenseschool_application" class="el_fed_licenseschool_application">
<span<?= $Grid->application->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->application->getDisplayValue($Grid->application->ViewValue) ?></span></span>
<input type="hidden" data-table="fed_licenseschool" data-field="x_application" data-hidden="1" name="x<?= $Grid->RowIndex ?>_application" id="x<?= $Grid->RowIndex ?>_application" value="<?= HtmlEncode($Grid->application->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_licenseschool" data-field="x_application" data-hidden="1" name="o<?= $Grid->RowIndex ?>_application" id="o<?= $Grid->RowIndex ?>_application" value="<?= HtmlEncode($Grid->application->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->dateLicense->Visible) { // dateLicense ?>
        <td data-name="dateLicense">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_licenseschool_dateLicense" class="el_fed_licenseschool_dateLicense">
<input type="<?= $Grid->dateLicense->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dateLicense" id="x<?= $Grid->RowIndex ?>_dateLicense" data-table="fed_licenseschool" data-field="x_dateLicense" value="<?= $Grid->dateLicense->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dateLicense->getPlaceHolder()) ?>"<?= $Grid->dateLicense->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dateLicense->getErrorMessage() ?></div>
<?php if (!$Grid->dateLicense->ReadOnly && !$Grid->dateLicense->Disabled && !isset($Grid->dateLicense->EditAttrs["readonly"]) && !isset($Grid->dateLicense->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolgrid", "x<?= $Grid->RowIndex ?>_dateLicense", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_licenseschool_dateLicense" class="el_fed_licenseschool_dateLicense">
<span<?= $Grid->dateLicense->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->dateLicense->getDisplayValue($Grid->dateLicense->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateLicense" data-hidden="1" name="x<?= $Grid->RowIndex ?>_dateLicense" id="x<?= $Grid->RowIndex ?>_dateLicense" value="<?= HtmlEncode($Grid->dateLicense->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateLicense" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dateLicense" id="o<?= $Grid->RowIndex ?>_dateLicense" value="<?= HtmlEncode($Grid->dateLicense->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->dateStart->Visible) { // dateStart ?>
        <td data-name="dateStart">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_licenseschool_dateStart" class="el_fed_licenseschool_dateStart">
<input type="<?= $Grid->dateStart->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dateStart" id="x<?= $Grid->RowIndex ?>_dateStart" data-table="fed_licenseschool" data-field="x_dateStart" value="<?= $Grid->dateStart->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dateStart->getPlaceHolder()) ?>"<?= $Grid->dateStart->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dateStart->getErrorMessage() ?></div>
<?php if (!$Grid->dateStart->ReadOnly && !$Grid->dateStart->Disabled && !isset($Grid->dateStart->EditAttrs["readonly"]) && !isset($Grid->dateStart->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolgrid", "x<?= $Grid->RowIndex ?>_dateStart", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_licenseschool_dateStart" class="el_fed_licenseschool_dateStart">
<span<?= $Grid->dateStart->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->dateStart->getDisplayValue($Grid->dateStart->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateStart" data-hidden="1" name="x<?= $Grid->RowIndex ?>_dateStart" id="x<?= $Grid->RowIndex ?>_dateStart" value="<?= HtmlEncode($Grid->dateStart->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateStart" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dateStart" id="o<?= $Grid->RowIndex ?>_dateStart" value="<?= HtmlEncode($Grid->dateStart->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->dateFinish->Visible) { // dateFinish ?>
        <td data-name="dateFinish">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_licenseschool_dateFinish" class="el_fed_licenseschool_dateFinish">
<input type="<?= $Grid->dateFinish->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dateFinish" id="x<?= $Grid->RowIndex ?>_dateFinish" data-table="fed_licenseschool" data-field="x_dateFinish" value="<?= $Grid->dateFinish->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dateFinish->getPlaceHolder()) ?>"<?= $Grid->dateFinish->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dateFinish->getErrorMessage() ?></div>
<?php if (!$Grid->dateFinish->ReadOnly && !$Grid->dateFinish->Disabled && !isset($Grid->dateFinish->EditAttrs["readonly"]) && !isset($Grid->dateFinish->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_licenseschoolgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_licenseschoolgrid", "x<?= $Grid->RowIndex ?>_dateFinish", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_licenseschool_dateFinish" class="el_fed_licenseschool_dateFinish">
<span<?= $Grid->dateFinish->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->dateFinish->getDisplayValue($Grid->dateFinish->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateFinish" data-hidden="1" name="x<?= $Grid->RowIndex ?>_dateFinish" id="x<?= $Grid->RowIndex ?>_dateFinish" value="<?= HtmlEncode($Grid->dateFinish->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_licenseschool" data-field="x_dateFinish" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dateFinish" id="o<?= $Grid->RowIndex ?>_dateFinish" value="<?= HtmlEncode($Grid->dateFinish->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->schooltype->Visible) { // schooltype ?>
        <td data-name="schooltype">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_licenseschool_schooltype" class="el_fed_licenseschool_schooltype">
    <select
        id="x<?= $Grid->RowIndex ?>_schooltype"
        name="x<?= $Grid->RowIndex ?>_schooltype"
        class="form-select ew-select<?= $Grid->schooltype->isInvalidClass() ?>"
        data-select2-id="ffed_licenseschoolgrid_x<?= $Grid->RowIndex ?>_schooltype"
        data-table="fed_licenseschool"
        data-field="x_schooltype"
        data-value-separator="<?= $Grid->schooltype->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->schooltype->getPlaceHolder()) ?>"
        <?= $Grid->schooltype->editAttributes() ?>>
        <?= $Grid->schooltype->selectOptionListHtml("x{$Grid->RowIndex}_schooltype") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->schooltype->getErrorMessage() ?></div>
<?= $Grid->schooltype->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schooltype") ?>
<script>
loadjs.ready("ffed_licenseschoolgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_schooltype", selectId: "ffed_licenseschoolgrid_x<?= $Grid->RowIndex ?>_schooltype" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_licenseschoolgrid.lists.schooltype.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_schooltype", form: "ffed_licenseschoolgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_schooltype", form: "ffed_licenseschoolgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_licenseschool.fields.schooltype.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_licenseschool_schooltype" class="el_fed_licenseschool_schooltype">
<span<?= $Grid->schooltype->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->schooltype->getDisplayValue($Grid->schooltype->ViewValue) ?></span></span>
<input type="hidden" data-table="fed_licenseschool" data-field="x_schooltype" data-hidden="1" name="x<?= $Grid->RowIndex ?>_schooltype" id="x<?= $Grid->RowIndex ?>_schooltype" value="<?= HtmlEncode($Grid->schooltype->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_licenseschool" data-field="x_schooltype" data-hidden="1" name="o<?= $Grid->RowIndex ?>_schooltype" id="o<?= $Grid->RowIndex ?>_schooltype" value="<?= HtmlEncode($Grid->schooltype->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["ffed_licenseschoolgrid","load"], () => ffed_licenseschoolgrid.updateLists(<?= $Grid->RowIndex ?>, true));
</script>
    </tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ffed_licenseschoolgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php if (!$Grid->isExport()) { ?>
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
