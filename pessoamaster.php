<?php
namespace PHPMaker2020\sistema;
?>
<?php if ($pessoa->Visible) { ?>
<div class="ew-master-div">
<table id="tbl_pessoamaster" class="table ew-view-table ew-master-table ew-vertical">
	<tbody>
<?php if ($pessoa->idaula->Visible) { // idaula ?>
		<tr id="r_idaula">
			<td class="<?php echo $pessoa->TableLeftColumnClass ?>"><?php echo $pessoa->idaula->caption() ?></td>
			<td <?php echo $pessoa->idaula->cellAttributes() ?>>
<span id="el_pessoa_idaula">
<span<?php echo $pessoa->idaula->viewAttributes() ?>><?php echo $pessoa->idaula->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($pessoa->Nome->Visible) { // Nome ?>
		<tr id="r_Nome">
			<td class="<?php echo $pessoa->TableLeftColumnClass ?>"><?php echo $pessoa->Nome->caption() ?></td>
			<td <?php echo $pessoa->Nome->cellAttributes() ?>>
<span id="el_pessoa_Nome">
<span<?php echo $pessoa->Nome->viewAttributes() ?>><?php echo $pessoa->Nome->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($pessoa->CPF->Visible) { // CPF ?>
		<tr id="r_CPF">
			<td class="<?php echo $pessoa->TableLeftColumnClass ?>"><?php echo $pessoa->CPF->caption() ?></td>
			<td <?php echo $pessoa->CPF->cellAttributes() ?>>
<span id="el_pessoa_CPF">
<span<?php echo $pessoa->CPF->viewAttributes() ?>><?php echo $pessoa->CPF->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($pessoa->Senha->Visible) { // Senha ?>
		<tr id="r_Senha">
			<td class="<?php echo $pessoa->TableLeftColumnClass ?>"><?php echo $pessoa->Senha->caption() ?></td>
			<td <?php echo $pessoa->Senha->cellAttributes() ?>>
<span id="el_pessoa_Senha">
<span<?php echo $pessoa->Senha->viewAttributes() ?>><?php echo $pessoa->Senha->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($pessoa->Sexo->Visible) { // Sexo ?>
		<tr id="r_Sexo">
			<td class="<?php echo $pessoa->TableLeftColumnClass ?>"><?php echo $pessoa->Sexo->caption() ?></td>
			<td <?php echo $pessoa->Sexo->cellAttributes() ?>>
<span id="el_pessoa_Sexo">
<span<?php echo $pessoa->Sexo->viewAttributes() ?>><?php echo $pessoa->Sexo->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($pessoa->datanascimento->Visible) { // datanascimento ?>
		<tr id="r_datanascimento">
			<td class="<?php echo $pessoa->TableLeftColumnClass ?>"><?php echo $pessoa->datanascimento->caption() ?></td>
			<td <?php echo $pessoa->datanascimento->cellAttributes() ?>>
<span id="el_pessoa_datanascimento">
<span<?php echo $pessoa->datanascimento->viewAttributes() ?>><?php echo $pessoa->datanascimento->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($pessoa->Funcao->Visible) { // Funcao ?>
		<tr id="r_Funcao">
			<td class="<?php echo $pessoa->TableLeftColumnClass ?>"><?php echo $pessoa->Funcao->caption() ?></td>
			<td <?php echo $pessoa->Funcao->cellAttributes() ?>>
<span id="el_pessoa_Funcao">
<span<?php echo $pessoa->Funcao->viewAttributes() ?>><?php echo $pessoa->Funcao->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($pessoa->_Email->Visible) { // Email ?>
		<tr id="r__Email">
			<td class="<?php echo $pessoa->TableLeftColumnClass ?>"><?php echo $pessoa->_Email->caption() ?></td>
			<td <?php echo $pessoa->_Email->cellAttributes() ?>>
<span id="el_pessoa__Email">
<span<?php echo $pessoa->_Email->viewAttributes() ?>><?php echo $pessoa->_Email->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($pessoa->Ativado->Visible) { // Ativado ?>
		<tr id="r_Ativado">
			<td class="<?php echo $pessoa->TableLeftColumnClass ?>"><?php echo $pessoa->Ativado->caption() ?></td>
			<td <?php echo $pessoa->Ativado->cellAttributes() ?>>
<span id="el_pessoa_Ativado">
<span<?php echo $pessoa->Ativado->viewAttributes() ?>><?php echo $pessoa->Ativado->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($pessoa->Idade->Visible) { // Idade ?>
		<tr id="r_Idade">
			<td class="<?php echo $pessoa->TableLeftColumnClass ?>"><?php echo $pessoa->Idade->caption() ?></td>
			<td <?php echo $pessoa->Idade->cellAttributes() ?>>
<span id="el_pessoa_Idade">
<span<?php echo $pessoa->Idade->viewAttributes() ?>><?php echo $pessoa->Idade->getViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>