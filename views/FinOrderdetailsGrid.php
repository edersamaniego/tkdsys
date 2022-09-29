<?php

namespace PHPMaker2022\school;

// Set up and run Grid object
$Grid = Container("FinOrderdetailsGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var ffin_orderdetailsgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_orderdetailsgrid = new ew.Form("ffin_orderdetailsgrid", "grid");
    ffin_orderdetailsgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { fin_orderdetails: currentTable } });
    var fields = currentTable.fields;
    ffin_orderdetailsgrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["orderId", [fields.orderId.visible && fields.orderId.required ? ew.Validators.required(fields.orderId.caption) : null, ew.Validators.integer], fields.orderId.isInvalid],
        ["item", [fields.item.visible && fields.item.required ? ew.Validators.required(fields.item.caption) : null, ew.Validators.integer], fields.item.isInvalid],
        ["amount", [fields.amount.visible && fields.amount.required ? ew.Validators.required(fields.amount.caption) : null, ew.Validators.float], fields.amount.isInvalid],
        ["value", [fields.value.visible && fields.value.required ? ew.Validators.required(fields.value.caption) : null, ew.Validators.float], fields.value.isInvalid],
        ["discountId", [fields.discountId.visible && fields.discountId.required ? ew.Validators.required(fields.discountId.caption) : null, ew.Validators.integer], fields.discountId.isInvalid]
    ]);

    // Check empty row
    ffin_orderdetailsgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["orderId",false],["item",false],["amount",false],["value",false],["discountId",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    ffin_orderdetailsgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_orderdetailsgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_orderdetailsgrid.lists.discountId = <?= $Grid->discountId->toClientList($Grid) ?>;
    loadjs.done("ffin_orderdetailsgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fin_orderdetails">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="ffin_orderdetailsgrid" class="ew-form ew-list-form">
<div id="gmp_fin_orderdetails" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_fin_orderdetailsgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_fin_orderdetails_id" class="fin_orderdetails_id"><?= $Grid->renderFieldHeader($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->orderId->Visible) { // orderId ?>
        <th data-name="orderId" class="<?= $Grid->orderId->headerCellClass() ?>"><div id="elh_fin_orderdetails_orderId" class="fin_orderdetails_orderId"><?= $Grid->renderFieldHeader($Grid->orderId) ?></div></th>
<?php } ?>
<?php if ($Grid->item->Visible) { // item ?>
        <th data-name="item" class="<?= $Grid->item->headerCellClass() ?>"><div id="elh_fin_orderdetails_item" class="fin_orderdetails_item"><?= $Grid->renderFieldHeader($Grid->item) ?></div></th>
<?php } ?>
<?php if ($Grid->amount->Visible) { // amount ?>
        <th data-name="amount" class="<?= $Grid->amount->headerCellClass() ?>"><div id="elh_fin_orderdetails_amount" class="fin_orderdetails_amount"><?= $Grid->renderFieldHeader($Grid->amount) ?></div></th>
<?php } ?>
<?php if ($Grid->value->Visible) { // value ?>
        <th data-name="value" class="<?= $Grid->value->headerCellClass() ?>"><div id="elh_fin_orderdetails_value" class="fin_orderdetails_value"><?= $Grid->renderFieldHeader($Grid->value) ?></div></th>
<?php } ?>
<?php if ($Grid->discountId->Visible) { // discountId ?>
        <th data-name="discountId" class="<?= $Grid->discountId->headerCellClass() ?>"><div id="elh_fin_orderdetails_discountId" class="fin_orderdetails_discountId"><?= $Grid->renderFieldHeader($Grid->discountId) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_fin_orderdetails",
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
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_id" class="el_fin_orderdetails_id"></span>
<input type="hidden" data-table="fin_orderdetails" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_id" class="el_fin_orderdetails_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fin_orderdetails" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_id" class="el_fin_orderdetails_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fin_orderdetails" data-field="x_id" data-hidden="1" name="ffin_orderdetailsgrid$x<?= $Grid->RowIndex ?>_id" id="ffin_orderdetailsgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="fin_orderdetails" data-field="x_id" data-hidden="1" name="ffin_orderdetailsgrid$o<?= $Grid->RowIndex ?>_id" id="ffin_orderdetailsgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="fin_orderdetails" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->orderId->Visible) { // orderId ?>
        <td data-name="orderId"<?= $Grid->orderId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->orderId->getSessionValue() != "") { ?>
<span<?= $Grid->orderId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->orderId->getDisplayValue($Grid->orderId->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_orderId" name="x<?= $Grid->RowIndex ?>_orderId" value="<?= HtmlEncode($Grid->orderId->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_orderId" class="el_fin_orderdetails_orderId">
<input type="<?= $Grid->orderId->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_orderId" id="x<?= $Grid->RowIndex ?>_orderId" data-table="fin_orderdetails" data-field="x_orderId" value="<?= $Grid->orderId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->orderId->getPlaceHolder()) ?>"<?= $Grid->orderId->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->orderId->getErrorMessage() ?></div>
</span>
<?php } ?>
<input type="hidden" data-table="fin_orderdetails" data-field="x_orderId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_orderId" id="o<?= $Grid->RowIndex ?>_orderId" value="<?= HtmlEncode($Grid->orderId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->orderId->getSessionValue() != "") { ?>
<span<?= $Grid->orderId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->orderId->getDisplayValue($Grid->orderId->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_orderId" name="x<?= $Grid->RowIndex ?>_orderId" value="<?= HtmlEncode($Grid->orderId->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_orderId" class="el_fin_orderdetails_orderId">
<input type="<?= $Grid->orderId->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_orderId" id="x<?= $Grid->RowIndex ?>_orderId" data-table="fin_orderdetails" data-field="x_orderId" value="<?= $Grid->orderId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->orderId->getPlaceHolder()) ?>"<?= $Grid->orderId->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->orderId->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_orderId" class="el_fin_orderdetails_orderId">
<span<?= $Grid->orderId->viewAttributes() ?>>
<?= $Grid->orderId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fin_orderdetails" data-field="x_orderId" data-hidden="1" name="ffin_orderdetailsgrid$x<?= $Grid->RowIndex ?>_orderId" id="ffin_orderdetailsgrid$x<?= $Grid->RowIndex ?>_orderId" value="<?= HtmlEncode($Grid->orderId->FormValue) ?>">
<input type="hidden" data-table="fin_orderdetails" data-field="x_orderId" data-hidden="1" name="ffin_orderdetailsgrid$o<?= $Grid->RowIndex ?>_orderId" id="ffin_orderdetailsgrid$o<?= $Grid->RowIndex ?>_orderId" value="<?= HtmlEncode($Grid->orderId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->item->Visible) { // item ?>
        <td data-name="item"<?= $Grid->item->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_item" class="el_fin_orderdetails_item">
<input type="<?= $Grid->item->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_item" id="x<?= $Grid->RowIndex ?>_item" data-table="fin_orderdetails" data-field="x_item" value="<?= $Grid->item->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->item->getPlaceHolder()) ?>"<?= $Grid->item->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->item->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fin_orderdetails" data-field="x_item" data-hidden="1" name="o<?= $Grid->RowIndex ?>_item" id="o<?= $Grid->RowIndex ?>_item" value="<?= HtmlEncode($Grid->item->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_item" class="el_fin_orderdetails_item">
<input type="<?= $Grid->item->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_item" id="x<?= $Grid->RowIndex ?>_item" data-table="fin_orderdetails" data-field="x_item" value="<?= $Grid->item->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->item->getPlaceHolder()) ?>"<?= $Grid->item->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->item->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_item" class="el_fin_orderdetails_item">
<span<?= $Grid->item->viewAttributes() ?>>
<?= $Grid->item->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fin_orderdetails" data-field="x_item" data-hidden="1" name="ffin_orderdetailsgrid$x<?= $Grid->RowIndex ?>_item" id="ffin_orderdetailsgrid$x<?= $Grid->RowIndex ?>_item" value="<?= HtmlEncode($Grid->item->FormValue) ?>">
<input type="hidden" data-table="fin_orderdetails" data-field="x_item" data-hidden="1" name="ffin_orderdetailsgrid$o<?= $Grid->RowIndex ?>_item" id="ffin_orderdetailsgrid$o<?= $Grid->RowIndex ?>_item" value="<?= HtmlEncode($Grid->item->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->amount->Visible) { // amount ?>
        <td data-name="amount"<?= $Grid->amount->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_amount" class="el_fin_orderdetails_amount">
<input type="<?= $Grid->amount->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_amount" id="x<?= $Grid->RowIndex ?>_amount" data-table="fin_orderdetails" data-field="x_amount" value="<?= $Grid->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->amount->getPlaceHolder()) ?>"<?= $Grid->amount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fin_orderdetails" data-field="x_amount" data-hidden="1" name="o<?= $Grid->RowIndex ?>_amount" id="o<?= $Grid->RowIndex ?>_amount" value="<?= HtmlEncode($Grid->amount->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_amount" class="el_fin_orderdetails_amount">
<input type="<?= $Grid->amount->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_amount" id="x<?= $Grid->RowIndex ?>_amount" data-table="fin_orderdetails" data-field="x_amount" value="<?= $Grid->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->amount->getPlaceHolder()) ?>"<?= $Grid->amount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_amount" class="el_fin_orderdetails_amount">
<span<?= $Grid->amount->viewAttributes() ?>>
<?= $Grid->amount->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fin_orderdetails" data-field="x_amount" data-hidden="1" name="ffin_orderdetailsgrid$x<?= $Grid->RowIndex ?>_amount" id="ffin_orderdetailsgrid$x<?= $Grid->RowIndex ?>_amount" value="<?= HtmlEncode($Grid->amount->FormValue) ?>">
<input type="hidden" data-table="fin_orderdetails" data-field="x_amount" data-hidden="1" name="ffin_orderdetailsgrid$o<?= $Grid->RowIndex ?>_amount" id="ffin_orderdetailsgrid$o<?= $Grid->RowIndex ?>_amount" value="<?= HtmlEncode($Grid->amount->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->value->Visible) { // value ?>
        <td data-name="value"<?= $Grid->value->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_value" class="el_fin_orderdetails_value">
<input type="<?= $Grid->value->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_value" id="x<?= $Grid->RowIndex ?>_value" data-table="fin_orderdetails" data-field="x_value" value="<?= $Grid->value->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->value->getPlaceHolder()) ?>"<?= $Grid->value->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->value->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fin_orderdetails" data-field="x_value" data-hidden="1" name="o<?= $Grid->RowIndex ?>_value" id="o<?= $Grid->RowIndex ?>_value" value="<?= HtmlEncode($Grid->value->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_value" class="el_fin_orderdetails_value">
<input type="<?= $Grid->value->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_value" id="x<?= $Grid->RowIndex ?>_value" data-table="fin_orderdetails" data-field="x_value" value="<?= $Grid->value->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->value->getPlaceHolder()) ?>"<?= $Grid->value->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->value->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_value" class="el_fin_orderdetails_value">
<span<?= $Grid->value->viewAttributes() ?>>
<?= $Grid->value->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fin_orderdetails" data-field="x_value" data-hidden="1" name="ffin_orderdetailsgrid$x<?= $Grid->RowIndex ?>_value" id="ffin_orderdetailsgrid$x<?= $Grid->RowIndex ?>_value" value="<?= HtmlEncode($Grid->value->FormValue) ?>">
<input type="hidden" data-table="fin_orderdetails" data-field="x_value" data-hidden="1" name="ffin_orderdetailsgrid$o<?= $Grid->RowIndex ?>_value" id="ffin_orderdetailsgrid$o<?= $Grid->RowIndex ?>_value" value="<?= HtmlEncode($Grid->value->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->discountId->Visible) { // discountId ?>
        <td data-name="discountId"<?= $Grid->discountId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_discountId" class="el_fin_orderdetails_discountId">
<?php
$onchange = $Grid->discountId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->discountId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->discountId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_discountId" class="ew-auto-suggest">
    <input type="<?= $Grid->discountId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_discountId" id="sv_x<?= $Grid->RowIndex ?>_discountId" value="<?= RemoveHtml($Grid->discountId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->discountId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->discountId->getPlaceHolder()) ?>"<?= $Grid->discountId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="fin_orderdetails" data-field="x_discountId" data-input="sv_x<?= $Grid->RowIndex ?>_discountId" data-value-separator="<?= $Grid->discountId->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_discountId" id="x<?= $Grid->RowIndex ?>_discountId" value="<?= HtmlEncode($Grid->discountId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->discountId->getErrorMessage() ?></div>
<script>
loadjs.ready("ffin_orderdetailsgrid", function() {
    ffin_orderdetailsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_discountId","forceSelect":false}, ew.vars.tables.fin_orderdetails.fields.discountId.autoSuggestOptions));
});
</script>
<?= $Grid->discountId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_discountId") ?>
</span>
<input type="hidden" data-table="fin_orderdetails" data-field="x_discountId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_discountId" id="o<?= $Grid->RowIndex ?>_discountId" value="<?= HtmlEncode($Grid->discountId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_discountId" class="el_fin_orderdetails_discountId">
<?php
$onchange = $Grid->discountId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->discountId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->discountId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_discountId" class="ew-auto-suggest">
    <input type="<?= $Grid->discountId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_discountId" id="sv_x<?= $Grid->RowIndex ?>_discountId" value="<?= RemoveHtml($Grid->discountId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->discountId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->discountId->getPlaceHolder()) ?>"<?= $Grid->discountId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="fin_orderdetails" data-field="x_discountId" data-input="sv_x<?= $Grid->RowIndex ?>_discountId" data-value-separator="<?= $Grid->discountId->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_discountId" id="x<?= $Grid->RowIndex ?>_discountId" value="<?= HtmlEncode($Grid->discountId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->discountId->getErrorMessage() ?></div>
<script>
loadjs.ready("ffin_orderdetailsgrid", function() {
    ffin_orderdetailsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_discountId","forceSelect":false}, ew.vars.tables.fin_orderdetails.fields.discountId.autoSuggestOptions));
});
</script>
<?= $Grid->discountId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_discountId") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fin_orderdetails_discountId" class="el_fin_orderdetails_discountId">
<span<?= $Grid->discountId->viewAttributes() ?>>
<?= $Grid->discountId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fin_orderdetails" data-field="x_discountId" data-hidden="1" name="ffin_orderdetailsgrid$x<?= $Grid->RowIndex ?>_discountId" id="ffin_orderdetailsgrid$x<?= $Grid->RowIndex ?>_discountId" value="<?= HtmlEncode($Grid->discountId->FormValue) ?>">
<input type="hidden" data-table="fin_orderdetails" data-field="x_discountId" data-hidden="1" name="ffin_orderdetailsgrid$o<?= $Grid->RowIndex ?>_discountId" id="ffin_orderdetailsgrid$o<?= $Grid->RowIndex ?>_discountId" value="<?= HtmlEncode($Grid->discountId->OldValue) ?>">
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
loadjs.ready(["ffin_orderdetailsgrid","load"], () => ffin_orderdetailsgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_fin_orderdetails", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_fin_orderdetails_id" class="el_fin_orderdetails_id"></span>
<?php } else { ?>
<span id="el$rowindex$_fin_orderdetails_id" class="el_fin_orderdetails_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
<input type="hidden" data-table="fin_orderdetails" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fin_orderdetails" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->orderId->Visible) { // orderId ?>
        <td data-name="orderId">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->orderId->getSessionValue() != "") { ?>
<span<?= $Grid->orderId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->orderId->getDisplayValue($Grid->orderId->ViewValue))) ?>"></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_orderId" name="x<?= $Grid->RowIndex ?>_orderId" value="<?= HtmlEncode($Grid->orderId->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_fin_orderdetails_orderId" class="el_fin_orderdetails_orderId">
<input type="<?= $Grid->orderId->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_orderId" id="x<?= $Grid->RowIndex ?>_orderId" data-table="fin_orderdetails" data-field="x_orderId" value="<?= $Grid->orderId->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->orderId->getPlaceHolder()) ?>"<?= $Grid->orderId->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->orderId->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_fin_orderdetails_orderId" class="el_fin_orderdetails_orderId">
<span<?= $Grid->orderId->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->orderId->getDisplayValue($Grid->orderId->ViewValue))) ?>"></span>
<input type="hidden" data-table="fin_orderdetails" data-field="x_orderId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_orderId" id="x<?= $Grid->RowIndex ?>_orderId" value="<?= HtmlEncode($Grid->orderId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fin_orderdetails" data-field="x_orderId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_orderId" id="o<?= $Grid->RowIndex ?>_orderId" value="<?= HtmlEncode($Grid->orderId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->item->Visible) { // item ?>
        <td data-name="item">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fin_orderdetails_item" class="el_fin_orderdetails_item">
<input type="<?= $Grid->item->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_item" id="x<?= $Grid->RowIndex ?>_item" data-table="fin_orderdetails" data-field="x_item" value="<?= $Grid->item->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->item->getPlaceHolder()) ?>"<?= $Grid->item->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->item->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fin_orderdetails_item" class="el_fin_orderdetails_item">
<span<?= $Grid->item->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->item->getDisplayValue($Grid->item->ViewValue))) ?>"></span>
<input type="hidden" data-table="fin_orderdetails" data-field="x_item" data-hidden="1" name="x<?= $Grid->RowIndex ?>_item" id="x<?= $Grid->RowIndex ?>_item" value="<?= HtmlEncode($Grid->item->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fin_orderdetails" data-field="x_item" data-hidden="1" name="o<?= $Grid->RowIndex ?>_item" id="o<?= $Grid->RowIndex ?>_item" value="<?= HtmlEncode($Grid->item->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->amount->Visible) { // amount ?>
        <td data-name="amount">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fin_orderdetails_amount" class="el_fin_orderdetails_amount">
<input type="<?= $Grid->amount->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_amount" id="x<?= $Grid->RowIndex ?>_amount" data-table="fin_orderdetails" data-field="x_amount" value="<?= $Grid->amount->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->amount->getPlaceHolder()) ?>"<?= $Grid->amount->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->amount->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fin_orderdetails_amount" class="el_fin_orderdetails_amount">
<span<?= $Grid->amount->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->amount->getDisplayValue($Grid->amount->ViewValue))) ?>"></span>
<input type="hidden" data-table="fin_orderdetails" data-field="x_amount" data-hidden="1" name="x<?= $Grid->RowIndex ?>_amount" id="x<?= $Grid->RowIndex ?>_amount" value="<?= HtmlEncode($Grid->amount->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fin_orderdetails" data-field="x_amount" data-hidden="1" name="o<?= $Grid->RowIndex ?>_amount" id="o<?= $Grid->RowIndex ?>_amount" value="<?= HtmlEncode($Grid->amount->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->value->Visible) { // value ?>
        <td data-name="value">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fin_orderdetails_value" class="el_fin_orderdetails_value">
<input type="<?= $Grid->value->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_value" id="x<?= $Grid->RowIndex ?>_value" data-table="fin_orderdetails" data-field="x_value" value="<?= $Grid->value->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->value->getPlaceHolder()) ?>"<?= $Grid->value->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->value->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fin_orderdetails_value" class="el_fin_orderdetails_value">
<span<?= $Grid->value->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->value->getDisplayValue($Grid->value->ViewValue))) ?>"></span>
<input type="hidden" data-table="fin_orderdetails" data-field="x_value" data-hidden="1" name="x<?= $Grid->RowIndex ?>_value" id="x<?= $Grid->RowIndex ?>_value" value="<?= HtmlEncode($Grid->value->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fin_orderdetails" data-field="x_value" data-hidden="1" name="o<?= $Grid->RowIndex ?>_value" id="o<?= $Grid->RowIndex ?>_value" value="<?= HtmlEncode($Grid->value->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->discountId->Visible) { // discountId ?>
        <td data-name="discountId">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fin_orderdetails_discountId" class="el_fin_orderdetails_discountId">
