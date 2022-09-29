<?php

namespace PHPMaker2022\school;

// Table
$fin_accountsreceivable = Container("fin_accountsreceivable");
?>
<?php if ($fin_accountsreceivable->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_fin_accountsreceivablemaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($fin_accountsreceivable->id->Visible) { // id ?>
        <tr id="r_id"<?= $fin_accountsreceivable->id->rowAttributes() ?>>
            <td class="<?= $fin_accountsreceivable->TableLeftColumnClass ?>"><?= $fin_accountsreceivable->id->caption() ?></td>
            <td<?= $fin_accountsreceivable->id->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_id">
<span<?= $fin_accountsreceivable->id->viewAttributes() ?>>
<?= $fin_accountsreceivable->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountsreceivable->issue->Visible) { // issue ?>
        <tr id="r_issue"<?= $fin_accountsreceivable->issue->rowAttributes() ?>>
            <td class="<?= $fin_accountsreceivable->TableLeftColumnClass ?>"><?= $fin_accountsreceivable->issue->caption() ?></td>
            <td<?= $fin_accountsreceivable->issue->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_issue">
<span<?= $fin_accountsreceivable->issue->viewAttributes() ?>>
<?= $fin_accountsreceivable->issue->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountsreceivable->due->Visible) { // due ?>
        <tr id="r_due"<?= $fin_accountsreceivable->due->rowAttributes() ?>>
            <td class="<?= $fin_accountsreceivable->TableLeftColumnClass ?>"><?= $fin_accountsreceivable->due->caption() ?></td>
            <td<?= $fin_accountsreceivable->due->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_due">
<span<?= $fin_accountsreceivable->due->viewAttributes() ?>>
<?= $fin_accountsreceivable->due->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountsreceivable->income->Visible) { // income ?>
        <tr id="r_income"<?= $fin_accountsreceivable->income->rowAttributes() ?>>
            <td class="<?= $fin_accountsreceivable->TableLeftColumnClass ?>"><?= $fin_accountsreceivable->income->caption() ?></td>
            <td<?= $fin_accountsreceivable->income->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_income">
<span<?= $fin_accountsreceivable->income->viewAttributes() ?>>
<?= $fin_accountsreceivable->income->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountsreceivable->status->Visible) { // status ?>
        <tr id="r_status"<?= $fin_accountsreceivable->status->rowAttributes() ?>>
            <td class="<?= $fin_accountsreceivable->TableLeftColumnClass ?>"><?= $fin_accountsreceivable->status->caption() ?></td>
            <td<?= $fin_accountsreceivable->status->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_status">
<span<?= $fin_accountsreceivable->status->viewAttributes() ?>>
<?= $fin_accountsreceivable->status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountsreceivable->value->Visible) { // value ?>
        <tr id="r_value"<?= $fin_accountsreceivable->value->rowAttributes() ?>>
            <td class="<?= $fin_accountsreceivable->TableLeftColumnClass ?>"><?= $fin_accountsreceivable->value->caption() ?></td>
            <td<?= $fin_accountsreceivable->value->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_value">
<span<?= $fin_accountsreceivable->value->viewAttributes() ?>>
<?= $fin_accountsreceivable->value->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountsreceivable->orderId->Visible) { // orderId ?>
        <tr id="r_orderId"<?= $fin_accountsreceivable->orderId->rowAttributes() ?>>
            <td class="<?= $fin_accountsreceivable->TableLeftColumnClass ?>"><?= $fin_accountsreceivable->orderId->caption() ?></td>
            <td<?= $fin_accountsreceivable->orderId->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_orderId">
<span<?= $fin_accountsreceivable->orderId->viewAttributes() ?>>
<?= $fin_accountsreceivable->orderId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountsreceivable->balance->Visible) { // balance ?>
        <tr id="r_balance"<?= $fin_accountsreceivable->balance->rowAttributes() ?>>
            <td class="<?= $fin_accountsreceivable->TableLeftColumnClass ?>"><?= $fin_accountsreceivable->balance->caption() ?></td>
            <td<?= $fin_accountsreceivable->balance->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_balance">
<span<?= $fin_accountsreceivable->balance->viewAttributes() ?>>
<?= $fin_accountsreceivable->balance->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountsreceivable->debtorId->Visible) { // debtorId ?>
        <tr id="r_debtorId"<?= $fin_accountsreceivable->debtorId->rowAttributes() ?>>
            <td class="<?= $fin_accountsreceivable->TableLeftColumnClass ?>"><?= $fin_accountsreceivable->debtorId->caption() ?></td>
            <td<?= $fin_accountsreceivable->debtorId->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_debtorId">
<span<?= $fin_accountsreceivable->debtorId->viewAttributes() ?>>
<?= $fin_accountsreceivable->debtorId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountsreceivable->licenseId->Visible) { // licenseId ?>
        <tr id="r_licenseId"<?= $fin_accountsreceivable->licenseId->rowAttributes() ?>>
            <td class="<?= $fin_accountsreceivable->TableLeftColumnClass ?>"><?= $fin_accountsreceivable->licenseId->caption() ?></td>
            <td<?= $fin_accountsreceivable->licenseId->cellAttributes() ?>>
<span id="el_fin_accountsreceivable_licenseId">
<span<?= $fin_accountsreceivable->licenseId->viewAttributes() ?>>
<?= $fin_accountsreceivable->licenseId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
