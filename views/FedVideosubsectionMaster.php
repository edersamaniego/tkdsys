<?php

namespace PHPMaker2022\school;

// Table
$fed_videosubsection = Container("fed_videosubsection");
?>
<?php if ($fed_videosubsection->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_fed_videosubsectionmaster" class="table ew-view-table ew-master-table ew-vertical">
    <tbody>
<?php if ($fed_videosubsection->section->Visible) { // section ?>
        <tr id="r_section"<?= $fed_videosubsection->section->rowAttributes() ?>>
            <td class="<?= $fed_videosubsection->TableLeftColumnClass ?>"><?= $fed_videosubsection->section->caption() ?></td>
            <td<?= $fed_videosubsection->section->cellAttributes() ?>>
<span id="el_fed_videosubsection_section">
<span<?= $fed_videosubsection->section->viewAttributes() ?>>
<?= $fed_videosubsection->section->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_videosubsection->subsection->Visible) { // subsection ?>
        <tr id="r_subsection"<?= $fed_videosubsection->subsection->rowAttributes() ?>>
            <td class="<?= $fed_videosubsection->TableLeftColumnClass ?>"><?= $fed_videosubsection->subsection->caption() ?></td>
            <td<?= $fed_videosubsection->subsection->cellAttributes() ?>>
<span id="el_fed_videosubsection_subsection">
<span<?= $fed_videosubsection->subsection->viewAttributes() ?>>
<?= $fed_videosubsection->subsection->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_videosubsection->subsectionBr->Visible) { // subsectionBr ?>
        <tr id="r_subsectionBr"<?= $fed_videosubsection->subsectionBr->rowAttributes() ?>>
            <td class="<?= $fed_videosubsection->TableLeftColumnClass ?>"><?= $fed_videosubsection->subsectionBr->caption() ?></td>
            <td<?= $fed_videosubsection->subsectionBr->cellAttributes() ?>>
<span id="el_fed_videosubsection_subsectionBr">
<span<?= $fed_videosubsection->subsectionBr->viewAttributes() ?>>
<?= $fed_videosubsection->subsectionBr->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
<?php if ($fed_videosubsection->subsectionSp->Visible) { // subsectionSp ?>
        <tr id="r_subsectionSp"<?= $fed_videosubsection->subsectionSp->rowAttributes() ?>>
            <td class="<?= $fed_videosubsection->TableLeftColumnClass ?>"><?= $fed_videosubsection->subsectionSp->caption() ?></td>
            <td<?= $fed_videosubsection->subsectionSp->cellAttributes() ?>>
<span id="el_fed_videosubsection_subsectionSp">
<span<?= $fed_videosubsection->subsectionSp->viewAttributes() ?>>
<?= $fed_videosubsection->subsectionSp->getViewValue() ?></span>
</span>
</td>
        </tr>
<?php } ?>
    </tbody>
</table>
</div>
<?php } ?>
