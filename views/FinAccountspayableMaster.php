<?php

namespace PHPMaker2022\school;

// Table
$fin_accountspayable = Container("fin_accountspayable");
?>
<?php if ($fin_accountspayable->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_fin_accountspayablemaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($fin_accountspayable->id->Visible) { // id ?>
        <tr id="r_id"<?= $fin_accountspayable->id->rowAttributes() ?>>
            <td class="<?= $fin_accountspayable->TableLeftColumnClass ?>"><?= $fin_accountspayable->id->caption() ?></td>
            <td<?= $fin_accountspayable->id->cellAttributes() ?>>
<span id="el_fin_accountspayable_id">
<span<?= $fin_accountspayable->id->viewAttributes() ?>>
<?= $fin_accountspayable->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountspayable->departamentId->Visible) { // departamentId ?>
        <tr id="r_departamentId"<?= $fin_accountspayable->departamentId->rowAttributes() ?>>
            <td class="<?= $fin_accountspayable->TableLeftColumnClass ?>"><?= $fin_accountspayable->departamentId->caption() ?></td>
            <td<?= $fin_accountspayable->departamentId->cellAttributes() ?>>
<span id="el_fin_accountspayable_departamentId">
<span<?= $fin_accountspayable->departamentId->viewAttributes() ?>>
<?= $fin_accountspayable->departamentId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountspayable->historic->Visible) { // historic ?>
        <tr id="r_historic"<?= $fin_accountspayable->historic->rowAttributes() ?>>
            <td class="<?= $fin_accountspayable->TableLeftColumnClass ?>"><?= $fin_accountspayable->historic->caption() ?></td>
            <td<?= $fin_accountspayable->historic->cellAttributes() ?>>
<span id="el_fin_accountspayable_historic">
<span<?= $fin_accountspayable->historic->viewAttributes() ?>>
<?= $fin_accountspayable->historic->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountspayable->issue->Visible) { // issue ?>
        <tr id="r_issue"<?= $fin_accountspayable->issue->rowAttributes() ?>>
            <td class="<?= $fin_accountspayable->TableLeftColumnClass ?>"><?= $fin_accountspayable->issue->caption() ?></td>
            <td<?= $fin_accountspayable->issue->cellAttributes() ?>>
<span id="el_fin_accountspayable_issue">
<span<?= $fin_accountspayable->issue->viewAttributes() ?>>
<?= $fin_accountspayable->issue->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountspayable->due->Visible) { // due ?>
        <tr id="r_due"<?= $fin_accountspayable->due->rowAttributes() ?>>
            <td class="<?= $fin_accountspayable->TableLeftColumnClass ?>"><?= $fin_accountspayable->due->caption() ?></td>
            <td<?= $fin_accountspayable->due->cellAttributes() ?>>
<span id="el_fin_accountspayable_due">
<span<?= $fin_accountspayable->due->viewAttributes() ?>>
<?= $fin_accountspayable->due->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountspayable->value->Visible) { // value ?>
        <tr id="r_value"<?= $fin_accountspayable->value->rowAttributes() ?>>
            <td class="<?= $fin_accountspayable->TableLeftColumnClass ?>"><?= $fin_accountspayable->value->caption() ?></td>
            <td<?= $fin_accountspayable->value->cellAttributes() ?>>
<span id="el_fin_accountspayable_value">
<span<?= $fin_accountspayable->value->viewAttributes() ?>>
<?= $fin_accountspayable->value->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountspayable->status->Visible) { // status ?>
        <tr id="r_status"<?= $fin_accountspayable->status->rowAttributes() ?>>
            <td class="<?= $fin_accountspayable->TableLeftColumnClass ?>"><?= $fin_accountspayable->status->caption() ?></td>
            <td<?= $fin_accountspayable->status->cellAttributes() ?>>
<span id="el_fin_accountspayable_status">
<span<?= $fin_accountspayable->status->viewAttributes() ?>>
<?= $fin_accountspayable->status->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountspayable->amountPaid->Visible) { // amountPaid ?>
        <tr id="r_amountPaid"<?= $fin_accountspayable->amountPaid->rowAttributes() ?>>
            <td class="<?= $fin_accountspayable->TableLeftColumnClass ?>"><?= $fin_accountspayable->amountPaid->caption() ?></td>
            <td<?= $fin_accountspayable->amountPaid->cellAttributes() ?>>
<span id="el_fin_accountspayable_amountPaid">
<span<?= $fin_accountspayable->amountPaid->viewAttributes() ?>>
<?= $fin_accountspayable->amountPaid->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountspayable->creditorsId->Visible) { // creditorsId ?>
        <tr id="r_creditorsId"<?= $fin_accountspayable->creditorsId->rowAttributes() ?>>
            <td class="<?= $fin_accountspayable->TableLeftColumnClass ?>"><?= $fin_accountspayable->creditorsId->caption() ?></td>
            <td<?= $fin_accountspayable->creditorsId->cellAttributes() ?>>
<span id="el_fin_accountspayable_creditorsId">
<span<?= $fin_accountspayable->creditorsId->viewAttributes() ?>>
<?= $fin_accountspayable->creditorsId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountspayable->typeId->Visible) { // typeId ?>
        <tr id="r_typeId"<?= $fin_accountspayable->typeId->rowAttributes() ?>>
            <td class="<?= $fin_accountspayable->TableLeftColumnClass ?>"><?= $fin_accountspayable->typeId->caption() ?></td>
            <td<?= $fin_accountspayable->typeId->cellAttributes() ?>>
<span id="el_fin_accountspayable_typeId">
<span<?= $fin_accountspayable->typeId->viewAttributes() ?>>
<?= $fin_accountspayable->typeId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fin_accountspayable->licenseId->Visible) { // licenseId ?>
        <tr id="r_licenseId"<?= $fin_accountspayable->licenseId->rowAttributes() ?>>
            <td class="<?= $fin_accountspayable->TableLeftColumnClass ?>"><?= $fin_accountspayable->licenseId->caption() ?></td>
            <td<?= $fin_accountspayable->licenseId->cellAttributes() ?>>
<span id="el_fin_accountspayable_licenseId">
<span<?= $fin_accountspayable->licenseId->viewAttributes() ?>>
<?= $fin_accountspayable->licenseId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
