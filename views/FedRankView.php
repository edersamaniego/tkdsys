<?php

namespace PHPMaker2022\school;

// Page object
$FedRankView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { fed_rank: currentTable } });
var currentForm, currentPageID;
var ffed_rankview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    ffed_rankview = new ew.Form("ffed_rankview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = ffed_rankview;
    loadjs.done("ffed_rankview");
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
<form name="ffed_rankview" id="ffed_rankview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="fed_rank">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_rank_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_fed_rank_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rankBR->Visible) { // rankBR ?>
    <tr id="r_rankBR"<?= $Page->rankBR->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_rank_rankBR"><?= $Page->rankBR->caption() ?></span></td>
        <td data-name="rankBR"<?= $Page->rankBR->cellAttributes() ?>>
<span id="el_fed_rank_rankBR">
<span<?= $Page->rankBR->viewAttributes() ?>>
<?= $Page->rankBR->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rankUS->Visible) { // rankUS ?>
    <tr id="r_rankUS"<?= $Page->rankUS->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_rank_rankUS"><?= $Page->rankUS->caption() ?></span></td>
        <td data-name="rankUS"<?= $Page->rankUS->cellAttributes() ?>>
<span id="el_fed_rank_rankUS">
<span<?= $Page->rankUS->viewAttributes() ?>>
<?= $Page->rankUS->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->rankES->Visible) { // rankES ?>
    <tr id="r_rankES"<?= $Page->rankES->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_rank_rankES"><?= $Page->rankES->caption() ?></span></td>
        <td data-name="rankES"<?= $Page->rankES->cellAttributes() ?>>
<span id="el_fed_rank_rankES">
<span<?= $Page->rankES->viewAttributes() ?>>
<?= $Page->rankES->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->ranking->Visible) { // ranking ?>
    <tr id="r_ranking"<?= $Page->ranking->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_rank_ranking"><?= $Page->ranking->caption() ?></span></td>
        <td data-name="ranking"<?= $Page->ranking->cellAttributes() ?>>
<span id="el_fed_rank_ranking">
<span<?= $Page->ranking->viewAttributes() ?>>
<?= $Page->ranking->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nextrankId->Visible) { // nextrankId ?>
    <tr id="r_nextrankId"<?= $Page->nextrankId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_rank_nextrankId"><?= $Page->nextrankId->caption() ?></span></td>
        <td data-name="nextrankId"<?= $Page->nextrankId->cellAttributes() ?>>
<span id="el_fed_rank_nextrankId">
<span<?= $Page->nextrankId->viewAttributes() ?>>
<?= $Page->nextrankId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->levelTournamentId->Visible) { // levelTournamentId ?>
    <tr id="r_levelTournamentId"<?= $Page->levelTournamentId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_rank_levelTournamentId"><?= $Page->levelTournamentId->caption() ?></span></td>
        <td data-name="levelTournamentId"<?= $Page->levelTournamentId->cellAttributes() ?>>
<span id="el_fed_rank_levelTournamentId">
<span<?= $Page->levelTournamentId->viewAttributes() ?>>
<?= $Page->levelTournamentId->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->martialArtsId->Visible) { // martialArtsId ?>
    <tr id="r_martialArtsId"<?= $Page->martialArtsId->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_fed_rank_martialArtsId"><?= $Page->martialArtsId->caption() ?></span></td>
        <td data-name="martialArtsId"<?= $Page->martialArtsId->cellAttributes() ?>>
<span id="el_fed_rank_martialArtsId">
<span<?= $Page->martialArtsId->viewAttributes() ?>>
<?= $Page->martialArtsId->getViewValue() ?></span>
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
