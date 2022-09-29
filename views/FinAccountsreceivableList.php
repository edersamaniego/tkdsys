<?php

namespace PHPMaker2022\school;

// Page object
$FinAccountsreceivableList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_accountsreceivable: currentTable } });
var currentForm, currentPageID;
var ffin_accountsreceivablelist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_accountsreceivablelist = new ew.Form("ffin_accountsreceivablelist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = ffin_accountsreceivablelist;
    ffin_accountsreceivablelist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("ffin_accountsreceivablelist");
});
var ffin_accountsreceivablesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    ffin_accountsreceivablesrch = new ew.Form("ffin_accountsreceivablesrch", "list");
    currentSearchForm = ffin_accountsreceivablesrch;

    // Add fields
    var fields = currentTable.fields;
    ffin_accountsreceivablesrch.addFields([
        ["id", [], fields.id.isInvalid],
        ["issue", [], fields.issue.isInvalid],
        ["due", [], fields.due.isInvalid],
        ["income", [], fields.income.isInvalid],
        ["status", [], fields.status.isInvalid],
        ["value", [], fields.value.isInvalid],
        ["orderId", [], fields.orderId.isInvalid],
        ["balance", [], fields.balance.isInvalid],
        ["debtorId", [], fields.debtorId.isInvalid],
        ["licenseId", [], fields.licenseId.isInvalid]
    ]);

    // Validate form
    ffin_accountsreceivablesrch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm();

        // Validate fields
        if (!this.validateFields())
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    ffin_accountsreceivablesrch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    ffin_accountsreceivablesrch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    ffin_accountsreceivablesrch.lists.income = <?= $Page->income->toClientList($Page) ?>;

    // Filters
    ffin_accountsreceivablesrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("ffin_accountsreceivablesrch");
});
</script>
<script>
ew.PREVIEW_SELECTOR = ".ew-preview-btn";
ew.PREVIEW_ROW = true;
ew.PREVIEW_SINGLE_ROW = false;
ew.ready("head", ew.PATH_BASE + "js/preview.min.js", "preview");
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="ffin_accountsreceivablesrch" id="ffin_accountsreceivablesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="ffin_accountsreceivablesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="fin_accountsreceivable">
<div class="ew-extended-search container-fluid">
<div class="row mb-0<?= ($Page->SearchFieldsPerRow > 0) ? " row-cols-sm-" . $Page->SearchFieldsPerRow : "" ?>">
<?php
// Render search row
$Page->RowType = ROWTYPE_SEARCH;
$Page->resetAttributes();
$Page->renderRow();
?>
<?php if ($Page->income->Visible) { // income ?>
<?php
if (!$Page->income->UseFilter) {
    $Page->SearchColumnCount++;
}
?>
    <div id="xs_income" class="col-sm-auto d-sm-flex mb-3 px-0 pe-sm-2<?= $Page->income->UseFilter ? " ew-filter-field" : "" ?>">
        <div class="d-flex my-1 my-sm-0">
            <label for="x_income" class="ew-search-caption ew-label"><?= $Page->income->caption() ?></label>
            <div class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_income" id="z_income" value="=">
</div>
        </div>
        <div id="el_fin_accountsreceivable_income" class="ew-search-field">
<input type="<?= $Page->income->getInputTextType() ?>" name="x_income" id="x_income" data-table="fin_accountsreceivable" data-field="x_income" value="<?= $Page->income->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->income->getPlaceHolder()) ?>"<?= $Page->income->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->income->getErrorMessage(false) ?></div>
<?= $Page->income->Lookup->getParamTag($Page, "p_x_income") ?>
</div>
        <div class="d-flex my-1 my-sm-0">
        </div><!-- /.ew-search-field -->
    </div><!-- /.col-sm-auto -->
<?php } ?>
<?php if ($Page->SearchColumnCount > 0) { ?>
   <div class="col-sm-auto mb-3">
       <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
   </div>
<?php } ?>
</div><!-- /.row -->
</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fin_accountsreceivable">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="ffin_accountsreceivablelist" id="ffin_accountsreceivablelist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_accountsreceivable">
<div id="gmp_fin_accountsreceivable" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_fin_accountsreceivablelist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id->Visible) { // id ?>
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_fin_accountsreceivable_id" class="fin_accountsreceivable_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->issue->Visible) { // issue ?>
        <th data-name="issue" class="<?= $Page->issue->headerCellClass() ?>"><div id="elh_fin_accountsreceivable_issue" class="fin_accountsreceivable_issue"><?= $Page->renderFieldHeader($Page->issue) ?></div></th>
<?php } ?>
<?php if ($Page->due->Visible) { // due ?>
        <th data-name="due" class="<?= $Page->due->headerCellClass() ?>"><div id="elh_fin_accountsreceivable_due" class="fin_accountsreceivable_due"><?= $Page->renderFieldHeader($Page->due) ?></div></th>
<?php } ?>
<?php if ($Page->income->Visible) { // income ?>
        <th data-name="income" class="<?= $Page->income->headerCellClass() ?>"><div id="elh_fin_accountsreceivable_income" class="fin_accountsreceivable_income"><?= $Page->renderFieldHeader($Page->income) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_fin_accountsreceivable_status" class="fin_accountsreceivable_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
        <th data-name="value" class="<?= $Page->value->headerCellClass() ?>"><div id="elh_fin_accountsreceivable_value" class="fin_accountsreceivable_value"><?= $Page->renderFieldHeader($Page->value) ?></div></th>
<?php } ?>
<?php if ($Page->orderId->Visible) { // orderId ?>
        <th data-name="orderId" class="<?= $Page->orderId->headerCellClass() ?>"><div id="elh_fin_accountsreceivable_orderId" class="fin_accountsreceivable_orderId"><?= $Page->renderFieldHeader($Page->orderId) ?></div></th>
<?php } ?>
<?php if ($Page->balance->Visible) { // balance ?>
        <th data-name="balance" class="<?= $Page->balance->headerCellClass() ?>"><div id="elh_fin_accountsreceivable_balance" class="fin_accountsreceivable_balance"><?= $Page->renderFieldHeader($Page->balance) ?></div></th>
<?php } ?>
<?php if ($Page->debtorId->Visible) { // debtorId ?>
        <th data-name="debtorId" class="<?= $Page->debtorId->headerCellClass() ?>"><div id="elh_fin_accountsreceivable_debtorId" class="fin_accountsreceivable_debtorId"><?= $Page->renderFieldHeader($Page->debtorId) ?></div></th>
<?php } ?>
<?php if ($Page->licenseId->Visible) { // licenseId ?>
        <th data-name="licenseId" class="<?= $Page->licenseId->headerCellClass() ?>"><div id="elh_fin_accountsreceivable_licenseId" class="fin_accountsreceivable_licenseId"><?= $Page->renderFieldHeader($Page->licenseId) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif ($Page->isGridAdd() && !$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row attributes
        $Page->RowAttrs->merge([
            "data-rowindex" => $Page->RowCount,
            "id" => "r" . $Page->RowCount . "_fin_accountsreceivable",
            "data-rowtype" => $Page->RowType,
            "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Page->isAdd() && $Page->RowType == ROWTYPE_ADD || $Page->isEdit() && $Page->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Page->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id->Visible) { // id ?>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_id" class="el_fin_accountsreceivable_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->issue->Visible) { // issue ?>
        <td data-name="issue"<?= $Page->issue->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_issue" class="el_fin_accountsreceivable_issue">
<span<?= $Page->issue->viewAttributes() ?>>
<?= $Page->issue->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->due->Visible) { // due ?>
        <td data-name="due"<?= $Page->due->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_due" class="el_fin_accountsreceivable_due">
<span<?= $Page->due->viewAttributes() ?>>
<?= $Page->due->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->income->Visible) { // income ?>
        <td data-name="income"<?= $Page->income->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_income" class="el_fin_accountsreceivable_income">
<span<?= $Page->income->viewAttributes() ?>>
<?= $Page->income->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_status" class="el_fin_accountsreceivable_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->value->Visible) { // value ?>
        <td data-name="value"<?= $Page->value->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_value" class="el_fin_accountsreceivable_value">
<span<?= $Page->value->viewAttributes() ?>>
<?= $Page->value->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->orderId->Visible) { // orderId ?>
        <td data-name="orderId"<?= $Page->orderId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_orderId" class="el_fin_accountsreceivable_orderId">
<span<?= $Page->orderId->viewAttributes() ?>>
<?= $Page->orderId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->balance->Visible) { // balance ?>
        <td data-name="balance"<?= $Page->balance->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_balance" class="el_fin_accountsreceivable_balance">
<span<?= $Page->balance->viewAttributes() ?>>
<?= $Page->balance->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->debtorId->Visible) { // debtorId ?>
        <td data-name="debtorId"<?= $Page->debtorId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_debtorId" class="el_fin_accountsreceivable_debtorId">
<span<?= $Page->debtorId->viewAttributes() ?>>
<?= $Page->debtorId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->licenseId->Visible) { // licenseId ?>
        <td data-name="licenseId"<?= $Page->licenseId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_accountsreceivable_licenseId" class="el_fin_accountsreceivable_licenseId">
<span<?= $Page->licenseId->viewAttributes() ?>>
<?= $Page->licenseId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("fin_accountsreceivable");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
