			<table width="100%" class="border">
				[test.rowid;strconv=no]
				<tr><td>Menu Principale</td><td>[test.mainmenu;strconv=no]</td></tr>
				<tr><td>Action/Déclencheur</td><td>[test.action;strconv=no]</td></tr>
				<tr><td>Code</td><td>[test.code;strconv=no]</td></tr>
				<tr><td>Code Test Précédent</td><td>[test.prev_code;strconv=no]</td></tr>
				<tr><td>Nom du module</td><td>[test.module_name;strconv=no]</td></tr>
				<tr><td>Titre du Test</td><td>[test.title;strconv=no]</td></tr>
				<tr><td>Description du Test</td><td>[test.description;strconv=no]</td></tr>
				<tr><td>Droit utilisateur lié</td><td>[test.rights;strconv=no]</td></tr>
				<tr><td>Lien menu haut</td><td>[test.mainmenutips;strconv=no]</td></tr>
				<tr><td>Lien dans la page</td><td>[test.tips;strconv=no]</td></tr>
			</table>
			
[onshow;block=begin;when [view.mode]=='view']
		
		<div class="tabsAction">
			<input type="button" id="action-delete" value="Supprimer" name="cancel" class="butActionDelete" onclick="if(confirm('Supprimer cet Test?')) document.location.href='?action=delete&id=[test.id]'">
			&nbsp; &nbsp; <a href="?id=[test.id]&action=edit" class="butAction">Modifier</a>
		</div>
[onshow;block=end]
	
[onshow;block=begin;when [view.mode]!='view']
		<p align="center">
			[onshow;block=begin;when [view.mode]!='add']
				<input type="submit" value="Enregistrer" name="save" class="button">
				&nbsp; &nbsp; <input type="button" value="Annuler" name="cancel" class="button" onclick="document.location.href='?id=[test.id]'">
			[onshow;block=end]
		</p>
[onshow;block=end]
