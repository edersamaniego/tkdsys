<?php

namespace PHPMaker2022\school;

// Set up and run Grid object
$Grid = Container("FedVideosubsectionGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var ffed_videosubsectiongrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_videosubsectiongrid = new ew.Form("ffed_videosubsectiongrid", "grid");
    ffed_videosubsectiongrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { fed_videosubsection: currentTable } });
    var fields = currentTable.fields;
    ffed_videosubsectiongrid.addFields([
        ["section", [fields.section.visible && fields.section.required ? ew.Validators.required(fields.section.caption) : null], fields.section.isInvalid],
        ["subsection", [fields.subsection.visible && fields.subsection.required ? ew.Validators.required(fields.subsection.caption) : null], fields.subsection.isInvalid],
        ["subsectionBr", [fields.subsectionBr.visible && fields.subsectionBr.required ? ew.Validators.required(fields.subsectionBr.caption) : null], fields.subsectionBr.isInvalid],
        ["subsectionSp", [fields.subsectionSp.visible && fields.subsectionSp.required ? ew.Validators.required(fields.subsectionSp.caption) : null], fields.subsectionSp.isInvalid]
    ]);

    // Check empty row
    ffed_videosubsectiongrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["section",false],["subsection",false],["subsectionBr",false],["subsectionSp",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    ffed_videosubsectiongrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_videosubsectiongrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffed_videosubsectiongrid.lists.section = <?= $Grid->section->toClientList($Grid) ?>;
    loadjs.done("ffed_videosubsectiongrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fed_videosubsection">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="ffed_videosubsectiongrid" class="ew-form ew-list-form">
<div id="gmp_fed_videosubsection" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_fed_videosubsectiongrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->section->Visible) { // section ?>
        <th data-name="section" class="<?= $Grid->section->headerCellClass() ?>"><div id="elh_fed_videosubsection_section" class="fed_videosubsection_section"><?= $Grid->renderFieldHeader($Grid->section) ?></div></th>
<?php } ?>
<?php if ($Grid->subsection->Visible) { // subsection ?>
        <th data-name="subsection" class="<?= $Grid->subsection->headerCellClass() ?>"><div id="elh_fed_videosubsection_subsection" class="fed_videosubsection_subsection"><?= $Grid->renderFieldHeader($Grid->subsection) ?></div></th>
<?php } ?>
<?php if ($Grid->subsectionBr->Visible) { // subsectionBr ?>
        <th data-name="subsectionBr" class="<?= $Grid->subsectionBr->headerCellClass() ?>"><div id="elh_fed_videosubsection_subsectionBr" class="fed_videosubsection_subsectionBr"><?= $Grid->renderFieldHeader($Grid->subsectionBr) ?></div></th>
<?php } ?>
<?php if ($Grid->subsectionSp->Visible) { // subsectionSp ?>
        <th data-name="subsectionSp" class="<?= $Grid->subsectionSp->headerCellClass() ?>"><div id="elh_fed_videosubsection_subsectionSp" class="fed_videosubsection_subsectionSp"><?= $Grid->renderFieldHeader($Grid->subsectionSp) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_fed_videosubsection",
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
    <?php if ($Grid->section->Visible) { // section ?>
        <td data-name="section"<?= $Grid->section->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->section->getSessionValue() != "") { ?>
<span<?= $Grid->section->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->section->getDisplayValue($Grid->section->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_section" name="x<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fed_videosubsection_section" class="el_fed_videosubsection_section">
    <select
        id="x<?= $Grid->RowIndex ?>_section"
        name="x<?= $Grid->RowIndex ?>_section"
        class="form-select ew-select<?= $Grid->section->isInvalidClass() ?>"
        data-select2-id="ffed_videosubsectiongrid_x<?= $Grid->RowIndex ?>_section"
        data-table="fed_videosubsection"
        data-field="x_section"
        data-value-separator="<?= $Grid->section->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->section->getPlaceHolder()) ?>"
        <?= $Grid->section->editAttributes() ?>>
        <?= $Grid->section->selectOptionListHtml("x{$Grid->RowIndex}_section") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->section->getErrorMessage() ?></div>
<?= $Grid->section->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_section") ?>
<script>
loadjs.ready("ffed_videosubsectiongrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_section", selectId: "ffed_videosubsectiongrid_x<?= $Grid->RowIndex ?>_section" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_videosubsectiongrid.lists.section.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_section", form: "ffed_videosubsectiongrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_section", form: "ffed_videosubsectiongrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_videosubsection.fields.section.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="fed_videosubsection" data-field="x_section" data-hidden="1" name="o<?= $Grid->RowIndex ?>_section" id="o<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->section->getSessionValue() != "") { ?>
<span<?= $Grid->section->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->section->getDisplayValue($Grid->section->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_section" name="x<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fed_videosubsection_section" class="el_fed_videosubsection_section">
    <select
        id="x<?= $Grid->RowIndex ?>_section"
        name="x<?= $Grid->RowIndex ?>_section"
        class="form-select ew-select<?= $Grid->section->isInvalidClass() ?>"
        data-select2-id="ffed_videosubsectiongrid_x<?= $Grid->RowIndex ?>_section"
        data-table="fed_videosubsection"
        data-field="x_section"
        data-value-separator="<?= $Grid->section->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->section->getPlaceHolder()) ?>"
        <?= $Grid->section->editAttributes() ?>>
        <?= $Grid->section->selectOptionListHtml("x{$Grid->RowIndex}_section") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->section->getErrorMessage() ?></div>
<?= $Grid->section->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_section") ?>
<script>
loadjs.ready("ffed_videosubsectiongrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_section", selectId: "ffed_videosubsectiongrid_x<?= $Grid->RowIndex ?>_section" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_videosubsectiongrid.lists.section.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_section", form: "ffed_videosubsectiongrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_section", form: "ffed_videosubsectiongrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_videosubsection.fields.section.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_videosubsection_section" class="el_fed_videosubsection_section">
<span<?= $Grid->section->viewAttributes() ?>>
<?= $Grid->section->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_videosubsection" data-field="x_section" data-hidden="1" name="ffed_videosubsectiongrid$x<?= $Grid->RowIndex ?>_section" id="ffed_videosubsectiongrid$x<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->FormValue) ?>">
<input type="hidden" data-table="fed_videosubsection" data-field="x_section" data-hidden="1" name="ffed_videosubsectiongrid$o<?= $Grid->RowIndex ?>_section" id="ffed_videosubsectiongrid$o<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->subsection->Visible) { // subsection ?>
        <td data-name="subsection"<?= $Grid->subsection->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_videosubsection_subsection" class="el_fed_videosubsection_subsection">
<input type="<?= $Grid->subsection->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_subsection" id="x<?= $Grid->RowIndex ?>_subsection" data-table="fed_videosubsection" data-field="x_subsection" value="<?= $Grid->subsection->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->subsection->getPlaceHolder()) ?>"<?= $Grid->subsection->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subsection->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsection" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subsection" id="o<?= $Grid->RowIndex ?>_subsection" value="<?= HtmlEncode($Grid->subsection->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_videosubsection_subsection" class="el_fed_videosubsection_subsection">
<input type="<?= $Grid->subsection->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_subsection" id="x<?= $Grid->RowIndex ?>_subsection" data-table="fed_videosubsection" data-field="x_subsection" value="<?= $Grid->subsection->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->subsection->getPlaceHolder()) ?>"<?= $Grid->subsection->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subsection->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_videosubsection_subsection" class="el_fed_videosubsection_subsection">
<span<?= $Grid->subsection->viewAttributes() ?>>
<?= $Grid->subsection->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsection" data-hidden="1" name="ffed_videosubsectiongrid$x<?= $Grid->RowIndex ?>_subsection" id="ffed_videosubsectiongrid$x<?= $Grid->RowIndex ?>_subsection" value="<?= HtmlEncode($Grid->subsection->FormValue) ?>">
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsection" data-hidden="1" name="ffed_videosubsectiongrid$o<?= $Grid->RowIndex ?>_subsection" id="ffed_videosubsectiongrid$o<?= $Grid->RowIndex ?>_subsection" value="<?= HtmlEncode($Grid->subsection->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->subsectionBr->Visible) { // subsectionBr ?>
        <td data-name="subsectionBr"<?= $Grid->subsectionBr->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_videosubsection_subsectionBr" class="el_fed_videosubsection_subsectionBr">
<input type="<?= $Grid->subsectionBr->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_subsectionBr" id="x<?= $Grid->RowIndex ?>_subsectionBr" data-table="fed_videosubsection" data-field="x_subsectionBr" value="<?= $Grid->subsectionBr->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->subsectionBr->getPlaceHolder()) ?>"<?= $Grid->subsectionBr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subsectionBr->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsectionBr" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subsectionBr" id="o<?= $Grid->RowIndex ?>_subsectionBr" value="<?= HtmlEncode($Grid->subsectionBr->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_videosubsection_subsectionBr" class="el_fed_videosubsection_subsectionBr">
<input type="<?= $Grid->subsectionBr->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_subsectionBr" id="x<?= $Grid->RowIndex ?>_subsectionBr" data-table="fed_videosubsection" data-field="x_subsectionBr" value="<?= $Grid->subsectionBr->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->subsectionBr->getPlaceHolder()) ?>"<?= $Grid->subsectionBr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subsectionBr->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_videosubsection_subsectionBr" class="el_fed_videosubsection_subsectionBr">
<span<?= $Grid->subsectionBr->viewAttributes() ?>>
<?= $Grid->subsectionBr->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsectionBr" data-hidden="1" name="ffed_videosubsectiongrid$x<?= $Grid->RowIndex ?>_subsectionBr" id="ffed_videosubsectiongrid$x<?= $Grid->RowIndex ?>_subsectionBr" value="<?= HtmlEncode($Grid->subsectionBr->FormValue) ?>">
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsectionBr" data-hidden="1" name="ffed_videosubsectiongrid$o<?= $Grid->RowIndex ?>_subsectionBr" id="ffed_videosubsectiongrid$o<?= $Grid->RowIndex ?>_subsectionBr" value="<?= HtmlEncode($Grid->subsectionBr->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->subsectionSp->Visible) { // subsectionSp ?>
        <td data-name="subsectionSp"<?= $Grid->subsectionSp->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_videosubsection_subsectionSp" class="el_fed_videosubsection_subsectionSp">
<input type="<?= $Grid->subsectionSp->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_subsectionSp" id="x<?= $Grid->RowIndex ?>_subsectionSp" data-table="fed_videosubsection" data-field="x_subsectionSp" value="<?= $Grid->subsectionSp->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->subsectionSp->getPlaceHolder()) ?>"<?= $Grid->subsectionSp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subsectionSp->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsectionSp" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subsectionSp" id="o<?= $Grid->RowIndex ?>_subsectionSp" value="<?= HtmlEncode($Grid->subsectionSp->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_videosubsection_subsectionSp" class="el_fed_videosubsection_subsectionSp">
<input type="<?= $Grid->subsectionSp->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_subsectionSp" id="x<?= $Grid->RowIndex ?>_subsectionSp" data-table="fed_videosubsection" data-field="x_subsectionSp" value="<?= $Grid->subsectionSp->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->subsectionSp->getPlaceHolder()) ?>"<?= $Grid->subsectionSp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subsectionSp->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_videosubsection_subsectionSp" class="el_fed_videosubsection_subsectionSp">
<span<?= $Grid->subsectionSp->viewAttributes() ?>>
<?= $Grid->subsectionSp->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsectionSp" data-hidden="1" name="ffed_videosubsectiongrid$x<?= $Grid->RowIndex ?>_subsectionSp" id="ffed_videosubsectiongrid$x<?= $Grid->RowIndex ?>_subsectionSp" value="<?= HtmlEncode($Grid->subsectionSp->FormValue) ?>">
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsectionSp" data-hidden="1" name="ffed_videosubsectiongrid$o<?= $Grid->RowIndex ?>_subsectionSp" id="ffed_videosubsectiongrid$o<?= $Grid->RowIndex ?>_subsectionSp" value="<?= HtmlEncode($Grid->subsectionSp->OldValue) ?>">
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
loadjs.ready(["ffed_videosubsectiongrid","load"], () => ffed_videosubsectiongrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_fed_videosubsection", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->section->Visible) { // section ?>
        <td data-name="section">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->section->getSessionValue() != "") { ?>
<span<?= $Grid->section->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->section->getDisplayValue($Grid->section->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_section" name="x<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_fed_videosubsection_section" class="el_fed_videosubsection_section">
    <select
        id="x<?= $Grid->RowIndex ?>_section"
        name="x<?= $Grid->RowIndex ?>_section"
        class="form-select ew-select<?= $Grid->section->isInvalidClass() ?>"
        data-select2-id="ffed_videosubsectiongrid_x<?= $Grid->RowIndex ?>_section"
        data-table="fed_videosubsection"
        data-field="x_section"
        data-value-separator="<?= $Grid->section->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->section->getPlaceHolder()) ?>"
        <?= $Grid->section->editAttributes() ?>>
        <?= $Grid->section->selectOptionListHtml("x{$Grid->RowIndex}_section") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->section->getErrorMessage() ?></div>
<?= $Grid->section->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_section") ?>
<script>
loadjs.ready("ffed_videosubsectiongrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_section", selectId: "ffed_videosubsectiongrid_x<?= $Grid->RowIndex ?>_section" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_videosubsectiongrid.lists.section.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_section", form: "ffed_videosubsectiongrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_section", form: "ffed_videosubsectiongrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_videosubsection.fields.section.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_fed_videosubsection_section" class="el_fed_videosubsection_section">
<span<?= $Grid->section->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->section->getDisplayValue($Grid->section->ViewValue) ?></span></span>
<input type="hidden" data-table="fed_videosubsection" data-field="x_section" data-hidden="1" name="x<?= $Grid->RowIndex ?>_section" id="x<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_videosubsection" data-field="x_section" data-hidden="1" name="o<?= $Grid->RowIndex ?>_section" id="o<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->subsection->Visible) { // subsection ?>
        <td data-name="subsection">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_videosubsection_subsection" class="el_fed_videosubsection_subsection">
<input type="<?= $Grid->subsection->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_subsection" id="x<?= $Grid->RowIndex ?>_subsection" data-table="fed_videosubsection" data-field="x_subsection" value="<?= $Grid->subsection->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->subsection->getPlaceHolder()) ?>"<?= $Grid->subsection->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subsection->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_videosubsection_subsection" class="el_fed_videosubsection_subsection">
<span<?= $Grid->subsection->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subsection->getDisplayValue($Grid->subsection->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsection" data-hidden="1" name="x<?= $Grid->RowIndex ?>_subsection" id="x<?= $Grid->RowIndex ?>_subsection" value="<?= HtmlEncode($Grid->subsection->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsection" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subsection" id="o<?= $Grid->RowIndex ?>_subsection" value="<?= HtmlEncode($Grid->subsection->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->subsectionBr->Visible) { // subsectionBr ?>
        <td data-name="subsectionBr">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_videosubsection_subsectionBr" class="el_fed_videosubsection_subsectionBr">
<input type="<?= $Grid->subsectionBr->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_subsectionBr" id="x<?= $Grid->RowIndex ?>_subsectionBr" data-table="fed_videosubsection" data-field="x_subsectionBr" value="<?= $Grid->subsectionBr->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->subsectionBr->getPlaceHolder()) ?>"<?= $Grid->subsectionBr->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subsectionBr->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_videosubsection_subsectionBr" class="el_fed_videosubsection_subsectionBr">
<span<?= $Grid->subsectionBr->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subsectionBr->getDisplayValue($Grid->subsectionBr->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsectionBr" data-hidden="1" name="x<?= $Grid->RowIndex ?>_subsectionBr" id="x<?= $Grid->RowIndex ?>_subsectionBr" value="<?= HtmlEncode($Grid->subsectionBr->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsectionBr" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subsectionBr" id="o<?= $Grid->RowIndex ?>_subsectionBr" value="<?= HtmlEncode($Grid->subsectionBr->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->subsectionSp->Visible) { // subsectionSp ?>
        <td data-name="subsectionSp">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_videosubsection_subsectionSp" class="el_fed_videosubsection_subsectionSp">
<input type="<?= $Grid->subsectionSp->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_subsectionSp" id="x<?= $Grid->RowIndex ?>_subsectionSp" data-table="fed_videosubsection" data-field="x_subsectionSp" value="<?= $Grid->subsectionSp->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->subsectionSp->getPlaceHolder()) ?>"<?= $Grid->subsectionSp->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->subsectionSp->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_videosubsection_subsectionSp" class="el_fed_videosubsection_subsectionSp">
<span<?= $Grid->subsectionSp->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->subsectionSp->getDisplayValue($Grid->subsectionSp->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsectionSp" data-hidden="1" name="x<?= $Grid->RowIndex ?>_subsectionSp" id="x<?= $Grid->RowIndex ?>_subsectionSp" value="<?= HtmlEncode($Grid->subsectionSp->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_videosubsection" data-field="x_subsectionSp" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subsectionSp" id="o<?= $Grid->RowIndex ?>_subsectionSp" value="<?= HtmlEncode($Grid->subsectionSp->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["ffed_videosubsectiongrid","load"], () => ffed_videosubsectiongrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="ffed_videosubsectiongrid">
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
    ew.addEventHandlers("fed_videosubsection");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
