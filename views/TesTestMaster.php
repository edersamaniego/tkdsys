<?php

namespace PHPMaker2022\school;

// Table
$tes_test = Container("tes_test");
?>
<?php if ($tes_test->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_tes_testmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($tes_test->id->Visible) { // id ?>
        <tr id="r_id"<?= $tes_test->id->rowAttributes() ?>>
            <td class="<?= $tes_test->TableLeftColumnClass ?>"><?= $tes_test->id->caption() ?></td>
            <td<?= $tes_test->id->cellAttributes() ?>>
<span id="el_tes_test_id">
<span<?= $tes_test->id->viewAttributes() ?>>
<?= $tes_test->id->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($tes_test->description->Visible) { // description ?>
        <tr id="r_description"<?= $tes_test->description->rowAttributes() ?>>
            <td class="<?= $tes_test->TableLeftColumnClass ?>"><?= $tes_test->description->caption() ?></td>
            <td<?= $tes_test->description->cellAttributes() ?>>
<span id="el_tes_test_description">
<span<?= $tes_test->description->viewAttributes() ?>>
<?= $tes_test->description->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($tes_test->testCity->Visible) { // testCity ?>
        <tr id="r_testCity"<?= $tes_test->testCity->rowAttributes() ?>>
            <td class="<?= $tes_test->TableLeftColumnClass ?>"><?= $tes_test->testCity->caption() ?></td>
            <td<?= $tes_test->testCity->cellAttributes() ?>>
<span id="el_tes_test_testCity">
<span<?= $tes_test->testCity->viewAttributes() ?>>
<?= $tes_test->testCity->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($tes_test->martialartsId->Visible) { // martialartsId ?>
        <tr id="r_martialartsId"<?= $tes_test->martialartsId->rowAttributes() ?>>
            <td class="<?= $tes_test->TableLeftColumnClass ?>"><?= $tes_test->martialartsId->caption() ?></td>
            <td<?= $tes_test->martialartsId->cellAttributes() ?>>
<span id="el_tes_test_martialartsId">
<span<?= $tes_test->martialartsId->viewAttributes() ?>>
<?= $tes_test->martialartsId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($tes_test->schoolId->Visible) { // schoolId ?>
        <tr id="r_schoolId"<?= $tes_test->schoolId->rowAttributes() ?>>
            <td class="<?= $tes_test->TableLeftColumnClass ?>"><?= $tes_test->schoolId->caption() ?></td>
            <td<?= $tes_test->schoolId->cellAttributes() ?>>
<span id="el_tes_test_schoolId">
<span<?= $tes_test->schoolId->viewAttributes() ?>>
<?= $tes_test->schoolId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($tes_test->testDate->Visible) { // testDate ?>
        <tr id="r_testDate"<?= $tes_test->testDate->rowAttributes() ?>>
            <td class="<?= $tes_test->TableLeftColumnClass ?>"><?= $tes_test->testDate->caption() ?></td>
            <td<?= $tes_test->testDate->cellAttributes() ?>>
<span id="el_tes_test_testDate">
<span<?= $tes_test->testDate->viewAttributes() ?>>
<?= $tes_test->testDate->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($tes_test->testTime->Visible) { // testTime ?>
        <tr id="r_testTime"<?= $tes_test->testTime->rowAttributes() ?>>
            <td class="<?= $tes_test->TableLeftColumnClass ?>"><?= $tes_test->testTime->caption() ?></td>
            <td<?= $tes_test->testTime->cellAttributes() ?>>
<span id="el_tes_test_testTime">
<span<?= $tes_test->testTime->viewAttributes() ?>>
<?= $tes_test->testTime->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($tes_test->ceremonyDate->Visible) { // ceremonyDate ?>
        <tr id="r_ceremonyDate"<?= $tes_test->ceremonyDate->rowAttributes() ?>>
            <td class="<?= $tes_test->TableLeftColumnClass ?>"><?= $tes_test->ceremonyDate->caption() ?></td>
            <td<?= $tes_test->ceremonyDate->cellAttributes() ?>>
<span id="el_tes_test_ceremonyDate">
<span<?= $tes_test->ceremonyDate->viewAttributes() ?>>
<?= $tes_test->ceremonyDate->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($tes_test->certificateId->Visible) { // certificateId ?>
        <tr id="r_certificateId"<?= $tes_test->certificateId->rowAttributes() ?>>
            <td class="<?= $tes_test->TableLeftColumnClass ?>"><?= $tes_test->certificateId->caption() ?></td>
            <td<?= $tes_test->certificateId->cellAttributes() ?>>
<span id="el_tes_test_certificateId">
<span<?= $tes_test->certificateId->viewAttributes() ?>>
<?= $tes_test->certificateId->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
