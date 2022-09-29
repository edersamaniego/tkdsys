<?php

namespace PHPMaker2022\school;

// Set up and run Grid object
$Grid = Container("ViewTestAprovedsGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fview_test_aprovedsgrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fview_test_aprovedsgrid = new ew.Form("fview_test_aprovedsgrid", "grid");
    fview_test_aprovedsgrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { view_test_aproveds: currentTable } });
    var fields = currentTable.fields;
    fview_test_aprovedsgrid.addFields([
        ["id", [fields.id.visible && fields.id.required ? ew.Validators.required(fields.id.caption) : null], fields.id.isInvalid],
        ["memberId", [fields.memberId.visible && fields.memberId.required ? ew.Validators.required(fields.memberId.caption) : null, ew.Validators.integer], fields.memberId.isInvalid],
        ["nextRankId", [fields.nextRankId.visible && fields.nextRankId.required ? ew.Validators.required(fields.nextRankId.caption) : null], fields.nextRankId.isInvalid],
        ["memberAge", [fields.memberAge.visible && fields.memberAge.required ? ew.Validators.required(fields.memberAge.caption) : null, ew.Validators.integer], fields.memberAge.isInvalid],
        ["renew", [fields.renew.visible && fields.renew.required ? ew.Validators.required(fields.renew.caption) : null], fields.renew.isInvalid],
        ["memberDOB", [fields.memberDOB.visible && fields.memberDOB.required ? ew.Validators.required(fields.memberDOB.caption) : null, ew.Validators.datetime(fields.memberDOB.clientFormatPattern)], fields.memberDOB.isInvalid]
    ]);

    // Check empty row
    fview_test_aprovedsgrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["memberId",false],["nextRankId",false],["memberAge",false],["renew[]",true],["memberDOB",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fview_test_aprovedsgrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fview_test_aprovedsgrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fview_test_aprovedsgrid.lists.memberId = <?= $Grid->memberId->toClientList($Grid) ?>;
    fview_test_aprovedsgrid.lists.nextRankId = <?= $Grid->nextRankId->toClientList($Grid) ?>;
    fview_test_aprovedsgrid.lists.renew = <?= $Grid->renew->toClientList($Grid) ?>;
    loadjs.done("fview_test_aprovedsgrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> view_test_aproveds">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="fview_test_aprovedsgrid" class="ew-form ew-list-form">
<div id="gmp_view_test_aproveds" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_view_test_aprovedsgrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Grid->id->headerCellClass() ?>"><div id="elh_view_test_aproveds_id" class="view_test_aproveds_id"><?= $Grid->renderFieldHeader($Grid->id) ?></div></th>
<?php } ?>
<?php if ($Grid->memberId->Visible) { // memberId ?>
        <th data-name="memberId" class="<?= $Grid->memberId->headerCellClass() ?>"><div id="elh_view_test_aproveds_memberId" class="view_test_aproveds_memberId"><?= $Grid->renderFieldHeader($Grid->memberId) ?></div></th>
<?php } ?>
<?php if ($Grid->nextRankId->Visible) { // nextRankId ?>
        <th data-name="nextRankId" class="<?= $Grid->nextRankId->headerCellClass() ?>"><div id="elh_view_test_aproveds_nextRankId" class="view_test_aproveds_nextRankId"><?= $Grid->renderFieldHeader($Grid->nextRankId) ?></div></th>
<?php } ?>
<?php if ($Grid->memberAge->Visible) { // memberAge ?>
        <th data-name="memberAge" class="<?= $Grid->memberAge->headerCellClass() ?>"><div id="elh_view_test_aproveds_memberAge" class="view_test_aproveds_memberAge"><?= $Grid->renderFieldHeader($Grid->memberAge) ?></div></th>
<?php } ?>
<?php if ($Grid->renew->Visible) { // renew ?>
        <th data-name="renew" class="<?= $Grid->renew->headerCellClass() ?>"><div id="elh_view_test_aproveds_renew" class="view_test_aproveds_renew"><?= $Grid->renderFieldHeader($Grid->renew) ?></div></th>
<?php } ?>
<?php if ($Grid->memberDOB->Visible) { // memberDOB ?>
        <th data-name="memberDOB" class="<?= $Grid->memberDOB->headerCellClass() ?>"><div id="elh_view_test_aproveds_memberDOB" class="view_test_aproveds_memberDOB"><?= $Grid->renderFieldHeader($Grid->memberDOB) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_view_test_aproveds",
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
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_id" class="el_view_test_aproveds_id"></span>
<input type="hidden" data-table="view_test_aproveds" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_id" class="el_view_test_aproveds_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->EditValue))) ?>"></span>
<input type="hidden" data-table="view_test_aproveds" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_id" class="el_view_test_aproveds_id">
<span<?= $Grid->id->viewAttributes() ?>>
<?= $Grid->id->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="view_test_aproveds" data-field="x_id" data-hidden="1" name="fview_test_aprovedsgrid$x<?= $Grid->RowIndex ?>_id" id="fview_test_aprovedsgrid$x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
<input type="hidden" data-table="view_test_aproveds" data-field="x_id" data-hidden="1" name="fview_test_aprovedsgrid$o<?= $Grid->RowIndex ?>_id" id="fview_test_aprovedsgrid$o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="view_test_aproveds" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->memberId->Visible) { // memberId ?>
        <td data-name="memberId"<?= $Grid->memberId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_memberId" class="el_view_test_aproveds_memberId">
