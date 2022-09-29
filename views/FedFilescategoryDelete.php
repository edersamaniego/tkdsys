<?php

namespace PHPMaker2022\school;

// Page object
$FedFilescategoryDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_filescategory: currentTable } });
var currentForm, currentPageID;
var ffed_filescategorydelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_filescategorydelete = new ew.Form("ffed_filescategorydelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = ffed_filescategorydelete;
    loadjs.done("ffed_filescategorydelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ffed_filescategorydelete" id="ffed_filescategorydelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_filescategory">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table table-bordered table-hover table-sm ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_fed_filescategory_id" class="fed_filescategory_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->category->Visible) { // category ?>
        <th class="<?= $Page->category->headerCellClass() ?>"><span id="elh_fed_filescategory_category" class="fed_filescategory_category"><?= $Page->category->caption() ?></span></th>
<?php } ?>
<?php if ($Page->categoryBr->Visible) { // categoryBr ?>
        <th class="<?= $Page->categoryBr->headerCellClass() ?>"><span id="elh_fed_filescategory_categoryBr" class="fed_filescategory_categoryBr"><?= $Page->categoryBr->caption() ?></span></th>
<?php } ?>
<?php if ($Page->categorySp->Visible) { // categorySp ?>
        <th class="<?= $Page->categorySp->headerCellClass() ?>"><span id="elh_fed_filescategory_categorySp" class="fed_filescategory_categorySp"><?= $Page->categorySp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_userId->Visible) { // userId ?>
        <th class="<?= $Page->_userId->headerCellClass() ?>"><span id="elh_fed_filescategory__userId" class="fed_filescategory__userId"><?= $Page->_userId->caption() ?></span></th>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <th class="<?= $Page->createDate->headerCellClass() ?>"><span id="elh_fed_filescategory_createDate" class="fed_filescategory_createDate"><?= $Page->createDate->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_filescategory_id" class="el_fed_filescategory_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->category->Visible) { // category ?>
        <td<?= $Page->category->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_filescategory_category" class="el_fed_filescategory_category">
<span<?= $Page->category->viewAttributes() ?>>
<?= $Page->category->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->categoryBr->Visible) { // categoryBr ?>
        <td<?= $Page->categoryBr->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_filescategory_categoryBr" class="el_fed_filescategory_categoryBr">
<span<?= $Page->categoryBr->viewAttributes() ?>>
<?= $Page->categoryBr->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->categorySp->Visible) { // categorySp ?>
        <td<?= $Page->categorySp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_filescategory_categorySp" class="el_fed_filescategory_categorySp">
<span<?= $Page->categorySp->viewAttributes() ?>>
<?= $Page->categorySp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_userId->Visible) { // userId ?>
        <td<?= $Page->_userId->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_filescategory__userId" class="el_fed_filescategory__userId">
<span<?= $Page->_userId->viewAttributes() ?>>
<?= $Page->_userId->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
        <td<?= $Page->createDate->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_fed_filescategory_createDate" class="el_fed_filescategory_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
