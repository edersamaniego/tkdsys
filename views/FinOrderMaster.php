<?php

namespace PHPMaker2022\school;

// Table
$fin_order = Container("fin_order");
?>
<?php if ($fin_order->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_fin_ordermaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($fin_order->id->Visible) { // id ?>
        <tr id="r_id"<?= $fin_order->id->rowAttributes() ?>>
            <td class="<?= $fin_order->TableLeftColumnClass ?>"><?= $fin_order->id->caption() ?></td>
            <td<?= $fin_order->id->cellAttributes() ?>>
<span id="el_fin_order_id">
<span<?= $fin_order->id->viewAttributes() ?>>
<?= $fin_order->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_order->discountId->Visible) { // discountId ?>
        <tr id="r_discountId"<?= $fin_order->discountId->rowAttributes() ?>>
            <td class="<?= $fin_order->TableLeftColumnClass ?>"><?= $fin_order->discountId->caption() ?></td>
            <td<?= $fin_order->discountId->cellAttributes() ?>>
<span id="el_fin_order_discountId">
<span<?= $fin_order->discountId->viewAttributes() ?>>
<?= $fin_order->discountId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_order->date->Visible) { // date ?>
        <tr id="r_date"<?= $fin_order->date->rowAttributes() ?>>
            <td class="<?= $fin_order->TableLeftColumnClass ?>"><?= $fin_order->date->caption() ?></td>
            <td<?= $fin_order->date->cellAttributes() ?>>
<span id="el_fin_order_date">
<span<?= $fin_order->date->viewAttributes() ?>>
<?= $fin_order->date->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_order->due->Visible) { // due ?>
        <tr id="r_due"<?= $fin_order->due->rowAttributes() ?>>
            <td class="<?= $fin_order->TableLeftColumnClass ?>"><?= $fin_order->due->caption() ?></td>
            <td<?= $fin_order->due->cellAttributes() ?>>
<span id="el_fin_order_due">
<span<?= $fin_order->due->viewAttributes() ?>>
<?= $fin_order->due->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_order->debtor->Visible) { // debtor ?>
        <tr id="r_debtor"<?= $fin_order->debtor->rowAttributes() ?>>
            <td class="<?= $fin_order->TableLeftColumnClass ?>"><?= $fin_order->debtor->caption() ?></td>
            <td<?= $fin_order->debtor->cellAttributes() ?>>
<span id="el_fin_order_debtor">
<span<?= $fin_order->debtor->viewAttributes() ?>>
<?= $fin_order->debtor->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
