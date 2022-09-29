<?php

namespace PHPMaker2022\school;

// Set up and run Grid object
$Grid = Container("FinDebitGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var ffin_debitgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_debitgrid = new ew.Form("ffin_debitgrid", "grid");
    ffin_debitgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { fin_debit: currentTable } });
    var fields = currentTable.fields;
    ffin_debitgrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["dueDate", [fields.dueDate.visible && fields.dueDate.required ? ew.Validators.required(fields.dueDate.caption) : null, ew.Validators.datetime(fields.dueDate.clientFormatPattern)], fields.dueDate.isInvalid],
        ["value", [fields.value.visible && fields.value.required ? ew.Validators.required(fields.value.caption) : null, ew.Validators.float], fields.value.isInvalid],
        ["paymentMethod", [fields.paymentMethod.visible && fields.paymentMethod.required ? ew.Validators.required(fields.paymentMethod.caption) : null], fields.paymentMethod.isInvalid],
        ["checkingAccountId", [fields.checkingAccountId.visible && fields.checkingAccountId.required ? ew.Validators.required(fields.checkingAccountId.caption) : null], fields.checkingAccountId.isInvalid]
    ]);

    // Check empty row
    ffin_debitgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["dueDate",false],["value",false],["paymentMethod",false],["checkingAccountId",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    ffin_debitgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_debitgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_debitgrid.lists.paymentMethod = <?= $Grid->paymentMethod->toClientList($Grid) ?>;
    ffin_debitgrid.lists.checkingAccountId = <?= $Grid->checkingAccountId->toClientList($Grid) ?>;
    loadjs.done("ffin_debitgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fin_debit">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="ffin_debitgrid" class="ew-form ew-list-form">
<div id="gmp_fin_debit" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_fin_debitgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_fin_debit_id" class="fin_debit_id"><?= $Grid->renderFieldHeader($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->dueDate->Visible) { // dueDate ?>
        <th data-name="dueDate" class="<?= $Grid->dueDate->headerCellClass() ?>"><div id="elh_fin_debit_dueDate" class="fin_debit_dueDate"><?= $Grid->renderFieldHeader($Grid->dueDate) ?></div></th>
<?php } ?>
<?php if ($Grid->value->Visible) { // value ?>
        <th data-name="value" class="<?= $Grid->value->headerCellClass() ?>"><div id="elh_fin_debit_value" class="fin_debit_value"><?= $Grid->renderFieldHeader($Grid->value) ?></div></th>
<?php } ?>
<?php if ($Grid->paymentMethod->Visible) { // paymentMethod ?>
        <th data-name="paymentMethod" class="<?= $Grid->paymentMethod->headerCellClass() ?>"><div id="elh_fin_debit_paymentMethod" class="fin_debit_paymentMethod"><?= $Grid->renderFieldHeader($Grid->paymentMethod) ?></div></th>
<?php } ?>
<?php if ($Grid->checkingAccountId->Visible) { // checkingAccountId ?>
        <th data-name="checkingAccountId" class="<?= $Grid->checkingAccountId->headerCellClass() ?>"><div id="elh_fin_debit_checkingAccountId" class="fin_debit_checkingAccountId"><?= $Grid->renderFieldHeader($Grid->checkingAccountId) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_fin_debit",
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
<span id="el<?= $Grid->RowCount ?>_fin_debit_id" class="el_fin_debit_id"></span>
<input type="hidden" data-table="fin_debit" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fin_debit_id" class="el_fin_debit_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fin_debit" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fin_debit_id" class="el_fin_debit_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fin_debit" data-field="x_id" data-hidden="1" name="ffin_debitgrid$x<?= $Grid->RowIndex ?>_id" id="ffin_debitgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="fin_debit" data-field="x_id" data-hidden="1" name="ffin_debitgrid$o<?= $Grid->RowIndex ?>_id" id="ffin_debitgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="fin_debit" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->dueDate->Visible) { // dueDate ?>
        <td data-name="dueDate"<?= $Grid->dueDate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fin_debit_dueDate" class="el_fin_debit_dueDate">
<input type="<?= $Grid->dueDate->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dueDate" id="x<?= $Grid->RowIndex ?>_dueDate" data-table="fin_debit" data-field="x_dueDate" value="<?= $Grid->dueDate->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dueDate->getPlaceHolder()) ?>"<?= $Grid->dueDate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dueDate->getErrorMessage() ?></div>
<?php if (!$Grid->dueDate->ReadOnly && !$Grid->dueDate->Disabled && !isset($Grid->dueDate->EditAttrs["readonly"]) && !isset($Grid->dueDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffin_debitgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_debitgrid", "x<?= $Grid->RowIndex ?>_dueDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="fin_debit" data-field="x_dueDate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dueDate" id="o<?= $Grid->RowIndex ?>_dueDate" value="<?= HtmlEncode($Grid->dueDate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fin_debit_dueDate" class="el_fin_debit_dueDate">
<input type="<?= $Grid->dueDate->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dueDate" id="x<?= $Grid->RowIndex ?>_dueDate" data-table="fin_debit" data-field="x_dueDate" value="<?= $Grid->dueDate->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dueDate->getPlaceHolder()) ?>"<?= $Grid->dueDate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dueDate->getErrorMessage() ?></div>
<?php if (!$Grid->dueDate->ReadOnly && !$Grid->dueDate->Disabled && !isset($Grid->dueDate->EditAttrs["readonly"]) && !isset($Grid->dueDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffin_debitgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_debitgrid", "x<?= $Grid->RowIndex ?>_dueDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fin_debit_dueDate" class="el_fin_debit_dueDate">
<span<?= $Grid->dueDate->viewAttributes() ?>>
<?= $Grid->dueDate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fin_debit" data-field="x_dueDate" data-hidden="1" name="ffin_debitgrid$x<?= $Grid->RowIndex ?>_dueDate" id="ffin_debitgrid$x<?= $Grid->RowIndex ?>_dueDate" value="<?= HtmlEncode($Grid->dueDate->FormValue) ?>">
<input type="hidden" data-table="fin_debit" data-field="x_dueDate" data-hidden="1" name="ffin_debitgrid$o<?= $Grid->RowIndex ?>_dueDate" id="ffin_debitgrid$o<?= $Grid->RowIndex ?>_dueDate" value="<?= HtmlEncode($Grid->dueDate->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->value->Visible) { // value ?>
        <td data-name="value"<?= $Grid->value->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fin_debit_value" class="el_fin_debit_value">
<input type="<?= $Grid->value->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_value" id="x<?= $Grid->RowIndex ?>_value" data-table="fin_debit" data-field="x_value" value="<?= $Grid->value->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->value->getPlaceHolder()) ?>"<?= $Grid->value->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->value->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fin_debit" data-field="x_value" data-hidden="1" name="o<?= $Grid->RowIndex ?>_value" id="o<?= $Grid->RowIndex ?>_value" value="<?= HtmlEncode($Grid->value->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fin_debit_value" class="el_fin_debit_value">
<input type="<?= $Grid->value->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_value" id="x<?= $Grid->RowIndex ?>_value" data-table="fin_debit" data-field="x_value" value="<?= $Grid->value->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->value->getPlaceHolder()) ?>"<?= $Grid->value->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->value->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fin_debit_value" class="el_fin_debit_value">
<span<?= $Grid->value->viewAttributes() ?>>
<?= $Grid->value->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fin_debit" data-field="x_value" data-hidden="1" name="ffin_debitgrid$x<?= $Grid->RowIndex ?>_value" id="ffin_debitgrid$x<?= $Grid->RowIndex ?>_value" value="<?= HtmlEncode($Grid->value->FormValue) ?>">
<input type="hidden" data-table="fin_debit" data-field="x_value" data-hidden="1" name="ffin_debitgrid$o<?= $Grid->RowIndex ?>_value" id="ffin_debitgrid$o<?= $Grid->RowIndex ?>_value" value="<?= HtmlEncode($Grid->value->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->paymentMethod->Visible) { // paymentMethod ?>
        <td data-name="paymentMethod"<?= $Grid->paymentMethod->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fin_debit_paymentMethod" class="el_fin_debit_paymentMethod">
    <select
        id="x<?= $Grid->RowIndex ?>_paymentMethod"
        name="x<?= $Grid->RowIndex ?>_paymentMethod"
        class="form-select ew-select<?= $Grid->paymentMethod->isInvalidClass() ?>"
        data-select2-id="ffin_debitgrid_x<?= $Grid->RowIndex ?>_paymentMethod"
        data-table="fin_debit"
        data-field="x_paymentMethod"
        data-value-separator="<?= $Grid->paymentMethod->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->paymentMethod->getPlaceHolder()) ?>"
        <?= $Grid->paymentMethod->editAttributes() ?>>
        <?= $Grid->paymentMethod->selectOptionListHtml("x{$Grid->RowIndex}_paymentMethod") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->paymentMethod->getErrorMessage() ?></div>
<?= $Grid->paymentMethod->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_paymentMethod") ?>
<script>
loadjs.ready("ffin_debitgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_paymentMethod", selectId: "ffin_debitgrid_x<?= $Grid->RowIndex ?>_paymentMethod" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_debitgrid.lists.paymentMethod.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_paymentMethod", form: "ffin_debitgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_paymentMethod", form: "ffin_debitgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_debit.fields.paymentMethod.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="fin_debit" data-field="x_paymentMethod" data-hidden="1" name="o<?= $Grid->RowIndex ?>_paymentMethod" id="o<?= $Grid->RowIndex ?>_paymentMethod" value="<?= HtmlEncode($Grid->paymentMethod->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fin_debit_paymentMethod" class="el_fin_debit_paymentMethod">
    <select
        id="x<?= $Grid->RowIndex ?>_paymentMethod"
        name="x<?= $Grid->RowIndex ?>_paymentMethod"
        class="form-select ew-select<?= $Grid->paymentMethod->isInvalidClass() ?>"
        data-select2-id="ffin_debitgrid_x<?= $Grid->RowIndex ?>_paymentMethod"
        data-table="fin_debit"
        data-field="x_paymentMethod"
        data-value-separator="<?= $Grid->paymentMethod->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->paymentMethod->getPlaceHolder()) ?>"
        <?= $Grid->paymentMethod->editAttributes() ?>>
        <?= $Grid->paymentMethod->selectOptionListHtml("x{$Grid->RowIndex}_paymentMethod") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->paymentMethod->getErrorMessage() ?></div>
<?= $Grid->paymentMethod->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_paymentMethod") ?>
<script>
loadjs.ready("ffin_debitgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_paymentMethod", selectId: "ffin_debitgrid_x<?= $Grid->RowIndex ?>_paymentMethod" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_debitgrid.lists.paymentMethod.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_paymentMethod", form: "ffin_debitgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_paymentMethod", form: "ffin_debitgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_debit.fields.paymentMethod.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fin_debit_paymentMethod" class="el_fin_debit_paymentMethod">
<span<?= $Grid->paymentMethod->viewAttributes() ?>>
<?= $Grid->paymentMethod->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fin_debit" data-field="x_paymentMethod" data-hidden="1" name="ffin_debitgrid$x<?= $Grid->RowIndex ?>_paymentMethod" id="ffin_debitgrid$x<?= $Grid->RowIndex ?>_paymentMethod" value="<?= HtmlEncode($Grid->paymentMethod->FormValue) ?>">
<input type="hidden" data-table="fin_debit" data-field="x_paymentMethod" data-hidden="1" name="ffin_debitgrid$o<?= $Grid->RowIndex ?>_paymentMethod" id="ffin_debitgrid$o<?= $Grid->RowIndex ?>_paymentMethod" value="<?= HtmlEncode($Grid->paymentMethod->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->checkingAccountId->Visible) { // checkingAccountId ?>
        <td data-name="checkingAccountId"<?= $Grid->checkingAccountId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fin_debit_checkingAccountId" class="el_fin_debit_checkingAccountId">
    <select
        id="x<?= $Grid->RowIndex ?>_checkingAccountId"
        name="x<?= $Grid->RowIndex ?>_checkingAccountId"
        class="form-select ew-select<?= $Grid->checkingAccountId->isInvalidClass() ?>"
        data-select2-id="ffin_debitgrid_x<?= $Grid->RowIndex ?>_checkingAccountId"
        data-table="fin_debit"
        data-field="x_checkingAccountId"
        data-value-separator="<?= $Grid->checkingAccountId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->checkingAccountId->getPlaceHolder()) ?>"
        <?= $Grid->checkingAccountId->editAttributes() ?>>
        <?= $Grid->checkingAccountId->selectOptionListHtml("x{$Grid->RowIndex}_checkingAccountId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->checkingAccountId->getErrorMessage() ?></div>
<?= $Grid->checkingAccountId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_checkingAccountId") ?>
<script>
loadjs.ready("ffin_debitgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_checkingAccountId", selectId: "ffin_debitgrid_x<?= $Grid->RowIndex ?>_checkingAccountId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_debitgrid.lists.checkingAccountId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_checkingAccountId", form: "ffin_debitgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_checkingAccountId", form: "ffin_debitgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_debit.fields.checkingAccountId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="fin_debit" data-field="x_checkingAccountId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_checkingAccountId" id="o<?= $Grid->RowIndex ?>_checkingAccountId" value="<?= HtmlEncode($Grid->checkingAccountId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fin_debit_checkingAccountId" class="el_fin_debit_checkingAccountId">
    <select
        id="x<?= $Grid->RowIndex ?>_checkingAccountId"
        name="x<?= $Grid->RowIndex ?>_checkingAccountId"
        class="form-select ew-select<?= $Grid->checkingAccountId->isInvalidClass() ?>"
        data-select2-id="ffin_debitgrid_x<?= $Grid->RowIndex ?>_checkingAccountId"
        data-table="fin_debit"
        data-field="x_checkingAccountId"
        data-value-separator="<?= $Grid->checkingAccountId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->checkingAccountId->getPlaceHolder()) ?>"
        <?= $Grid->checkingAccountId->editAttributes() ?>>
        <?= $Grid->checkingAccountId->selectOptionListHtml("x{$Grid->RowIndex}_checkingAccountId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->checkingAccountId->getErrorMessage() ?></div>
<?= $Grid->checkingAccountId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_checkingAccountId") ?>
<script>
loadjs.ready("ffin_debitgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_checkingAccountId", selectId: "ffin_debitgrid_x<?= $Grid->RowIndex ?>_checkingAccountId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_debitgrid.lists.checkingAccountId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_checkingAccountId", form: "ffin_debitgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_checkingAccountId", form: "ffin_debitgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_debit.fields.checkingAccountId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fin_debit_checkingAccountId" class="el_fin_debit_checkingAccountId">
<span<?= $Grid->checkingAccountId->viewAttributes() ?>>
<?= $Grid->checkingAccountId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fin_debit" data-field="x_checkingAccountId" data-hidden="1" name="ffin_debitgrid$x<?= $Grid->RowIndex ?>_checkingAccountId" id="ffin_debitgrid$x<?= $Grid->RowIndex ?>_checkingAccountId" value="<?= HtmlEncode($Grid->checkingAccountId->FormValue) ?>">
<input type="hidden" data-table="fin_debit" data-field="x_checkingAccountId" data-hidden="1" name="ffin_debitgrid$o<?= $Grid->RowIndex ?>_checkingAccountId" id="ffin_debitgrid$o<?= $Grid->RowIndex ?>_checkingAccountId" value="<?= HtmlEncode($Grid->checkingAccountId->OldValue) ?>">
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
loadjs.ready(["ffin_debitgrid","load"], () => ffin_debitgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_fin_debit", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_fin_debit_id" class="el_fin_debit_id"></span>
<?php } else { ?>
<span id="el$rowindex$_fin_debit_id" class="el_fin_debit_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
<input type="hidden" data-table="fin_debit" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fin_debit" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->dueDate->Visible) { // dueDate ?>
        <td data-name="dueDate">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fin_debit_dueDate" class="el_fin_debit_dueDate">
<input type="<?= $Grid->dueDate->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_dueDate" id="x<?= $Grid->RowIndex ?>_dueDate" data-table="fin_debit" data-field="x_dueDate" value="<?= $Grid->dueDate->EditValue ?>" placeholder="<?= HtmlEncode($Grid->dueDate->getPlaceHolder()) ?>"<?= $Grid->dueDate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->dueDate->getErrorMessage() ?></div>
<?php if (!$Grid->dueDate->ReadOnly && !$Grid->dueDate->Disabled && !isset($Grid->dueDate->EditAttrs["readonly"]) && !isset($Grid->dueDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffin_debitgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffin_debitgrid", "x<?= $Grid->RowIndex ?>_dueDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_fin_debit_dueDate" class="el_fin_debit_dueDate">
<span<?= $Grid->dueDate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->dueDate->getDisplayValue($Grid->dueDate->ViewValue))) ?>"></span>
<input type="hidden" data-table="fin_debit" data-field="x_dueDate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_dueDate" id="x<?= $Grid->RowIndex ?>_dueDate" value="<?= HtmlEncode($Grid->dueDate->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fin_debit" data-field="x_dueDate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_dueDate" id="o<?= $Grid->RowIndex ?>_dueDate" value="<?= HtmlEncode($Grid->dueDate->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->value->Visible) { // value ?>
        <td data-name="value">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fin_debit_value" class="el_fin_debit_value">
<input type="<?= $Grid->value->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_value" id="x<?= $Grid->RowIndex ?>_value" data-table="fin_debit" data-field="x_value" value="<?= $Grid->value->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->value->getPlaceHolder()) ?>"<?= $Grid->value->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->value->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fin_debit_value" class="el_fin_debit_value">
<span<?= $Grid->value->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->value->getDisplayValue($Grid->value->ViewValue))) ?>"></span>
<input type="hidden" data-table="fin_debit" data-field="x_value" data-hidden="1" name="x<?= $Grid->RowIndex ?>_value" id="x<?= $Grid->RowIndex ?>_value" value="<?= HtmlEncode($Grid->value->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fin_debit" data-field="x_value" data-hidden="1" name="o<?= $Grid->RowIndex ?>_value" id="o<?= $Grid->RowIndex ?>_value" value="<?= HtmlEncode($Grid->value->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->paymentMethod->Visible) { // paymentMethod ?>
        <td data-name="paymentMethod">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fin_debit_paymentMethod" class="el_fin_debit_paymentMethod">
    <select
        id="x<?= $Grid->RowIndex ?>_paymentMethod"
        name="x<?= $Grid->RowIndex ?>_paymentMethod"
        class="form-select ew-select<?= $Grid->paymentMethod->isInvalidClass() ?>"
        data-select2-id="ffin_debitgrid_x<?= $Grid->RowIndex ?>_paymentMethod"
        data-table="fin_debit"
        data-field="x_paymentMethod"
        data-value-separator="<?= $Grid->paymentMethod->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->paymentMethod->getPlaceHolder()) ?>"
        <?= $Grid->paymentMethod->editAttributes() ?>>
        <?= $Grid->paymentMethod->selectOptionListHtml("x{$Grid->RowIndex}_paymentMethod") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->paymentMethod->getErrorMessage() ?></div>
<?= $Grid->paymentMethod->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_paymentMethod") ?>
<script>
loadjs.ready("ffin_debitgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_paymentMethod", selectId: "ffin_debitgrid_x<?= $Grid->RowIndex ?>_paymentMethod" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_debitgrid.lists.paymentMethod.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_paymentMethod", form: "ffin_debitgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_paymentMethod", form: "ffin_debitgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_debit.fields.paymentMethod.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_fin_debit_paymentMethod" class="el_fin_debit_paymentMethod">
<span<?= $Grid->paymentMethod->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->paymentMethod->getDisplayValue($Grid->paymentMethod->ViewValue) ?></span></span>
<input type="hidden" data-table="fin_debit" data-field="x_paymentMethod" data-hidden="1" name="x<?= $Grid->RowIndex ?>_paymentMethod" id="x<?= $Grid->RowIndex ?>_paymentMethod" value="<?= HtmlEncode($Grid->paymentMethod->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fin_debit" data-field="x_paymentMethod" data-hidden="1" name="o<?= $Grid->RowIndex ?>_paymentMethod" id="o<?= $Grid->RowIndex ?>_paymentMethod" value="<?= HtmlEncode($Grid->paymentMethod->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->checkingAccountId->Visible) { // checkingAccountId ?>
        <td data-name="checkingAccountId">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fin_debit_checkingAccountId" class="el_fin_debit_checkingAccountId">
    <select
        id="x<?= $Grid->RowIndex ?>_checkingAccountId"
        name="x<?= $Grid->RowIndex ?>_checkingAccountId"
        class="form-select ew-select<?= $Grid->checkingAccountId->isInvalidClass() ?>"
        data-select2-id="ffin_debitgrid_x<?= $Grid->RowIndex ?>_checkingAccountId"
        data-table="fin_debit"
        data-field="x_checkingAccountId"
        data-value-separator="<?= $Grid->checkingAccountId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->checkingAccountId->getPlaceHolder()) ?>"
        <?= $Grid->checkingAccountId->editAttributes() ?>>
        <?= $Grid->checkingAccountId->selectOptionListHtml("x{$Grid->RowIndex}_checkingAccountId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->checkingAccountId->getErrorMessage() ?></div>
<?= $Grid->checkingAccountId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_checkingAccountId") ?>
<script>
loadjs.ready("ffin_debitgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_checkingAccountId", selectId: "ffin_debitgrid_x<?= $Grid->RowIndex ?>_checkingAccountId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ffin_debitgrid.lists.checkingAccountId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_checkingAccountId", form: "ffin_debitgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_checkingAccountId", form: "ffin_debitgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.fin_debit.fields.checkingAccountId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_fin_debit_checkingAccountId" class="el_fin_debit_checkingAccountId">
<span<?= $Grid->checkingAccountId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->checkingAccountId->getDisplayValue($Grid->checkingAccountId->ViewValue) ?></span></span>
<input type="hidden" data-table="fin_debit" data-field="x_checkingAccountId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_checkingAccountId" id="x<?= $Grid->RowIndex ?>_checkingAccountId" value="<?= HtmlEncode($Grid->checkingAccountId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fin_debit" data-field="x_checkingAccountId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_checkingAccountId" id="o<?= $Grid->RowIndex ?>_checkingAccountId" value="<?= HtmlEncode($Grid->checkingAccountId->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["ffin_debitgrid","load"], () => ffin_debitgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="ffin_debitgrid">
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
    ew.addEventHandlers("fin_debit");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
