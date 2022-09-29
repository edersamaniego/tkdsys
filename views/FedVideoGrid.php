<?php

namespace PHPMaker2022\school;

// Set up and run Grid object
$Grid = Container("FedVideoGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var ffed_videogrid;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_videogrid = new ew.Form("ffed_videogrid", "grid");
    ffed_videogrid.formKeyCountName = "<?= $Grid->FormKeyCountName ?>";

    // Add fields
    var currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { fed_video: currentTable } });
    var fields = currentTable.fields;
    ffed_videogrid.addFields([
        ["_title", [fields._title.visible && fields._title.required ? ew.Validators.required(fields._title.caption) : null], fields._title.isInvalid],
        ["URL", [fields.URL.visible && fields.URL.required ? ew.Validators.required(fields.URL.caption) : null], fields.URL.isInvalid],
        ["section", [fields.section.visible && fields.section.required ? ew.Validators.required(fields.section.caption) : null], fields.section.isInvalid],
        ["subsection", [fields.subsection.visible && fields.subsection.required ? ew.Validators.required(fields.subsection.caption) : null], fields.subsection.isInvalid],
        ["createDate", [fields.createDate.visible && fields.createDate.required ? ew.Validators.required(fields.createDate.caption) : null, ew.Validators.datetime(fields.createDate.clientFormatPattern)], fields.createDate.isInvalid]
    ]);

    // Check empty row
    ffed_videogrid.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["_title",false],["URL",false],["section",false],["subsection",false],["createDate",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    ffed_videogrid.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffed_videogrid.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffed_videogrid.lists.section = <?= $Grid->section->toClientList($Grid) ?>;
    ffed_videogrid.lists.subsection = <?= $Grid->subsection->toClientList($Grid) ?>;
    loadjs.done("ffed_videogrid");
});
</script>
<?php } ?>
<?php
$Grid->renderOtherOptions();
?>
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Grid->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fed_video">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="ffed_videogrid" class="ew-form ew-list-form">
<div id="gmp_fed_video" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table id="tbl_fed_videogrid" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Grid->_title->Visible) { // title ?>
        <th data-name="_title" class="<?= $Grid->_title->headerCellClass() ?>"><div id="elh_fed_video__title" class="fed_video__title"><?= $Grid->renderFieldHeader($Grid->_title) ?></div></th>
<?php } ?>
<?php if ($Grid->URL->Visible) { // URL ?>
        <th data-name="URL" class="<?= $Grid->URL->headerCellClass() ?>"><div id="elh_fed_video_URL" class="fed_video_URL"><?= $Grid->renderFieldHeader($Grid->URL) ?></div></th>
<?php } ?>
<?php if ($Grid->section->Visible) { // section ?>
        <th data-name="section" class="<?= $Grid->section->headerCellClass() ?>"><div id="elh_fed_video_section" class="fed_video_section"><?= $Grid->renderFieldHeader($Grid->section) ?></div></th>
<?php } ?>
<?php if ($Grid->subsection->Visible) { // subsection ?>
        <th data-name="subsection" class="<?= $Grid->subsection->headerCellClass() ?>"><div id="elh_fed_video_subsection" class="fed_video_subsection"><?= $Grid->renderFieldHeader($Grid->subsection) ?></div></th>
<?php } ?>
<?php if ($Grid->createDate->Visible) { // createDate ?>
        <th data-name="createDate" class="<?= $Grid->createDate->headerCellClass() ?>"><div id="elh_fed_video_createDate" class="fed_video_createDate"><?= $Grid->renderFieldHeader($Grid->createDate) ?></div></th>
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
            "id" => "r" . $Grid->RowCount . "_fed_video",
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
    <?php if ($Grid->_title->Visible) { // title ?>
        <td data-name="_title"<?= $Grid->_title->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_video__title" class="el_fed_video__title">
<input type="<?= $Grid->_title->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__title" id="x<?= $Grid->RowIndex ?>__title" data-table="fed_video" data-field="x__title" value="<?= $Grid->_title->EditValue ?>" size="50" maxlength="255" placeholder="<?= HtmlEncode($Grid->_title->getPlaceHolder()) ?>"<?= $Grid->_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fed_video" data-field="x__title" data-hidden="1" name="o<?= $Grid->RowIndex ?>__title" id="o<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_video__title" class="el_fed_video__title">
<input type="<?= $Grid->_title->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__title" id="x<?= $Grid->RowIndex ?>__title" data-table="fed_video" data-field="x__title" value="<?= $Grid->_title->EditValue ?>" size="50" maxlength="255" placeholder="<?= HtmlEncode($Grid->_title->getPlaceHolder()) ?>"<?= $Grid->_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_title->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_video__title" class="el_fed_video__title">
<span<?= $Grid->_title->viewAttributes() ?>>
<?= $Grid->_title->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_video" data-field="x__title" data-hidden="1" name="ffed_videogrid$x<?= $Grid->RowIndex ?>__title" id="ffed_videogrid$x<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->FormValue) ?>">
<input type="hidden" data-table="fed_video" data-field="x__title" data-hidden="1" name="ffed_videogrid$o<?= $Grid->RowIndex ?>__title" id="ffed_videogrid$o<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->URL->Visible) { // URL ?>
        <td data-name="URL"<?= $Grid->URL->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_video_URL" class="el_fed_video_URL">
<input type="<?= $Grid->URL->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_URL" id="x<?= $Grid->RowIndex ?>_URL" data-table="fed_video" data-field="x_URL" value="<?= $Grid->URL->EditValue ?>" size="50" maxlength="255" placeholder="<?= HtmlEncode($Grid->URL->getPlaceHolder()) ?>"<?= $Grid->URL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->URL->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="fed_video" data-field="x_URL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_URL" id="o<?= $Grid->RowIndex ?>_URL" value="<?= HtmlEncode($Grid->URL->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_video_URL" class="el_fed_video_URL">
<input type="<?= $Grid->URL->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_URL" id="x<?= $Grid->RowIndex ?>_URL" data-table="fed_video" data-field="x_URL" value="<?= $Grid->URL->EditValue ?>" size="50" maxlength="255" placeholder="<?= HtmlEncode($Grid->URL->getPlaceHolder()) ?>"<?= $Grid->URL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->URL->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_video_URL" class="el_fed_video_URL">
<span><iframe src="https://player.vimeo.com/video/<?= CurrentPage()->URL->CurrentValue ?>" width="100%" height="100%" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
</span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_video" data-field="x_URL" data-hidden="1" name="ffed_videogrid$x<?= $Grid->RowIndex ?>_URL" id="ffed_videogrid$x<?= $Grid->RowIndex ?>_URL" value="<?= HtmlEncode($Grid->URL->FormValue) ?>">
<input type="hidden" data-table="fed_video" data-field="x_URL" data-hidden="1" name="ffed_videogrid$o<?= $Grid->RowIndex ?>_URL" id="ffed_videogrid$o<?= $Grid->RowIndex ?>_URL" value="<?= HtmlEncode($Grid->URL->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->section->Visible) { // section ?>
        <td data-name="section"<?= $Grid->section->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->section->getSessionValue() != "") { ?>
<span<?= $Grid->section->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->section->getDisplayValue($Grid->section->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_section" name="x<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fed_video_section" class="el_fed_video_section">
<template id="tp_x<?= $Grid->RowIndex ?>_section">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fed_video" data-field="x_section" name="x<?= $Grid->RowIndex ?>_section" id="x<?= $Grid->RowIndex ?>_section"<?= $Grid->section->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_section" class="ew-item-list"></div>
<?php $Grid->section->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_section"
    name="x<?= $Grid->RowIndex ?>_section"
    value="<?= HtmlEncode($Grid->section->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_section"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_section"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->section->isInvalidClass() ?>"
    data-table="fed_video"
    data-field="x_section"
    data-value-separator="<?= $Grid->section->displayValueSeparatorAttribute() ?>"
    <?= $Grid->section->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->section->getErrorMessage() ?></div>
<?= $Grid->section->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_section") ?>
</span>
<?php } ?>
<input type="hidden" data-table="fed_video" data-field="x_section" data-hidden="1" name="o<?= $Grid->RowIndex ?>_section" id="o<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->section->getSessionValue() != "") { ?>
<span<?= $Grid->section->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->section->getDisplayValue($Grid->section->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_section" name="x<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fed_video_section" class="el_fed_video_section">
<template id="tp_x<?= $Grid->RowIndex ?>_section">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fed_video" data-field="x_section" name="x<?= $Grid->RowIndex ?>_section" id="x<?= $Grid->RowIndex ?>_section"<?= $Grid->section->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_section" class="ew-item-list"></div>
<?php $Grid->section->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_section"
    name="x<?= $Grid->RowIndex ?>_section"
    value="<?= HtmlEncode($Grid->section->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_section"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_section"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->section->isInvalidClass() ?>"
    data-table="fed_video"
    data-field="x_section"
    data-value-separator="<?= $Grid->section->displayValueSeparatorAttribute() ?>"
    <?= $Grid->section->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->section->getErrorMessage() ?></div>
<?= $Grid->section->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_section") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_video_section" class="el_fed_video_section">
<span<?= $Grid->section->viewAttributes() ?>>
<?= $Grid->section->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_video" data-field="x_section" data-hidden="1" name="ffed_videogrid$x<?= $Grid->RowIndex ?>_section" id="ffed_videogrid$x<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->FormValue) ?>">
<input type="hidden" data-table="fed_video" data-field="x_section" data-hidden="1" name="ffed_videogrid$o<?= $Grid->RowIndex ?>_section" id="ffed_videogrid$o<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->subsection->Visible) { // subsection ?>
        <td data-name="subsection"<?= $Grid->subsection->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->subsection->getSessionValue() != "") { ?>
<span<?= $Grid->subsection->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->subsection->getDisplayValue($Grid->subsection->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_subsection" name="x<?= $Grid->RowIndex ?>_subsection" value="<?= HtmlEncode($Grid->subsection->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fed_video_subsection" class="el_fed_video_subsection">
<template id="tp_x<?= $Grid->RowIndex ?>_subsection">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fed_video" data-field="x_subsection" name="x<?= $Grid->RowIndex ?>_subsection" id="x<?= $Grid->RowIndex ?>_subsection"<?= $Grid->subsection->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_subsection" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_subsection"
    name="x<?= $Grid->RowIndex ?>_subsection"
    value="<?= HtmlEncode($Grid->subsection->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_subsection"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_subsection"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->subsection->isInvalidClass() ?>"
    data-table="fed_video"
    data-field="x_subsection"
    data-value-separator="<?= $Grid->subsection->displayValueSeparatorAttribute() ?>"
    <?= $Grid->subsection->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->subsection->getErrorMessage() ?></div>
<?= $Grid->subsection->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_subsection") ?>
</span>
<?php } ?>
<input type="hidden" data-table="fed_video" data-field="x_subsection" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subsection" id="o<?= $Grid->RowIndex ?>_subsection" value="<?= HtmlEncode($Grid->subsection->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->subsection->getSessionValue() != "") { ?>
<span<?= $Grid->subsection->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->subsection->getDisplayValue($Grid->subsection->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_subsection" name="x<?= $Grid->RowIndex ?>_subsection" value="<?= HtmlEncode($Grid->subsection->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_fed_video_subsection" class="el_fed_video_subsection">
<template id="tp_x<?= $Grid->RowIndex ?>_subsection">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fed_video" data-field="x_subsection" name="x<?= $Grid->RowIndex ?>_subsection" id="x<?= $Grid->RowIndex ?>_subsection"<?= $Grid->subsection->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_subsection" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_subsection"
    name="x<?= $Grid->RowIndex ?>_subsection"
    value="<?= HtmlEncode($Grid->subsection->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_subsection"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_subsection"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->subsection->isInvalidClass() ?>"
    data-table="fed_video"
    data-field="x_subsection"
    data-value-separator="<?= $Grid->subsection->displayValueSeparatorAttribute() ?>"
    <?= $Grid->subsection->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->subsection->getErrorMessage() ?></div>
<?= $Grid->subsection->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_subsection") ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_video_subsection" class="el_fed_video_subsection">
<span<?= $Grid->subsection->viewAttributes() ?>>
<?= $Grid->subsection->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_video" data-field="x_subsection" data-hidden="1" name="ffed_videogrid$x<?= $Grid->RowIndex ?>_subsection" id="ffed_videogrid$x<?= $Grid->RowIndex ?>_subsection" value="<?= HtmlEncode($Grid->subsection->FormValue) ?>">
<input type="hidden" data-table="fed_video" data-field="x_subsection" data-hidden="1" name="ffed_videogrid$o<?= $Grid->RowIndex ?>_subsection" id="ffed_videogrid$o<?= $Grid->RowIndex ?>_subsection" value="<?= HtmlEncode($Grid->subsection->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->createDate->Visible) { // createDate ?>
        <td data-name="createDate"<?= $Grid->createDate->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_fed_video_createDate" class="el_fed_video_createDate">
<input type="<?= $Grid->createDate->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_createDate" id="x<?= $Grid->RowIndex ?>_createDate" data-table="fed_video" data-field="x_createDate" value="<?= $Grid->createDate->EditValue ?>" placeholder="<?= HtmlEncode($Grid->createDate->getPlaceHolder()) ?>"<?= $Grid->createDate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->createDate->getErrorMessage() ?></div>
<?php if (!$Grid->createDate->ReadOnly && !$Grid->createDate->Disabled && !isset($Grid->createDate->EditAttrs["readonly"]) && !isset($Grid->createDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_videogrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_videogrid", "x<?= $Grid->RowIndex ?>_createDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="fed_video" data-field="x_createDate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_createDate" id="o<?= $Grid->RowIndex ?>_createDate" value="<?= HtmlEncode($Grid->createDate->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_fed_video_createDate" class="el_fed_video_createDate">
<input type="<?= $Grid->createDate->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_createDate" id="x<?= $Grid->RowIndex ?>_createDate" data-table="fed_video" data-field="x_createDate" value="<?= $Grid->createDate->EditValue ?>" placeholder="<?= HtmlEncode($Grid->createDate->getPlaceHolder()) ?>"<?= $Grid->createDate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->createDate->getErrorMessage() ?></div>
<?php if (!$Grid->createDate->ReadOnly && !$Grid->createDate->Disabled && !isset($Grid->createDate->EditAttrs["readonly"]) && !isset($Grid->createDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_videogrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_videogrid", "x<?= $Grid->RowIndex ?>_createDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_fed_video_createDate" class="el_fed_video_createDate">
<span<?= $Grid->createDate->viewAttributes() ?>>
<?= $Grid->createDate->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="fed_video" data-field="x_createDate" data-hidden="1" name="ffed_videogrid$x<?= $Grid->RowIndex ?>_createDate" id="ffed_videogrid$x<?= $Grid->RowIndex ?>_createDate" value="<?= HtmlEncode($Grid->createDate->FormValue) ?>">
<input type="hidden" data-table="fed_video" data-field="x_createDate" data-hidden="1" name="ffed_videogrid$o<?= $Grid->RowIndex ?>_createDate" id="ffed_videogrid$o<?= $Grid->RowIndex ?>_createDate" value="<?= HtmlEncode($Grid->createDate->OldValue) ?>">
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
loadjs.ready(["ffed_videogrid","load"], () => ffed_videogrid.updateLists(<?= $Grid->RowIndex ?>));
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
    $Grid->RowAttrs->merge(["data-rowindex" => $Grid->RowIndex, "id" => "r0_fed_video", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Grid->_title->Visible) { // title ?>
        <td data-name="_title">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_video__title" class="el_fed_video__title">
<input type="<?= $Grid->_title->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>__title" id="x<?= $Grid->RowIndex ?>__title" data-table="fed_video" data-field="x__title" value="<?= $Grid->_title->EditValue ?>" size="50" maxlength="255" placeholder="<?= HtmlEncode($Grid->_title->getPlaceHolder()) ?>"<?= $Grid->_title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->_title->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_video__title" class="el_fed_video__title">
<span<?= $Grid->_title->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->_title->getDisplayValue($Grid->_title->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_video" data-field="x__title" data-hidden="1" name="x<?= $Grid->RowIndex ?>__title" id="x<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_video" data-field="x__title" data-hidden="1" name="o<?= $Grid->RowIndex ?>__title" id="o<?= $Grid->RowIndex ?>__title" value="<?= HtmlEncode($Grid->_title->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->URL->Visible) { // URL ?>
        <td data-name="URL">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_video_URL" class="el_fed_video_URL">
<input type="<?= $Grid->URL->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_URL" id="x<?= $Grid->RowIndex ?>_URL" data-table="fed_video" data-field="x_URL" value="<?= $Grid->URL->EditValue ?>" size="50" maxlength="255" placeholder="<?= HtmlEncode($Grid->URL->getPlaceHolder()) ?>"<?= $Grid->URL->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->URL->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_video_URL" class="el_fed_video_URL">
<span>
<?= GetImageViewTag($Grid->URL, $Grid->URL->ViewValue) ?></span>
<input type="hidden" data-table="fed_video" data-field="x_URL" data-hidden="1" name="x<?= $Grid->RowIndex ?>_URL" id="x<?= $Grid->RowIndex ?>_URL" value="<?= HtmlEncode($Grid->URL->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_video" data-field="x_URL" data-hidden="1" name="o<?= $Grid->RowIndex ?>_URL" id="o<?= $Grid->RowIndex ?>_URL" value="<?= HtmlEncode($Grid->URL->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->section->Visible) { // section ?>
        <td data-name="section">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->section->getSessionValue() != "") { ?>
<span<?= $Grid->section->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->section->getDisplayValue($Grid->section->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_section" name="x<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_fed_video_section" class="el_fed_video_section">
<template id="tp_x<?= $Grid->RowIndex ?>_section">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fed_video" data-field="x_section" name="x<?= $Grid->RowIndex ?>_section" id="x<?= $Grid->RowIndex ?>_section"<?= $Grid->section->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_section" class="ew-item-list"></div>
<?php $Grid->section->EditAttrs->prepend("onchange", "ew.updateOptions.call(this);"); ?>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_section"
    name="x<?= $Grid->RowIndex ?>_section"
    value="<?= HtmlEncode($Grid->section->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_section"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_section"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->section->isInvalidClass() ?>"
    data-table="fed_video"
    data-field="x_section"
    data-value-separator="<?= $Grid->section->displayValueSeparatorAttribute() ?>"
    <?= $Grid->section->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->section->getErrorMessage() ?></div>
<?= $Grid->section->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_section") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_fed_video_section" class="el_fed_video_section">
<span<?= $Grid->section->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->section->getDisplayValue($Grid->section->ViewValue) ?></span></span>
<input type="hidden" data-table="fed_video" data-field="x_section" data-hidden="1" name="x<?= $Grid->RowIndex ?>_section" id="x<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_video" data-field="x_section" data-hidden="1" name="o<?= $Grid->RowIndex ?>_section" id="o<?= $Grid->RowIndex ?>_section" value="<?= HtmlEncode($Grid->section->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->subsection->Visible) { // subsection ?>
        <td data-name="subsection">
<?php if (!$Grid->isConfirm()) { ?>
<?php if ($Grid->subsection->getSessionValue() != "") { ?>
<span<?= $Grid->subsection->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->subsection->getDisplayValue($Grid->subsection->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_subsection" name="x<?= $Grid->RowIndex ?>_subsection" value="<?= HtmlEncode($Grid->subsection->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el$rowindex$_fed_video_subsection" class="el_fed_video_subsection">
<template id="tp_x<?= $Grid->RowIndex ?>_subsection">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="fed_video" data-field="x_subsection" name="x<?= $Grid->RowIndex ?>_subsection" id="x<?= $Grid->RowIndex ?>_subsection"<?= $Grid->subsection->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Grid->RowIndex ?>_subsection" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Grid->RowIndex ?>_subsection"
    name="x<?= $Grid->RowIndex ?>_subsection"
    value="<?= HtmlEncode($Grid->subsection->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Grid->RowIndex ?>_subsection"
    data-bs-target="dsl_x<?= $Grid->RowIndex ?>_subsection"
    data-repeatcolumn="5"
    class="form-control<?= $Grid->subsection->isInvalidClass() ?>"
    data-table="fed_video"
    data-field="x_subsection"
    data-value-separator="<?= $Grid->subsection->displayValueSeparatorAttribute() ?>"
    <?= $Grid->subsection->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Grid->subsection->getErrorMessage() ?></div>
<?= $Grid->subsection->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_subsection") ?>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_fed_video_subsection" class="el_fed_video_subsection">
<span<?= $Grid->subsection->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->subsection->getDisplayValue($Grid->subsection->ViewValue) ?></span></span>
<input type="hidden" data-table="fed_video" data-field="x_subsection" data-hidden="1" name="x<?= $Grid->RowIndex ?>_subsection" id="x<?= $Grid->RowIndex ?>_subsection" value="<?= HtmlEncode($Grid->subsection->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_video" data-field="x_subsection" data-hidden="1" name="o<?= $Grid->RowIndex ?>_subsection" id="o<?= $Grid->RowIndex ?>_subsection" value="<?= HtmlEncode($Grid->subsection->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Grid->createDate->Visible) { // createDate ?>
        <td data-name="createDate">
<?php if (!$Grid->isConfirm()) { ?>
<span id="el$rowindex$_fed_video_createDate" class="el_fed_video_createDate">
<input type="<?= $Grid->createDate->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_createDate" id="x<?= $Grid->RowIndex ?>_createDate" data-table="fed_video" data-field="x_createDate" value="<?= $Grid->createDate->EditValue ?>" placeholder="<?= HtmlEncode($Grid->createDate->getPlaceHolder()) ?>"<?= $Grid->createDate->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->createDate->getErrorMessage() ?></div>
<?php if (!$Grid->createDate->ReadOnly && !$Grid->createDate->Disabled && !isset($Grid->createDate->EditAttrs["readonly"]) && !isset($Grid->createDate->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["ffed_videogrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("ffed_videogrid", "x<?= $Grid->RowIndex ?>_createDate", ew.deepAssign({"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_fed_video_createDate" class="el_fed_video_createDate">
<span<?= $Grid->createDate->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->createDate->getDisplayValue($Grid->createDate->ViewValue))) ?>"></span>
<input type="hidden" data-table="fed_video" data-field="x_createDate" data-hidden="1" name="x<?= $Grid->RowIndex ?>_createDate" id="x<?= $Grid->RowIndex ?>_createDate" value="<?= HtmlEncode($Grid->createDate->FormValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="fed_video" data-field="x_createDate" data-hidden="1" name="o<?= $Grid->RowIndex ?>_createDate" id="o<?= $Grid->RowIndex ?>_createDate" value="<?= HtmlEncode($Grid->createDate->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowIndex);
?>
<script>
loadjs.ready(["ffed_videogrid","load"], () => ffed_videogrid.updateLists(<?= $Grid->RowIndex ?>, true));
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
<input type="hidden" name="detailpage" value="ffed_videogrid">
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
    ew.addEventHandlers("fed_video");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
