<?php

namespace PHPMaker2022\school;

// Page object
$TesResultamountList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { tes_resultamount: currentTable } });
var currentForm, currentPageID;
var ftes_resultamountlist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ftes_resultamountlist = new ew.Form("ftes_resultamountlist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = ftes_resultamountlist;
    ftes_resultamountlist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";
    loadjs.done("ftes_resultamountlist");
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
<?php
$Page->renderOtherOptions();
?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> tes_resultamount">
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
<form name="ftes_resultamountlist" id="ftes_resultamountlist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="tes_resultamount">
<div id="gmp_tes_resultamount" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_tes_resultamountlist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="id" class="<?= $Page->id->headerCellClass() ?>"><div id="elh_tes_resultamount_id" class="tes_resultamount_id"><?= $Page->renderFieldHeader($Page->id) ?></div></th>
<?php } ?>
<?php if ($Page->federationId->Visible) { // federationId ?>
        <th data-name="federationId" class="<?= $Page->federationId->headerCellClass() ?>"><div id="elh_tes_resultamount_federationId" class="tes_resultamount_federationId"><?= $Page->renderFieldHeader($Page->federationId) ?></div></th>
<?php } ?>
<?php if ($Page->schoolId->Visible) { // schoolId ?>
        <th data-name="schoolId" class="<?= $Page->schoolId->headerCellClass() ?>"><div id="elh_tes_resultamount_schoolId" class="tes_resultamount_schoolId"><?= $Page->renderFieldHeader($Page->schoolId) ?></div></th>
<?php } ?>
<?php if ($Page->testId->Visible) { // testId ?>
        <th data-name="testId" class="<?= $Page->testId->headerCellClass() ?>"><div id="elh_tes_resultamount_testId" class="tes_resultamount_testId"><?= $Page->renderFieldHeader($Page->testId) ?></div></th>
<?php } ?>
<?php if ($Page->sendingDate->Visible) { // sendingDate ?>
        <th data-name="sendingDate" class="<?= $Page->sendingDate->headerCellClass() ?>"><div id="elh_tes_resultamount_sendingDate" class="tes_resultamount_sendingDate"><?= $Page->renderFieldHeader($Page->sendingDate) ?></div></th>
<?php } ?>
<?php if ($Page->paymentDate->Visible) { // paymentDate ?>
        <th data-name="paymentDate" class="<?= $Page->paymentDate->headerCellClass() ?>"><div id="elh_tes_resultamount_paymentDate" class="tes_resultamount_paymentDate"><?= $Page->renderFieldHeader($Page->paymentDate) ?></div></th>
<?php } ?>
<?php if ($Page->printingDate->Visible) { // printingDate ?>
        <th data-name="printingDate" class="<?= $Page->printingDate->headerCellClass() ?>"><div id="elh_tes_resultamount_printingDate" class="tes_resultamount_printingDate"><?= $Page->renderFieldHeader($Page->printingDate) ?></div></th>
<?php } ?>
<?php if ($Page->shippedDate->Visible) { // shippedDate ?>
        <th data-name="shippedDate" class="<?= $Page->shippedDate->headerCellClass() ?>"><div id="elh_tes_resultamount_shippedDate" class="tes_resultamount_shippedDate"><?= $Page->renderFieldHeader($Page->shippedDate) ?></div></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th data-name="status" class="<?= $Page->status->headerCellClass() ?>"><div id="elh_tes_resultamount_status" class="tes_resultamount_status"><?= $Page->renderFieldHeader($Page->status) ?></div></th>
<?php } ?>
<?php if ($Page->createUserId->Visible) { // createUserId ?>
        <th data-name="createUserId" class="<?= $Page->createUserId->headerCellClass() ?>"><div id="elh_tes_resultamount_createUserId" class="tes_resultamount_createUserId"><?= $Page->renderFieldHeader($Page->createUserId) ?></div></th>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <th data-name="createDate" class="<?= $Page->createDate->headerCellClass() ?>"><div id="elh_tes_resultamount_createDate" class="tes_resultamount_createDate"><?= $Page->renderFieldHeader($Page->createDate) ?></div></th>
<?php } ?>
<?php if ($Page->totalAmount->Visible) { // totalAmount ?>
        <th data-name="totalAmount" class="<?= $Page->totalAmount->headerCellClass() ?>"><div id="elh_tes_resultamount_totalAmount" class="tes_resultamount_totalAmount"><?= $Page->renderFieldHeader($Page->totalAmount) ?></div></th>
<?php } ?>
<?php if ($Page->paymentId->Visible) { // paymentId ?>
        <th data-name="paymentId" class="<?= $Page->paymentId->headerCellClass() ?>"><div id="elh_tes_resultamount_paymentId" class="tes_resultamount_paymentId"><?= $Page->renderFieldHeader($Page->paymentId) ?></div></th>
<?php } ?>
<?php if ($Page->totalValue->Visible) { // totalValue ?>
        <th data-name="totalValue" class="<?= $Page->totalValue->headerCellClass() ?>"><div id="elh_tes_resultamount_totalValue" class="tes_resultamount_totalValue"><?= $Page->renderFieldHeader($Page->totalValue) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_tes_resultamount",
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
<span id="el<?= $Page->RowCount ?>_tes_resultamount_id" class="el_tes_resultamount_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->federationId->Visible) { // federationId ?>
        <td data-name="federationId"<?= $Page->federationId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_federationId" class="el_tes_resultamount_federationId">
<span<?= $Page->federationId->viewAttributes() ?>>
<?= $Page->federationId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->schoolId->Visible) { // schoolId ?>
        <td data-name="schoolId"<?= $Page->schoolId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_schoolId" class="el_tes_resultamount_schoolId">
<span<?= $Page->schoolId->viewAttributes() ?>>
<?= $Page->schoolId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->testId->Visible) { // testId ?>
        <td data-name="testId"<?= $Page->testId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_testId" class="el_tes_resultamount_testId">
<span<?= $Page->testId->viewAttributes() ?>>
<?= $Page->testId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->sendingDate->Visible) { // sendingDate ?>
        <td data-name="sendingDate"<?= $Page->sendingDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_sendingDate" class="el_tes_resultamount_sendingDate">
<span<?= $Page->sendingDate->viewAttributes() ?>>
<?= $Page->sendingDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paymentDate->Visible) { // paymentDate ?>
        <td data-name="paymentDate"<?= $Page->paymentDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_paymentDate" class="el_tes_resultamount_paymentDate">
<span<?= $Page->paymentDate->viewAttributes() ?>>
<?= $Page->paymentDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->printingDate->Visible) { // printingDate ?>
        <td data-name="printingDate"<?= $Page->printingDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_printingDate" class="el_tes_resultamount_printingDate">
<span<?= $Page->printingDate->viewAttributes() ?>>
<?= $Page->printingDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->shippedDate->Visible) { // shippedDate ?>
        <td data-name="shippedDate"<?= $Page->shippedDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_shippedDate" class="el_tes_resultamount_shippedDate">
<span<?= $Page->shippedDate->viewAttributes() ?>>
<?= $Page->shippedDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->status->Visible) { // status ?>
        <td data-name="status"<?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_status" class="el_tes_resultamount_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->createUserId->Visible) { // createUserId ?>
        <td data-name="createUserId"<?= $Page->createUserId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_createUserId" class="el_tes_resultamount_createUserId">
<span<?= $Page->createUserId->viewAttributes() ?>>
<?= $Page->createUserId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->createDate->Visible) { // createDate ?>
        <td data-name="createDate"<?= $Page->createDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_createDate" class="el_tes_resultamount_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totalAmount->Visible) { // totalAmount ?>
        <td data-name="totalAmount"<?= $Page->totalAmount->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_totalAmount" class="el_tes_resultamount_totalAmount">
<span<?= $Page->totalAmount->viewAttributes() ?>>
<?= $Page->totalAmount->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->paymentId->Visible) { // paymentId ?>
        <td data-name="paymentId"<?= $Page->paymentId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_paymentId" class="el_tes_resultamount_paymentId">
<span<?= $Page->paymentId->viewAttributes() ?>>
<?= $Page->paymentId->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->totalValue->Visible) { // totalValue ?>
        <td data-name="totalValue"<?= $Page->totalValue->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_tes_resultamount_totalValue" class="el_tes_resultamount_totalValue">
<span<?= $Page->totalValue->viewAttributes() ?>>
<?= $Page->totalValue->getViewValue() ?></span>
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
    ew.addEventHandlers("tes_resultamount");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
