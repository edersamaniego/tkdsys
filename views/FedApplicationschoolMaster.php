<?php

namespace PHPMaker2022\school;

// Table
$fed_applicationschool = Container("fed_applicationschool");
?>
<?php if ($fed_applicationschool->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_fed_applicationschoolmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($fed_applicationschool->id->Visible) { // id ?>
        <tr id="r_id"<?= $fed_applicationschool->id->rowAttributes() ?>>
            <td class="<?= $fed_applicationschool->TableLeftColumnClass ?>"><?= $fed_applicationschool->id->caption() ?></td>
            <td<?= $fed_applicationschool->id->cellAttributes() ?>>
<span id="el_fed_applicationschool_id">
<span<?= $fed_applicationschool->id->viewAttributes() ?>>
<?= $fed_applicationschool->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_applicationschool->school->Visible) { // school ?>
        <tr id="r_school"<?= $fed_applicationschool->school->rowAttributes() ?>>
            <td class="<?= $fed_applicationschool->TableLeftColumnClass ?>"><?= $fed_applicationschool->school->caption() ?></td>
            <td<?= $fed_applicationschool->school->cellAttributes() ?>>
<span id="el_fed_applicationschool_school">
<span<?= $fed_applicationschool->school->viewAttributes() ?>>
<?= $fed_applicationschool->school->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_applicationschool->countryId->Visible) { // countryId ?>
        <tr id="r_countryId"<?= $fed_applicationschool->countryId->rowAttributes() ?>>
            <td class="<?= $fed_applicationschool->TableLeftColumnClass ?>"><?= $fed_applicationschool->countryId->caption() ?></td>
            <td<?= $fed_applicationschool->countryId->cellAttributes() ?>>
<span id="el_fed_applicationschool_countryId">
<span<?= $fed_applicationschool->countryId->viewAttributes() ?>>
<?= $fed_applicationschool->countryId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_applicationschool->UFId->Visible) { // UFId ?>
        <tr id="r_UFId"<?= $fed_applicationschool->UFId->rowAttributes() ?>>
            <td class="<?= $fed_applicationschool->TableLeftColumnClass ?>"><?= $fed_applicationschool->UFId->caption() ?></td>
            <td<?= $fed_applicationschool->UFId->cellAttributes() ?>>
<span id="el_fed_applicationschool_UFId">
<span<?= $fed_applicationschool->UFId->viewAttributes() ?>>
<?= $fed_applicationschool->UFId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_applicationschool->cityId->Visible) { // cityId ?>
        <tr id="r_cityId"<?= $fed_applicationschool->cityId->rowAttributes() ?>>
            <td class="<?= $fed_applicationschool->TableLeftColumnClass ?>"><?= $fed_applicationschool->cityId->caption() ?></td>
            <td<?= $fed_applicationschool->cityId->cellAttributes() ?>>
<span id="el_fed_applicationschool_cityId">
<span<?= $fed_applicationschool->cityId->viewAttributes() ?>>
<?= $fed_applicationschool->cityId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_applicationschool->logo->Visible) { // logo ?>
        <tr id="r_logo"<?= $fed_applicationschool->logo->rowAttributes() ?>>
            <td class="<?= $fed_applicationschool->TableLeftColumnClass ?>"><?= $fed_applicationschool->logo->caption() ?></td>
            <td<?= $fed_applicationschool->logo->cellAttributes() ?>>
<span id="el_fed_applicationschool_logo">
<span>
<?= GetFileViewTag($fed_applicationschool->logo, $fed_applicationschool->logo->getViewValue(), false) ?>
</span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
