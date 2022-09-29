<?php

namespace PHPMaker2022\school;

// Page object
$ConfUfView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_uf: currentTable } });
var currentForm, currentPageID;
var fconf_ufview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_ufview = new ew.Form("fconf_ufview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fconf_ufview;
    loadjs.done("fconf_ufview");
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
<form name="fconf_ufview" id="fconf_ufview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_uf">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_uf_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_conf_uf_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->UF->Visible) { // UF ?>
    <tr id="r_UF"<?= $Page->UF->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_uf_UF"><?= $Page->UF->caption() ?></span></td>
        <td data-name="UF"<?= $Page->UF->cellAttributes() ?>>
<span id="el_conf_uf_UF">
<span<?= $Page->UF->viewAttributes() ?>>
<?= $Page->UF->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->abbreviation->Visible) { // abbreviation ?>
    <tr id="r_abbreviation"<?= $Page->abbreviation->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_uf_abbreviation"><?= $Page->abbreviation->caption() ?></span></td>
        <td data-name="abbreviation"<?= $Page->abbreviation->cellAttributes() ?>>
<span id="el_conf_uf_abbreviation">
<span<?= $Page->abbreviation->viewAttributes() ?>>
<?= $Page->abbreviation->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->countryId->Visible) { // countryId ?>
    <tr id="r_countryId"<?= $Page->countryId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_uf_countryId"><?= $Page->countryId->caption() ?></span></td>
        <td data-name="countryId"<?= $Page->countryId->cellAttributes() ?>>
<span id="el_conf_uf_countryId">
<span<?= $Page->countryId->viewAttributes() ?>>
<?= $Page->countryId->getViewValue() ?></span>
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
