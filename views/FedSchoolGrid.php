<?php

namespace PHPMaker2022\school;

// Set up and run Grid object
$Grid = Container("FedSchoolGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var ffed_schoolgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_schoolgrid = new ew.Form("ffed_schoolgrid", "grid");
    ffed_schoolgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { fed_school: currentTable } });
    var fields = currentTable.fields;
    ffed_schoolgrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["masterSchoolId", [fields.masterSchoolId.visible && fields.masterSchoolId.required ? ew.Validators.required(fields.masterSchoolId.caption) : null], fields.masterSchoolId.isInvalid],
        ["school", [fields.school.visible && fields.school.required ? ew.Validators.required(fields.school.caption) : null], fields.school.isInvalid],
        ["countryId", [fields.countryId.visible && fields.countryId.required ? ew.Validators.required(fields.countryId.caption) : null], fields.countryId.isInvalid],
        ["cityId", [fields.cityId.visible && fields.cityId.required ? ew.Validators.required(fields.cityId.caption) : null], fields.cityId.isInvalid],
        ["owner", [fields.owner.visible && fields.owner.required ? ew.Validators.required(fields.owner.caption) : null], fields.owner.isInvalid],
        ["applicationId", [fields.applicationId.visible && fields.applicationId.required ? ew.Validators.required(fields.applicationId.caption) : null, ew.Validators.integer], fields.applicationId.isInvalid],
        ["isheadquarter", [fields.isheadquarter.visible && fields.isheadquarter.required ? ew.Validators.required(fields.isheadquarter.caption) : null], fields.isheadquarter.isInvalid]
    ]);

    // Check empty row
    ffed_schoolgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["masterSchoolId",false],["school",false],["countryId",false],["cityId",false],["owner",false],["applicationId",false],["isheadquarter[]",true]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    ffed_schoolgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_schoolgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffed_schoolgrid.lists.masterSchoolId = <?= $Grid->masterSchoolId->toClientList($Grid) ?>;
    ffed_schoolgrid.lists.countryId = <?= $Grid->countryId->toClientList($Grid) ?>;
    ffed_schoolgrid.lists.cityId = <?= $Grid->cityId->toClientList($Grid) ?>;
    ffed_schoolgrid.lists.isheadquarter = <?= $Grid->isheadquarter->toClientList($Grid) ?>;
    loadjs.done("ffed_schoolgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fed_school">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="ffed_schoolgrid" class="ew-form ew-list-form">
<div id="gmp_fed_school" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_fed_schoolgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_fed_school_id" class="fed_school_id"><?= $Grid->renderFieldHeader($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->masterSchoolId->Visible) { // masterSchoolId ?>
        <th data-name="masterSchoolId" class="<?= $Grid->masterSchoolId->headerCellClass() ?>"><div id="elh_fed_school_masterSchoolId" class="fed_school_masterSchoolId"><?= $Grid->renderFieldHeader($Grid->masterSchoolId) ?></div></th>
<?php } ?>
<?php if ($Grid->school->Visible) { // school ?>
        <th data-name="school" class="<?= $Grid->school->headerCellClass() ?>"><div id="elh_fed_school_school" class="fed_school_school"><?= $Grid->renderFieldHeader($Grid->school) ?></div></th>
<?php } ?>
<?php if ($Grid->countryId->Visible) { // countryId ?>
        <th data-name="countryId" class="<?= $Grid->countryId->headerCellClass() ?>"><div id="elh_fed_school_countryId" class="fed_school_countryId"><?= $Grid->renderFieldHeader($Grid->countryId) ?></div></th>
<?php } ?>
<?php if ($Grid->cityId->Visible) { // cityId ?>
        <th data-name="cityId" class="<?= $Grid->cityId->headerCellClass() ?>"><div id="elh_fed_school_cityId" class="fed_school_cityId"><?= $Grid->renderFieldHeader($Grid->cityId) ?></div></th>
<?php } ?>
<?php if ($Grid->owner->Visible) { // owner ?>
        <th data-name="owner" class="<?= $Grid->owner->headerCellClass() ?>"><div id="elh_fed_school_owner" class="fed_school_owner"><?= $Grid->renderFieldHeader($Grid->owner) ?></div></th>
<?php } ?>
<?php if ($Grid->applicationId->Visible) { // applicationId ?>
        <th data-name="applicationId" class="<?= $Grid->applicationId->headerCellClass() ?>"><div id="elh_fed_school_applicationId" class="fed_school_applicationId"><?= $Grid->renderFieldHeader($Grid->applicationId) ?></div></th>
<?php } ?>
<?php if ($Grid->isheadquarter->Visible) { // isheadquarter ?>
        <th data-name="isheadquarter" class="<?= $Grid->isheadquarter->headerCellClass() ?>"><div id="elh_fed_school_isheadquarter" class="fed_school_isheadquarter"><?= $Grid->renderFieldHeader($Grid->isheadquarter) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_fed_school",
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
<span id="el<?= $Grid->RowCount ?>_fed_school_id" class="el_fed_school_id"></span>
<input type="hidden" data-table="fed_school" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_id" class="el_fed_school_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fed_school" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_id" class="el_fed_school_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_school" data-field="x_id" data-hidden="1" name="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_id" id="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="fed_school" data-field="x_id" data-hidden="1" name="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_id" id="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="fed_school" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->masterSchoolId->Visible) { // masterSchoolId ?>
        <td data-name="masterSchoolId"<?= $Grid->masterSchoolId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_masterSchoolId" class="el_fed_school_masterSchoolId">
<?php $Grid->masterSchoolId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_masterSchoolId"
        name="x<?= $Grid->RowIndex ?>_masterSchoolId"
        class="form-select ew-select<?= $Grid->masterSchoolId->isInvalidClass() ?>"
        data-select2-id="ffed_schoolgrid_x<?= $Grid->RowIndex ?>_masterSchoolId"
        data-table="fed_school"
        data-field="x_masterSchoolId"
        data-value-separator="<?= $Grid->masterSchoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->masterSchoolId->getPlaceHolder()) ?>"
        <?= $Grid->masterSchoolId->editAttributes() ?>>
        <?= $Grid->masterSchoolId->selectOptionListHtml("x{$Grid->RowIndex}_masterSchoolId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->masterSchoolId->getErrorMessage() ?></div>
<?= $Grid->masterSchoolId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_masterSchoolId") ?>
<script>
loadjs.ready("ffed_schoolgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_masterSchoolId", selectId: "ffed_schoolgrid_x<?= $Grid->RowIndex ?>_masterSchoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schoolgrid.lists.masterSchoolId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_masterSchoolId", form: "ffed_schoolgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_masterSchoolId", form: "ffed_schoolgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.masterSchoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="fed_school" data-field="x_masterSchoolId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_masterSchoolId" id="o<?= $Grid->RowIndex ?>_masterSchoolId" value="<?= HtmlEncode($Grid->masterSchoolId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_masterSchoolId" class="el_fed_school_masterSchoolId">
<?php $Grid->masterSchoolId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_masterSchoolId"
        name="x<?= $Grid->RowIndex ?>_masterSchoolId"
        class="form-select ew-select<?= $Grid->masterSchoolId->isInvalidClass() ?>"
        data-select2-id="ffed_schoolgrid_x<?= $Grid->RowIndex ?>_masterSchoolId"
        data-table="fed_school"
        data-field="x_masterSchoolId"
        data-value-separator="<?= $Grid->masterSchoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->masterSchoolId->getPlaceHolder()) ?>"
        <?= $Grid->masterSchoolId->editAttributes() ?>>
        <?= $Grid->masterSchoolId->selectOptionListHtml("x{$Grid->RowIndex}_masterSchoolId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->masterSchoolId->getErrorMessage() ?></div>
<?= $Grid->masterSchoolId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_masterSchoolId") ?>
<script>
loadjs.ready("ffed_schoolgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_masterSchoolId", selectId: "ffed_schoolgrid_x<?= $Grid->RowIndex ?>_masterSchoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schoolgrid.lists.masterSchoolId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_masterSchoolId", form: "ffed_schoolgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_masterSchoolId", form: "ffed_schoolgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.masterSchoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_masterSchoolId" class="el_fed_school_masterSchoolId">
<span<?= $Grid->masterSchoolId->viewAttributes() ?>>
<?= $Grid->masterSchoolId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_school" data-field="x_masterSchoolId" data-hidden="1" name="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_masterSchoolId" id="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_masterSchoolId" value="<?= HtmlEncode($Grid->masterSchoolId->FormValue) ?>">
<input type="hidden" data-table="fed_school" data-field="x_masterSchoolId" data-hidden="1" name="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_masterSchoolId" id="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_masterSchoolId" value="<?= HtmlEncode($Grid->masterSchoolId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->school->Visible) { // school ?>
        <td data-name="school"<?= $Grid->school->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_school" class="el_fed_school_school">
<input type="<?= $Grid->school->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_school" id="x<?= $Grid->RowIndex ?>_school" data-table="fed_school" data-field="x_school" value="<?= $Grid->school->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->school->getPlaceHolder()) ?>"<?= $Grid->school->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->school->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fed_school" data-field="x_school" data-hidden="1" name="o<?= $Grid->RowIndex ?>_school" id="o<?= $Grid->RowIndex ?>_school" value="<?= HtmlEncode($Grid->school->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_school" class="el_fed_school_school">
<input type="<?= $Grid->school->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_school" id="x<?= $Grid->RowIndex ?>_school" data-table="fed_school" data-field="x_school" value="<?= $Grid->school->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->school->getPlaceHolder()) ?>"<?= $Grid->school->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->school->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_school" class="el_fed_school_school">
<span<?= $Grid->school->viewAttributes() ?>>
<?= $Grid->school->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_school" data-field="x_school" data-hidden="1" name="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_school" id="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_school" value="<?= HtmlEncode($Grid->school->FormValue) ?>">
<input type="hidden" data-table="fed_school" data-field="x_school" data-hidden="1" name="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_school" id="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_school" value="<?= HtmlEncode($Grid->school->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->countryId->Visible) { // countryId ?>
        <td data-name="countryId"<?= $Grid->countryId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_countryId" class="el_fed_school_countryId">
    <select
        id="x<?= $Grid->RowIndex ?>_countryId"
        name="x<?= $Grid->RowIndex ?>_countryId"
        class="form-select ew-select<?= $Grid->countryId->isInvalidClass() ?>"
        data-select2-id="ffed_schoolgrid_x<?= $Grid->RowIndex ?>_countryId"
        data-table="fed_school"
        data-field="x_countryId"
        data-value-separator="<?= $Grid->countryId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->countryId->getPlaceHolder()) ?>"
        <?= $Grid->countryId->editAttributes() ?>>
        <?= $Grid->countryId->selectOptionListHtml("x{$Grid->RowIndex}_countryId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->countryId->getErrorMessage() ?></div>
<?= $Grid->countryId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_countryId") ?>
<script>
loadjs.ready("ffed_schoolgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_countryId", selectId: "ffed_schoolgrid_x<?= $Grid->RowIndex ?>_countryId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schoolgrid.lists.countryId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_countryId", form: "ffed_schoolgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_countryId", form: "ffed_schoolgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.countryId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="fed_school" data-field="x_countryId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_countryId" id="o<?= $Grid->RowIndex ?>_countryId" value="<?= HtmlEncode($Grid->countryId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_countryId" class="el_fed_school_countryId">
    <select
        id="x<?= $Grid->RowIndex ?>_countryId"
        name="x<?= $Grid->RowIndex ?>_countryId"
        class="form-select ew-select<?= $Grid->countryId->isInvalidClass() ?>"
        data-select2-id="ffed_schoolgrid_x<?= $Grid->RowIndex ?>_countryId"
        data-table="fed_school"
        data-field="x_countryId"
        data-value-separator="<?= $Grid->countryId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->countryId->getPlaceHolder()) ?>"
        <?= $Grid->countryId->editAttributes() ?>>
        <?= $Grid->countryId->selectOptionListHtml("x{$Grid->RowIndex}_countryId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->countryId->getErrorMessage() ?></div>
<?= $Grid->countryId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_countryId") ?>
<script>
loadjs.ready("ffed_schoolgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_countryId", selectId: "ffed_schoolgrid_x<?= $Grid->RowIndex ?>_countryId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schoolgrid.lists.countryId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_countryId", form: "ffed_schoolgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_countryId", form: "ffed_schoolgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.countryId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_countryId" class="el_fed_school_countryId">
<span<?= $Grid->countryId->viewAttributes() ?>>
<?= $Grid->countryId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_school" data-field="x_countryId" data-hidden="1" name="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_countryId" id="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_countryId" value="<?= HtmlEncode($Grid->countryId->FormValue) ?>">
<input type="hidden" data-table="fed_school" data-field="x_countryId" data-hidden="1" name="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_countryId" id="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_countryId" value="<?= HtmlEncode($Grid->countryId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->cityId->Visible) { // cityId ?>
        <td data-name="cityId"<?= $Grid->cityId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_cityId" class="el_fed_school_cityId">
<div class="input-group flex-nowrap">
    <select
        id="x<?= $Grid->RowIndex ?>_cityId"
        name="x<?= $Grid->RowIndex ?>_cityId"
        class="form-select ew-select<?= $Grid->cityId->isInvalidClass() ?>"
        data-select2-id="ffed_schoolgrid_x<?= $Grid->RowIndex ?>_cityId"
        data-table="fed_school"
        data-field="x_cityId"
        data-value-separator="<?= $Grid->cityId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cityId->getPlaceHolder()) ?>"
        <?= $Grid->cityId->editAttributes() ?>>
        <?= $Grid->cityId->selectOptionListHtml("x{$Grid->RowIndex}_cityId") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "conf_city") && !$Grid->cityId->ReadOnly) { ?>
    <button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x<?= $Grid->RowIndex ?>_cityId" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Grid->cityId->caption() ?>" data-title="<?= $Grid->cityId->caption() ?>" data-ew-action="add-option" data-el="x<?= $Grid->RowIndex ?>_cityId" data-url="<?= GetUrl("ConfCityAddopt") ?>"><i class="fas fa-plus ew-icon"></i></button>
    <?php } ?>
</div>
<div class="invalid-feedback"><?= $Grid->cityId->getErrorMessage() ?></div>
<?= $Grid->cityId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cityId") ?>
<script>
loadjs.ready("ffed_schoolgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cityId", selectId: "ffed_schoolgrid_x<?= $Grid->RowIndex ?>_cityId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schoolgrid.lists.cityId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cityId", form: "ffed_schoolgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cityId", form: "ffed_schoolgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.cityId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="fed_school" data-field="x_cityId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cityId" id="o<?= $Grid->RowIndex ?>_cityId" value="<?= HtmlEncode($Grid->cityId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_cityId" class="el_fed_school_cityId">
<div class="input-group flex-nowrap">
    <select
        id="x<?= $Grid->RowIndex ?>_cityId"
        name="x<?= $Grid->RowIndex ?>_cityId"
        class="form-select ew-select<?= $Grid->cityId->isInvalidClass() ?>"
        data-select2-id="ffed_schoolgrid_x<?= $Grid->RowIndex ?>_cityId"
        data-table="fed_school"
        data-field="x_cityId"
        data-value-separator="<?= $Grid->cityId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cityId->getPlaceHolder()) ?>"
        <?= $Grid->cityId->editAttributes() ?>>
        <?= $Grid->cityId->selectOptionListHtml("x{$Grid->RowIndex}_cityId") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "conf_city") && !$Grid->cityId->ReadOnly) { ?>
    <button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x<?= $Grid->RowIndex ?>_cityId" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Grid->cityId->caption() ?>" data-title="<?= $Grid->cityId->caption() ?>" data-ew-action="add-option" data-el="x<?= $Grid->RowIndex ?>_cityId" data-url="<?= GetUrl("ConfCityAddopt") ?>"><i class="fas fa-plus ew-icon"></i></button>
    <?php } ?>
</div>
<div class="invalid-feedback"><?= $Grid->cityId->getErrorMessage() ?></div>
<?= $Grid->cityId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cityId") ?>
<script>
loadjs.ready("ffed_schoolgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cityId", selectId: "ffed_schoolgrid_x<?= $Grid->RowIndex ?>_cityId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schoolgrid.lists.cityId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cityId", form: "ffed_schoolgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cityId", form: "ffed_schoolgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.cityId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_cityId" class="el_fed_school_cityId">
<span<?= $Grid->cityId->viewAttributes() ?>>
<?= $Grid->cityId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_school" data-field="x_cityId" data-hidden="1" name="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_cityId" id="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_cityId" value="<?= HtmlEncode($Grid->cityId->FormValue) ?>">
<input type="hidden" data-table="fed_school" data-field="x_cityId" data-hidden="1" name="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_cityId" id="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_cityId" value="<?= HtmlEncode($Grid->cityId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->owner->Visible) { // owner ?>
        <td data-name="owner"<?= $Grid->owner->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_owner" class="el_fed_school_owner">
<input type="<?= $Grid->owner->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_owner" id="x<?= $Grid->RowIndex ?>_owner" data-table="fed_school" data-field="x_owner" value="<?= $Grid->owner->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->owner->getPlaceHolder()) ?>"<?= $Grid->owner->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->owner->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fed_school" data-field="x_owner" data-hidden="1" name="o<?= $Grid->RowIndex ?>_owner" id="o<?= $Grid->RowIndex ?>_owner" value="<?= HtmlEncode($Grid->owner->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_owner" class="el_fed_school_owner">
<input type="<?= $Grid->owner->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_owner" id="x<?= $Grid->RowIndex ?>_owner" data-table="fed_school" data-field="x_owner" value="<?= $Grid->owner->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->owner->getPlaceHolder()) ?>"<?= $Grid->owner->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->owner->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_owner" class="el_fed_school_owner">
<span<?= $Grid->owner->viewAttributes() ?>>
<?= $Grid->owner->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_school" data-field="x_owner" data-hidden="1" name="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_owner" id="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_owner" value="<?= HtmlEncode($Grid->owner->FormValue) ?>">
<input type="hidden" data-table="fed_school" data-field="x_owner" data-hidden="1" name="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_owner" id="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_owner" value="<?= HtmlEncode($Grid->owner->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->applicationId->Visible) { // applicationId ?>
        <td data-name="applicationId"<?= $Grid->applicationId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->applicationId->getSessionValue() != "") { ?>
<span<?= $Grid->applicationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->applicationId->getDisplayValue($Grid->applicationId->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_applicationId" name="x<?= $Grid->RowIndex ?>_applicationId" value="<?= HtmlEncode($Grid->applicationId->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_applicationId" class="el_fed_school_applicationId">
<input type="<?= $Grid->applicationId->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_applicationId" id="x<?= $Grid->RowIndex ?>_applicationId" data-table="fed_school" data-field="x_applicationId" value="<?= $Grid->applicationId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->applicationId->getPlaceHolder()) ?>"<?= $Grid->applicationId->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->applicationId->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="fed_school" data-field="x_applicationId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_applicationId" id="o<?= $Grid->RowIndex ?>_applicationId" value="<?= HtmlEncode($Grid->applicationId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->applicationId->getSessionValue() != "") { ?>
<span<?= $Grid->applicationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->applicationId->getDisplayValue($Grid->applicationId->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_applicationId" name="x<?= $Grid->RowIndex ?>_applicationId" value="<?= HtmlEncode($Grid->applicationId->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_applicationId" class="el_fed_school_applicationId">
<input type="<?= $Grid->applicationId->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_applicationId" id="x<?= $Grid->RowIndex ?>_applicationId" data-table="fed_school" data-field="x_applicationId" value="<?= $Grid->applicationId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->applicationId->getPlaceHolder()) ?>"<?= $Grid->applicationId->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->applicationId->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_applicationId" class="el_fed_school_applicationId">
<span<?= $Grid->applicationId->viewAttributes() ?>>
<?= $Grid->applicationId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_school" data-field="x_applicationId" data-hidden="1" name="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_applicationId" id="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_applicationId" value="<?= HtmlEncode($Grid->applicationId->FormValue) ?>">
<input type="hidden" data-table="fed_school" data-field="x_applicationId" data-hidden="1" name="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_applicationId" id="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_applicationId" value="<?= HtmlEncode($Grid->applicationId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->isheadquarter->Visible) { // isheadquarter ?>
        <td data-name="isheadquarter"<?= $Grid->isheadquarter->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_isheadquarter" class="el_fed_school_isheadquarter">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->isheadquarter->isInvalidClass() ?>" data-table="fed_school" data-field="x_isheadquarter" name="x<?= $Grid->RowIndex ?>_isheadquarter[]" id="x<?= $Grid->RowIndex ?>_isheadquarter_925789" value="1"<?= ConvertToBool($Grid->isheadquarter->CurrentValue) ? " checked" : "" ?><?= $Grid->isheadquarter->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->isheadquarter->getErrorMessage() ?></div>
</div>
</span>
<input type="hidden" data-table="fed_school" data-field="x_isheadquarter" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isheadquarter[]" id="o<?= $Grid->RowIndex ?>_isheadquarter[]" value="<?= HtmlEncode($Grid->isheadquarter->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_isheadquarter" class="el_fed_school_isheadquarter">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->isheadquarter->isInvalidClass() ?>" data-table="fed_school" data-field="x_isheadquarter" name="x<?= $Grid->RowIndex ?>_isheadquarter[]" id="x<?= $Grid->RowIndex ?>_isheadquarter_573451" value="1"<?= ConvertToBool($Grid->isheadquarter->CurrentValue) ? " checked" : "" ?><?= $Grid->isheadquarter->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->isheadquarter->getErrorMessage() ?></div>
</div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_school_isheadquarter" class="el_fed_school_isheadquarter">
<span<?= $Grid->isheadquarter->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_isheadquarter_<?= $Grid->RowCount ?>" class="form-check-input" value="<?= $Grid->isheadquarter->getViewValue() ?>" disabled<?php if (ConvertToBool($Grid->isheadquarter->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_isheadquarter_<?= $Grid->RowCount ?>"></label>
</div></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_school" data-field="x_isheadquarter" data-hidden="1" name="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_isheadquarter" id="ffed_schoolgrid$x<?= $Grid->RowIndex ?>_isheadquarter" value="<?= HtmlEncode($Grid->isheadquarter->FormValue) ?>">
<input type="hidden" data-table="fed_school" data-field="x_isheadquarter" data-hidden="1" name="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_isheadquarter[]" id="ffed_schoolgrid$o<?= $Grid->RowIndex ?>_isheadquarter[]" value="<?= HtmlEncode($Grid->isheadquarter->OldValue) ?>">
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
loadjs.ready(["ffed_schoolgrid","load"], () => ffed_schoolgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_fed_school", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_fed_school_id" class="el_fed_school_id"></span>
<?php } else { ?>
<span id="el$rowindex$_fed_school_id" class="el_fed_school_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_school" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_school" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->masterSchoolId->Visible) { // masterSchoolId ?>
        <td data-name="masterSchoolId">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_school_masterSchoolId" class="el_fed_school_masterSchoolId">
<?php $Grid->masterSchoolId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_masterSchoolId"
        name="x<?= $Grid->RowIndex ?>_masterSchoolId"
        class="form-select ew-select<?= $Grid->masterSchoolId->isInvalidClass() ?>"
        data-select2-id="ffed_schoolgrid_x<?= $Grid->RowIndex ?>_masterSchoolId"
        data-table="fed_school"
        data-field="x_masterSchoolId"
        data-value-separator="<?= $Grid->masterSchoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->masterSchoolId->getPlaceHolder()) ?>"
        <?= $Grid->masterSchoolId->editAttributes() ?>>
        <?= $Grid->masterSchoolId->selectOptionListHtml("x{$Grid->RowIndex}_masterSchoolId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->masterSchoolId->getErrorMessage() ?></div>
<?= $Grid->masterSchoolId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_masterSchoolId") ?>
<script>
loadjs.ready("ffed_schoolgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_masterSchoolId", selectId: "ffed_schoolgrid_x<?= $Grid->RowIndex ?>_masterSchoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schoolgrid.lists.masterSchoolId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_masterSchoolId", form: "ffed_schoolgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_masterSchoolId", form: "ffed_schoolgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.masterSchoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_school_masterSchoolId" class="el_fed_school_masterSchoolId">
<span<?= $Grid->masterSchoolId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->masterSchoolId->getDisplayValue($Grid->masterSchoolId->ViewValue) ?></span></span>
<input type="hidden" data-table="fed_school" data-field="x_masterSchoolId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_masterSchoolId" id="x<?= $Grid->RowIndex ?>_masterSchoolId" value="<?= HtmlEncode($Grid->masterSchoolId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_school" data-field="x_masterSchoolId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_masterSchoolId" id="o<?= $Grid->RowIndex ?>_masterSchoolId" value="<?= HtmlEncode($Grid->masterSchoolId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->school->Visible) { // school ?>
        <td data-name="school">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_school_school" class="el_fed_school_school">
<input type="<?= $Grid->school->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_school" id="x<?= $Grid->RowIndex ?>_school" data-table="fed_school" data-field="x_school" value="<?= $Grid->school->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->school->getPlaceHolder()) ?>"<?= $Grid->school->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->school->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_school_school" class="el_fed_school_school">
<span<?= $Grid->school->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->school->getDisplayValue($Grid->school->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_school" data-field="x_school" data-hidden="1" name="x<?= $Grid->RowIndex ?>_school" id="x<?= $Grid->RowIndex ?>_school" value="<?= HtmlEncode($Grid->school->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_school" data-field="x_school" data-hidden="1" name="o<?= $Grid->RowIndex ?>_school" id="o<?= $Grid->RowIndex ?>_school" value="<?= HtmlEncode($Grid->school->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->countryId->Visible) { // countryId ?>
        <td data-name="countryId">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_school_countryId" class="el_fed_school_countryId">
    <select
        id="x<?= $Grid->RowIndex ?>_countryId"
        name="x<?= $Grid->RowIndex ?>_countryId"
        class="form-select ew-select<?= $Grid->countryId->isInvalidClass() ?>"
        data-select2-id="ffed_schoolgrid_x<?= $Grid->RowIndex ?>_countryId"
        data-table="fed_school"
        data-field="x_countryId"
        data-value-separator="<?= $Grid->countryId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->countryId->getPlaceHolder()) ?>"
        <?= $Grid->countryId->editAttributes() ?>>
        <?= $Grid->countryId->selectOptionListHtml("x{$Grid->RowIndex}_countryId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->countryId->getErrorMessage() ?></div>
<?= $Grid->countryId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_countryId") ?>
<script>
loadjs.ready("ffed_schoolgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_countryId", selectId: "ffed_schoolgrid_x<?= $Grid->RowIndex ?>_countryId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schoolgrid.lists.countryId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_countryId", form: "ffed_schoolgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_countryId", form: "ffed_schoolgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.countryId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_school_countryId" class="el_fed_school_countryId">
<span<?= $Grid->countryId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->countryId->getDisplayValue($Grid->countryId->ViewValue) ?></span></span>
<input type="hidden" data-table="fed_school" data-field="x_countryId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_countryId" id="x<?= $Grid->RowIndex ?>_countryId" value="<?= HtmlEncode($Grid->countryId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_school" data-field="x_countryId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_countryId" id="o<?= $Grid->RowIndex ?>_countryId" value="<?= HtmlEncode($Grid->countryId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->cityId->Visible) { // cityId ?>
        <td data-name="cityId">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_school_cityId" class="el_fed_school_cityId">
<div class="input-group flex-nowrap">
    <select
        id="x<?= $Grid->RowIndex ?>_cityId"
        name="x<?= $Grid->RowIndex ?>_cityId"
        class="form-select ew-select<?= $Grid->cityId->isInvalidClass() ?>"
        data-select2-id="ffed_schoolgrid_x<?= $Grid->RowIndex ?>_cityId"
        data-table="fed_school"
        data-field="x_cityId"
        data-value-separator="<?= $Grid->cityId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->cityId->getPlaceHolder()) ?>"
        <?= $Grid->cityId->editAttributes() ?>>
        <?= $Grid->cityId->selectOptionListHtml("x{$Grid->RowIndex}_cityId") ?>
    </select>
    <?php if (AllowAdd(CurrentProjectID() . "conf_city") && !$Grid->cityId->ReadOnly) { ?>
    <button type="button" class="btn btn-default ew-add-opt-btn" id="aol_x<?= $Grid->RowIndex ?>_cityId" title="<?= HtmlTitle($Language->phrase("AddLink")) . "&nbsp;" . $Grid->cityId->caption() ?>" data-title="<?= $Grid->cityId->caption() ?>" data-ew-action="add-option" data-el="x<?= $Grid->RowIndex ?>_cityId" data-url="<?= GetUrl("ConfCityAddopt") ?>"><i class="fas fa-plus ew-icon"></i></button>
    <?php } ?>
</div>
<div class="invalid-feedback"><?= $Grid->cityId->getErrorMessage() ?></div>
<?= $Grid->cityId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_cityId") ?>
<script>
loadjs.ready("ffed_schoolgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_cityId", selectId: "ffed_schoolgrid_x<?= $Grid->RowIndex ?>_cityId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffed_schoolgrid.lists.cityId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_cityId", form: "ffed_schoolgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_cityId", form: "ffed_schoolgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fed_school.fields.cityId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_school_cityId" class="el_fed_school_cityId">
<span<?= $Grid->cityId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->cityId->getDisplayValue($Grid->cityId->ViewValue) ?></span></span>
<input type="hidden" data-table="fed_school" data-field="x_cityId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_cityId" id="x<?= $Grid->RowIndex ?>_cityId" value="<?= HtmlEncode($Grid->cityId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_school" data-field="x_cityId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_cityId" id="o<?= $Grid->RowIndex ?>_cityId" value="<?= HtmlEncode($Grid->cityId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->owner->Visible) { // owner ?>
        <td data-name="owner">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_school_owner" class="el_fed_school_owner">
<input type="<?= $Grid->owner->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_owner" id="x<?= $Grid->RowIndex ?>_owner" data-table="fed_school" data-field="x_owner" value="<?= $Grid->owner->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->owner->getPlaceHolder()) ?>"<?= $Grid->owner->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->owner->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_school_owner" class="el_fed_school_owner">
<span<?= $Grid->owner->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->owner->getDisplayValue($Grid->owner->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_school" data-field="x_owner" data-hidden="1" name="x<?= $Grid->RowIndex ?>_owner" id="x<?= $Grid->RowIndex ?>_owner" value="<?= HtmlEncode($Grid->owner->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_school" data-field="x_owner" data-hidden="1" name="o<?= $Grid->RowIndex ?>_owner" id="o<?= $Grid->RowIndex ?>_owner" value="<?= HtmlEncode($Grid->owner->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->applicationId->Visible) { // applicationId ?>
        <td data-name="applicationId">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->applicationId->getSessionValue() != "") { ?>
<span<?= $Grid->applicationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->applicationId->getDisplayValue($Grid->applicationId->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_applicationId" name="x<?= $Grid->RowIndex ?>_applicationId" value="<?= HtmlEncode($Grid->applicationId->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_fed_school_applicationId" class="el_fed_school_applicationId">
<input type="<?= $Grid->applicationId->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_applicationId" id="x<?= $Grid->RowIndex ?>_applicationId" data-table="fed_school" data-field="x_applicationId" value="<?= $Grid->applicationId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->applicationId->getPlaceHolder()) ?>"<?= $Grid->applicationId->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->applicationId->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_fed_school_applicationId" class="el_fed_school_applicationId">
<span<?= $Grid->applicationId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->applicationId->getDisplayValue($Grid->applicationId->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_school" data-field="x_applicationId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_applicationId" id="x<?= $Grid->RowIndex ?>_applicationId" value="<?= HtmlEncode($Grid->applicationId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_school" data-field="x_applicationId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_applicationId" id="o<?= $Grid->RowIndex ?>_applicationId" value="<?= HtmlEncode($Grid->applicationId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->isheadquarter->Visible) { // isheadquarter ?>
        <td data-name="isheadquarter">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_school_isheadquarter" class="el_fed_school_isheadquarter">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->isheadquarter->isInvalidClass() ?>" data-table="fed_school" data-field="x_isheadquarter" name="x<?= $Grid->RowIndex ?>_isheadquarter[]" id="x<?= $Grid->RowIndex ?>_isheadquarter_334848" value="1"<?= ConvertToBool($Grid->isheadquarter->CurrentValue) ? " checked" : "" ?><?= $Grid->isheadquarter->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->isheadquarter->getErrorMessage() ?></div>
</div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_school_isheadquarter" class="el_fed_school_isheadquarter">
<span<?= $Grid->isheadquarter->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_isheadquarter_<?= $Grid->RowCount ?>" class="form-check-input" value="<?= $Grid->isheadquarter->ViewValue ?>" disabled<?php if (ConvertToBool($Grid->isheadquarter->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_isheadquarter_<?= $Grid->RowCount ?>"></label>
</div></span>
<input type="hidden" data-table="fed_school" data-field="x_isheadquarter" data-hidden="1" name="x<?= $Grid->RowIndex ?>_isheadquarter" id="x<?= $Grid->RowIndex ?>_isheadquarter" value="<?= HtmlEncode($Grid->isheadquarter->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_school" data-field="x_isheadquarter" data-hidden="1" name="o<?= $Grid->RowIndex ?>_isheadquarter[]" id="o<?= $Grid->RowIndex ?>_isheadquarter[]" value="<?= HtmlEncode($Grid->isheadquarter->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["ffed_schoolgrid","load"], () => ffed_schoolgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="ffed_schoolgrid">
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
    ew.addEventHandlers("fed_school");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
