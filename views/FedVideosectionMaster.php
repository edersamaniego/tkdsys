<?php

namespace PHPMaker2022\school;

// Table
$fed_videosection = Container("fed_videosection");
?>
<?php if ($fed_videosection->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_fed_videosectionmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($fed_videosection->section->Visible) { // section ?>
        <tr id="r_section"<?= $fed_videosection->section->rowAttributes() ?>>
            <td class="<?= $fed_videosection->TableLeftColumnClass ?>"><?= $fed_videosection->section->caption() ?></td>
            <td<?= $fed_videosection->section->cellAttributes() ?>>
<span id="el_fed_videosection_section">
<span<?= $fed_videosection->section->viewAttributes() ?>>
<?= $fed_videosection->section->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_videosection->sectionBr->Visible) { // sectionBr ?>
        <tr id="r_sectionBr"<?= $fed_videosection->sectionBr->rowAttributes() ?>>
            <td class="<?= $fed_videosection->TableLeftColumnClass ?>"><?= $fed_videosection->sectionBr->caption() ?></td>
            <td<?= $fed_videosection->sectionBr->cellAttributes() ?>>
<span id="el_fed_videosection_sectionBr">
<span<?= $fed_videosection->sectionBr->viewAttributes() ?>>
<?= $fed_videosection->sectionBr->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_videosection->sectionSp->Visible) { // sectionSp ?>
        <tr id="r_sectionSp"<?= $fed_videosection->sectionSp->rowAttributes() ?>>
            <td class="<?= $fed_videosection->TableLeftColumnClass ?>"><?= $fed_videosection->sectionSp->caption() ?></td>
            <td<?= $fed_videosection->sectionSp->cellAttributes() ?>>
<span id="el_fed_videosection_sectionSp">
<span<?= $fed_videosection->sectionSp->viewAttributes() ?>>
<?= $fed_videosection->sectionSp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
