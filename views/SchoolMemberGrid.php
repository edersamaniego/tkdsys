<?php

namespace PHPMaker2022\school;

// Set up and run Grid object
$Grid = Container("SchoolMemberGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fschool_membergrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_membergrid = new ew.Form("fschool_membergrid", "grid");
    fschool_membergrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { school_member: currentTable } });
    var fields = currentTable.fields;
    fschool_membergrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["lastName", [fields.lastName.visible && fields.lastName.required ? ew.Validators.required(fields.lastName.caption) : null], fields.lastName.isInvalid],
        ["martialArtId", [fields.martialArtId.visible && fields.martialArtId.required ? ew.Validators.required(fields.martialArtId.caption) : null], fields.martialArtId.isInvalid],
        ["rankId", [fields.rankId.visible && fields.rankId.required ? ew.Validators.required(fields.rankId.caption) : null], fields.rankId.isInvalid],
        ["photo", [fields.photo.visible && fields.photo.required ? ew.Validators.fileRequired(fields.photo.caption) : null], fields.photo.isInvalid]
    ]);

    // Check empty row
    fschool_membergrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["name",false],["lastName",false],["martialArtId",false],["rankId",false],["photo",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fschool_membergrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fschool_membergrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fschool_membergrid.lists.martialArtId = <?= $Grid->martialArtId->toClientList($Grid) ?>;
    fschool_membergrid.lists.rankId = <?= $Grid->rankId->toClientList($Grid) ?>;
    loadjs.done("fschool_membergrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> school_member">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="fschool_membergrid" class="ew-form ew-list-form">
<div id="gmp_school_member" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_school_membergrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_school_member_id" class="school_member_id"><?= $Grid->renderFieldHeader($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Grid->name->headerCellClass() ?>"><div id="elh_school_member_name" class="school_member_name"><?= $Grid->renderFieldHeader($Grid->name) ?></div></th>
<?php } ?>
<?php if ($Grid->lastName->Visible) { // lastName ?>
        <th data-name="lastName" class="<?= $Grid->lastName->headerCellClass() ?>"><div id="elh_school_member_lastName" class="school_member_lastName"><?= $Grid->renderFieldHeader($Grid->lastName) ?></div></th>
<?php } ?>
<?php if ($Grid->martialArtId->Visible) { // martialArtId ?>
        <th data-name="martialArtId" class="<?= $Grid->martialArtId->headerCellClass() ?>"><div id="elh_school_member_martialArtId" class="school_member_martialArtId"><?= $Grid->renderFieldHeader($Grid->martialArtId) ?></div></th>
<?php } ?>
<?php if ($Grid->rankId->Visible) { // rankId ?>
        <th data-name="rankId" class="<?= $Grid->rankId->headerCellClass() ?>"><div id="elh_school_member_rankId" class="school_member_rankId"><?= $Grid->renderFieldHeader($Grid->rankId) ?></div></th>
<?php } ?>
<?php if ($Grid->photo->Visible) { // photo ?>
        <th data-name="photo" class="<?= $Grid->photo->headerCellClass() ?>"><div id="elh_school_member_photo" class="school_member_photo"><?= $Grid->renderFieldHeader($Grid->photo) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_school_member",
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
<span id="el<?= $Grid->RowCount ?>_school_member_id" class="el_school_member_id"></span>
<input type="hidden" data-table="school_member" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_id" class="el_school_member_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
<input type="hidden" data-table="school_member" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_id" class="el_school_member_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_member" data-field="x_id" data-hidden="1" name="fschool_membergrid$x<?= $Grid->RowIndex ?>_id" id="fschool_membergrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="school_member" data-field="x_id" data-hidden="1" name="fschool_membergrid$o<?= $Grid->RowIndex ?>_id" id="fschool_membergrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="school_member" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->name->Visible) { // name ?>
        <td data-name="name"<?= $Grid->name->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_name" class="el_school_member_name">
<input type="<?= $Grid->name->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" data-table="school_member" data-field="x_name" value="<?= $Grid->name->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>"<?= $Grid->name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="school_member" data-field="x_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_name" id="o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_name" class="el_school_member_name">
<input type="<?= $Grid->name->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" data-table="school_member" data-field="x_name" value="<?= $Grid->name->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>"<?= $Grid->name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_name" class="el_school_member_name">
<span<?= $Grid->name->viewAttributes() ?>>
<?= $Grid->name->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_member" data-field="x_name" data-hidden="1" name="fschool_membergrid$x<?= $Grid->RowIndex ?>_name" id="fschool_membergrid$x<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->FormValue) ?>">
<input type="hidden" data-table="school_member" data-field="x_name" data-hidden="1" name="fschool_membergrid$o<?= $Grid->RowIndex ?>_name" id="fschool_membergrid$o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->lastName->Visible) { // lastName ?>
        <td data-name="lastName"<?= $Grid->lastName->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_lastName" class="el_school_member_lastName">
<input type="<?= $Grid->lastName->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_lastName" id="x<?= $Grid->RowIndex ?>_lastName" data-table="school_member" data-field="x_lastName" value="<?= $Grid->lastName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->lastName->getPlaceHolder()) ?>"<?= $Grid->lastName->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lastName->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="school_member" data-field="x_lastName" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lastName" id="o<?= $Grid->RowIndex ?>_lastName" value="<?= HtmlEncode($Grid->lastName->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_lastName" class="el_school_member_lastName">
<input type="<?= $Grid->lastName->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_lastName" id="x<?= $Grid->RowIndex ?>_lastName" data-table="school_member" data-field="x_lastName" value="<?= $Grid->lastName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->lastName->getPlaceHolder()) ?>"<?= $Grid->lastName->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lastName->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_lastName" class="el_school_member_lastName">
<span<?= $Grid->lastName->viewAttributes() ?>>
<?= $Grid->lastName->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_member" data-field="x_lastName" data-hidden="1" name="fschool_membergrid$x<?= $Grid->RowIndex ?>_lastName" id="fschool_membergrid$x<?= $Grid->RowIndex ?>_lastName" value="<?= HtmlEncode($Grid->lastName->FormValue) ?>">
<input type="hidden" data-table="school_member" data-field="x_lastName" data-hidden="1" name="fschool_membergrid$o<?= $Grid->RowIndex ?>_lastName" id="fschool_membergrid$o<?= $Grid->RowIndex ?>_lastName" value="<?= HtmlEncode($Grid->lastName->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->martialArtId->Visible) { // martialArtId ?>
        <td data-name="martialArtId"<?= $Grid->martialArtId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_martialArtId" class="el_school_member_martialArtId">
<?php $Grid->martialArtId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_martialArtId"
        name="x<?= $Grid->RowIndex ?>_martialArtId"
        class="form-select ew-select<?= $Grid->martialArtId->isInvalidClass() ?>"
        data-select2-id="fschool_membergrid_x<?= $Grid->RowIndex ?>_martialArtId"
        data-table="school_member"
        data-field="x_martialArtId"
        data-value-separator="<?= $Grid->martialArtId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->martialArtId->getPlaceHolder()) ?>"
        <?= $Grid->martialArtId->editAttributes() ?>>
        <?= $Grid->martialArtId->selectOptionListHtml("x{$Grid->RowIndex}_martialArtId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->martialArtId->getErrorMessage() ?></div>
<?= $Grid->martialArtId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_martialArtId") ?>
<script>
loadjs.ready("fschool_membergrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_martialArtId", selectId: "fschool_membergrid_x<?= $Grid->RowIndex ?>_martialArtId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_membergrid.lists.martialArtId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_martialArtId", form: "fschool_membergrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_martialArtId", form: "fschool_membergrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.martialArtId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="school_member" data-field="x_martialArtId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_martialArtId" id="o<?= $Grid->RowIndex ?>_martialArtId" value="<?= HtmlEncode($Grid->martialArtId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_martialArtId" class="el_school_member_martialArtId">
<?php $Grid->martialArtId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_martialArtId"
        name="x<?= $Grid->RowIndex ?>_martialArtId"
        class="form-select ew-select<?= $Grid->martialArtId->isInvalidClass() ?>"
        data-select2-id="fschool_membergrid_x<?= $Grid->RowIndex ?>_martialArtId"
        data-table="school_member"
        data-field="x_martialArtId"
        data-value-separator="<?= $Grid->martialArtId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->martialArtId->getPlaceHolder()) ?>"
        <?= $Grid->martialArtId->editAttributes() ?>>
        <?= $Grid->martialArtId->selectOptionListHtml("x{$Grid->RowIndex}_martialArtId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->martialArtId->getErrorMessage() ?></div>
<?= $Grid->martialArtId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_martialArtId") ?>
<script>
loadjs.ready("fschool_membergrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_martialArtId", selectId: "fschool_membergrid_x<?= $Grid->RowIndex ?>_martialArtId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_membergrid.lists.martialArtId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_martialArtId", form: "fschool_membergrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_martialArtId", form: "fschool_membergrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.martialArtId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_martialArtId" class="el_school_member_martialArtId">
<span<?= $Grid->martialArtId->viewAttributes() ?>>
<?= $Grid->martialArtId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_member" data-field="x_martialArtId" data-hidden="1" name="fschool_membergrid$x<?= $Grid->RowIndex ?>_martialArtId" id="fschool_membergrid$x<?= $Grid->RowIndex ?>_martialArtId" value="<?= HtmlEncode($Grid->martialArtId->FormValue) ?>">
<input type="hidden" data-table="school_member" data-field="x_martialArtId" data-hidden="1" name="fschool_membergrid$o<?= $Grid->RowIndex ?>_martialArtId" id="fschool_membergrid$o<?= $Grid->RowIndex ?>_martialArtId" value="<?= HtmlEncode($Grid->martialArtId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->rankId->Visible) { // rankId ?>
        <td data-name="rankId"<?= $Grid->rankId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_rankId" class="el_school_member_rankId">
    <select
        id="x<?= $Grid->RowIndex ?>_rankId"
        name="x<?= $Grid->RowIndex ?>_rankId"
        class="form-select ew-select<?= $Grid->rankId->isInvalidClass() ?>"
        data-select2-id="fschool_membergrid_x<?= $Grid->RowIndex ?>_rankId"
        data-table="school_member"
        data-field="x_rankId"
        data-value-separator="<?= $Grid->rankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->rankId->getPlaceHolder()) ?>"
        <?= $Grid->rankId->editAttributes() ?>>
        <?= $Grid->rankId->selectOptionListHtml("x{$Grid->RowIndex}_rankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->rankId->getErrorMessage() ?></div>
<?= $Grid->rankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_rankId") ?>
<script>
loadjs.ready("fschool_membergrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_rankId", selectId: "fschool_membergrid_x<?= $Grid->RowIndex ?>_rankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_membergrid.lists.rankId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_rankId", form: "fschool_membergrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_rankId", form: "fschool_membergrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.rankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="school_member" data-field="x_rankId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_rankId" id="o<?= $Grid->RowIndex ?>_rankId" value="<?= HtmlEncode($Grid->rankId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_rankId" class="el_school_member_rankId">
    <select
        id="x<?= $Grid->RowIndex ?>_rankId"
        name="x<?= $Grid->RowIndex ?>_rankId"
        class="form-select ew-select<?= $Grid->rankId->isInvalidClass() ?>"
        data-select2-id="fschool_membergrid_x<?= $Grid->RowIndex ?>_rankId"
        data-table="school_member"
        data-field="x_rankId"
        data-value-separator="<?= $Grid->rankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->rankId->getPlaceHolder()) ?>"
        <?= $Grid->rankId->editAttributes() ?>>
        <?= $Grid->rankId->selectOptionListHtml("x{$Grid->RowIndex}_rankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->rankId->getErrorMessage() ?></div>
<?= $Grid->rankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_rankId") ?>
<script>
loadjs.ready("fschool_membergrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_rankId", selectId: "fschool_membergrid_x<?= $Grid->RowIndex ?>_rankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_membergrid.lists.rankId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_rankId", form: "fschool_membergrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_rankId", form: "fschool_membergrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.rankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_rankId" class="el_school_member_rankId">
<span<?= $Grid->rankId->viewAttributes() ?>>
<?= $Grid->rankId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_member" data-field="x_rankId" data-hidden="1" name="fschool_membergrid$x<?= $Grid->RowIndex ?>_rankId" id="fschool_membergrid$x<?= $Grid->RowIndex ?>_rankId" value="<?= HtmlEncode($Grid->rankId->FormValue) ?>">
<input type="hidden" data-table="school_member" data-field="x_rankId" data-hidden="1" name="fschool_membergrid$o<?= $Grid->RowIndex ?>_rankId" id="fschool_membergrid$o<?= $Grid->RowIndex ?>_rankId" value="<?= HtmlEncode($Grid->rankId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->photo->Visible) { // photo ?>
        <td data-name="photo"<?= $Grid->photo->cellAttributes() ?>>
<?php if ($Grid->RowAction == "insert") { // Add record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_school_member_photo" class="el_school_member_photo">
<div id="fd_x<?= $Grid->RowIndex ?>_photo" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Grid->photo->title() ?>" data-table="school_member" data-field="x_photo" name="x<?= $Grid->RowIndex ?>_photo" id="x<?= $Grid->RowIndex ?>_photo" lang="<?= CurrentLanguageID() ?>"<?= $Grid->photo->editAttributes() ?><?= ($Grid->photo->ReadOnly || $Grid->photo->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Grid->photo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_photo" id= "fn_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_photo" id= "fa_x<?= $Grid->RowIndex ?>_photo" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_photo" id= "fs_x<?= $Grid->RowIndex ?>_photo" value="45">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_photo" id= "fx_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_photo" id= "fm_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_photo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_member_photo" class="el_school_member_photo">
<div id="fd_x<?= $Grid->RowIndex ?>_photo">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Grid->photo->title() ?>" data-table="school_member" data-field="x_photo" name="x<?= $Grid->RowIndex ?>_photo" id="x<?= $Grid->RowIndex ?>_photo" lang="<?= CurrentLanguageID() ?>"<?= $Grid->photo->editAttributes() ?>>
</div>
<div class="invalid-feedback"><?= $Grid->photo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_photo" id= "fn_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_photo" id= "fa_x<?= $Grid->RowIndex ?>_photo" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_photo" id= "fs_x<?= $Grid->RowIndex ?>_photo" value="45">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_photo" id= "fx_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_photo" id= "fm_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_photo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<input type="hidden" data-table="school_member" data-field="x_photo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_photo" id="o<?= $Grid->RowIndex ?>_photo" value="<?= HtmlEncode($Grid->photo->OldValue) ?>">
<?php } elseif ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_member_photo" class="el_school_member_photo">
<span>
<?= GetFileViewTag($Grid->photo, $Grid->photo->getViewValue(), false) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<?php if (!$Grid->isConfirm()) { ?>
<span id="el<?= $Grid->RowCount ?>_school_member_photo" class="el_school_member_photo">
<div id="fd_x<?= $Grid->RowIndex ?>_photo">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Grid->photo->title() ?>" data-table="school_member" data-field="x_photo" name="x<?= $Grid->RowIndex ?>_photo" id="x<?= $Grid->RowIndex ?>_photo" lang="<?= CurrentLanguageID() ?>"<?= $Grid->photo->editAttributes() ?>>
</div>
<div class="invalid-feedback"><?= $Grid->photo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_photo" id= "fn_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_photo" id= "fa_x<?= $Grid->RowIndex ?>_photo" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_photo") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_photo" id= "fs_x<?= $Grid->RowIndex ?>_photo" value="45">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_photo" id= "fx_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_photo" id= "fm_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_photo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_school_member_photo" class="el_school_member_photo">
<div id="fd_x<?= $Grid->RowIndex ?>_photo">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Grid->photo->title() ?>" data-table="school_member" data-field="x_photo" name="x<?= $Grid->RowIndex ?>_photo" id="x<?= $Grid->RowIndex ?>_photo" lang="<?= CurrentLanguageID() ?>"<?= $Grid->photo->editAttributes() ?>>
</div>
<div class="invalid-feedback"><?= $Grid->photo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_photo" id= "fn_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_photo" id= "fa_x<?= $Grid->RowIndex ?>_photo" value="<?= (Post("fa_x<?= $Grid->RowIndex ?>_photo") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_photo" id= "fs_x<?= $Grid->RowIndex ?>_photo" value="45">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_photo" id= "fx_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_photo" id= "fm_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_photo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
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
loadjs.ready(["fschool_membergrid","load"], () => fschool_membergrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_school_member", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_school_member_id" class="el_school_member_id"></span>
<?php } else { ?>
<span id="el$rowindex$_school_member_id" class="el_school_member_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_member" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_member" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->name->Visible) { // name ?>
        <td data-name="name">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_school_member_name" class="el_school_member_name">
<input type="<?= $Grid->name->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" data-table="school_member" data-field="x_name" value="<?= $Grid->name->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>"<?= $Grid->name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_member_name" class="el_school_member_name">
<span<?= $Grid->name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->name->getDisplayValue($Grid->name->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_member" data-field="x_name" data-hidden="1" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_member" data-field="x_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_name" id="o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->lastName->Visible) { // lastName ?>
        <td data-name="lastName">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_school_member_lastName" class="el_school_member_lastName">
<input type="<?= $Grid->lastName->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_lastName" id="x<?= $Grid->RowIndex ?>_lastName" data-table="school_member" data-field="x_lastName" value="<?= $Grid->lastName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->lastName->getPlaceHolder()) ?>"<?= $Grid->lastName->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lastName->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_member_lastName" class="el_school_member_lastName">
<span<?= $Grid->lastName->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->lastName->getDisplayValue($Grid->lastName->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_member" data-field="x_lastName" data-hidden="1" name="x<?= $Grid->RowIndex ?>_lastName" id="x<?= $Grid->RowIndex ?>_lastName" value="<?= HtmlEncode($Grid->lastName->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_member" data-field="x_lastName" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lastName" id="o<?= $Grid->RowIndex ?>_lastName" value="<?= HtmlEncode($Grid->lastName->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->martialArtId->Visible) { // martialArtId ?>
        <td data-name="martialArtId">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_school_member_martialArtId" class="el_school_member_martialArtId">
<?php $Grid->martialArtId->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_martialArtId"
        name="x<?= $Grid->RowIndex ?>_martialArtId"
        class="form-select ew-select<?= $Grid->martialArtId->isInvalidClass() ?>"
        data-select2-id="fschool_membergrid_x<?= $Grid->RowIndex ?>_martialArtId"
        data-table="school_member"
        data-field="x_martialArtId"
        data-value-separator="<?= $Grid->martialArtId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->martialArtId->getPlaceHolder()) ?>"
        <?= $Grid->martialArtId->editAttributes() ?>>
        <?= $Grid->martialArtId->selectOptionListHtml("x{$Grid->RowIndex}_martialArtId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->martialArtId->getErrorMessage() ?></div>
<?= $Grid->martialArtId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_martialArtId") ?>
<script>
loadjs.ready("fschool_membergrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_martialArtId", selectId: "fschool_membergrid_x<?= $Grid->RowIndex ?>_martialArtId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_membergrid.lists.martialArtId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_martialArtId", form: "fschool_membergrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_martialArtId", form: "fschool_membergrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.martialArtId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_member_martialArtId" class="el_school_member_martialArtId">
<span<?= $Grid->martialArtId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->martialArtId->getDisplayValue($Grid->martialArtId->ViewValue) ?></span></span>
<input type="hidden" data-table="school_member" data-field="x_martialArtId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_martialArtId" id="x<?= $Grid->RowIndex ?>_martialArtId" value="<?= HtmlEncode($Grid->martialArtId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_member" data-field="x_martialArtId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_martialArtId" id="o<?= $Grid->RowIndex ?>_martialArtId" value="<?= HtmlEncode($Grid->martialArtId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->rankId->Visible) { // rankId ?>
        <td data-name="rankId">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_school_member_rankId" class="el_school_member_rankId">
    <select
        id="x<?= $Grid->RowIndex ?>_rankId"
        name="x<?= $Grid->RowIndex ?>_rankId"
        class="form-select ew-select<?= $Grid->rankId->isInvalidClass() ?>"
        data-select2-id="fschool_membergrid_x<?= $Grid->RowIndex ?>_rankId"
        data-table="school_member"
        data-field="x_rankId"
        data-value-separator="<?= $Grid->rankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->rankId->getPlaceHolder()) ?>"
        <?= $Grid->rankId->editAttributes() ?>>
        <?= $Grid->rankId->selectOptionListHtml("x{$Grid->RowIndex}_rankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->rankId->getErrorMessage() ?></div>
<?= $Grid->rankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_rankId") ?>
<script>
loadjs.ready("fschool_membergrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_rankId", selectId: "fschool_membergrid_x<?= $Grid->RowIndex ?>_rankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_membergrid.lists.rankId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_rankId", form: "fschool_membergrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_rankId", form: "fschool_membergrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_member.fields.rankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_member_rankId" class="el_school_member_rankId">
<span<?= $Grid->rankId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->rankId->getDisplayValue($Grid->rankId->ViewValue) ?></span></span>
<input type="hidden" data-table="school_member" data-field="x_rankId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_rankId" id="x<?= $Grid->RowIndex ?>_rankId" value="<?= HtmlEncode($Grid->rankId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_member" data-field="x_rankId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_rankId" id="o<?= $Grid->RowIndex ?>_rankId" value="<?= HtmlEncode($Grid->rankId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->photo->Visible) { // photo ?>
        <td data-name="photo">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_school_member_photo" class="el_school_member_photo">
<div id="fd_x<?= $Grid->RowIndex ?>_photo" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Grid->photo->title() ?>" data-table="school_member" data-field="x_photo" name="x<?= $Grid->RowIndex ?>_photo" id="x<?= $Grid->RowIndex ?>_photo" lang="<?= CurrentLanguageID() ?>"<?= $Grid->photo->editAttributes() ?><?= ($Grid->photo->ReadOnly || $Grid->photo->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Grid->photo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_photo" id= "fn_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_photo" id= "fa_x<?= $Grid->RowIndex ?>_photo" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_photo" id= "fs_x<?= $Grid->RowIndex ?>_photo" value="45">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_photo" id= "fx_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_photo" id= "fm_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_photo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_member_photo" class="el_school_member_photo">
<div id="fd_x<?= $Grid->RowIndex ?>_photo">
    <input type="file" class="form-control ew-file-input d-none" title="<?= $Grid->photo->title() ?>" data-table="school_member" data-field="x_photo" name="x<?= $Grid->RowIndex ?>_photo" id="x<?= $Grid->RowIndex ?>_photo" lang="<?= CurrentLanguageID() ?>"<?= $Grid->photo->editAttributes() ?>>
</div>
<div class="invalid-feedback"><?= $Grid->photo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Grid->RowIndex ?>_photo" id= "fn_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Grid->RowIndex ?>_photo" id= "fa_x<?= $Grid->RowIndex ?>_photo" value="0">
<input type="hidden" name="fs_x<?= $Grid->RowIndex ?>_photo" id= "fs_x<?= $Grid->RowIndex ?>_photo" value="45">
<input type="hidden" name="fx_x<?= $Grid->RowIndex ?>_photo" id= "fx_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Grid->RowIndex ?>_photo" id= "fm_x<?= $Grid->RowIndex ?>_photo" value="<?= $Grid->photo->UploadMaxFileSize ?>">
<table id="ft_x<?= $Grid->RowIndex ?>_photo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<input type="hidden" data-table="school_member" data-field="x_photo" data-hidden="1" name="o<?= $Grid->RowIndex ?>_photo" id="o<?= $Grid->RowIndex ?>_photo" value="<?= HtmlEncode($Grid->photo->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fschool_membergrid","load"], () => fschool_membergrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fschool_membergrid">
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
    ew.addEventHandlers("school_member");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
