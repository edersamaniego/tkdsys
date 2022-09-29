<?php

namespace PHPMaker2022\school;

// Set up and run Grid object
$Grid = Container("SchoolUsersGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fschool_usersgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fschool_usersgrid = new ew.Form("fschool_usersgrid", "grid");
    fschool_usersgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { school_users: currentTable } });
    var fields = currentTable.fields;
    fschool_usersgrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["lastName", [fields.lastName.visible && fields.lastName.required ? ew.Validators.required(fields.lastName.caption) : null], fields.lastName.isInvalid],
        ["schoolIdMaster", [fields.schoolIdMaster.visible && fields.schoolIdMaster.required ? ew.Validators.required(fields.schoolIdMaster.caption) : null, ew.Validators.integer], fields.schoolIdMaster.isInvalid],
        ["schoolId", [fields.schoolId.visible && fields.schoolId.required ? ew.Validators.required(fields.schoolId.caption) : null], fields.schoolId.isInvalid],
        ["_login", [fields._login.visible && fields._login.required ? ew.Validators.required(fields._login.caption) : null], fields._login.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null, ew.Validators.email], fields._email.isInvalid],
        ["activateEmail", [fields.activateEmail.visible && fields.activateEmail.required ? ew.Validators.required(fields.activateEmail.caption) : null, ew.Validators.integer], fields.activateEmail.isInvalid],
        ["_password", [fields._password.visible && fields._password.required ? ew.Validators.required(fields._password.caption) : null], fields._password.isInvalid],
        ["createUserId", [fields.createUserId.visible && fields.createUserId.required ? ew.Validators.required(fields.createUserId.caption) : null], fields.createUserId.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null], fields.createDate.isInvalid],
        ["level", [fields.level.visible && fields.level.required ? ew.Validators.required(fields.level.caption) : null], fields.level.isInvalid]
    ]);

    // Check empty row
    fschool_usersgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["name",false],["lastName",false],["schoolIdMaster",false],["schoolId",false],["_login",false],["_email",false],["activateEmail",false],["_password",false],["level",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fschool_usersgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fschool_usersgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fschool_usersgrid.lists.schoolIdMaster = <?= $Grid->schoolIdMaster->toClientList($Grid) ?>;
    fschool_usersgrid.lists.schoolId = <?= $Grid->schoolId->toClientList($Grid) ?>;
    fschool_usersgrid.lists.createUserId = <?= $Grid->createUserId->toClientList($Grid) ?>;
    fschool_usersgrid.lists.level = <?= $Grid->level->toClientList($Grid) ?>;
    loadjs.done("fschool_usersgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> school_users">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="fschool_usersgrid" class="ew-form ew-list-form">
<div id="gmp_school_users" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_school_usersgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_school_users_id" class="school_users_id"><?= $Grid->renderFieldHeader($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->name->Visible) { // name ?>
        <th data-name="name" class="<?= $Grid->name->headerCellClass() ?>"><div id="elh_school_users_name" class="school_users_name"><?= $Grid->renderFieldHeader($Grid->name) ?></div></th>
<?php } ?>
<?php if ($Grid->lastName->Visible) { // lastName ?>
        <th data-name="lastName" class="<?= $Grid->lastName->headerCellClass() ?>"><div id="elh_school_users_lastName" class="school_users_lastName"><?= $Grid->renderFieldHeader($Grid->lastName) ?></div></th>
<?php } ?>
<?php if ($Grid->schoolIdMaster->Visible) { // schoolIdMaster ?>
        <th data-name="schoolIdMaster" class="<?= $Grid->schoolIdMaster->headerCellClass() ?>"><div id="elh_school_users_schoolIdMaster" class="school_users_schoolIdMaster"><?= $Grid->renderFieldHeader($Grid->schoolIdMaster) ?></div></th>
<?php } ?>
<?php if ($Grid->schoolId->Visible) { // schoolId ?>
        <th data-name="schoolId" class="<?= $Grid->schoolId->headerCellClass() ?>"><div id="elh_school_users_schoolId" class="school_users_schoolId"><?= $Grid->renderFieldHeader($Grid->schoolId) ?></div></th>
<?php } ?>
<?php if ($Grid->_login->Visible) { // login ?>
        <th data-name="_login" class="<?= $Grid->_login->headerCellClass() ?>"><div id="elh_school_users__login" class="school_users__login"><?= $Grid->renderFieldHeader($Grid->_login) ?></div></th>
<?php } ?>
<?php if ($Grid->_email->Visible) { // email ?>
        <th data-name="_email" class="<?= $Grid->_email->headerCellClass() ?>"><div id="elh_school_users__email" class="school_users__email"><?= $Grid->renderFieldHeader($Grid->_email) ?></div></th>
<?php } ?>
<?php if ($Grid->activateEmail->Visible) { // activateEmail ?>
        <th data-name="activateEmail" class="<?= $Grid->activateEmail->headerCellClass() ?>"><div id="elh_school_users_activateEmail" class="school_users_activateEmail"><?= $Grid->renderFieldHeader($Grid->activateEmail) ?></div></th>
<?php } ?>
<?php if ($Grid->_password->Visible) { // password ?>
        <th data-name="_password" class="<?= $Grid->_password->headerCellClass() ?>"><div id="elh_school_users__password" class="school_users__password"><?= $Grid->renderFieldHeader($Grid->_password) ?></div></th>
<?php } ?>
<?php if ($Grid->createUserId->Visible) { // createUserId ?>
        <th data-name="createUserId" class="<?= $Grid->createUserId->headerCellClass() ?>"><div id="elh_school_users_createUserId" class="school_users_createUserId"><?= $Grid->renderFieldHeader($Grid->createUserId) ?></div></th>
<?php } ?>
<?php if ($Grid->createDate->Visible) { // createDate ?>
        <th data-name="createDate" class="<?= $Grid->createDate->headerCellClass() ?>"><div id="elh_school_users_createDate" class="school_users_createDate"><?= $Grid->renderFieldHeader($Grid->createDate) ?></div></th>
<?php } ?>
<?php if ($Grid->level->Visible) { // level ?>
        <th data-name="level" class="<?= $Grid->level->headerCellClass() ?>"><div id="elh_school_users_level" class="school_users_level"><?= $Grid->renderFieldHeader($Grid->level) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_school_users",
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
<span id="el<?= $Grid->RowCount ?>_school_users_id" class="el_school_users_id"></span>
<input type="hidden" data-table="school_users" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_id" class="el_school_users_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_id" class="el_school_users_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_users" data-field="x_id" data-hidden="1" name="fschool_usersgrid$x<?= $Grid->RowIndex ?>_id" id="fschool_usersgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="school_users" data-field="x_id" data-hidden="1" name="fschool_usersgrid$o<?= $Grid->RowIndex ?>_id" id="fschool_usersgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="school_users" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->name->Visible) { // name ?>
        <td data-name="name"<?= $Grid->name->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_name" class="el_school_users_name">
<input type="<?= $Grid->name->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" data-table="school_users" data-field="x_name" value="<?= $Grid->name->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>"<?= $Grid->name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="school_users" data-field="x_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_name" id="o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_name" class="el_school_users_name">
<input type="<?= $Grid->name->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" data-table="school_users" data-field="x_name" value="<?= $Grid->name->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>"<?= $Grid->name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_name" class="el_school_users_name">
<span<?= $Grid->name->viewAttributes() ?>>
<?= $Grid->name->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_users" data-field="x_name" data-hidden="1" name="fschool_usersgrid$x<?= $Grid->RowIndex ?>_name" id="fschool_usersgrid$x<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->FormValue) ?>">
<input type="hidden" data-table="school_users" data-field="x_name" data-hidden="1" name="fschool_usersgrid$o<?= $Grid->RowIndex ?>_name" id="fschool_usersgrid$o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->lastName->Visible) { // lastName ?>
        <td data-name="lastName"<?= $Grid->lastName->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_lastName" class="el_school_users_lastName">
<input type="<?= $Grid->lastName->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_lastName" id="x<?= $Grid->RowIndex ?>_lastName" data-table="school_users" data-field="x_lastName" value="<?= $Grid->lastName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->lastName->getPlaceHolder()) ?>"<?= $Grid->lastName->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lastName->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="school_users" data-field="x_lastName" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lastName" id="o<?= $Grid->RowIndex ?>_lastName" value="<?= HtmlEncode($Grid->lastName->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_lastName" class="el_school_users_lastName">
<input type="<?= $Grid->lastName->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_lastName" id="x<?= $Grid->RowIndex ?>_lastName" data-table="school_users" data-field="x_lastName" value="<?= $Grid->lastName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->lastName->getPlaceHolder()) ?>"<?= $Grid->lastName->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lastName->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_lastName" class="el_school_users_lastName">
<span<?= $Grid->lastName->viewAttributes() ?>>
<?= $Grid->lastName->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_users" data-field="x_lastName" data-hidden="1" name="fschool_usersgrid$x<?= $Grid->RowIndex ?>_lastName" id="fschool_usersgrid$x<?= $Grid->RowIndex ?>_lastName" value="<?= HtmlEncode($Grid->lastName->FormValue) ?>">
<input type="hidden" data-table="school_users" data-field="x_lastName" data-hidden="1" name="fschool_usersgrid$o<?= $Grid->RowIndex ?>_lastName" id="fschool_usersgrid$o<?= $Grid->RowIndex ?>_lastName" value="<?= HtmlEncode($Grid->lastName->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->schoolIdMaster->Visible) { // schoolIdMaster ?>
        <td data-name="schoolIdMaster"<?= $Grid->schoolIdMaster->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_school_users_schoolIdMaster" class="el_school_users_schoolIdMaster">
    <select
        id="x<?= $Grid->RowIndex ?>_schoolIdMaster"
        name="x<?= $Grid->RowIndex ?>_schoolIdMaster"
        class="form-select ew-select<?= $Grid->schoolIdMaster->isInvalidClass() ?>"
        data-select2-id="fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolIdMaster"
        data-table="school_users"
        data-field="x_schoolIdMaster"
        data-value-separator="<?= $Grid->schoolIdMaster->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->schoolIdMaster->getPlaceHolder()) ?>"
        <?= $Grid->schoolIdMaster->editAttributes() ?>>
        <?= $Grid->schoolIdMaster->selectOptionListHtml("x{$Grid->RowIndex}_schoolIdMaster") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->schoolIdMaster->getErrorMessage() ?></div>
<?= $Grid->schoolIdMaster->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schoolIdMaster") ?>
<script>
loadjs.ready("fschool_usersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_schoolIdMaster", selectId: "fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolIdMaster" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersgrid.lists.schoolIdMaster.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_schoolIdMaster", form: "fschool_usersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_schoolIdMaster", form: "fschool_usersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.schoolIdMaster.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_school_users_schoolIdMaster" class="el_school_users_schoolIdMaster">
<?php
$onchange = $Grid->schoolIdMaster->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->schoolIdMaster->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->schoolIdMaster->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_schoolIdMaster" class="ew-auto-suggest">
    <input type="<?= $Grid->schoolIdMaster->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_schoolIdMaster" id="sv_x<?= $Grid->RowIndex ?>_schoolIdMaster" value="<?= RemoveHtml($Grid->schoolIdMaster->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->schoolIdMaster->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->schoolIdMaster->getPlaceHolder()) ?>"<?= $Grid->schoolIdMaster->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="school_users" data-field="x_schoolIdMaster" data-input="sv_x<?= $Grid->RowIndex ?>_schoolIdMaster" data-value-separator="<?= $Grid->schoolIdMaster->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_schoolIdMaster" id="x<?= $Grid->RowIndex ?>_schoolIdMaster" value="<?= HtmlEncode($Grid->schoolIdMaster->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->schoolIdMaster->getErrorMessage() ?></div>
<script>
loadjs.ready("fschool_usersgrid", function() {
    fschool_usersgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_schoolIdMaster","forceSelect":false}, ew.vars.tables.school_users.fields.schoolIdMaster.autoSuggestOptions));
});
</script>
<?= $Grid->schoolIdMaster->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schoolIdMaster") ?>
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x_schoolIdMaster" data-hidden="1" name="o<?= $Grid->RowIndex ?>_schoolIdMaster" id="o<?= $Grid->RowIndex ?>_schoolIdMaster" value="<?= HtmlEncode($Grid->schoolIdMaster->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<?php if (SameString($Grid->schoolId->CurrentValue, CurrentUserID())) { ?>
    <span<?= $Grid->schoolIdMaster->viewAttributes() ?>>
    <span class="form-control-plaintext"><?= $Grid->schoolIdMaster->getDisplayValue($Grid->schoolIdMaster->EditValue) ?></span></span>
    <input type="hidden" data-table="school_users" data-field="x_schoolIdMaster" data-hidden="1" name="x<?= $Grid->RowIndex ?>_schoolIdMaster" id="x<?= $Grid->RowIndex ?>_schoolIdMaster" value="<?= HtmlEncode($Grid->schoolIdMaster->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_school_users_schoolIdMaster" class="el_school_users_schoolIdMaster">
    <select
        id="x<?= $Grid->RowIndex ?>_schoolIdMaster"
        name="x<?= $Grid->RowIndex ?>_schoolIdMaster"
        class="form-select ew-select<?= $Grid->schoolIdMaster->isInvalidClass() ?>"
        data-select2-id="fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolIdMaster"
        data-table="school_users"
        data-field="x_schoolIdMaster"
        data-value-separator="<?= $Grid->schoolIdMaster->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->schoolIdMaster->getPlaceHolder()) ?>"
        <?= $Grid->schoolIdMaster->editAttributes() ?>>
        <?= $Grid->schoolIdMaster->selectOptionListHtml("x{$Grid->RowIndex}_schoolIdMaster") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->schoolIdMaster->getErrorMessage() ?></div>
<?= $Grid->schoolIdMaster->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schoolIdMaster") ?>
<script>
loadjs.ready("fschool_usersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_schoolIdMaster", selectId: "fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolIdMaster" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersgrid.lists.schoolIdMaster.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_schoolIdMaster", form: "fschool_usersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_schoolIdMaster", form: "fschool_usersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.schoolIdMaster.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_school_users_schoolIdMaster" class="el_school_users_schoolIdMaster">
<?php
$onchange = $Grid->schoolIdMaster->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->schoolIdMaster->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->schoolIdMaster->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_schoolIdMaster" class="ew-auto-suggest">
    <input type="<?= $Grid->schoolIdMaster->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_schoolIdMaster" id="sv_x<?= $Grid->RowIndex ?>_schoolIdMaster" value="<?= RemoveHtml($Grid->schoolIdMaster->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->schoolIdMaster->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->schoolIdMaster->getPlaceHolder()) ?>"<?= $Grid->schoolIdMaster->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="school_users" data-field="x_schoolIdMaster" data-input="sv_x<?= $Grid->RowIndex ?>_schoolIdMaster" data-value-separator="<?= $Grid->schoolIdMaster->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_schoolIdMaster" id="x<?= $Grid->RowIndex ?>_schoolIdMaster" value="<?= HtmlEncode($Grid->schoolIdMaster->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->schoolIdMaster->getErrorMessage() ?></div>
<script>
loadjs.ready("fschool_usersgrid", function() {
    fschool_usersgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_schoolIdMaster","forceSelect":false}, ew.vars.tables.school_users.fields.schoolIdMaster.autoSuggestOptions));
});
</script>
<?= $Grid->schoolIdMaster->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schoolIdMaster") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_schoolIdMaster" class="el_school_users_schoolIdMaster">
<span<?= $Grid->schoolIdMaster->viewAttributes() ?>>
<?= $Grid->schoolIdMaster->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_users" data-field="x_schoolIdMaster" data-hidden="1" name="fschool_usersgrid$x<?= $Grid->RowIndex ?>_schoolIdMaster" id="fschool_usersgrid$x<?= $Grid->RowIndex ?>_schoolIdMaster" value="<?= HtmlEncode($Grid->schoolIdMaster->FormValue) ?>">
<input type="hidden" data-table="school_users" data-field="x_schoolIdMaster" data-hidden="1" name="fschool_usersgrid$o<?= $Grid->RowIndex ?>_schoolIdMaster" id="fschool_usersgrid$o<?= $Grid->RowIndex ?>_schoolIdMaster" value="<?= HtmlEncode($Grid->schoolIdMaster->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->schoolId->Visible) { // schoolId ?>
        <td data-name="schoolId"<?= $Grid->schoolId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->schoolId->getSessionValue() != "") { ?>
<span<?= $Grid->schoolId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->schoolId->getDisplayValue($Grid->schoolId->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_schoolId" name="x<?= $Grid->RowIndex ?>_schoolId" value="<?= HtmlEncode($Grid->schoolId->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_school_users_schoolId" class="el_school_users_schoolId">
    <select
        id="x<?= $Grid->RowIndex ?>_schoolId"
        name="x<?= $Grid->RowIndex ?>_schoolId"
        class="form-select ew-select<?= $Grid->schoolId->isInvalidClass() ?>"
        data-select2-id="fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolId"
        data-table="school_users"
        data-field="x_schoolId"
        data-value-separator="<?= $Grid->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->schoolId->getPlaceHolder()) ?>"
        <?= $Grid->schoolId->editAttributes() ?>>
        <?= $Grid->schoolId->selectOptionListHtml("x{$Grid->RowIndex}_schoolId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->schoolId->getErrorMessage() ?></div>
<?= $Grid->schoolId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schoolId") ?>
<script>
loadjs.ready("fschool_usersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_schoolId", selectId: "fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersgrid.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_schoolId", form: "fschool_usersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_schoolId", form: "fschool_usersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.schoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_school_users_schoolId" class="el_school_users_schoolId">
    <select
        id="x<?= $Grid->RowIndex ?>_schoolId"
        name="x<?= $Grid->RowIndex ?>_schoolId"
        class="form-select ew-select<?= $Grid->schoolId->isInvalidClass() ?>"
        data-select2-id="fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolId"
        data-table="school_users"
        data-field="x_schoolId"
        data-value-separator="<?= $Grid->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->schoolId->getPlaceHolder()) ?>"
        <?= $Grid->schoolId->editAttributes() ?>>
        <?= $Grid->schoolId->selectOptionListHtml("x{$Grid->RowIndex}_schoolId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->schoolId->getErrorMessage() ?></div>
<?= $Grid->schoolId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schoolId") ?>
<script>
loadjs.ready("fschool_usersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_schoolId", selectId: "fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersgrid.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_schoolId", form: "fschool_usersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_schoolId", form: "fschool_usersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.schoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x_schoolId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_schoolId" id="o<?= $Grid->RowIndex ?>_schoolId" value="<?= HtmlEncode($Grid->schoolId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->schoolId->getSessionValue() != "") { ?>
<span<?= $Grid->schoolId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->schoolId->getDisplayValue($Grid->schoolId->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_schoolId" name="x<?= $Grid->RowIndex ?>_schoolId" value="<?= HtmlEncode($Grid->schoolId->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_school_users_schoolId" class="el_school_users_schoolId">
    <select
        id="x<?= $Grid->RowIndex ?>_schoolId"
        name="x<?= $Grid->RowIndex ?>_schoolId"
        class="form-select ew-select<?= $Grid->schoolId->isInvalidClass() ?>"
        data-select2-id="fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolId"
        data-table="school_users"
        data-field="x_schoolId"
        data-value-separator="<?= $Grid->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->schoolId->getPlaceHolder()) ?>"
        <?= $Grid->schoolId->editAttributes() ?>>
        <?= $Grid->schoolId->selectOptionListHtml("x{$Grid->RowIndex}_schoolId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->schoolId->getErrorMessage() ?></div>
<?= $Grid->schoolId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schoolId") ?>
<script>
loadjs.ready("fschool_usersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_schoolId", selectId: "fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersgrid.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_schoolId", form: "fschool_usersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_schoolId", form: "fschool_usersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.schoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_school_users_schoolId" class="el_school_users_schoolId">
    <select
        id="x<?= $Grid->RowIndex ?>_schoolId"
        name="x<?= $Grid->RowIndex ?>_schoolId"
        class="form-select ew-select<?= $Grid->schoolId->isInvalidClass() ?>"
        data-select2-id="fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolId"
        data-table="school_users"
        data-field="x_schoolId"
        data-value-separator="<?= $Grid->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->schoolId->getPlaceHolder()) ?>"
        <?= $Grid->schoolId->editAttributes() ?>>
        <?= $Grid->schoolId->selectOptionListHtml("x{$Grid->RowIndex}_schoolId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->schoolId->getErrorMessage() ?></div>
<?= $Grid->schoolId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schoolId") ?>
<script>
loadjs.ready("fschool_usersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_schoolId", selectId: "fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersgrid.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_schoolId", form: "fschool_usersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_schoolId", form: "fschool_usersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.schoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_schoolId" class="el_school_users_schoolId">
<span<?= $Grid->schoolId->viewAttributes() ?>>
<?= $Grid->schoolId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_users" data-field="x_schoolId" data-hidden="1" name="fschool_usersgrid$x<?= $Grid->RowIndex ?>_schoolId" id="fschool_usersgrid$x<?= $Grid->RowIndex ?>_schoolId" value="<?= HtmlEncode($Grid->schoolId->FormValue) ?>">
<input type="hidden" data-table="school_users" data-field="x_schoolId" data-hidden="1" name="fschool_usersgrid$o<?= $Grid->RowIndex ?>_schoolId" id="fschool_usersgrid$o<?= $Grid->RowIndex ?>_schoolId" value="<?= HtmlEncode($Grid->schoolId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->_login->Visible) { // login ?>
        <td data-name="_login"<?= $Grid->_login->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_school_users__login" class="el_school_users__login">
<input type="<?= $Grid->_login->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__login" id="x<?= $Grid->RowIndex ?>__login" data-table="school_users" data-field="x__login" value="<?= $Grid->_login->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_login->getPlaceHolder()) ?>"<?= $Grid->_login->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_login->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="school_users" data-field="x__login" data-hidden="1" name="o<?= $Grid->RowIndex ?>__login" id="o<?= $Grid->RowIndex ?>__login" value="<?= HtmlEncode($Grid->_login->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_school_users__login" class="el_school_users__login">
<input type="<?= $Grid->_login->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__login" id="x<?= $Grid->RowIndex ?>__login" data-table="school_users" data-field="x__login" value="<?= $Grid->_login->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_login->getPlaceHolder()) ?>"<?= $Grid->_login->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_login->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_users__login" class="el_school_users__login">
<span<?= $Grid->_login->viewAttributes() ?>>
<?= $Grid->_login->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_users" data-field="x__login" data-hidden="1" name="fschool_usersgrid$x<?= $Grid->RowIndex ?>__login" id="fschool_usersgrid$x<?= $Grid->RowIndex ?>__login" value="<?= HtmlEncode($Grid->_login->FormValue) ?>">
<input type="hidden" data-table="school_users" data-field="x__login" data-hidden="1" name="fschool_usersgrid$o<?= $Grid->RowIndex ?>__login" id="fschool_usersgrid$o<?= $Grid->RowIndex ?>__login" value="<?= HtmlEncode($Grid->_login->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->_email->Visible) { // email ?>
        <td data-name="_email"<?= $Grid->_email->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_school_users__email" class="el_school_users__email">
<input type="<?= $Grid->_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__email" id="x<?= $Grid->RowIndex ?>__email" data-table="school_users" data-field="x__email" value="<?= $Grid->_email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_email->getPlaceHolder()) ?>"<?= $Grid->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="school_users" data-field="x__email" data-hidden="1" name="o<?= $Grid->RowIndex ?>__email" id="o<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_school_users__email" class="el_school_users__email">
<input type="<?= $Grid->_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__email" id="x<?= $Grid->RowIndex ?>__email" data-table="school_users" data-field="x__email" value="<?= $Grid->_email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_email->getPlaceHolder()) ?>"<?= $Grid->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_users__email" class="el_school_users__email">
<span<?= $Grid->_email->viewAttributes() ?>>
<?= $Grid->_email->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_users" data-field="x__email" data-hidden="1" name="fschool_usersgrid$x<?= $Grid->RowIndex ?>__email" id="fschool_usersgrid$x<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->FormValue) ?>">
<input type="hidden" data-table="school_users" data-field="x__email" data-hidden="1" name="fschool_usersgrid$o<?= $Grid->RowIndex ?>__email" id="fschool_usersgrid$o<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->activateEmail->Visible) { // activateEmail ?>
        <td data-name="activateEmail"<?= $Grid->activateEmail->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_activateEmail" class="el_school_users_activateEmail">
<input type="<?= $Grid->activateEmail->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_activateEmail" id="x<?= $Grid->RowIndex ?>_activateEmail" data-table="school_users" data-field="x_activateEmail" value="<?= $Grid->activateEmail->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->activateEmail->getPlaceHolder()) ?>"<?= $Grid->activateEmail->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->activateEmail->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="school_users" data-field="x_activateEmail" data-hidden="1" name="o<?= $Grid->RowIndex ?>_activateEmail" id="o<?= $Grid->RowIndex ?>_activateEmail" value="<?= HtmlEncode($Grid->activateEmail->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_activateEmail" class="el_school_users_activateEmail">
<input type="<?= $Grid->activateEmail->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_activateEmail" id="x<?= $Grid->RowIndex ?>_activateEmail" data-table="school_users" data-field="x_activateEmail" value="<?= $Grid->activateEmail->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->activateEmail->getPlaceHolder()) ?>"<?= $Grid->activateEmail->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->activateEmail->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_activateEmail" class="el_school_users_activateEmail">
<span<?= $Grid->activateEmail->viewAttributes() ?>>
<?= $Grid->activateEmail->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_users" data-field="x_activateEmail" data-hidden="1" name="fschool_usersgrid$x<?= $Grid->RowIndex ?>_activateEmail" id="fschool_usersgrid$x<?= $Grid->RowIndex ?>_activateEmail" value="<?= HtmlEncode($Grid->activateEmail->FormValue) ?>">
<input type="hidden" data-table="school_users" data-field="x_activateEmail" data-hidden="1" name="fschool_usersgrid$o<?= $Grid->RowIndex ?>_activateEmail" id="fschool_usersgrid$o<?= $Grid->RowIndex ?>_activateEmail" value="<?= HtmlEncode($Grid->activateEmail->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->_password->Visible) { // password ?>
        <td data-name="_password"<?= $Grid->_password->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_school_users__password" class="el_school_users__password">
<div class="input-group">
    <input type="password" name="x<?= $Grid->RowIndex ?>__password" id="x<?= $Grid->RowIndex ?>__password" autocomplete="new-password" data-field="x__password" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_password->getPlaceHolder()) ?>"<?= $Grid->_password->editAttributes() ?>>
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fas fa-eye"></i></button>
</div>
<div class="invalid-feedback"><?= $Grid->_password->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="school_users" data-field="x__password" data-hidden="1" name="o<?= $Grid->RowIndex ?>__password" id="o<?= $Grid->RowIndex ?>__password" value="<?= HtmlEncode($Grid->_password->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_school_users__password" class="el_school_users__password">
<div class="input-group">
    <input type="password" name="x<?= $Grid->RowIndex ?>__password" id="x<?= $Grid->RowIndex ?>__password" autocomplete="new-password" data-field="x__password" value="<?= $Grid->_password->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_password->getPlaceHolder()) ?>"<?= $Grid->_password->editAttributes() ?>>
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fas fa-eye"></i></button>
</div>
<div class="invalid-feedback"><?= $Grid->_password->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_users__password" class="el_school_users__password">
<span<?= $Grid->_password->viewAttributes() ?>>
<?= $Grid->_password->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_users" data-field="x__password" data-hidden="1" name="fschool_usersgrid$x<?= $Grid->RowIndex ?>__password" id="fschool_usersgrid$x<?= $Grid->RowIndex ?>__password" value="<?= HtmlEncode($Grid->_password->FormValue) ?>">
<input type="hidden" data-table="school_users" data-field="x__password" data-hidden="1" name="fschool_usersgrid$o<?= $Grid->RowIndex ?>__password" id="fschool_usersgrid$o<?= $Grid->RowIndex ?>__password" value="<?= HtmlEncode($Grid->_password->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->createUserId->Visible) { // createUserId ?>
        <td data-name="createUserId"<?= $Grid->createUserId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="school_users" data-field="x_createUserId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_createUserId" id="o<?= $Grid->RowIndex ?>_createUserId" value="<?= HtmlEncode($Grid->createUserId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_createUserId" class="el_school_users_createUserId">
<span<?= $Grid->createUserId->viewAttributes() ?>>
<?= $Grid->createUserId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_users" data-field="x_createUserId" data-hidden="1" name="fschool_usersgrid$x<?= $Grid->RowIndex ?>_createUserId" id="fschool_usersgrid$x<?= $Grid->RowIndex ?>_createUserId" value="<?= HtmlEncode($Grid->createUserId->FormValue) ?>">
<input type="hidden" data-table="school_users" data-field="x_createUserId" data-hidden="1" name="fschool_usersgrid$o<?= $Grid->RowIndex ?>_createUserId" id="fschool_usersgrid$o<?= $Grid->RowIndex ?>_createUserId" value="<?= HtmlEncode($Grid->createUserId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->createDate->Visible) { // createDate ?>
        <td data-name="createDate"<?= $Grid->createDate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="school_users" data-field="x_createDate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_createDate" id="o<?= $Grid->RowIndex ?>_createDate" value="<?= HtmlEncode($Grid->createDate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_createDate" class="el_school_users_createDate">
<span<?= $Grid->createDate->viewAttributes() ?>>
<?= $Grid->createDate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_users" data-field="x_createDate" data-hidden="1" name="fschool_usersgrid$x<?= $Grid->RowIndex ?>_createDate" id="fschool_usersgrid$x<?= $Grid->RowIndex ?>_createDate" value="<?= HtmlEncode($Grid->createDate->FormValue) ?>">
<input type="hidden" data-table="school_users" data-field="x_createDate" data-hidden="1" name="fschool_usersgrid$o<?= $Grid->RowIndex ?>_createDate" id="fschool_usersgrid$o<?= $Grid->RowIndex ?>_createDate" value="<?= HtmlEncode($Grid->createDate->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->level->Visible) { // level ?>
        <td data-name="level"<?= $Grid->level->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_school_users_level" class="el_school_users_level">
<span class="form-control-plaintext"><?= $Grid->level->getDisplayValue($Grid->level->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_school_users_level" class="el_school_users_level">
    <select
        id="x<?= $Grid->RowIndex ?>_level"
        name="x<?= $Grid->RowIndex ?>_level"
        class="form-select ew-select<?= $Grid->level->isInvalidClass() ?>"
        data-select2-id="fschool_usersgrid_x<?= $Grid->RowIndex ?>_level"
        data-table="school_users"
        data-field="x_level"
        data-value-separator="<?= $Grid->level->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->level->getPlaceHolder()) ?>"
        <?= $Grid->level->editAttributes() ?>>
        <?= $Grid->level->selectOptionListHtml("x{$Grid->RowIndex}_level") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->level->getErrorMessage() ?></div>
<?= $Grid->level->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_level") ?>
<script>
loadjs.ready("fschool_usersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_level", selectId: "fschool_usersgrid_x<?= $Grid->RowIndex ?>_level" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersgrid.lists.level.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_level", form: "fschool_usersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_level", form: "fschool_usersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.level.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x_level" data-hidden="1" name="o<?= $Grid->RowIndex ?>_level" id="o<?= $Grid->RowIndex ?>_level" value="<?= HtmlEncode($Grid->level->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Grid->RowCount ?>_school_users_level" class="el_school_users_level">
<span class="form-control-plaintext"><?= $Grid->level->getDisplayValue($Grid->level->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_school_users_level" class="el_school_users_level">
    <select
        id="x<?= $Grid->RowIndex ?>_level"
        name="x<?= $Grid->RowIndex ?>_level"
        class="form-select ew-select<?= $Grid->level->isInvalidClass() ?>"
        data-select2-id="fschool_usersgrid_x<?= $Grid->RowIndex ?>_level"
        data-table="school_users"
        data-field="x_level"
        data-value-separator="<?= $Grid->level->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->level->getPlaceHolder()) ?>"
        <?= $Grid->level->editAttributes() ?>>
        <?= $Grid->level->selectOptionListHtml("x{$Grid->RowIndex}_level") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->level->getErrorMessage() ?></div>
<?= $Grid->level->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_level") ?>
<script>
loadjs.ready("fschool_usersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_level", selectId: "fschool_usersgrid_x<?= $Grid->RowIndex ?>_level" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersgrid.lists.level.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_level", form: "fschool_usersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_level", form: "fschool_usersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.level.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_school_users_level" class="el_school_users_level">
<span<?= $Grid->level->viewAttributes() ?>>
<?= $Grid->level->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="school_users" data-field="x_level" data-hidden="1" name="fschool_usersgrid$x<?= $Grid->RowIndex ?>_level" id="fschool_usersgrid$x<?= $Grid->RowIndex ?>_level" value="<?= HtmlEncode($Grid->level->FormValue) ?>">
<input type="hidden" data-table="school_users" data-field="x_level" data-hidden="1" name="fschool_usersgrid$o<?= $Grid->RowIndex ?>_level" id="fschool_usersgrid$o<?= $Grid->RowIndex ?>_level" value="<?= HtmlEncode($Grid->level->OldValue) ?>">
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
loadjs.ready(["fschool_usersgrid","load"], () => fschool_usersgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_school_users", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_school_users_id" class="el_school_users_id"></span>
<?php } else { ?>
<span id="el$rowindex$_school_users_id" class="el_school_users_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->name->Visible) { // name ?>
        <td data-name="name">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_school_users_name" class="el_school_users_name">
<input type="<?= $Grid->name->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" data-table="school_users" data-field="x_name" value="<?= $Grid->name->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Grid->name->getPlaceHolder()) ?>"<?= $Grid->name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_users_name" class="el_school_users_name">
<span<?= $Grid->name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->name->getDisplayValue($Grid->name->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x_name" data-hidden="1" name="x<?= $Grid->RowIndex ?>_name" id="x<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x_name" data-hidden="1" name="o<?= $Grid->RowIndex ?>_name" id="o<?= $Grid->RowIndex ?>_name" value="<?= HtmlEncode($Grid->name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->lastName->Visible) { // lastName ?>
        <td data-name="lastName">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_school_users_lastName" class="el_school_users_lastName">
<input type="<?= $Grid->lastName->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_lastName" id="x<?= $Grid->RowIndex ?>_lastName" data-table="school_users" data-field="x_lastName" value="<?= $Grid->lastName->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->lastName->getPlaceHolder()) ?>"<?= $Grid->lastName->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->lastName->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_users_lastName" class="el_school_users_lastName">
<span<?= $Grid->lastName->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->lastName->getDisplayValue($Grid->lastName->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x_lastName" data-hidden="1" name="x<?= $Grid->RowIndex ?>_lastName" id="x<?= $Grid->RowIndex ?>_lastName" value="<?= HtmlEncode($Grid->lastName->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x_lastName" data-hidden="1" name="o<?= $Grid->RowIndex ?>_lastName" id="o<?= $Grid->RowIndex ?>_lastName" value="<?= HtmlEncode($Grid->lastName->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->schoolIdMaster->Visible) { // schoolIdMaster ?>
        <td data-name="schoolIdMaster">
<?php if (!$Grid->isConfirm()) { ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el$rowindex$_school_users_schoolIdMaster" class="el_school_users_schoolIdMaster">
    <select
        id="x<?= $Grid->RowIndex ?>_schoolIdMaster"
        name="x<?= $Grid->RowIndex ?>_schoolIdMaster"
        class="form-select ew-select<?= $Grid->schoolIdMaster->isInvalidClass() ?>"
        data-select2-id="fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolIdMaster"
        data-table="school_users"
        data-field="x_schoolIdMaster"
        data-value-separator="<?= $Grid->schoolIdMaster->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->schoolIdMaster->getPlaceHolder()) ?>"
        <?= $Grid->schoolIdMaster->editAttributes() ?>>
        <?= $Grid->schoolIdMaster->selectOptionListHtml("x{$Grid->RowIndex}_schoolIdMaster") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->schoolIdMaster->getErrorMessage() ?></div>
<?= $Grid->schoolIdMaster->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schoolIdMaster") ?>
<script>
loadjs.ready("fschool_usersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_schoolIdMaster", selectId: "fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolIdMaster" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersgrid.lists.schoolIdMaster.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_schoolIdMaster", form: "fschool_usersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_schoolIdMaster", form: "fschool_usersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.schoolIdMaster.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_users_schoolIdMaster" class="el_school_users_schoolIdMaster">
<?php
$onchange = $Grid->schoolIdMaster->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->schoolIdMaster->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->schoolIdMaster->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_schoolIdMaster" class="ew-auto-suggest">
    <input type="<?= $Grid->schoolIdMaster->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_schoolIdMaster" id="sv_x<?= $Grid->RowIndex ?>_schoolIdMaster" value="<?= RemoveHtml($Grid->schoolIdMaster->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->schoolIdMaster->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->schoolIdMaster->getPlaceHolder()) ?>"<?= $Grid->schoolIdMaster->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="school_users" data-field="x_schoolIdMaster" data-input="sv_x<?= $Grid->RowIndex ?>_schoolIdMaster" data-value-separator="<?= $Grid->schoolIdMaster->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_schoolIdMaster" id="x<?= $Grid->RowIndex ?>_schoolIdMaster" value="<?= HtmlEncode($Grid->schoolIdMaster->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->schoolIdMaster->getErrorMessage() ?></div>
<script>
loadjs.ready("fschool_usersgrid", function() {
    fschool_usersgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_schoolIdMaster","forceSelect":false}, ew.vars.tables.school_users.fields.schoolIdMaster.autoSuggestOptions));
});
</script>
<?= $Grid->schoolIdMaster->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schoolIdMaster") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_school_users_schoolIdMaster" class="el_school_users_schoolIdMaster">
<span<?= $Grid->schoolIdMaster->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->schoolIdMaster->getDisplayValue($Grid->schoolIdMaster->ViewValue) ?></span></span>
<input type="hidden" data-table="school_users" data-field="x_schoolIdMaster" data-hidden="1" name="x<?= $Grid->RowIndex ?>_schoolIdMaster" id="x<?= $Grid->RowIndex ?>_schoolIdMaster" value="<?= HtmlEncode($Grid->schoolIdMaster->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x_schoolIdMaster" data-hidden="1" name="o<?= $Grid->RowIndex ?>_schoolIdMaster" id="o<?= $Grid->RowIndex ?>_schoolIdMaster" value="<?= HtmlEncode($Grid->schoolIdMaster->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->schoolId->Visible) { // schoolId ?>
        <td data-name="schoolId">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->schoolId->getSessionValue() != "") { ?>
<span<?= $Grid->schoolId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->schoolId->getDisplayValue($Grid->schoolId->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_schoolId" name="x<?= $Grid->RowIndex ?>_schoolId" value="<?= HtmlEncode($Grid->schoolId->CurrentValue) ?>" data-hidden="1">
<?php } elseif (!$Security->isAdmin() && $Security->isLoggedIn() && !$Grid->userIDAllow("grid")) { // Non system admin ?>
<span id="el$rowindex$_school_users_schoolId" class="el_school_users_schoolId">
    <select
        id="x<?= $Grid->RowIndex ?>_schoolId"
        name="x<?= $Grid->RowIndex ?>_schoolId"
        class="form-select ew-select<?= $Grid->schoolId->isInvalidClass() ?>"
        data-select2-id="fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolId"
        data-table="school_users"
        data-field="x_schoolId"
        data-value-separator="<?= $Grid->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->schoolId->getPlaceHolder()) ?>"
        <?= $Grid->schoolId->editAttributes() ?>>
        <?= $Grid->schoolId->selectOptionListHtml("x{$Grid->RowIndex}_schoolId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->schoolId->getErrorMessage() ?></div>
<?= $Grid->schoolId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schoolId") ?>
<script>
loadjs.ready("fschool_usersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_schoolId", selectId: "fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersgrid.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_schoolId", form: "fschool_usersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_schoolId", form: "fschool_usersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.schoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_users_schoolId" class="el_school_users_schoolId">
    <select
        id="x<?= $Grid->RowIndex ?>_schoolId"
        name="x<?= $Grid->RowIndex ?>_schoolId"
        class="form-select ew-select<?= $Grid->schoolId->isInvalidClass() ?>"
        data-select2-id="fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolId"
        data-table="school_users"
        data-field="x_schoolId"
        data-value-separator="<?= $Grid->schoolId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->schoolId->getPlaceHolder()) ?>"
        <?= $Grid->schoolId->editAttributes() ?>>
        <?= $Grid->schoolId->selectOptionListHtml("x{$Grid->RowIndex}_schoolId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->schoolId->getErrorMessage() ?></div>
<?= $Grid->schoolId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_schoolId") ?>
<script>
loadjs.ready("fschool_usersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_schoolId", selectId: "fschool_usersgrid_x<?= $Grid->RowIndex ?>_schoolId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersgrid.lists.schoolId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_schoolId", form: "fschool_usersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_schoolId", form: "fschool_usersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.schoolId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_school_users_schoolId" class="el_school_users_schoolId">
<span<?= $Grid->schoolId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->schoolId->getDisplayValue($Grid->schoolId->ViewValue) ?></span></span>
<input type="hidden" data-table="school_users" data-field="x_schoolId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_schoolId" id="x<?= $Grid->RowIndex ?>_schoolId" value="<?= HtmlEncode($Grid->schoolId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x_schoolId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_schoolId" id="o<?= $Grid->RowIndex ?>_schoolId" value="<?= HtmlEncode($Grid->schoolId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->_login->Visible) { // login ?>
        <td data-name="_login">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_school_users__login" class="el_school_users__login">
<input type="<?= $Grid->_login->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__login" id="x<?= $Grid->RowIndex ?>__login" data-table="school_users" data-field="x__login" value="<?= $Grid->_login->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_login->getPlaceHolder()) ?>"<?= $Grid->_login->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_login->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_users__login" class="el_school_users__login">
<span<?= $Grid->_login->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->_login->getDisplayValue($Grid->_login->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x__login" data-hidden="1" name="x<?= $Grid->RowIndex ?>__login" id="x<?= $Grid->RowIndex ?>__login" value="<?= HtmlEncode($Grid->_login->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x__login" data-hidden="1" name="o<?= $Grid->RowIndex ?>__login" id="o<?= $Grid->RowIndex ?>__login" value="<?= HtmlEncode($Grid->_login->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->_email->Visible) { // email ?>
        <td data-name="_email">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_school_users__email" class="el_school_users__email">
<input type="<?= $Grid->_email->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__email" id="x<?= $Grid->RowIndex ?>__email" data-table="school_users" data-field="x__email" value="<?= $Grid->_email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_email->getPlaceHolder()) ?>"<?= $Grid->_email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_users__email" class="el_school_users__email">
<span<?= $Grid->_email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->_email->getDisplayValue($Grid->_email->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x__email" data-hidden="1" name="x<?= $Grid->RowIndex ?>__email" id="x<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x__email" data-hidden="1" name="o<?= $Grid->RowIndex ?>__email" id="o<?= $Grid->RowIndex ?>__email" value="<?= HtmlEncode($Grid->_email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->activateEmail->Visible) { // activateEmail ?>
        <td data-name="activateEmail">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_school_users_activateEmail" class="el_school_users_activateEmail">
<input type="<?= $Grid->activateEmail->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_activateEmail" id="x<?= $Grid->RowIndex ?>_activateEmail" data-table="school_users" data-field="x_activateEmail" value="<?= $Grid->activateEmail->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->activateEmail->getPlaceHolder()) ?>"<?= $Grid->activateEmail->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->activateEmail->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_users_activateEmail" class="el_school_users_activateEmail">
<span<?= $Grid->activateEmail->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->activateEmail->getDisplayValue($Grid->activateEmail->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x_activateEmail" data-hidden="1" name="x<?= $Grid->RowIndex ?>_activateEmail" id="x<?= $Grid->RowIndex ?>_activateEmail" value="<?= HtmlEncode($Grid->activateEmail->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x_activateEmail" data-hidden="1" name="o<?= $Grid->RowIndex ?>_activateEmail" id="o<?= $Grid->RowIndex ?>_activateEmail" value="<?= HtmlEncode($Grid->activateEmail->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->_password->Visible) { // password ?>
        <td data-name="_password">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_school_users__password" class="el_school_users__password">
<div class="input-group">
    <input type="password" name="x<?= $Grid->RowIndex ?>__password" id="x<?= $Grid->RowIndex ?>__password" autocomplete="new-password" data-field="x__password" size="30" maxlength="255" placeholder="<?= HtmlEncode($Grid->_password->getPlaceHolder()) ?>"<?= $Grid->_password->editAttributes() ?>>
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fas fa-eye"></i></button>
</div>
<div class="invalid-feedback"><?= $Grid->_password->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_users__password" class="el_school_users__password">
<span<?= $Grid->_password->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->_password->getDisplayValue($Grid->_password->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x__password" data-hidden="1" name="x<?= $Grid->RowIndex ?>__password" id="x<?= $Grid->RowIndex ?>__password" value="<?= HtmlEncode($Grid->_password->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x__password" data-hidden="1" name="o<?= $Grid->RowIndex ?>__password" id="o<?= $Grid->RowIndex ?>__password" value="<?= HtmlEncode($Grid->_password->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->createUserId->Visible) { // createUserId ?>
        <td data-name="createUserId">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_school_users_createUserId" class="el_school_users_createUserId">
<span<?= $Grid->createUserId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->createUserId->getDisplayValue($Grid->createUserId->ViewValue) ?></span></span>
<input type="hidden" data-table="school_users" data-field="x_createUserId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_createUserId" id="x<?= $Grid->RowIndex ?>_createUserId" value="<?= HtmlEncode($Grid->createUserId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x_createUserId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_createUserId" id="o<?= $Grid->RowIndex ?>_createUserId" value="<?= HtmlEncode($Grid->createUserId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->createDate->Visible) { // createDate ?>
        <td data-name="createDate">
<?php if (!$Grid->isConfirm()) { ?>
<?php } else { ?>
<span id="el$rowindex$_school_users_createDate" class="el_school_users_createDate">
<span<?= $Grid->createDate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->createDate->getDisplayValue($Grid->createDate->ViewValue))) ?>"></span>
<input type="hidden" data-table="school_users" data-field="x_createDate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_createDate" id="x<?= $Grid->RowIndex ?>_createDate" value="<?= HtmlEncode($Grid->createDate->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x_createDate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_createDate" id="o<?= $Grid->RowIndex ?>_createDate" value="<?= HtmlEncode($Grid->createDate->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->level->Visible) { // level ?>
        <td data-name="level">
<?php if (!$Grid->isConfirm()) { ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el$rowindex$_school_users_level" class="el_school_users_level">
<span class="form-control-plaintext"><?= $Grid->level->getDisplayValue($Grid->level->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el$rowindex$_school_users_level" class="el_school_users_level">
    <select
        id="x<?= $Grid->RowIndex ?>_level"
        name="x<?= $Grid->RowIndex ?>_level"
        class="form-select ew-select<?= $Grid->level->isInvalidClass() ?>"
        data-select2-id="fschool_usersgrid_x<?= $Grid->RowIndex ?>_level"
        data-table="school_users"
        data-field="x_level"
        data-value-separator="<?= $Grid->level->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->level->getPlaceHolder()) ?>"
        <?= $Grid->level->editAttributes() ?>>
        <?= $Grid->level->selectOptionListHtml("x{$Grid->RowIndex}_level") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->level->getErrorMessage() ?></div>
<?= $Grid->level->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_level") ?>
<script>
loadjs.ready("fschool_usersgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_level", selectId: "fschool_usersgrid_x<?= $Grid->RowIndex ?>_level" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fschool_usersgrid.lists.level.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_level", form: "fschool_usersgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_level", form: "fschool_usersgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.school_users.fields.level.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_school_users_level" class="el_school_users_level">
<span<?= $Grid->level->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->level->getDisplayValue($Grid->level->ViewValue) ?></span></span>
<input type="hidden" data-table="school_users" data-field="x_level" data-hidden="1" name="x<?= $Grid->RowIndex ?>_level" id="x<?= $Grid->RowIndex ?>_level" value="<?= HtmlEncode($Grid->level->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="school_users" data-field="x_level" data-hidden="1" name="o<?= $Grid->RowIndex ?>_level" id="o<?= $Grid->RowIndex ?>_level" value="<?= HtmlEncode($Grid->level->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fschool_usersgrid","load"], () => fschool_usersgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fschool_usersgrid">
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
    ew.addEventHandlers("school_users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