<?php
$onchange = $Grid->memberId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->memberId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->memberId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_memberId" class="ew-auto-suggest">
    <input type="<?= $Grid->memberId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_memberId" id="sv_x<?= $Grid->RowIndex ?>_memberId" value="<?= RemoveHtml($Grid->memberId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->memberId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->memberId->getPlaceHolder()) ?>"<?= $Grid->memberId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="view_test_aproveds" data-field="x_memberId" data-input="sv_x<?= $Grid->RowIndex ?>_memberId" data-value-separator="<?= $Grid->memberId->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_memberId" id="x<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->memberId->getErrorMessage() ?></div>
<script>
loadjs.ready("fview_test_aprovedsgrid", function() {
    fview_test_aprovedsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_memberId","forceSelect":false}, ew.vars.tables.view_test_aproveds.fields.memberId.autoSuggestOptions));
});
</script>
<?= $Grid->memberId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_memberId") ?>
</span>
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_memberId" id="o<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_memberId" class="el_view_test_aproveds_memberId">
<?php
$onchange = $Grid->memberId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->memberId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->memberId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_memberId" class="ew-auto-suggest">
    <input type="<?= $Grid->memberId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_memberId" id="sv_x<?= $Grid->RowIndex ?>_memberId" value="<?= RemoveHtml($Grid->memberId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->memberId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->memberId->getPlaceHolder()) ?>"<?= $Grid->memberId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="view_test_aproveds" data-field="x_memberId" data-input="sv_x<?= $Grid->RowIndex ?>_memberId" data-value-separator="<?= $Grid->memberId->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_memberId" id="x<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->memberId->getErrorMessage() ?></div>
