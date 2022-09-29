<?php

namespace PHPMaker2022\school;

// Set up and run Grid object
$Grid = Container("TesCandidateGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var ftes_candidategrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_candidategrid = new ew.Form("ftes_candidategrid", "grid");
    ftes_candidategrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { tes_candidate: currentTable } });
    var fields = currentTable.fields;
    ftes_candidategrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["memberId", [fields.memberId.visible && fields.memberId.required ? ew.Validators.required(fields.memberId.caption) : null, ew.Validators.integer], fields.memberId.isInvalid],
        ["rankId", [fields.rankId.visible && fields.rankId.required ? ew.Validators.required(fields.rankId.caption) : null], fields.rankId.isInvalid],
        ["testNominated", [fields.testNominated.visible && fields.testNominated.required ? ew.Validators.required(fields.testNominated.caption) : null], fields.testNominated.isInvalid],
        ["testPaid", [fields.testPaid.visible && fields.testPaid.required ? ew.Validators.required(fields.testPaid.caption) : null], fields.testPaid.isInvalid],
        ["result", [fields.result.visible && fields.result.required ? ew.Validators.required(fields.result.caption) : null], fields.result.isInvalid],
        ["nextRankId", [fields.nextRankId.visible && fields.nextRankId.required ? ew.Validators.required(fields.nextRankId.caption) : null], fields.nextRankId.isInvalid],
        ["memberAge", [fields.memberAge.visible && fields.memberAge.required ? ew.Validators.required(fields.memberAge.caption) : null, ew.Validators.integer], fields.memberAge.isInvalid]
    ]);

    // Check empty row
    ftes_candidategrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["memberId",false],["rankId",false],["testNominated[]",true],["testPaid[]",true],["result[]",true],["nextRankId",false],["memberAge",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    ftes_candidategrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ftes_candidategrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ftes_candidategrid.lists.memberId = <?= $Grid->memberId->toClientList($Grid) ?>;
    ftes_candidategrid.lists.rankId = <?= $Grid->rankId->toClientList($Grid) ?>;
    ftes_candidategrid.lists.testNominated = <?= $Grid->testNominated->toClientList($Grid) ?>;
    ftes_candidategrid.lists.testPaid = <?= $Grid->testPaid->toClientList($Grid) ?>;
    ftes_candidategrid.lists.result = <?= $Grid->result->toClientList($Grid) ?>;
    ftes_candidategrid.lists.nextRankId = <?= $Grid->nextRankId->toClientList($Grid) ?>;
    loadjs.done("ftes_candidategrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> tes_candidate">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="ftes_candidategrid" class="ew-form ew-list-form">
<div id="gmp_tes_candidate" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_tes_candidategrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_tes_candidate_id" class="tes_candidate_id"><?= $Grid->renderFieldHeader($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->memberId->Visible) { // memberId ?>
        <th data-name="memberId" class="<?= $Grid->memberId->headerCellClass() ?>"><div id="elh_tes_candidate_memberId" class="tes_candidate_memberId"><?= $Grid->renderFieldHeader($Grid->memberId) ?></div></th>
<?php } ?>
<?php if ($Grid->rankId->Visible) { // rankId ?>
        <th data-name="rankId" class="<?= $Grid->rankId->headerCellClass() ?>"><div id="elh_tes_candidate_rankId" class="tes_candidate_rankId"><?= $Grid->renderFieldHeader($Grid->rankId) ?></div></th>
<?php } ?>
<?php if ($Grid->testNominated->Visible) { // testNominated ?>
        <th data-name="testNominated" class="<?= $Grid->testNominated->headerCellClass() ?>"><div id="elh_tes_candidate_testNominated" class="tes_candidate_testNominated"><?= $Grid->renderFieldHeader($Grid->testNominated) ?></div></th>
<?php } ?>
<?php if ($Grid->testPaid->Visible) { // testPaid ?>
        <th data-name="testPaid" class="<?= $Grid->testPaid->headerCellClass() ?>"><div id="elh_tes_candidate_testPaid" class="tes_candidate_testPaid"><?= $Grid->renderFieldHeader($Grid->testPaid) ?></div></th>
<?php } ?>
<?php if ($Grid->result->Visible) { // result ?>
        <th data-name="result" class="<?= $Grid->result->headerCellClass() ?>"><div id="elh_tes_candidate_result" class="tes_candidate_result"><?= $Grid->renderFieldHeader($Grid->result) ?></div></th>
<?php } ?>
<?php if ($Grid->nextRankId->Visible) { // nextRankId ?>
        <th data-name="nextRankId" class="<?= $Grid->nextRankId->headerCellClass() ?>"><div id="elh_tes_candidate_nextRankId" class="tes_candidate_nextRankId"><?= $Grid->renderFieldHeader($Grid->nextRankId) ?></div></th>
<?php } ?>
<?php if ($Grid->memberAge->Visible) { // memberAge ?>
        <th data-name="memberAge" class="<?= $Grid->memberAge->headerCellClass() ?>"><div id="elh_tes_candidate_memberAge" class="tes_candidate_memberAge"><?= $Grid->renderFieldHeader($Grid->memberAge) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_tes_candidate",
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
<span id="el<?= $Grid->RowCount ?>_tes_candidate_id" class="el_tes_candidate_id"></span>
<input type="hidden" data-table="tes_candidate" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_id" class="el_tes_candidate_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
<input type="hidden" data-table="tes_candidate" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_id" class="el_tes_candidate_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tes_candidate" data-field="x_id" data-hidden="1" name="ftes_candidategrid$x<?= $Grid->RowIndex ?>_id" id="ftes_candidategrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="tes_candidate" data-field="x_id" data-hidden="1" name="ftes_candidategrid$o<?= $Grid->RowIndex ?>_id" id="ftes_candidategrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="tes_candidate" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->memberId->Visible) { // memberId ?>
        <td data-name="memberId"<?= $Grid->memberId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_memberId" class="el_tes_candidate_memberId">
<?php
$onchange = $Grid->memberId->EditAttrs->prepend("onchange", "ew.autoFill(this);");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->memberId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->memberId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_memberId" class="ew-auto-suggest">
    <input type="<?= $Grid->memberId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_memberId" id="sv_x<?= $Grid->RowIndex ?>_memberId" value="<?= RemoveHtml($Grid->memberId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->memberId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->memberId->getPlaceHolder()) ?>"<?= $Grid->memberId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="tes_candidate" data-field="x_memberId" data-input="sv_x<?= $Grid->RowIndex ?>_memberId" data-value-separator="<?= $Grid->memberId->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_memberId" id="x<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->memberId->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_candidategrid", function() {
    ftes_candidategrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_memberId","forceSelect":true}, ew.vars.tables.tes_candidate.fields.memberId.autoSuggestOptions));
});
</script>
<?= $Grid->memberId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_memberId") ?>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_memberId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_memberId" id="o<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_memberId" class="el_tes_candidate_memberId">
<?php
$onchange = $Grid->memberId->EditAttrs->prepend("onchange", "ew.autoFill(this);");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->memberId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->memberId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_memberId" class="ew-auto-suggest">
    <input type="<?= $Grid->memberId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_memberId" id="sv_x<?= $Grid->RowIndex ?>_memberId" value="<?= RemoveHtml($Grid->memberId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->memberId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->memberId->getPlaceHolder()) ?>"<?= $Grid->memberId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="tes_candidate" data-field="x_memberId" data-input="sv_x<?= $Grid->RowIndex ?>_memberId" data-value-separator="<?= $Grid->memberId->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_memberId" id="x<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->memberId->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_candidategrid", function() {
    ftes_candidategrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_memberId","forceSelect":true}, ew.vars.tables.tes_candidate.fields.memberId.autoSuggestOptions));
});
</script>
<?= $Grid->memberId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_memberId") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_memberId" class="el_tes_candidate_memberId">
<span<?= $Grid->memberId->viewAttributes() ?>>
<?= $Grid->memberId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tes_candidate" data-field="x_memberId" data-hidden="1" name="ftes_candidategrid$x<?= $Grid->RowIndex ?>_memberId" id="ftes_candidategrid$x<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->FormValue) ?>">
<input type="hidden" data-table="tes_candidate" data-field="x_memberId" data-hidden="1" name="ftes_candidategrid$o<?= $Grid->RowIndex ?>_memberId" id="ftes_candidategrid$o<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->rankId->Visible) { // rankId ?>
        <td data-name="rankId"<?= $Grid->rankId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_rankId" class="el_tes_candidate_rankId">
