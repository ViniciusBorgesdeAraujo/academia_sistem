<?php
namespace PHPMaker2020\sistema;
?>
<?php if ($aulas->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_aulasmaster" class="table ew-view-table ew-master-table ew-vertical">
	<tbody>
<?php if ($aulas->idturnos->Visible) { // idturnos ?>
		<tr id="r_idturnos">
			<td class="<?php echo $aulas->TableLeftColumnClass ?>"><?php echo $aulas->idturnos->caption() ?></td>
			<td <?php echo $aulas->idturnos->cellAttributes() ?>>
<span id="el_aulas_idturnos">
<span<?php echo $aulas->idturnos->viewAttributes() ?>><?php echo $aulas->idturnos->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($aulas->idaluno->Visible) { // idaluno ?>
		<tr id="r_idaluno">
			<td class="<?php echo $aulas->TableLeftColumnClass ?>"><?php echo $aulas->idaluno->caption() ?></td>
			<td <?php echo $aulas->idaluno->cellAttributes() ?>>
<span id="el_aulas_idaluno">
<span<?php echo $aulas->idaluno->viewAttributes() ?>><?php echo $aulas->idaluno->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($aulas->nome->Visible) { // nome ?>
		<tr id="r_nome">
			<td class="<?php echo $aulas->TableLeftColumnClass ?>"><?php echo $aulas->nome->caption() ?></td>
			<td <?php echo $aulas->nome->cellAttributes() ?>>
<span id="el_aulas_nome">
<span<?php echo $aulas->nome->viewAttributes() ?>><?php echo $aulas->nome->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($aulas->ativado->Visible) { // ativado ?>
		<tr id="r_ativado">
			<td class="<?php echo $aulas->TableLeftColumnClass ?>"><?php echo $aulas->ativado->caption() ?></td>
			<td <?php echo $aulas->ativado->cellAttributes() ?>>
<span id="el_aulas_ativado">
<span<?php echo $aulas->ativado->viewAttributes() ?>><?php echo $aulas->ativado->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>