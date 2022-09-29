<?php

namespace PHPMaker2022\school;

// Page object
$ConfMarketingsourceView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_marketingsource: currentTable } });
var currentForm, currentPageID;
var fconf_marketingsourceview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_marketingsourceview = new ew.Form("fconf_marketingsourceview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fconf_marketingsourceview;
    loadjs.done("fconf_marketingsourceview");
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
<form name="fconf_marketingsourceview" id="fconf_marketingsourceview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_marketingsource">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_marketingsource_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_conf_marketingsource_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->marketingsourceBR->Visible) { // marketingsourceBR ?>
    <tr id="r_marketingsourceBR"<?= $Page->marketingsourceBR->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_marketingsource_marketingsourceBR"><?= $Page->marketingsourceBR->caption() ?></span></td>
        <td data-name="marketingsourceBR"<?= $Page->marketingsourceBR->cellAttributes() ?>>
<span id="el_conf_marketingsource_marketingsourceBR">
<span<?= $Page->marketingsourceBR->viewAttributes() ?>>
<?= $Page->marketingsourceBR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->marketingsourceEN->Visible) { // marketingsourceEN ?>
    <tr id="r_marketingsourceEN"<?= $Page->marketingsourceEN->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_marketingsource_marketingsourceEN"><?= $Page->marketingsourceEN->caption() ?></span></td>
        <td data-name="marketingsourceEN"<?= $Page->marketingsourceEN->cellAttributes() ?>>
<span id="el_conf_marketingsource_marketingsourceEN">
<span<?= $Page->marketingsourceEN->viewAttributes() ?>>
<?= $Page->marketingsourceEN->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->marketingsourceSP->Visible) { // marketingsourceSP ?>
    <tr id="r_marketingsourceSP"<?= $Page->marketingsourceSP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_marketingsource_marketingsourceSP"><?= $Page->marketingsourceSP->caption() ?></span></td>
        <td data-name="marketingsourceSP"<?= $Page->marketingsourceSP->cellAttributes() ?>>
<span id="el_conf_marketingsource_marketingsourceSP">
<span<?= $Page->marketingsourceSP->viewAttributes() ?>>
<?= $Page->marketingsourceSP->getViewValue() ?></span>
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
