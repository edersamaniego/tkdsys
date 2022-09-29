<?php

namespace PHPMaker2022\school;

// Page object
$FedFilescategoryView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_filescategory: currentTable } });
var currentForm, currentPageID;
var ffed_filescategoryview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_filescategoryview = new ew.Form("ffed_filescategoryview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ffed_filescategoryview;
    loadjs.done("ffed_filescategoryview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<?php } ?>
<form name="ffed_filescategoryview" id="ffed_filescategoryview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_filescategory">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_filescategory_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_fed_filescategory_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->category->Visible) { // category ?>
    <tr id="r_category"<?= $Page->category->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_filescategory_category"><?= $Page->category->caption() ?></span></td>
        <td data-name="category"<?= $Page->category->cellAttributes() ?>>
<span id="el_fed_filescategory_category">
<span<?= $Page->category->viewAttributes() ?>>
<?= $Page->category->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->categoryBr->Visible) { // categoryBr ?>
    <tr id="r_categoryBr"<?= $Page->categoryBr->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_filescategory_categoryBr"><?= $Page->categoryBr->caption() ?></span></td>
        <td data-name="categoryBr"<?= $Page->categoryBr->cellAttributes() ?>>
<span id="el_fed_filescategory_categoryBr">
<span<?= $Page->categoryBr->viewAttributes() ?>>
<?= $Page->categoryBr->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->categorySp->Visible) { // categorySp ?>
    <tr id="r_categorySp"<?= $Page->categorySp->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_filescategory_categorySp"><?= $Page->categorySp->caption() ?></span></td>
        <td data-name="categorySp"<?= $Page->categorySp->cellAttributes() ?>>
<span id="el_fed_filescategory_categorySp">
<span<?= $Page->categorySp->viewAttributes() ?>>
<?= $Page->categorySp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_userId->Visible) { // userId ?>
    <tr id="r__userId"<?= $Page->_userId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_filescategory__userId"><?= $Page->_userId->caption() ?></span></td>
        <td data-name="_userId"<?= $Page->_userId->cellAttributes() ?>>
<span id="el_fed_filescategory__userId">
<span<?= $Page->_userId->viewAttributes() ?>>
<?= $Page->_userId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->createDate->Visible) { // createDate ?>
    <tr id="r_createDate"<?= $Page->createDate->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_filescategory_createDate"><?= $Page->createDate->caption() ?></span></td>
        <td data-name="createDate"<?= $Page->createDate->cellAttributes() ?>>
<span id="el_fed_filescategory_createDate">
<span<?= $Page->createDate->viewAttributes() ?>>
<?= $Page->createDate->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