<?php
$onchange = $Grid->discountId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->discountId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->discountId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_discountId" class="ew-auto-suggest">
    <input type="<?= $Grid->discountId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_discountId" id="sv_x<?= $Grid->RowIndex ?>_discountId" value="<?= RemoveHtml($Grid->discountId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->discountId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->discountId->getPlaceHolder()) ?>"<?= $Grid->discountId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="fin_orderdetails" data-field="x_discountId" data-input="sv_x<?= $Grid->RowIndex ?>_discountId" data-value-separator="<?= $Grid->discountId->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_discountId" id="x<?= $Grid->RowIndex ?>_discountId" value="<?= HtmlEncode($Grid->discountId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->discountId->getErrorMessage() ?></div>
<script>
loadjs.ready("ffin_orderdetailsgrid", function() {
    ffin_orderdetailsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_discountId","forceSelect":false}, ew.vars.tables.fin_orderdetails.fields.discountId.autoSuggestOptions));
});
</script>
<?= $Grid->discountId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_discountId") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_fin_orderdetails_discountId" class="el_fin_orderdetails_discountId">
<span<?= $Grid->discountId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->discountId->getDisplayValue($Grid->discountId->ViewValue) ?></span></span>
<input type="hidden" data-table="fin_orderdetails" data-field="x_discountId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_discountId" id="x<?= $Grid->RowIndex ?>_discountId" value="<?= HtmlEncode($Grid->discountId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fin_orderdetails" data-field="x_discountId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_discountId" id="o<?= $Grid->RowIndex ?>_discountId" value="<?= HtmlEncode($Grid->discountId->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["ffin_orderdetailsgrid","load"], () => ffin_orderdetailsgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="ffin_orderdetailsgrid">
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
    ew.addEventHandlers("fin_orderdetails");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
