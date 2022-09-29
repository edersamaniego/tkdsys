<?php

namespace PHPMaker2022\school;

// Page object
$ConfTesttypeView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_testtype: currentTable } });
var currentForm, currentPageID;
var fconf_testtypeview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_testtypeview = new ew.Form("fconf_testtypeview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fconf_testtypeview;
    loadjs.done("fconf_testtypeview");
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
<form name="fconf_testtypeview" id="fconf_testtypeview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_testtype">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_testtype_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_conf_testtype_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testType->Visible) { // testType ?>
    <tr id="r_testType"<?= $Page->testType->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_testtype_testType"><?= $Page->testType->caption() ?></span></td>
        <td data-name="testType"<?= $Page->testType->cellAttributes() ?>>
<span id="el_conf_testtype_testType">
<span<?= $Page->testType->viewAttributes() ?>>
<?= $Page->testType->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testTypeEN->Visible) { // testTypeEN ?>
    <tr id="r_testTypeEN"<?= $Page->testTypeEN->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_testtype_testTypeEN"><?= $Page->testTypeEN->caption() ?></span></td>
        <td data-name="testTypeEN"<?= $Page->testTypeEN->cellAttributes() ?>>
<span id="el_conf_testtype_testTypeEN">
<span<?= $Page->testTypeEN->viewAttributes() ?>>
<?= $Page->testTypeEN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->testTypeES->Visible) { // testTypeES ?>
    <tr id="r_testTypeES"<?= $Page->testTypeES->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_testtype_testTypeES"><?= $Page->testTypeES->caption() ?></span></td>
        <td data-name="testTypeES"<?= $Page->testTypeES->cellAttributes() ?>>
<span id="el_conf_testtype_testTypeES">
<span<?= $Page->testTypeES->viewAttributes() ?>>
<?= $Page->testTypeES->getViewValue() ?></span>
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
