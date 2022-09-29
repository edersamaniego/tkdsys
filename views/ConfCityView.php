<?php

namespace PHPMaker2022\school;

// Page object
$ConfCityView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { conf_city: currentTable } });
var currentForm, currentPageID;
var fconf_cityview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fconf_cityview = new ew.Form("fconf_cityview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fconf_cityview;
    loadjs.done("fconf_cityview");
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
<form name="fconf_cityview" id="fconf_cityview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="conf_city">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_city_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_conf_city_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->city->Visible) { // city ?>
    <tr id="r_city"<?= $Page->city->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_city_city"><?= $Page->city->caption() ?></span></td>
        <td data-name="city"<?= $Page->city->cellAttributes() ?>>
<span id="el_conf_city_city">
<span<?= $Page->city->viewAttributes() ?>>
<?= $Page->city->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uf->Visible) { // uf ?>
    <tr id="r_uf"<?= $Page->uf->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_city_uf"><?= $Page->uf->caption() ?></span></td>
        <td data-name="uf"<?= $Page->uf->cellAttributes() ?>>
<span id="el_conf_city_uf">
<span<?= $Page->uf->viewAttributes() ?>>
<?= $Page->uf->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ufId->Visible) { // ufId ?>
    <tr id="r_ufId"<?= $Page->ufId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_city_ufId"><?= $Page->ufId->caption() ?></span></td>
        <td data-name="ufId"<?= $Page->ufId->cellAttributes() ?>>
<span id="el_conf_city_ufId">
<span<?= $Page->ufId->viewAttributes() ?>>
<?= $Page->ufId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->county->Visible) { // county ?>
    <tr id="r_county"<?= $Page->county->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_city_county"><?= $Page->county->caption() ?></span></td>
        <td data-name="county"<?= $Page->county->cellAttributes() ?>>
<span id="el_conf_city_county">
<span<?= $Page->county->viewAttributes() ?>>
<?= $Page->county->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->longitude->Visible) { // longitude ?>
    <tr id="r_longitude"<?= $Page->longitude->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_city_longitude"><?= $Page->longitude->caption() ?></span></td>
        <td data-name="longitude"<?= $Page->longitude->cellAttributes() ?>>
<span id="el_conf_city_longitude">
<span<?= $Page->longitude->viewAttributes() ?>>
<?= $Page->longitude->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->latitude->Visible) { // latitude ?>
    <tr id="r_latitude"<?= $Page->latitude->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_conf_city_latitude"><?= $Page->latitude->caption() ?></span></td>
        <td data-name="latitude"<?= $Page->latitude->cellAttributes() ?>>
<span id="el_conf_city_latitude">
<span<?= $Page->latitude->viewAttributes() ?>>
<?= $Page->latitude->getViewValue() ?></span>
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
