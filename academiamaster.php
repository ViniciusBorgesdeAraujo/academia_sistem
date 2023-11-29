<?php
namespace PHPMaker2020\sistema;
?>
<?php if ($academia->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_academiamaster" class="table ew-view-table ew-master-table ew-vertical">
	<tbody>
<?php if ($academia->nome->Visible) { // nome ?>
		<tr id="r_nome">
			<td class="<?php echo $academia->TableLeftColumnClass ?>"><?php echo $academia->nome->caption() ?></td>
			<td <?php echo $academia->nome->cellAttributes() ?>>
<span id="el_academia_nome">
<span<?php echo $academia->nome->viewAttributes() ?>><?php echo $academia->nome->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($academia->registro->Visible) { // registro ?>
		<tr id="r_registro">
			<td class="<?php echo $academia->TableLeftColumnClass ?>"><?php echo $academia->registro->caption() ?></td>
			<td <?php echo $academia->registro->cellAttributes() ?>>
<span id="el_academia_registro">
<span<?php echo $academia->registro->viewAttributes() ?>><?php echo $academia->registro->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($academia->ativado->Visible) { // ativado ?>
		<tr id="r_ativado">
			<td class="<?php echo $academia->TableLeftColumnClass ?>"><?php echo $academia->ativado->caption() ?></td>
			<td <?php echo $academia->ativado->cellAttributes() ?>>
<span id="el_academia_ativado">
<span<?php echo $academia->ativado->viewAttributes() ?>><?php echo $academia->ativado->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>