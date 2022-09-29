<?php

namespace PHPMaker2022\school;

// Table
$fed_martialarts = Container("fed_martialarts");
?>
<?php if ($fed_martialarts->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_fed_martialartsmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($fed_martialarts->id->Visible) { // id ?>
        <tr id="r_id"<?= $fed_martialarts->id->rowAttributes() ?>>
            <td class="<?= $fed_martialarts->TableLeftColumnClass ?>"><?= $fed_martialarts->id->caption() ?></td>
            <td<?= $fed_martialarts->id->cellAttributes() ?>>
<span id="el_fed_martialarts_id">
<span<?= $fed_martialarts->id->viewAttributes() ?>>
<?= $fed_martialarts->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_martialarts->martialArts->Visible) { // martialArts ?>
        <tr id="r_martialArts"<?= $fed_martialarts->martialArts->rowAttributes() ?>>
            <td class="<?= $fed_martialarts->TableLeftColumnClass ?>"><?= $fed_martialarts->martialArts->caption() ?></td>
            <td<?= $fed_martialarts->martialArts->cellAttributes() ?>>
<span id="el_fed_martialarts_martialArts">
<span<?= $fed_martialarts->martialArts->viewAttributes() ?>>
<?= $fed_martialarts->martialArts->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
