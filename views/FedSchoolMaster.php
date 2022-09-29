<?php

namespace PHPMaker2022\school;

// Table
$fed_school = Container("fed_school");
?>
<?php if ($fed_school->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_fed_schoolmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($fed_school->id->Visible) { // id ?>
        <tr id="r_id"<?= $fed_school->id->rowAttributes() ?>>
            <td class="<?= $fed_school->TableLeftColumnClass ?>"><?= $fed_school->id->caption() ?></td>
            <td<?= $fed_school->id->cellAttributes() ?>>
<span id="el_fed_school_id">
<span<?= $fed_school->id->viewAttributes() ?>>
<?= $fed_school->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_school->masterSchoolId->Visible) { // masterSchoolId ?>
        <tr id="r_masterSchoolId"<?= $fed_school->masterSchoolId->rowAttributes() ?>>
            <td class="<?= $fed_school->TableLeftColumnClass ?>"><?= $fed_school->masterSchoolId->caption() ?></td>
            <td<?= $fed_school->masterSchoolId->cellAttributes() ?>>
<span id="el_fed_school_masterSchoolId">
<span<?= $fed_school->masterSchoolId->viewAttributes() ?>>
<?= $fed_school->masterSchoolId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_school->school->Visible) { // school ?>
        <tr id="r_school"<?= $fed_school->school->rowAttributes() ?>>
            <td class="<?= $fed_school->TableLeftColumnClass ?>"><?= $fed_school->school->caption() ?></td>
            <td<?= $fed_school->school->cellAttributes() ?>>
<span id="el_fed_school_school">
<span<?= $fed_school->school->viewAttributes() ?>>
<?= $fed_school->school->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_school->countryId->Visible) { // countryId ?>
        <tr id="r_countryId"<?= $fed_school->countryId->rowAttributes() ?>>
            <td class="<?= $fed_school->TableLeftColumnClass ?>"><?= $fed_school->countryId->caption() ?></td>
            <td<?= $fed_school->countryId->cellAttributes() ?>>
<span id="el_fed_school_countryId">
<span<?= $fed_school->countryId->viewAttributes() ?>>
<?= $fed_school->countryId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_school->cityId->Visible) { // cityId ?>
        <tr id="r_cityId"<?= $fed_school->cityId->rowAttributes() ?>>
            <td class="<?= $fed_school->TableLeftColumnClass ?>"><?= $fed_school->cityId->caption() ?></td>
            <td<?= $fed_school->cityId->cellAttributes() ?>>
<span id="el_fed_school_cityId">
<span<?= $fed_school->cityId->viewAttributes() ?>>
<?= $fed_school->cityId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_school->owner->Visible) { // owner ?>
        <tr id="r_owner"<?= $fed_school->owner->rowAttributes() ?>>
            <td class="<?= $fed_school->TableLeftColumnClass ?>"><?= $fed_school->owner->caption() ?></td>
            <td<?= $fed_school->owner->cellAttributes() ?>>
<span id="el_fed_school_owner">
<span<?= $fed_school->owner->viewAttributes() ?>>
<?= $fed_school->owner->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_school->applicationId->Visible) { // applicationId ?>
        <tr id="r_applicationId"<?= $fed_school->applicationId->rowAttributes() ?>>
            <td class="<?= $fed_school->TableLeftColumnClass ?>"><?= $fed_school->applicationId->caption() ?></td>
            <td<?= $fed_school->applicationId->cellAttributes() ?>>
<span id="el_fed_school_applicationId">
<span<?= $fed_school->applicationId->viewAttributes() ?>>
<?= $fed_school->applicationId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_school->isheadquarter->Visible) { // isheadquarter ?>
        <tr id="r_isheadquarter"<?= $fed_school->isheadquarter->rowAttributes() ?>>
            <td class="<?= $fed_school->TableLeftColumnClass ?>"><?= $fed_school->isheadquarter->caption() ?></td>
            <td<?= $fed_school->isheadquarter->cellAttributes() ?>>
<span id="el_fed_school_isheadquarter">
<span<?= $fed_school->isheadquarter->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_isheadquarter_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $fed_school->isheadquarter->getViewValue() ?>" disabled<?php if (ConvertToBool($fed_school->isheadquarter->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_isheadquarter_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
