<?php
namespace PHPMaker2020\sistema;
?>
<?php if ($turnos->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_turnosmaster" class="table ew-view-table ew-master-table ew-vertical">
	<tbody>
<?php if ($turnos->idacademia->Visible) { // idacademia ?>
		<tr id="r_idacademia">
			<td class="<?php echo $turnos->TableLeftColumnClass ?>"><?php echo $turnos->idacademia->caption() ?></td>
			<td <?php echo $turnos->idacademia->cellAttributes() ?>>
<span id="el_turnos_idacademia">
<span<?php echo $turnos->idacademia->viewAttributes() ?>><?php echo $turnos->idacademia->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($turnos->turmas->Visible) { // turmas ?>
		<tr id="r_turmas">
			<td class="<?php echo $turnos->TableLeftColumnClass ?>"><?php echo $turnos->turmas->caption() ?></td>
			<td <?php echo $turnos->turmas->cellAttributes() ?>>
<span id="el_turnos_turmas">
<span<?php echo $turnos->turmas->viewAttributes() ?>><?php echo $turnos->turmas->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>