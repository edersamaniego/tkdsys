<?php

namespace PHPMaker2022\school;

// Page object
$ConfScholarityView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_scholarity: currentTable } });
var currentForm, currentPageID;
var fconf_scholarityview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_scholarityview = new ew.Form("fconf_scholarityview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fconf_scholarityview;
    loadjs.done("fconf_scholarityview");
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
<form name="fconf_scholarityview" id="fconf_scholarityview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_scholarity">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_scholarity_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_conf_scholarity_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->escolarityBR->Visible) { // escolarityBR ?>
    <tr id="r_escolarityBR"<?= $Page->escolarityBR->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_scholarity_escolarityBR"><?= $Page->escolarityBR->caption() ?></span></td>
        <td data-name="escolarityBR"<?= $Page->escolarityBR->cellAttributes() ?>>
<span id="el_conf_scholarity_escolarityBR">
<span<?= $Page->escolarityBR->viewAttributes() ?>>
<?= $Page->escolarityBR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->escolarityEN->Visible) { // escolarityEN ?>
    <tr id="r_escolarityEN"<?= $Page->escolarityEN->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_scholarity_escolarityEN"><?= $Page->escolarityEN->caption() ?></span></td>
        <td data-name="escolarityEN"<?= $Page->escolarityEN->cellAttributes() ?>>
<span id="el_conf_scholarity_escolarityEN">
<span<?= $Page->escolarityEN->viewAttributes() ?>>
<?= $Page->escolarityEN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->escolaritySP->Visible) { // escolaritySP ?>
    <tr id="r_escolaritySP"<?= $Page->escolaritySP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_scholarity_escolaritySP"><?= $Page->escolaritySP->caption() ?></span></td>
        <td data-name="escolaritySP"<?= $Page->escolaritySP->cellAttributes() ?>>
<span id="el_conf_scholarity_escolaritySP">
<span<?= $Page->escolaritySP->viewAttributes() ?>>
<?= $Page->escolaritySP->getViewValue() ?></span>
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
