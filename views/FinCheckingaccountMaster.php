<?php

namespace PHPMaker2022\school;

// Table
$fin_checkingaccount = Container("fin_checkingaccount");
?>
<?php if ($fin_checkingaccount->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_fin_checkingaccountmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($fin_checkingaccount->id->Visible) { // id ?>
        <tr id="r_id"<?= $fin_checkingaccount->id->rowAttributes() ?>>
            <td class="<?= $fin_checkingaccount->TableLeftColumnClass ?>"><?= $fin_checkingaccount->id->caption() ?></td>
            <td<?= $fin_checkingaccount->id->cellAttributes() ?>>
<span id="el_fin_checkingaccount_id">
<span<?= $fin_checkingaccount->id->viewAttributes() ?>>
<?= $fin_checkingaccount->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_checkingaccount->bank->Visible) { // bank ?>
        <tr id="r_bank"<?= $fin_checkingaccount->bank->rowAttributes() ?>>
            <td class="<?= $fin_checkingaccount->TableLeftColumnClass ?>"><?= $fin_checkingaccount->bank->caption() ?></td>
            <td<?= $fin_checkingaccount->bank->cellAttributes() ?>>
<span id="el_fin_checkingaccount_bank">
<span<?= $fin_checkingaccount->bank->viewAttributes() ?>>
<?= $fin_checkingaccount->bank->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_checkingaccount->responsable->Visible) { // responsable ?>
        <tr id="r_responsable"<?= $fin_checkingaccount->responsable->rowAttributes() ?>>
            <td class="<?= $fin_checkingaccount->TableLeftColumnClass ?>"><?= $fin_checkingaccount->responsable->caption() ?></td>
            <td<?= $fin_checkingaccount->responsable->cellAttributes() ?>>
<span id="el_fin_checkingaccount_responsable">
<span<?= $fin_checkingaccount->responsable->viewAttributes() ?>>
<?= $fin_checkingaccount->responsable->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_checkingaccount->balance->Visible) { // balance ?>
        <tr id="r_balance"<?= $fin_checkingaccount->balance->rowAttributes() ?>>
            <td class="<?= $fin_checkingaccount->TableLeftColumnClass ?>"><?= $fin_checkingaccount->balance->caption() ?></td>
            <td<?= $fin_checkingaccount->balance->cellAttributes() ?>>
<span id="el_fin_checkingaccount_balance">
<span<?= $fin_checkingaccount->balance->viewAttributes() ?>>
<?= $fin_checkingaccount->balance->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