<script>
loadjs.ready("fview_test_aprovedsgrid", function() {
    fview_test_aprovedsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_memberId","forceSelect":false}, ew.vars.tables.view_test_aproveds.fields.memberId.autoSuggestOptions));
});
</script>
<?= $Grid->memberId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_memberId") ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_memberId" class="el_view_test_aproveds_memberId">
<span<?= $Grid->memberId->viewAttributes() ?>>
<?php if (!EmptyString($Grid->memberId->getViewValue()) && $Grid->memberId->linkAttributes() != "") { ?>
<a<?= $Grid->memberId->linkAttributes() ?>><?= $Grid->memberId->getViewValue() ?></a>
<?php } else { ?>
<?= $Grid->memberId->getViewValue() ?>
<?php } ?>
</span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberId" data-hidden="1" name="fview_test_aprovedsgrid$x<?= $Grid->RowIndex ?>_memberId" id="fview_test_aprovedsgrid$x<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->FormValue) ?>">
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberId" data-hidden="1" name="fview_test_aprovedsgrid$o<?= $Grid->RowIndex ?>_memberId" id="fview_test_aprovedsgrid$o<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->nextRankId->Visible) { // nextRankId ?>
        <td data-name="nextRankId"<?= $Grid->nextRankId->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_nextRankId" class="el_view_test_aproveds_nextRankId">
    <select
        id="x<?= $Grid->RowIndex ?>_nextRankId"
        name="x<?= $Grid->RowIndex ?>_nextRankId"
        class="form-select ew-select<?= $Grid->nextRankId->isInvalidClass() ?>"
        data-select2-id="fview_test_aprovedsgrid_x<?= $Grid->RowIndex ?>_nextRankId"
        data-table="view_test_aproveds"
        data-field="x_nextRankId"
        data-value-separator="<?= $Grid->nextRankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->nextRankId->getPlaceHolder()) ?>"
        <?= $Grid->nextRankId->editAttributes() ?>>
        <?= $Grid->nextRankId->selectOptionListHtml("x{$Grid->RowIndex}_nextRankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->nextRankId->getErrorMessage() ?></div>
<?= $Grid->nextRankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_nextRankId") ?>
<script>
loadjs.ready("fview_test_aprovedsgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_nextRankId", selectId: "fview_test_aprovedsgrid_x<?= $Grid->RowIndex ?>_nextRankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_test_aprovedsgrid.lists.nextRankId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_nextRankId", form: "fview_test_aprovedsgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_nextRankId", form: "fview_test_aprovedsgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_test_aproveds.fields.nextRankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="view_test_aproveds" data-field="x_nextRankId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nextRankId" id="o<?= $Grid->RowIndex ?>_nextRankId" value="<?= HtmlEncode($Grid->nextRankId->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_nextRankId" class="el_view_test_aproveds_nextRankId">
    <select
        id="x<?= $Grid->RowIndex ?>_nextRankId"
        name="x<?= $Grid->RowIndex ?>_nextRankId"
        class="form-select ew-select<?= $Grid->nextRankId->isInvalidClass() ?>"
        data-select2-id="fview_test_aprovedsgrid_x<?= $Grid->RowIndex ?>_nextRankId"
        data-table="view_test_aproveds"
        data-field="x_nextRankId"
        data-value-separator="<?= $Grid->nextRankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->nextRankId->getPlaceHolder()) ?>"
        <?= $Grid->nextRankId->editAttributes() ?>>
        <?= $Grid->nextRankId->selectOptionListHtml("x{$Grid->RowIndex}_nextRankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->nextRankId->getErrorMessage() ?></div>
<?= $Grid->nextRankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_nextRankId") ?>
<script>
loadjs.ready("fview_test_aprovedsgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_nextRankId", selectId: "fview_test_aprovedsgrid_x<?= $Grid->RowIndex ?>_nextRankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_test_aprovedsgrid.lists.nextRankId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_nextRankId", form: "fview_test_aprovedsgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_nextRankId", form: "fview_test_aprovedsgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_test_aproveds.fields.nextRankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_nextRankId" class="el_view_test_aproveds_nextRankId">
<span<?= $Grid->nextRankId->viewAttributes() ?>>
<?= $Grid->nextRankId->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="view_test_aproveds" data-field="x_nextRankId" data-hidden="1" name="fview_test_aprovedsgrid$x<?= $Grid->RowIndex ?>_nextRankId" id="fview_test_aprovedsgrid$x<?= $Grid->RowIndex ?>_nextRankId" value="<?= HtmlEncode($Grid->nextRankId->FormValue) ?>">
<input type="hidden" data-table="view_test_aproveds" data-field="x_nextRankId" data-hidden="1" name="fview_test_aprovedsgrid$o<?= $Grid->RowIndex ?>_nextRankId" id="fview_test_aprovedsgrid$o<?= $Grid->RowIndex ?>_nextRankId" value="<?= HtmlEncode($Grid->nextRankId->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->memberAge->Visible) { // memberAge ?>
        <td data-name="memberAge"<?= $Grid->memberAge->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_memberAge" class="el_view_test_aproveds_memberAge">
<input type="<?= $Grid->memberAge->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_memberAge" id="x<?= $Grid->RowIndex ?>_memberAge" data-table="view_test_aproveds" data-field="x_memberAge" value="<?= $Grid->memberAge->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->memberAge->getPlaceHolder()) ?>"<?= $Grid->memberAge->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->memberAge->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberAge" data-hidden="1" name="o<?= $Grid->RowIndex ?>_memberAge" id="o<?= $Grid->RowIndex ?>_memberAge" value="<?= HtmlEncode($Grid->memberAge->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_memberAge" class="el_view_test_aproveds_memberAge">
<input type="<?= $Grid->memberAge->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_memberAge" id="x<?= $Grid->RowIndex ?>_memberAge" data-table="view_test_aproveds" data-field="x_memberAge" value="<?= $Grid->memberAge->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->memberAge->getPlaceHolder()) ?>"<?= $Grid->memberAge->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->memberAge->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_memberAge" class="el_view_test_aproveds_memberAge">
<span<?= $Grid->memberAge->viewAttributes() ?>>
<?= $Grid->memberAge->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberAge" data-hidden="1" name="fview_test_aprovedsgrid$x<?= $Grid->RowIndex ?>_memberAge" id="fview_test_aprovedsgrid$x<?= $Grid->RowIndex ?>_memberAge" value="<?= HtmlEncode($Grid->memberAge->FormValue) ?>">
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberAge" data-hidden="1" name="fview_test_aprovedsgrid$o<?= $Grid->RowIndex ?>_memberAge" id="fview_test_aprovedsgrid$o<?= $Grid->RowIndex ?>_memberAge" value="<?= HtmlEncode($Grid->memberAge->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->renew->Visible) { // renew ?>
        <td data-name="renew"<?= $Grid->renew->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_renew" class="el_view_test_aproveds_renew">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->renew->isInvalidClass() ?>" data-table="view_test_aproveds" data-field="x_renew" name="x<?= $Grid->RowIndex ?>_renew[]" id="x<?= $Grid->RowIndex ?>_renew_611840" value="1"<?= ConvertToBool($Grid->renew->CurrentValue) ? " checked" : "" ?><?= $Grid->renew->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->renew->getErrorMessage() ?></div>
</div>
</span>
<input type="hidden" data-table="view_test_aproveds" data-field="x_renew" data-hidden="1" name="o<?= $Grid->RowIndex ?>_renew[]" id="o<?= $Grid->RowIndex ?>_renew[]" value="<?= HtmlEncode($Grid->renew->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_renew" class="el_view_test_aproveds_renew">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->renew->isInvalidClass() ?>" data-table="view_test_aproveds" data-field="x_renew" name="x<?= $Grid->RowIndex ?>_renew[]" id="x<?= $Grid->RowIndex ?>_renew_518124" value="1"<?= ConvertToBool($Grid->renew->CurrentValue) ? " checked" : "" ?><?= $Grid->renew->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->renew->getErrorMessage() ?></div>
</div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_renew" class="el_view_test_aproveds_renew">
<span<?= $Grid->renew->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_renew_<?= $Grid->RowCount ?>" class="form-check-input" value="<?= $Grid->renew->getViewValue() ?>" disabled<?php if (ConvertToBool($Grid->renew->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_renew_<?= $Grid->RowCount ?>"></label>
</div></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="view_test_aproveds" data-field="x_renew" data-hidden="1" name="fview_test_aprovedsgrid$x<?= $Grid->RowIndex ?>_renew" id="fview_test_aprovedsgrid$x<?= $Grid->RowIndex ?>_renew" value="<?= HtmlEncode($Grid->renew->FormValue) ?>">
<input type="hidden" data-table="view_test_aproveds" data-field="x_renew" data-hidden="1" name="fview_test_aprovedsgrid$o<?= $Grid->RowIndex ?>_renew[]" id="fview_test_aprovedsgrid$o<?= $Grid->RowIndex ?>_renew[]" value="<?= HtmlEncode($Grid->renew->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->memberDOB->Visible) { // memberDOB ?>
        <td data-name="memberDOB"<?= $Grid->memberDOB->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_memberDOB" class="el_view_test_aproveds_memberDOB">
<input type="<?= $Grid->memberDOB->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_memberDOB" id="x<?= $Grid->RowIndex ?>_memberDOB" data-table="view_test_aproveds" data-field="x_memberDOB" value="<?= $Grid->memberDOB->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->memberDOB->getPlaceHolder()) ?>"<?= $Grid->memberDOB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->memberDOB->getErrorMessage() ?></div>
<?php if (!$Grid->memberDOB->ReadOnly && !$Grid->memberDOB->Disabled && !isset($Grid->memberDOB->EditAttrs["readonly"]) && !isset($Grid->memberDOB->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_test_aprovedsgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_test_aprovedsgrid", "x<?= $Grid->RowIndex ?>_memberDOB", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberDOB" data-hidden="1" name="o<?= $Grid->RowIndex ?>_memberDOB" id="o<?= $Grid->RowIndex ?>_memberDOB" value="<?= HtmlEncode($Grid->memberDOB->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_memberDOB" class="el_view_test_aproveds_memberDOB">
<input type="<?= $Grid->memberDOB->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_memberDOB" id="x<?= $Grid->RowIndex ?>_memberDOB" data-table="view_test_aproveds" data-field="x_memberDOB" value="<?= $Grid->memberDOB->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->memberDOB->getPlaceHolder()) ?>"<?= $Grid->memberDOB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->memberDOB->getErrorMessage() ?></div>
<?php if (!$Grid->memberDOB->ReadOnly && !$Grid->memberDOB->Disabled && !isset($Grid->memberDOB->EditAttrs["readonly"]) && !isset($Grid->memberDOB->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_test_aprovedsgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_test_aprovedsgrid", "x<?= $Grid->RowIndex ?>_memberDOB", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_view_test_aproveds_memberDOB" class="el_view_test_aproveds_memberDOB">
<span<?= $Grid->memberDOB->viewAttributes() ?>>
<?= $Grid->memberDOB->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberDOB" data-hidden="1" name="fview_test_aprovedsgrid$x<?= $Grid->RowIndex ?>_memberDOB" id="fview_test_aprovedsgrid$x<?= $Grid->RowIndex ?>_memberDOB" value="<?= HtmlEncode($Grid->memberDOB->FormValue) ?>">
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberDOB" data-hidden="1" name="fview_test_aprovedsgrid$o<?= $Grid->RowIndex ?>_memberDOB" id="fview_test_aprovedsgrid$o<?= $Grid->RowIndex ?>_memberDOB" value="<?= HtmlEncode($Grid->memberDOB->OldValue) ?>">
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
loadjs.ready(["fview_test_aprovedsgrid","load"], () => fview_test_aprovedsgrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_view_test_aproveds", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_view_test_aproveds_id" class="el_view_test_aproveds_id"></span>
<?php } else { ?>
<span id="el$rowindex$_view_test_aproveds_id" class="el_view_test_aproveds_id">
<span<?= $Grid->id->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->id->getDisplayValue($Grid->id->ViewValue))) ?>"></span>
<input type="hidden" data-table="view_test_aproveds" data-field="x_id" data-hidden="1" name="x<?= $Grid->RowIndex ?>_id" id="x<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="view_test_aproveds" data-field="x_id" data-hidden="1" name="o<?= $Grid->RowIndex ?>_id" id="o<?= $Grid->RowIndex ?>_id" value="<?= HtmlEncode($Grid->id->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->memberId->Visible) { // memberId ?>
        <td data-name="memberId">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_view_test_aproveds_memberId" class="el_view_test_aproveds_memberId">
<?php
$onchange = $Grid->memberId->EditAttrs->prepend("onchange", "");
$onchange = ($onchange) ? ' onchange="' . JsEncode($onchange) . '"' : '';
$Grid->memberId->EditAttrs["onchange"] = "";
if (IsRTL()) {
    $Grid->memberId->EditAttrs["dir"] = "rtl";
}
?>
<span id="as_x<?= $Grid->RowIndex ?>_memberId" class="ew-auto-suggest">
    <input type="<?= $Grid->memberId->getInputTextType() ?>" class="form-control" name="sv_x<?= $Grid->RowIndex ?>_memberId" id="sv_x<?= $Grid->RowIndex ?>_memberId" value="<?= RemoveHtml($Grid->memberId->EditValue) ?>" size="30" placeholder="<?= HtmlEncode($Grid->memberId->getPlaceHolder()) ?>" data-placeholder="<?= HtmlEncode($Grid->memberId->getPlaceHolder()) ?>"<?= $Grid->memberId->editAttributes() ?>>
</span>
<selection-list hidden class="form-control" data-table="view_test_aproveds" data-field="x_memberId" data-input="sv_x<?= $Grid->RowIndex ?>_memberId" data-value-separator="<?= $Grid->memberId->displayValueSeparatorAttribute() ?>" name="x<?= $Grid->RowIndex ?>_memberId" id="x<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->CurrentValue) ?>"<?= $onchange ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->memberId->getErrorMessage() ?></div>
<script>
loadjs.ready("fview_test_aprovedsgrid", function() {
    fview_test_aprovedsgrid.createAutoSuggest(Object.assign({"id":"x<?= $Grid->RowIndex ?>_memberId","forceSelect":false}, ew.vars.tables.view_test_aproveds.fields.memberId.autoSuggestOptions));
});
</script>
<?= $Grid->memberId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_memberId") ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_view_test_aproveds_memberId" class="el_view_test_aproveds_memberId">
<span<?= $Grid->memberId->viewAttributes() ?>>
<?php if (!EmptyString($Grid->memberId->ViewValue) && $Grid->memberId->linkAttributes() != "") { ?>
<a<?= $Grid->memberId->linkAttributes() ?>><span class="form-control-plaintext"><?= $Grid->memberId->getDisplayValue($Grid->memberId->ViewValue) ?></span></a>
<?php } else { ?>
<span class="form-control-plaintext"><?= $Grid->memberId->getDisplayValue($Grid->memberId->ViewValue) ?></span>
<?php } ?>
</span>
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_memberId" id="x<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_memberId" id="o<?= $Grid->RowIndex ?>_memberId" value="<?= HtmlEncode($Grid->memberId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->nextRankId->Visible) { // nextRankId ?>
        <td data-name="nextRankId">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_view_test_aproveds_nextRankId" class="el_view_test_aproveds_nextRankId">
    <select
        id="x<?= $Grid->RowIndex ?>_nextRankId"
        name="x<?= $Grid->RowIndex ?>_nextRankId"
        class="form-select ew-select<?= $Grid->nextRankId->isInvalidClass() ?>"
        data-select2-id="fview_test_aprovedsgrid_x<?= $Grid->RowIndex ?>_nextRankId"
        data-table="view_test_aproveds"
        data-field="x_nextRankId"
        data-value-separator="<?= $Grid->nextRankId->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->nextRankId->getPlaceHolder()) ?>"
        <?= $Grid->nextRankId->editAttributes() ?>>
        <?= $Grid->nextRankId->selectOptionListHtml("x{$Grid->RowIndex}_nextRankId") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->nextRankId->getErrorMessage() ?></div>
<?= $Grid->nextRankId->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_nextRankId") ?>
<script>
loadjs.ready("fview_test_aprovedsgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_nextRankId", selectId: "fview_test_aprovedsgrid_x<?= $Grid->RowIndex ?>_nextRankId" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fview_test_aprovedsgrid.lists.nextRankId.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_nextRankId", form: "fview_test_aprovedsgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_nextRankId", form: "fview_test_aprovedsgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.view_test_aproveds.fields.nextRankId.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_view_test_aproveds_nextRankId" class="el_view_test_aproveds_nextRankId">
<span<?= $Grid->nextRankId->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->nextRankId->getDisplayValue($Grid->nextRankId->ViewValue) ?></span></span>
<input type="hidden" data-table="view_test_aproveds" data-field="x_nextRankId" data-hidden="1" name="x<?= $Grid->RowIndex ?>_nextRankId" id="x<?= $Grid->RowIndex ?>_nextRankId" value="<?= HtmlEncode($Grid->nextRankId->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="view_test_aproveds" data-field="x_nextRankId" data-hidden="1" name="o<?= $Grid->RowIndex ?>_nextRankId" id="o<?= $Grid->RowIndex ?>_nextRankId" value="<?= HtmlEncode($Grid->nextRankId->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->memberAge->Visible) { // memberAge ?>
        <td data-name="memberAge">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_view_test_aproveds_memberAge" class="el_view_test_aproveds_memberAge">
<input type="<?= $Grid->memberAge->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_memberAge" id="x<?= $Grid->RowIndex ?>_memberAge" data-table="view_test_aproveds" data-field="x_memberAge" value="<?= $Grid->memberAge->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->memberAge->getPlaceHolder()) ?>"<?= $Grid->memberAge->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->memberAge->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_view_test_aproveds_memberAge" class="el_view_test_aproveds_memberAge">
<span<?= $Grid->memberAge->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->memberAge->getDisplayValue($Grid->memberAge->ViewValue))) ?>"></span>
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberAge" data-hidden="1" name="x<?= $Grid->RowIndex ?>_memberAge" id="x<?= $Grid->RowIndex ?>_memberAge" value="<?= HtmlEncode($Grid->memberAge->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberAge" data-hidden="1" name="o<?= $Grid->RowIndex ?>_memberAge" id="o<?= $Grid->RowIndex ?>_memberAge" value="<?= HtmlEncode($Grid->memberAge->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->renew->Visible) { // renew ?>
        <td data-name="renew">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_view_test_aproveds_renew" class="el_view_test_aproveds_renew">
<div class="form-check d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Grid->renew->isInvalidClass() ?>" data-table="view_test_aproveds" data-field="x_renew" name="x<?= $Grid->RowIndex ?>_renew[]" id="x<?= $Grid->RowIndex ?>_renew_338457" value="1"<?= ConvertToBool($Grid->renew->CurrentValue) ? " checked" : "" ?><?= $Grid->renew->editAttributes() ?>>
    <div class="invalid-feedback"><?= $Grid->renew->getErrorMessage() ?></div>
</div>
</span>
<?php } else { ?>
<span id="el$rowindex$_view_test_aproveds_renew" class="el_view_test_aproveds_renew">
<span<?= $Grid->renew->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_renew_<?= $Grid->RowCount ?>" class="form-check-input" value="<?= $Grid->renew->ViewValue ?>" disabled<?php if (ConvertToBool($Grid->renew->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_renew_<?= $Grid->RowCount ?>"></label>
</div></span>
<input type="hidden" data-table="view_test_aproveds" data-field="x_renew" data-hidden="1" name="x<?= $Grid->RowIndex ?>_renew" id="x<?= $Grid->RowIndex ?>_renew" value="<?= HtmlEncode($Grid->renew->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="view_test_aproveds" data-field="x_renew" data-hidden="1" name="o<?= $Grid->RowIndex ?>_renew[]" id="o<?= $Grid->RowIndex ?>_renew[]" value="<?= HtmlEncode($Grid->renew->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->memberDOB->Visible) { // memberDOB ?>
        <td data-name="memberDOB">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_view_test_aproveds_memberDOB" class="el_view_test_aproveds_memberDOB">
<input type="<?= $Grid->memberDOB->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_memberDOB" id="x<?= $Grid->RowIndex ?>_memberDOB" data-table="view_test_aproveds" data-field="x_memberDOB" value="<?= $Grid->memberDOB->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Grid->memberDOB->getPlaceHolder()) ?>"<?= $Grid->memberDOB->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->memberDOB->getErrorMessage() ?></div>
<?php if (!$Grid->memberDOB->ReadOnly && !$Grid->memberDOB->Disabled && !isset($Grid->memberDOB->EditAttrs["readonly"]) && !isset($Grid->memberDOB->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fview_test_aprovedsgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fview_test_aprovedsgrid", "x<?= $Grid->RowIndex ?>_memberDOB", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_view_test_aproveds_memberDOB" class="el_view_test_aproveds_memberDOB">
<span<?= $Grid->memberDOB->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->memberDOB->getDisplayValue($Grid->memberDOB->ViewValue))) ?>"></span>
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberDOB" data-hidden="1" name="x<?= $Grid->RowIndex ?>_memberDOB" id="x<?= $Grid->RowIndex ?>_memberDOB" value="<?= HtmlEncode($Grid->memberDOB->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="view_test_aproveds" data-field="x_memberDOB" data-hidden="1" name="o<?= $Grid->RowIndex ?>_memberDOB" id="o<?= $Grid->RowIndex ?>_memberDOB" value="<?= HtmlEncode($Grid->memberDOB->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["fview_test_aprovedsgrid","load"], () => fview_test_aprovedsgrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="fview_test_aprovedsgrid">
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
    ew.addEventHandlers("view_test_aproveds");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