<?php $Grid->rankId->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_rankId"
        name="x<?= $Grid->RowIndex ?>_rankId"
        class="form-select ew-select<?= $Grid->rankId->isInvalidClass() ?>"
        data-select2-id="ftes_candidategrid_x<?= $Grid->RowIndex ?>_rankId"
        data-table="tes_candidate"
        data-field="x_rankId"
        data-value-separator="<?= $Grid->rankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->rankId->getPlaceHolder()) ?>"
        <?= $Grid->rankId->editAttributes() ?>>
        <?= $Grid->rankId->selectOptionListHtml("x{$Grid->RowIndex}_rankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->rankId->getErrorMessage() ?></div>
<?= $Grid->rankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_rankId") ?>
<script>
loadjs.ready("ftes_candidategrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_rankId", selectId: "ftes_candidategrid_x<?= $Grid->RowIndex ?>_rankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_candidategrid.lists.rankId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_rankId", form: "ftes_candidategrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_rankId", form: "ftes_candidategrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_candidate.fields.rankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_rankId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_rankId" id="o<?= $Grid->RowIndex ?>_rankId" value="<?= HtmlEncode($Grid->rankId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_rankId" class="el_tes_candidate_rankId">
<?php $Grid->rankId->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_rankId"
        name="x<?= $Grid->RowIndex ?>_rankId"
        class="form-select ew-select<?= $Grid->rankId->isInvalidClass() ?>"
        data-select2-id="ftes_candidategrid_x<?= $Grid->RowIndex ?>_rankId"
        data-table="tes_candidate"
        data-field="x_rankId"
        data-value-separator="<?= $Grid->rankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->rankId->getPlaceHolder()) ?>"
        <?= $Grid->rankId->editAttributes() ?>>
        <?= $Grid->rankId->selectOptionListHtml("x{$Grid->RowIndex}_rankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->rankId->getErrorMessage() ?></div>
<?= $Grid->rankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_rankId") ?>
<script>
loadjs.ready("ftes_candidategrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_rankId", selectId: "ftes_candidategrid_x<?= $Grid->RowIndex ?>_rankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_candidategrid.lists.rankId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_rankId", form: "ftes_candidategrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_rankId", form: "ftes_candidategrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_candidate.fields.rankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_rankId" class="el_tes_candidate_rankId">
<span<?= $Grid->rankId->viewAttributes() ?>>
<?= $Grid->rankId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tes_candidate" data-field="x_rankId" data-hidden="1" name="ftes_candidategrid$x<?= $Grid->RowIndex ?>_rankId" id="ftes_candidategrid$x<?= $Grid->RowIndex ?>_rankId" value="<?= HtmlEncode($Grid->rankId->FormValue) ?>">
<input type="hidden" data-table="tes_candidate" data-field="x_rankId" data-hidden="1" name="ftes_candidategrid$o<?= $Grid->RowIndex ?>_rankId" id="ftes_candidategrid$o<?= $Grid->RowIndex ?>_rankId" value="<?= HtmlEncode($Grid->rankId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->testNominated->Visible) { // testNominated ?>
        <td data-name="testNominated"<?= $Grid->testNominated->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_testNominated" class="el_tes_candidate_testNominated">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->testNominated->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_testNominated" name="x<?= $Grid->RowIndex ?>_testNominated[]" id="x<?= $Grid->RowIndex ?>_testNominated_720718" value="1"<?= ConvertToBool($Grid->testNominated->CurrentValue) ? " checked" : "" ?><?= $Grid->testNominated->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->testNominated->getErrorMessage() ?></div>
</div>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_testNominated" data-hidden="1" name="o<?= $Grid->RowIndex ?>_testNominated[]" id="o<?= $Grid->RowIndex ?>_testNominated[]" value="<?= HtmlEncode($Grid->testNominated->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_testNominated" class="el_tes_candidate_testNominated">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->testNominated->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_testNominated" name="x<?= $Grid->RowIndex ?>_testNominated[]" id="x<?= $Grid->RowIndex ?>_testNominated_642351" value="1"<?= ConvertToBool($Grid->testNominated->CurrentValue) ? " checked" : "" ?><?= $Grid->testNominated->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->testNominated->getErrorMessage() ?></div>
</div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_testNominated" class="el_tes_candidate_testNominated">
<span<?= $Grid->testNominated->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_testNominated_<?= $Grid->RowCount ?>" class="form-check-input" value="<?= $Grid->testNominated->getViewValue() ?>" disabled<?php if (ConvertToBool($Grid->testNominated->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_testNominated_<?= $Grid->RowCount ?>"></label>
</div></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tes_candidate" data-field="x_testNominated" data-hidden="1" name="ftes_candidategrid$x<?= $Grid->RowIndex ?>_testNominated" id="ftes_candidategrid$x<?= $Grid->RowIndex ?>_testNominated" value="<?= HtmlEncode($Grid->testNominated->FormValue) ?>">
<input type="hidden" data-table="tes_candidate" data-field="x_testNominated" data-hidden="1" name="ftes_candidategrid$o<?= $Grid->RowIndex ?>_testNominated[]" id="ftes_candidategrid$o<?= $Grid->RowIndex ?>_testNominated[]" value="<?= HtmlEncode($Grid->testNominated->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->testPaid->Visible) { // testPaid ?>
        <td data-name="testPaid"<?= $Grid->testPaid->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_testPaid" class="el_tes_candidate_testPaid">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->testPaid->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_testPaid" name="x<?= $Grid->RowIndex ?>_testPaid[]" id="x<?= $Grid->RowIndex ?>_testPaid_886530" value="1"<?= ConvertToBool($Grid->testPaid->CurrentValue) ? " checked" : "" ?><?= $Grid->testPaid->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->testPaid->getErrorMessage() ?></div>
</div>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_testPaid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_testPaid[]" id="o<?= $Grid->RowIndex ?>_testPaid[]" value="<?= HtmlEncode($Grid->testPaid->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_testPaid" class="el_tes_candidate_testPaid">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->testPaid->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_testPaid" name="x<?= $Grid->RowIndex ?>_testPaid[]" id="x<?= $Grid->RowIndex ?>_testPaid_264362" value="1"<?= ConvertToBool($Grid->testPaid->CurrentValue) ? " checked" : "" ?><?= $Grid->testPaid->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->testPaid->getErrorMessage() ?></div>
</div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_testPaid" class="el_tes_candidate_testPaid">
<span<?= $Grid->testPaid->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_testPaid_<?= $Grid->RowCount ?>" class="form-check-input" value="<?= $Grid->testPaid->getViewValue() ?>" disabled<?php if (ConvertToBool($Grid->testPaid->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_testPaid_<?= $Grid->RowCount ?>"></label>
</div></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tes_candidate" data-field="x_testPaid" data-hidden="1" name="ftes_candidategrid$x<?= $Grid->RowIndex ?>_testPaid" id="ftes_candidategrid$x<?= $Grid->RowIndex ?>_testPaid" value="<?= HtmlEncode($Grid->testPaid->FormValue) ?>">
<input type="hidden" data-table="tes_candidate" data-field="x_testPaid" data-hidden="1" name="ftes_candidategrid$o<?= $Grid->RowIndex ?>_testPaid[]" id="ftes_candidategrid$o<?= $Grid->RowIndex ?>_testPaid[]" value="<?= HtmlEncode($Grid->testPaid->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->result->Visible) { // result ?>
        <td data-name="result"<?= $Grid->result->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_result" class="el_tes_candidate_result">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->result->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_result" name="x<?= $Grid->RowIndex ?>_result[]" id="x<?= $Grid->RowIndex ?>_result_890681" value="1"<?= ConvertToBool($Grid->result->CurrentValue) ? " checked" : "" ?><?= $Grid->result->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->result->getErrorMessage() ?></div>
</div>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_result" data-hidden="1" name="o<?= $Grid->RowIndex ?>_result[]" id="o<?= $Grid->RowIndex ?>_result[]" value="<?= HtmlEncode($Grid->result->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_result" class="el_tes_candidate_result">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->result->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_result" name="x<?= $Grid->RowIndex ?>_result[]" id="x<?= $Grid->RowIndex ?>_result_666862" value="1"<?= ConvertToBool($Grid->result->CurrentValue) ? " checked" : "" ?><?= $Grid->result->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->result->getErrorMessage() ?></div>
</div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_result" class="el_tes_candidate_result">
<span<?= $Grid->result->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_result_<?= $Grid->RowCount ?>" class="form-check-input" value="<?= $Grid->result->getViewValue() ?>" disabled<?php if (ConvertToBool($Grid->result->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_result_<?= $Grid->RowCount ?>"></label>
</div></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tes_candidate" data-field="x_result" data-hidden="1" name="ftes_candidategrid$x<?= $Grid->RowIndex ?>_result" id="ftes_candidategrid$x<?= $Grid->RowIndex ?>_result" value="<?= HtmlEncode($Grid->result->FormValue) ?>">
<input type="hidden" data-table="tes_candidate" data-field="x_result" data-hidden="1" name="ftes_candidategrid$o<?= $Grid->RowIndex ?>_result[]" id="ftes_candidategrid$o<?= $Grid->RowIndex ?>_result[]" value="<?= HtmlEncode($Grid->result->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nextRankId->Visible) { // nextRankId ?>
        <td data-name="nextRankId"<?= $Grid->nextRankId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_nextRankId" class="el_tes_candidate_nextRankId">
    <select
        id="x<?= $Grid->RowIndex ?>_nextRankId"
        name="x<?= $Grid->RowIndex ?>_nextRankId"
        class="form-select ew-select<?= $Grid->nextRankId->isInvalidClass() ?>"
        data-select2-id="ftes_candidategrid_x<?= $Grid->RowIndex ?>_nextRankId"
        data-table="tes_candidate"
        data-field="x_nextRankId"
        data-value-separator="<?= $Grid->nextRankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->nextRankId->getPlaceHolder()) ?>"
        <?= $Grid->nextRankId->editAttributes() ?>>
        <?= $Grid->nextRankId->selectOptionListHtml("x{$Grid->RowIndex}_nextRankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->nextRankId->getErrorMessage() ?></div>
<?= $Grid->nextRankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_nextRankId") ?>
<script>
loadjs.ready("ftes_candidategrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_nextRankId", selectId: "ftes_candidategrid_x<?= $Grid->RowIndex ?>_nextRankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_candidategrid.lists.nextRankId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_nextRankId", form: "ftes_candidategrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_nextRankId", form: "ftes_candidategrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_candidate.fields.nextRankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_nextRankId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nextRankId" id="o<?= $Grid->RowIndex ?>_nextRankId" value="<?= HtmlEncode($Grid->nextRankId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_nextRankId" class="el_tes_candidate_nextRankId">
    <select
        id="x<?= $Grid->RowIndex ?>_nextRankId"
        name="x<?= $Grid->RowIndex ?>_nextRankId"
        class="form-select ew-select<?= $Grid->nextRankId->isInvalidClass() ?>"
        data-select2-id="ftes_candidategrid_x<?= $Grid->RowIndex ?>_nextRankId"
        data-table="tes_candidate"
        data-field="x_nextRankId"
        data-value-separator="<?= $Grid->nextRankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->nextRankId->getPlaceHolder()) ?>"
        <?= $Grid->nextRankId->editAttributes() ?>>
        <?= $Grid->nextRankId->selectOptionListHtml("x{$Grid->RowIndex}_nextRankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->nextRankId->getErrorMessage() ?></div>
<?= $Grid->nextRankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_nextRankId") ?>
<script>
loadjs.ready("ftes_candidategrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_nextRankId", selectId: "ftes_candidategrid_x<?= $Grid->RowIndex ?>_nextRankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_candidategrid.lists.nextRankId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_nextRankId", form: "ftes_candidategrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_nextRankId", form: "ftes_candidategrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_candidate.fields.nextRankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_nextRankId" class="el_tes_candidate_nextRankId">
<span<?= $Grid->nextRankId->viewAttributes() ?>>
<?= $Grid->nextRankId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tes_candidate" data-field="x_nextRankId" data-hidden="1" name="ftes_candidategrid$x<?= $Grid->RowIndex ?>_nextRankId" id="ftes_candidategrid$x<?= $Grid->RowIndex ?>_nextRankId" value="<?= HtmlEncode($Grid->nextRankId->FormValue) ?>">
<input type="hidden" data-table="tes_candidate" data-field="x_nextRankId" data-hidden="1" name="ftes_candidategrid$o<?= $Grid->RowIndex ?>_nextRankId" id="ftes_candidategrid$o<?= $Grid->RowIndex ?>_nextRankId" value="<?= HtmlEncode($Grid->nextRankId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->memberAge->Visible) { // memberAge ?>
        <td data-name="memberAge"<?= $Grid->memberAge->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_memberAge" class="el_tes_candidate_memberAge">
<input type="<?= $Grid->memberAge->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_memberAge" id="x<?= $Grid->RowIndex ?>_memberAge" data-table="tes_candidate" data-field="x_memberAge" value="<?= $Grid->memberAge->EditValue ?>" size="4" placeholder="<?= HtmlEncode($Grid->memberAge->getPlaceHolder()) ?>"<?= $Grid->memberAge->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->memberAge->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="tes_candidate" data-field="x_memberAge" data-hidden="1" name="o<?= $Grid->RowIndex ?>_memberAge" id="o<?= $Grid->RowIndex ?>_memberAge" value="<?= HtmlEncode($Grid->memberAge->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_memberAge" class="el_tes_candidate_memberAge">
<input type="<?= $Grid->memberAge->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_memberAge" id="x<?= $Grid->RowIndex ?>_memberAge" data-table="tes_candidate" data-field="x_memberAge" value="<?= $Grid->memberAge->EditValue ?>" size="4" placeholder="<?= HtmlEncode($Grid->memberAge->getPlaceHolder()) ?>"<?= $Grid->memberAge->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->memberAge->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_tes_candidate_memberAge" class="el_tes_candidate_memberAge">
<span<?= $Grid->memberAge->viewAttributes() ?>>
<?= $Grid->memberAge->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="tes_candidate" data-field="x_memberAge" data-hidden="1" name="ftes_candidategrid$x<?= $Grid->RowIndex ?>_memberAge" id="ftes_candidategrid$x<?= $Grid->RowIndex ?>_memberAge" value="<?= HtmlEncode($Grid->memberAge->FormValue) ?>">
<input type="hidden" data-table="tes_candidate" data-field="x_memberAge" data-hidden="1" name="ftes_candidategrid$o<?= $Grid->RowIndex ?>_memberAge" id="ftes_candidategrid$o<?= $Grid->RowIndex ?>_memberAge" value="<?= HtmlEncode($Grid->memberAge->OldValue) ?>">
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
loadjs.ready(["ftes_candidategrid","load"], () => ftes_candidategrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_tes_candidate", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_tes_candidate_id" class="el_tes_candidate_id"></span>
<?php } else { ?>
<span id="el$rowindex$_tes_candidate_id" class="el_tes_candidate_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
<input type="hidden" data-table="tes_candidate" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="tes_candidate" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->memberId->Visible) { // memberId ?>
        <td data-name="memberId">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_tes_candidate_memberId" class="el_tes_candidate_memberId">
<?php
$onchange = $Grid->memberId->EditAttrs->prepend("onchange", "ew.autoFill(this);");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->memberId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->memberId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_memberId" class="ew-auto-suggest">
    <input type="<?= $Grid->memberId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_memberId" id="sv_x<?= $Grid->RowIndex ?>_memberId" value="<?= RemoveHtml($Grid->memberId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->memberId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->memberId->getPlaceHolder()) ?>"<?= $Grid->memberId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="tes_candidate" data-field="x_memberId" data-input="sv_x<?= $Grid->RowIndex ?>_memberId" data-value-separator="<?= $Grid->memberId->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_memberId" id="x<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->memberId->getErrorMessage() ?></div>
<script>
loadjs.ready("ftes_candidategrid", function() {
    ftes_candidategrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_memberId","forceSelect":true}, ew.vars.tables.tes_candidate.fields.memberId.autoSuggestOptions));
});
</script>
<?= $Grid->memberId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_memberId") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_tes_candidate_memberId" class="el_tes_candidate_memberId">
<span<?= $Grid->memberId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->memberId->getDisplayValue($Grid->memberId->ViewValue) ?></span></span>
<input type="hidden" data-table="tes_candidate" data-field="x_memberId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_memberId" id="x<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="tes_candidate" data-field="x_memberId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_memberId" id="o<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->rankId->Visible) { // rankId ?>
        <td data-name="rankId">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_tes_candidate_rankId" class="el_tes_candidate_rankId">
<?php $Grid->rankId->EditAttrs->prepend("onchange", "ew.autoFill(this);"); ?>
    <select
        id="x<?= $Grid->RowIndex ?>_rankId"
        name="x<?= $Grid->RowIndex ?>_rankId"
        class="form-select ew-select<?= $Grid->rankId->isInvalidClass() ?>"
        data-select2-id="ftes_candidategrid_x<?= $Grid->RowIndex ?>_rankId"
        data-table="tes_candidate"
        data-field="x_rankId"
        data-value-separator="<?= $Grid->rankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->rankId->getPlaceHolder()) ?>"
        <?= $Grid->rankId->editAttributes() ?>>
        <?= $Grid->rankId->selectOptionListHtml("x{$Grid->RowIndex}_rankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->rankId->getErrorMessage() ?></div>
<?= $Grid->rankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_rankId") ?>
<script>
loadjs.ready("ftes_candidategrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_rankId", selectId: "ftes_candidategrid_x<?= $Grid->RowIndex ?>_rankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_candidategrid.lists.rankId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_rankId", form: "ftes_candidategrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_rankId", form: "ftes_candidategrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_candidate.fields.rankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_tes_candidate_rankId" class="el_tes_candidate_rankId">
<span<?= $Grid->rankId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->rankId->getDisplayValue($Grid->rankId->ViewValue) ?></span></span>
<input type="hidden" data-table="tes_candidate" data-field="x_rankId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_rankId" id="x<?= $Grid->RowIndex ?>_rankId" value="<?= HtmlEncode($Grid->rankId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="tes_candidate" data-field="x_rankId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_rankId" id="o<?= $Grid->RowIndex ?>_rankId" value="<?= HtmlEncode($Grid->rankId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->testNominated->Visible) { // testNominated ?>
        <td data-name="testNominated">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_tes_candidate_testNominated" class="el_tes_candidate_testNominated">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->testNominated->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_testNominated" name="x<?= $Grid->RowIndex ?>_testNominated[]" id="x<?= $Grid->RowIndex ?>_testNominated_268535" value="1"<?= ConvertToBool($Grid->testNominated->CurrentValue) ? " checked" : "" ?><?= $Grid->testNominated->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->testNominated->getErrorMessage() ?></div>
</div>
</span>
<?php } else { ?>
<span id="el$rowindex$_tes_candidate_testNominated" class="el_tes_candidate_testNominated">
<span<?= $Grid->testNominated->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_testNominated_<?= $Grid->RowCount ?>" class="form-check-input" value="<?= $Grid->testNominated->ViewValue ?>" disabled<?php if (ConvertToBool($Grid->testNominated->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_testNominated_<?= $Grid->RowCount ?>"></label>
</div></span>
<input type="hidden" data-table="tes_candidate" data-field="x_testNominated" data-hidden="1" name="x<?= $Grid->RowIndex ?>_testNominated" id="x<?= $Grid->RowIndex ?>_testNominated" value="<?= HtmlEncode($Grid->testNominated->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="tes_candidate" data-field="x_testNominated" data-hidden="1" name="o<?= $Grid->RowIndex ?>_testNominated[]" id="o<?= $Grid->RowIndex ?>_testNominated[]" value="<?= HtmlEncode($Grid->testNominated->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->testPaid->Visible) { // testPaid ?>
        <td data-name="testPaid">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_tes_candidate_testPaid" class="el_tes_candidate_testPaid">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->testPaid->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_testPaid" name="x<?= $Grid->RowIndex ?>_testPaid[]" id="x<?= $Grid->RowIndex ?>_testPaid_710595" value="1"<?= ConvertToBool($Grid->testPaid->CurrentValue) ? " checked" : "" ?><?= $Grid->testPaid->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->testPaid->getErrorMessage() ?></div>
</div>
</span>
<?php } else { ?>
<span id="el$rowindex$_tes_candidate_testPaid" class="el_tes_candidate_testPaid">
<span<?= $Grid->testPaid->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_testPaid_<?= $Grid->RowCount ?>" class="form-check-input" value="<?= $Grid->testPaid->ViewValue ?>" disabled<?php if (ConvertToBool($Grid->testPaid->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_testPaid_<?= $Grid->RowCount ?>"></label>
</div></span>
<input type="hidden" data-table="tes_candidate" data-field="x_testPaid" data-hidden="1" name="x<?= $Grid->RowIndex ?>_testPaid" id="x<?= $Grid->RowIndex ?>_testPaid" value="<?= HtmlEncode($Grid->testPaid->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="tes_candidate" data-field="x_testPaid" data-hidden="1" name="o<?= $Grid->RowIndex ?>_testPaid[]" id="o<?= $Grid->RowIndex ?>_testPaid[]" value="<?= HtmlEncode($Grid->testPaid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->result->Visible) { // result ?>
        <td data-name="result">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_tes_candidate_result" class="el_tes_candidate_result">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->result->isInvalidClass() ?>" data-table="tes_candidate" data-field="x_result" name="x<?= $Grid->RowIndex ?>_result[]" id="x<?= $Grid->RowIndex ?>_result_497517" value="1"<?= ConvertToBool($Grid->result->CurrentValue) ? " checked" : "" ?><?= $Grid->result->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->result->getErrorMessage() ?></div>
</div>
</span>
<?php } else { ?>
<span id="el$rowindex$_tes_candidate_result" class="el_tes_candidate_result">
<span<?= $Grid->result->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_result_<?= $Grid->RowCount ?>" class="form-check-input" value="<?= $Grid->result->ViewValue ?>" disabled<?php if (ConvertToBool($Grid->result->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_result_<?= $Grid->RowCount ?>"></label>
</div></span>
<input type="hidden" data-table="tes_candidate" data-field="x_result" data-hidden="1" name="x<?= $Grid->RowIndex ?>_result" id="x<?= $Grid->RowIndex ?>_result" value="<?= HtmlEncode($Grid->result->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="tes_candidate" data-field="x_result" data-hidden="1" name="o<?= $Grid->RowIndex ?>_result[]" id="o<?= $Grid->RowIndex ?>_result[]" value="<?= HtmlEncode($Grid->result->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nextRankId->Visible) { // nextRankId ?>
        <td data-name="nextRankId">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_tes_candidate_nextRankId" class="el_tes_candidate_nextRankId">
    <select
        id="x<?= $Grid->RowIndex ?>_nextRankId"
        name="x<?= $Grid->RowIndex ?>_nextRankId"
        class="form-select ew-select<?= $Grid->nextRankId->isInvalidClass() ?>"
        data-select2-id="ftes_candidategrid_x<?= $Grid->RowIndex ?>_nextRankId"
        data-table="tes_candidate"
        data-field="x_nextRankId"
        data-value-separator="<?= $Grid->nextRankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->nextRankId->getPlaceHolder()) ?>"
        <?= $Grid->nextRankId->editAttributes() ?>>
        <?= $Grid->nextRankId->selectOptionListHtml("x{$Grid->RowIndex}_nextRankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->nextRankId->getErrorMessage() ?></div>
<?= $Grid->nextRankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_nextRankId") ?>
<script>
loadjs.ready("ftes_candidategrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_nextRankId", selectId: "ftes_candidategrid_x<?= $Grid->RowIndex ?>_nextRankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (ftes_candidategrid.lists.nextRankId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_nextRankId", form: "ftes_candidategrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_nextRankId", form: "ftes_candidategrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.tes_candidate.fields.nextRankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_tes_candidate_nextRankId" class="el_tes_candidate_nextRankId">
<span<?= $Grid->nextRankId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->nextRankId->getDisplayValue($Grid->nextRankId->ViewValue) ?></span></span>
<input type="hidden" data-table="tes_candidate" data-field="x_nextRankId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nextRankId" id="x<?= $Grid->RowIndex ?>_nextRankId" value="<?= HtmlEncode($Grid->nextRankId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="tes_candidate" data-field="x_nextRankId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nextRankId" id="o<?= $Grid->RowIndex ?>_nextRankId" value="<?= HtmlEncode($Grid->nextRankId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->memberAge->Visible) { // memberAge ?>
        <td data-name="memberAge">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_tes_candidate_memberAge" class="el_tes_candidate_memberAge">
<input type="<?= $Grid->memberAge->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_memberAge" id="x<?= $Grid->RowIndex ?>_memberAge" data-table="tes_candidate" data-field="x_memberAge" value="<?= $Grid->memberAge->EditValue ?>" size="4" placeholder="<?= HtmlEncode($Grid->memberAge->getPlaceHolder()) ?>"<?= $Grid->memberAge->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->memberAge->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_tes_candidate_memberAge" class="el_tes_candidate_memberAge">
<span<?= $Grid->memberAge->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->memberAge->getDisplayValue($Grid->memberAge->ViewValue))) ?>"></span>
<input type="hidden" data-table="tes_candidate" data-field="x_memberAge" data-hidden="1" name="x<?= $Grid->RowIndex ?>_memberAge" id="x<?= $Grid->RowIndex ?>_memberAge" value="<?= HtmlEncode($Grid->memberAge->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="tes_candidate" data-field="x_memberAge" data-hidden="1" name="o<?= $Grid->RowIndex ?>_memberAge" id="o<?= $Grid->RowIndex ?>_memberAge" value="<?= HtmlEncode($Grid->memberAge->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["ftes_candidategrid","load"], () => ftes_candidategrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="ftes_candidategrid">
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
    ew.addEventHandlers("tes_candidate");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
