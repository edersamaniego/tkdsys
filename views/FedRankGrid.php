<?php

namespace PHPMaker2022\school;

// Set up and run Grid object
$Grid = Container("FedRankGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var ffed_rankgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_rankgrid = new ew.Form("ffed_rankgrid", "grid");
    ffed_rankgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { fed_rank: currentTable } });
    var fields = currentTable.fields;
    ffed_rankgrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["rankBR", [fields.rankBR.visible && fields.rankBR.required ? ew.Validators.required(fields.rankBR.caption) : null], fields.rankBR.isInvalid],
        ["rankUS", [fields.rankUS.visible && fields.rankUS.required ? ew.Validators.required(fields.rankUS.caption) : null], fields.rankUS.isInvalid],
        ["rankES", [fields.rankES.visible && fields.rankES.required ? ew.Validators.required(fields.rankES.caption) : null], fields.rankES.isInvalid],
        ["ranking", [fields.ranking.visible && fields.ranking.required ? ew.Validators.required(fields.ranking.caption) : null], fields.ranking.isInvalid],
        ["nextrankId", [fields.nextrankId.visible && fields.nextrankId.required ? ew.Validators.required(fields.nextrankId.caption) : null, ew.Validators.integer], fields.nextrankId.isInvalid]
    ]);

    // Check empty row
    ffed_rankgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["rankBR",false],["rankUS",false],["rankES",false],["ranking",false],["nextrankId",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    ffed_rankgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_rankgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffed_rankgrid.lists.nextrankId = <?= $Grid->nextrankId->toClientList($Grid) ?>;
    loadjs.done("ffed_rankgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fed_rank">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="ffed_rankgrid" class="ew-form ew-list-form">
<div id="gmp_fed_rank" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_fed_rankgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_fed_rank_id" class="fed_rank_id"><?= $Grid->renderFieldHeader($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->rankBR->Visible) { // rankBR ?>
        <th data-name="rankBR" class="<?= $Grid->rankBR->headerCellClass() ?>"><div id="elh_fed_rank_rankBR" class="fed_rank_rankBR"><?= $Grid->renderFieldHeader($Grid->rankBR) ?></div></th>
<?php } ?>
<?php if ($Grid->rankUS->Visible) { // rankUS ?>
        <th data-name="rankUS" class="<?= $Grid->rankUS->headerCellClass() ?>"><div id="elh_fed_rank_rankUS" class="fed_rank_rankUS"><?= $Grid->renderFieldHeader($Grid->rankUS) ?></div></th>
<?php } ?>
<?php if ($Grid->rankES->Visible) { // rankES ?>
        <th data-name="rankES" class="<?= $Grid->rankES->headerCellClass() ?>"><div id="elh_fed_rank_rankES" class="fed_rank_rankES"><?= $Grid->renderFieldHeader($Grid->rankES) ?></div></th>
<?php } ?>
<?php if ($Grid->ranking->Visible) { // ranking ?>
        <th data-name="ranking" class="<?= $Grid->ranking->headerCellClass() ?>"><div id="elh_fed_rank_ranking" class="fed_rank_ranking"><?= $Grid->renderFieldHeader($Grid->ranking) ?></div></th>
<?php } ?>
<?php if ($Grid->nextrankId->Visible) { // nextrankId ?>
        <th data-name="nextrankId" class="<?= $Grid->nextrankId->headerCellClass() ?>"><div id="elh_fed_rank_nextrankId" class="fed_rank_nextrankId"><?= $Grid->renderFieldHeader($Grid->nextrankId) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_fed_rank",
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
<span id="el<?= $Grid->RowCount ?>_fed_rank_id" class="el_fed_rank_id"></span>
<input type="hidden" data-table="fed_rank" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_id" class="el_fed_rank_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
<input type="hidden" data-table="fed_rank" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_id" class="el_fed_rank_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_rank" data-field="x_id" data-hidden="1" name="ffed_rankgrid$x<?= $Grid->RowIndex ?>_id" id="ffed_rankgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="fed_rank" data-field="x_id" data-hidden="1" name="ffed_rankgrid$o<?= $Grid->RowIndex ?>_id" id="ffed_rankgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="fed_rank" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->rankBR->Visible) { // rankBR ?>
        <td data-name="rankBR"<?= $Grid->rankBR->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_rankBR" class="el_fed_rank_rankBR">
<input type="<?= $Grid->rankBR->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_rankBR" id="x<?= $Grid->RowIndex ?>_rankBR" data-table="fed_rank" data-field="x_rankBR" value="<?= $Grid->rankBR->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->rankBR->getPlaceHolder()) ?>"<?= $Grid->rankBR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->rankBR->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fed_rank" data-field="x_rankBR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_rankBR" id="o<?= $Grid->RowIndex ?>_rankBR" value="<?= HtmlEncode($Grid->rankBR->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_rankBR" class="el_fed_rank_rankBR">
<input type="<?= $Grid->rankBR->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_rankBR" id="x<?= $Grid->RowIndex ?>_rankBR" data-table="fed_rank" data-field="x_rankBR" value="<?= $Grid->rankBR->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->rankBR->getPlaceHolder()) ?>"<?= $Grid->rankBR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->rankBR->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_rankBR" class="el_fed_rank_rankBR">
<span<?= $Grid->rankBR->viewAttributes() ?>>
<?= $Grid->rankBR->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_rank" data-field="x_rankBR" data-hidden="1" name="ffed_rankgrid$x<?= $Grid->RowIndex ?>_rankBR" id="ffed_rankgrid$x<?= $Grid->RowIndex ?>_rankBR" value="<?= HtmlEncode($Grid->rankBR->FormValue) ?>">
<input type="hidden" data-table="fed_rank" data-field="x_rankBR" data-hidden="1" name="ffed_rankgrid$o<?= $Grid->RowIndex ?>_rankBR" id="ffed_rankgrid$o<?= $Grid->RowIndex ?>_rankBR" value="<?= HtmlEncode($Grid->rankBR->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->rankUS->Visible) { // rankUS ?>
        <td data-name="rankUS"<?= $Grid->rankUS->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_rankUS" class="el_fed_rank_rankUS">
<input type="<?= $Grid->rankUS->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_rankUS" id="x<?= $Grid->RowIndex ?>_rankUS" data-table="fed_rank" data-field="x_rankUS" value="<?= $Grid->rankUS->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->rankUS->getPlaceHolder()) ?>"<?= $Grid->rankUS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->rankUS->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fed_rank" data-field="x_rankUS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_rankUS" id="o<?= $Grid->RowIndex ?>_rankUS" value="<?= HtmlEncode($Grid->rankUS->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_rankUS" class="el_fed_rank_rankUS">
<input type="<?= $Grid->rankUS->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_rankUS" id="x<?= $Grid->RowIndex ?>_rankUS" data-table="fed_rank" data-field="x_rankUS" value="<?= $Grid->rankUS->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->rankUS->getPlaceHolder()) ?>"<?= $Grid->rankUS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->rankUS->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_rankUS" class="el_fed_rank_rankUS">
<span<?= $Grid->rankUS->viewAttributes() ?>>
<?= $Grid->rankUS->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_rank" data-field="x_rankUS" data-hidden="1" name="ffed_rankgrid$x<?= $Grid->RowIndex ?>_rankUS" id="ffed_rankgrid$x<?= $Grid->RowIndex ?>_rankUS" value="<?= HtmlEncode($Grid->rankUS->FormValue) ?>">
<input type="hidden" data-table="fed_rank" data-field="x_rankUS" data-hidden="1" name="ffed_rankgrid$o<?= $Grid->RowIndex ?>_rankUS" id="ffed_rankgrid$o<?= $Grid->RowIndex ?>_rankUS" value="<?= HtmlEncode($Grid->rankUS->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->rankES->Visible) { // rankES ?>
        <td data-name="rankES"<?= $Grid->rankES->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_rankES" class="el_fed_rank_rankES">
<input type="<?= $Grid->rankES->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_rankES" id="x<?= $Grid->RowIndex ?>_rankES" data-table="fed_rank" data-field="x_rankES" value="<?= $Grid->rankES->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->rankES->getPlaceHolder()) ?>"<?= $Grid->rankES->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->rankES->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fed_rank" data-field="x_rankES" data-hidden="1" name="o<?= $Grid->RowIndex ?>_rankES" id="o<?= $Grid->RowIndex ?>_rankES" value="<?= HtmlEncode($Grid->rankES->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_rankES" class="el_fed_rank_rankES">
<input type="<?= $Grid->rankES->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_rankES" id="x<?= $Grid->RowIndex ?>_rankES" data-table="fed_rank" data-field="x_rankES" value="<?= $Grid->rankES->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->rankES->getPlaceHolder()) ?>"<?= $Grid->rankES->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->rankES->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_rankES" class="el_fed_rank_rankES">
<span<?= $Grid->rankES->viewAttributes() ?>>
<?= $Grid->rankES->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_rank" data-field="x_rankES" data-hidden="1" name="ffed_rankgrid$x<?= $Grid->RowIndex ?>_rankES" id="ffed_rankgrid$x<?= $Grid->RowIndex ?>_rankES" value="<?= HtmlEncode($Grid->rankES->FormValue) ?>">
<input type="hidden" data-table="fed_rank" data-field="x_rankES" data-hidden="1" name="ffed_rankgrid$o<?= $Grid->RowIndex ?>_rankES" id="ffed_rankgrid$o<?= $Grid->RowIndex ?>_rankES" value="<?= HtmlEncode($Grid->rankES->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->ranking->Visible) { // ranking ?>
        <td data-name="ranking"<?= $Grid->ranking->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_ranking" class="el_fed_rank_ranking">
<input type="<?= $Grid->ranking->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ranking" id="x<?= $Grid->RowIndex ?>_ranking" data-table="fed_rank" data-field="x_ranking" value="<?= $Grid->ranking->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->ranking->getPlaceHolder()) ?>"<?= $Grid->ranking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ranking->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fed_rank" data-field="x_ranking" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ranking" id="o<?= $Grid->RowIndex ?>_ranking" value="<?= HtmlEncode($Grid->ranking->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_ranking" class="el_fed_rank_ranking">
<input type="<?= $Grid->ranking->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ranking" id="x<?= $Grid->RowIndex ?>_ranking" data-table="fed_rank" data-field="x_ranking" value="<?= $Grid->ranking->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->ranking->getPlaceHolder()) ?>"<?= $Grid->ranking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ranking->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_ranking" class="el_fed_rank_ranking">
<span<?= $Grid->ranking->viewAttributes() ?>>
<?= $Grid->ranking->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_rank" data-field="x_ranking" data-hidden="1" name="ffed_rankgrid$x<?= $Grid->RowIndex ?>_ranking" id="ffed_rankgrid$x<?= $Grid->RowIndex ?>_ranking" value="<?= HtmlEncode($Grid->ranking->FormValue) ?>">
<input type="hidden" data-table="fed_rank" data-field="x_ranking" data-hidden="1" name="ffed_rankgrid$o<?= $Grid->RowIndex ?>_ranking" id="ffed_rankgrid$o<?= $Grid->RowIndex ?>_ranking" value="<?= HtmlEncode($Grid->ranking->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nextrankId->Visible) { // nextrankId ?>
        <td data-name="nextrankId"<?= $Grid->nextrankId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_nextrankId" class="el_fed_rank_nextrankId">
<?php
$onchange = $Grid->nextrankId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->nextrankId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->nextrankId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_nextrankId" class="ew-auto-suggest">
    <input type="<?= $Grid->nextrankId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_nextrankId" id="sv_x<?= $Grid->RowIndex ?>_nextrankId" value="<?= RemoveHtml($Grid->nextrankId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->nextrankId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->nextrankId->getPlaceHolder()) ?>"<?= $Grid->nextrankId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="fed_rank" data-field="x_nextrankId" data-input="sv_x<?= $Grid->RowIndex ?>_nextrankId" data-value-separator="<?= $Grid->nextrankId->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_nextrankId" id="x<?= $Grid->RowIndex ?>_nextrankId" value="<?= HtmlEncode($Grid->nextrankId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->nextrankId->getErrorMessage() ?></div>
<script>
loadjs.ready("ffed_rankgrid", function() {
    ffed_rankgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_nextrankId","forceSelect":false}, ew.vars.tables.fed_rank.fields.nextrankId.autoSuggestOptions));
});
</script>
<?= $Grid->nextrankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_nextrankId") ?>
</span>
<input type="hidden" data-table="fed_rank" data-field="x_nextrankId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nextrankId" id="o<?= $Grid->RowIndex ?>_nextrankId" value="<?= HtmlEncode($Grid->nextrankId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_nextrankId" class="el_fed_rank_nextrankId">
<?php
$onchange = $Grid->nextrankId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->nextrankId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->nextrankId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_nextrankId" class="ew-auto-suggest">
    <input type="<?= $Grid->nextrankId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_nextrankId" id="sv_x<?= $Grid->RowIndex ?>_nextrankId" value="<?= RemoveHtml($Grid->nextrankId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->nextrankId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->nextrankId->getPlaceHolder()) ?>"<?= $Grid->nextrankId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="fed_rank" data-field="x_nextrankId" data-input="sv_x<?= $Grid->RowIndex ?>_nextrankId" data-value-separator="<?= $Grid->nextrankId->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_nextrankId" id="x<?= $Grid->RowIndex ?>_nextrankId" value="<?= HtmlEncode($Grid->nextrankId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->nextrankId->getErrorMessage() ?></div>
<script>
loadjs.ready("ffed_rankgrid", function() {
    ffed_rankgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_nextrankId","forceSelect":false}, ew.vars.tables.fed_rank.fields.nextrankId.autoSuggestOptions));
});
</script>
<?= $Grid->nextrankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_nextrankId") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_rank_nextrankId" class="el_fed_rank_nextrankId">
<span<?= $Grid->nextrankId->viewAttributes() ?>>
<?= $Grid->nextrankId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_rank" data-field="x_nextrankId" data-hidden="1" name="ffed_rankgrid$x<?= $Grid->RowIndex ?>_nextrankId" id="ffed_rankgrid$x<?= $Grid->RowIndex ?>_nextrankId" value="<?= HtmlEncode($Grid->nextrankId->FormValue) ?>">
<input type="hidden" data-table="fed_rank" data-field="x_nextrankId" data-hidden="1" name="ffed_rankgrid$o<?= $Grid->RowIndex ?>_nextrankId" id="ffed_rankgrid$o<?= $Grid->RowIndex ?>_nextrankId" value="<?= HtmlEncode($Grid->nextrankId->OldValue) ?>">
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
loadjs.ready(["ffed_rankgrid","load"], () => ffed_rankgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_fed_rank", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_fed_rank_id" class="el_fed_rank_id"></span>
<?php } else { ?>
<span id="el$rowindex$_fed_rank_id" class="el_fed_rank_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_rank" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_rank" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->rankBR->Visible) { // rankBR ?>
        <td data-name="rankBR">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_rank_rankBR" class="el_fed_rank_rankBR">
<input type="<?= $Grid->rankBR->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_rankBR" id="x<?= $Grid->RowIndex ?>_rankBR" data-table="fed_rank" data-field="x_rankBR" value="<?= $Grid->rankBR->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->rankBR->getPlaceHolder()) ?>"<?= $Grid->rankBR->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->rankBR->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_rank_rankBR" class="el_fed_rank_rankBR">
<span<?= $Grid->rankBR->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->rankBR->getDisplayValue($Grid->rankBR->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_rank" data-field="x_rankBR" data-hidden="1" name="x<?= $Grid->RowIndex ?>_rankBR" id="x<?= $Grid->RowIndex ?>_rankBR" value="<?= HtmlEncode($Grid->rankBR->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_rank" data-field="x_rankBR" data-hidden="1" name="o<?= $Grid->RowIndex ?>_rankBR" id="o<?= $Grid->RowIndex ?>_rankBR" value="<?= HtmlEncode($Grid->rankBR->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->rankUS->Visible) { // rankUS ?>
        <td data-name="rankUS">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_rank_rankUS" class="el_fed_rank_rankUS">
<input type="<?= $Grid->rankUS->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_rankUS" id="x<?= $Grid->RowIndex ?>_rankUS" data-table="fed_rank" data-field="x_rankUS" value="<?= $Grid->rankUS->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->rankUS->getPlaceHolder()) ?>"<?= $Grid->rankUS->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->rankUS->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_rank_rankUS" class="el_fed_rank_rankUS">
<span<?= $Grid->rankUS->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->rankUS->getDisplayValue($Grid->rankUS->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_rank" data-field="x_rankUS" data-hidden="1" name="x<?= $Grid->RowIndex ?>_rankUS" id="x<?= $Grid->RowIndex ?>_rankUS" value="<?= HtmlEncode($Grid->rankUS->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_rank" data-field="x_rankUS" data-hidden="1" name="o<?= $Grid->RowIndex ?>_rankUS" id="o<?= $Grid->RowIndex ?>_rankUS" value="<?= HtmlEncode($Grid->rankUS->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->rankES->Visible) { // rankES ?>
        <td data-name="rankES">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_rank_rankES" class="el_fed_rank_rankES">
<input type="<?= $Grid->rankES->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_rankES" id="x<?= $Grid->RowIndex ?>_rankES" data-table="fed_rank" data-field="x_rankES" value="<?= $Grid->rankES->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->rankES->getPlaceHolder()) ?>"<?= $Grid->rankES->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->rankES->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_rank_rankES" class="el_fed_rank_rankES">
<span<?= $Grid->rankES->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->rankES->getDisplayValue($Grid->rankES->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_rank" data-field="x_rankES" data-hidden="1" name="x<?= $Grid->RowIndex ?>_rankES" id="x<?= $Grid->RowIndex ?>_rankES" value="<?= HtmlEncode($Grid->rankES->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_rank" data-field="x_rankES" data-hidden="1" name="o<?= $Grid->RowIndex ?>_rankES" id="o<?= $Grid->RowIndex ?>_rankES" value="<?= HtmlEncode($Grid->rankES->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->ranking->Visible) { // ranking ?>
        <td data-name="ranking">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_rank_ranking" class="el_fed_rank_ranking">
<input type="<?= $Grid->ranking->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_ranking" id="x<?= $Grid->RowIndex ?>_ranking" data-table="fed_rank" data-field="x_ranking" value="<?= $Grid->ranking->EditValue ?>" size="30" maxlength="45" placeholder="<?= HtmlEncode($Grid->ranking->getPlaceHolder()) ?>"<?= $Grid->ranking->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->ranking->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_rank_ranking" class="el_fed_rank_ranking">
<span<?= $Grid->ranking->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->ranking->getDisplayValue($Grid->ranking->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_rank" data-field="x_ranking" data-hidden="1" name="x<?= $Grid->RowIndex ?>_ranking" id="x<?= $Grid->RowIndex ?>_ranking" value="<?= HtmlEncode($Grid->ranking->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_rank" data-field="x_ranking" data-hidden="1" name="o<?= $Grid->RowIndex ?>_ranking" id="o<?= $Grid->RowIndex ?>_ranking" value="<?= HtmlEncode($Grid->ranking->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nextrankId->Visible) { // nextrankId ?>
        <td data-name="nextrankId">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_rank_nextrankId" class="el_fed_rank_nextrankId">
<?php
$onchange = $Grid->nextrankId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->nextrankId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->nextrankId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_nextrankId" class="ew-auto-suggest">
    <input type="<?= $Grid->nextrankId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_nextrankId" id="sv_x<?= $Grid->RowIndex ?>_nextrankId" value="<?= RemoveHtml($Grid->nextrankId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->nextrankId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->nextrankId->getPlaceHolder()) ?>"<?= $Grid->nextrankId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="fed_rank" data-field="x_nextrankId" data-input="sv_x<?= $Grid->RowIndex ?>_nextrankId" data-value-separator="<?= $Grid->nextrankId->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_nextrankId" id="x<?= $Grid->RowIndex ?>_nextrankId" value="<?= HtmlEncode($Grid->nextrankId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->nextrankId->getErrorMessage() ?></div>
<script>
loadjs.ready("ffed_rankgrid", function() {
    ffed_rankgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_nextrankId","forceSelect":false}, ew.vars.tables.fed_rank.fields.nextrankId.autoSuggestOptions));
});
</script>
<?= $Grid->nextrankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_nextrankId") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_rank_nextrankId" class="el_fed_rank_nextrankId">
<span<?= $Grid->nextrankId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->nextrankId->getDisplayValue($Grid->nextrankId->ViewValue) ?></span></span>
<input type="hidden" data-table="fed_rank" data-field="x_nextrankId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nextrankId" id="x<?= $Grid->RowIndex ?>_nextrankId" value="<?= HtmlEncode($Grid->nextrankId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_rank" data-field="x_nextrankId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nextrankId" id="o<?= $Grid->RowIndex ?>_nextrankId" value="<?= HtmlEncode($Grid->nextrankId->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["ffed_rankgrid","load"], () => ffed_rankgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="ffed_rankgrid">
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
    ew.addEventHandlers("fed_rank");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
