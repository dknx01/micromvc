<?php require_once realpath(__DIR__) . '/Abstract.php';?>
<?php if (count($data->formError) > 0) {?>
<div id="error">
    Es gab Fehle beim Abspeichern (<?php echo count($data->formError);?>)<br />
    <?php
        foreach ($data->formError as $name => $errorMsg) {
            echo '<div>' . htmlentities($name) . ': ' . htmlentities($errorMsg) . '</div>';
        }
    ?>
</div>
<?php }?>
<form method="post" accept-charset="UTF-8" action="?<?php echo $request->getBaseName()?>" style="text-align: left;">
        <table>
            <tr>
                <td class="needed">Name des Systems: </td><td><input type="text" name="systemName" /></td>
            </tr>
            <tr>
                <td>Ansprechpartner / Kontakt: </td><td><input type="text" name="systemContact"/></td>
            </tr>
            <tr>
                <td>Standort: </td><td><input type="text" name="systemPlace" /></td>
            </tr>
            <tr>
                <td>Link zu weiterf. Infos: </td><td><input type="text" name="systemInfoLink" /></td>
            </tr>
            <tr>
                <td class="needed">Klassifizierung: </td><td><input type="text" name="systemClassification" /></td>
            </tr>
        </table>
        <input type="hidden" name="isForeign" value="0" >
        <input type="submit" name="Speichern" value="save"/>
    </form>
    <br />
    <br />
    Rote Einträge sind neu erstellte Systeme<br />
    <br />
    <table>
        <tr style="font-weight:bold;">
            <td>id</td>
            <td>Name des Systems</td>
            <td>Ansprechpartner / Kontakt</td>
            <td>Standort</td>
            <td>Link zu weiterf. Infos</td>
            <td>Klassifizierung</td>
            <td>Abhängigkeiten (Ids)</td>
            <td></td>
            <td></td>
        </tr>
        <?php
        foreach ($data->systemResult as $key => $row) {?>
            <tr <?php echo $row->isForeign  == 1 ? 'style="background-color:red;"' : '';?>>
                <td><?php echo htmlentities($row->id);?></td>
                <td><?php echo htmlentities($row->name);?></td>
                <td><?php echo htmlentities($row->contact);?></td>
                <td><?php echo htmlentities($row->place);?></td>
                <td><?php echo htmlentities($row->infoLink);?></td>
                <td><?php echo htmlentities($row->classification);?></td>
                <td><?php echo implode(', ', $row->childrenIds);?> </td>
                <td><a href="?AddChildren/id=<?php echo $row->id;?>">Abhängigkeiten verwalten</a></td>
                <td><a href="?DelSystem/id=<?php echo $row->id;?>">System löschen</a></td>
            </tr>
  <?php }
        ?>
    </table>