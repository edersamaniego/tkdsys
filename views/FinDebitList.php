<?php

namespace PHPMaker2022\school;

// Page object
$FinDebitList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fin_debit: currentTable } });
var currentForm, currentPageID;
var ffin_debitlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffin_debitlist = new ew.Form("ffin_debitlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = ffin_debitlist;
    ffin_debitlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("ffin_debitlist");
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
</div>
<?php } ?>
<?php if (!$Page->isExport() || Config("EXPORT_MASTER_RECORD") && $Page->isExport("print")) { ?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "fin_accountspayable") {
    if ($Page->MasterRecordExists) {
        include_once "views/FinAccountspayableMaster.php";
    }
}
?>
<?php
if ($Page->DbMasterFilter != "" && $Page->getCurrentMasterTable() == "fin_checkingaccount") {
    if ($Page->MasterRecordExists) {
        include_once "views/FinCheckingaccountMaster.php";
    }
}
?>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> fin_debit">
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
<form name="ffin_debitlist" id="ffin_debitlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fin_debit">
<?php if ($Page->getCurrentMasterTable() == "fin_accountspayable" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fin_accountspayable">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->accountId->getSessionValue()) ?>">
<?php } ?>
<?php if ($Page->getCurrentMasterTable() == "fin_checkingaccount" && $Page->CurrentAction) { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="fin_checkingaccount">
<input type="hidden" name="fk_id" value="<?= HtmlEncode($Page->accountId->getSessionValue()) ?>">
<?php } ?>
<div id="gmp_fin_debit" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_fin_debitlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_fin_debit_id" class="fin_debit_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->dueDate->Visible) { // dueDate ?>
        <th data-name="dueDate" class="<?= $Page->dueDate->headerCellClass() ?>"><div id="elh_fin_debit_dueDate" class="fin_debit_dueDate"><?= $Page->renderFieldHeader($Page->dueDate) ?></div></th>
<?php } ?>
<?php if ($Page->value->Visible) { // value ?>
        <th data-name="value" class="<?= $Page->value->headerCellClass() ?>"><div id="elh_fin_debit_value" class="fin_debit_value"><?= $Page->renderFieldHeader($Page->value) ?></div></th>
<?php } ?>
<?php if ($Page->paymentMethod->Visible) { // paymentMethod ?>
        <th data-name="paymentMethod" class="<?= $Page->paymentMethod->headerCellClass() ?>"><div id="elh_fin_debit_paymentMethod" class="fin_debit_paymentMethod"><?= $Page->renderFieldHeader($Page->paymentMethod) ?></div></th>
<?php } ?>
<?php if ($Page->checkingAccountId->Visible) { // checkingAccountId ?>
        <th data-name="checkingAccountId" class="<?= $Page->checkingAccountId->headerCellClass() ?>"><div id="elh_fin_debit_checkingAccountId" class="fin_debit_checkingAccountId"><?= $Page->renderFieldHeader($Page->checkingAccountId) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_fin_debit",
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
<span id="el<?= $Page->RowCount ?>_fin_debit_id" class="el_fin_debit_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->dueDate->Visible) { // dueDate ?>
        <td data-name="dueDate"<?= $Page->dueDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_debit_dueDate" class="el_fin_debit_dueDate">
<span<?= $Page->dueDate->viewAttributes() ?>>
<?= $Page->dueDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->value->Visible) { // value ?>
        <td data-name="value"<?= $Page->value->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_debit_value" class="el_fin_debit_value">
<span<?= $Page->value->viewAttributes() ?>>
<?= $Page->value->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paymentMethod->Visible) { // paymentMethod ?>
        <td data-name="paymentMethod"<?= $Page->paymentMethod->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_debit_paymentMethod" class="el_fin_debit_paymentMethod">
<span<?= $Page->paymentMethod->viewAttributes() ?>>
<?= $Page->paymentMethod->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->checkingAccountId->Visible) { // checkingAccountId ?>
        <td data-name="checkingAccountId"<?= $Page->checkingAccountId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fin_debit_checkingAccountId" class="el_fin_debit_checkingAccountId">
<span<?= $Page->checkingAccountId->viewAttributes() ?>>
<?= $Page->checkingAccountId->getViewValue() ?></span>
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
    ew.addEventHandlers("fin_debit");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
