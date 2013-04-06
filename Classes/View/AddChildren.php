<?php
$systemtemConnectionDml = new Db_SystemConnectionDml();
$row = $this->_viewdata->parent[0];
$parentName = $row->name;
$parentId = $row->id;

if (count($data->formError) > 0) {?>
<div id="error">
    Es gab Fehle beim Abspeichern (<?php echo count($data->formError);?>)<br />
    <ul>
    <?php
        foreach ($data->formError as $name => $errorMsg) {
            echo '<li>' . htmlentities($name) . ': ' . htmlentities($errorMsg) . '</li>';
        }
    ?>
    </ul>
</div>
<?php }
?>
    Name: <?php echo htmlentities($row->name);?><br/>
    Standort: <?php echo htmlentities($row->place);?><br/>
    Klassifizierung: <?php echo htmlentities($row->classification);?><br/>

<hr>
Rote Einträge sind neu erstellte Systeme<br /><br />
    <form method="post" action="?<?php echo $request->getBaseName()?>" accept-charset="UTF-8">
    <table>
        <tr style="font-weight:bold;text-align: center;">
            <td>id</td>
            <td>Name des Systems</td>
            <td>Ansprechpartner / Kontakt</td>
            <td>Standort</td>
            <td>Link zu weiterf. Infos</td>
            <td>Klassifizierung</td>
            <td>Abhängigkeit</td>
            <td class="needed">Schweregrad</td>
            <td class="needed">Beschreibung der Beziehung</td>
            <td>Ausfallwahrscheinlichkeit</td>
            <td class="needed">Ausfallwirkung</td>
            <td>Verbindung löschen</td>
        </tr>
        <?php
        foreach ($data->systemResult as $key => $row) {
            if ($parentId != $row->id) {
                 $connection = $systemtemConnectionDml->getAllByIds($parentId, $row->id);
                 $isChild =(!empty($connection->systemChild) && $connection->systemChild == $row->id) ? true : false;
            ?>
            <tr <?php echo $isChild == true ? 'style="background-color:#6BF806;"' : '';?>>
                <td <?php echo $row->isForeign  == 1 ? 'style="background-color:red;"' : '';?>><?php echo htmlentities($row->id);?></td>
                <td><?php echo htmlentities($row->name);?></td>
                <td><?php echo htmlentities($row->contact);?></td>
                <td><?php echo htmlentities($row->place);?></td>
                <td><?php echo htmlentities($row->infoLink);?></td>
                <td><?php echo htmlentities($row->classification);?></td>
                <td><?php echo htmlentities($parentName);?> hängt ab von <?php echo htmlentities($row->name);?>
                    <input type="checkbox" name="child[<?php echo $row->id;?>]" value="<?php echo $row->id;?>"
                    <?php echo $isChild == true ? 'checked="checked"' : ''?> id ="Add<?php echo $row->id;?>"
                    onclick="changeConnection(<?php echo $row->id;?>, 'add')">
                </td>
                <td>
                    <input type="text" name="severity[<?php echo $row->id;?>]" value="<?php echo utf8_encode($connection->severity);?>">
                </td>
                <td><input type="text" name="description[<?php echo $row->id;?>]" value="<?php echo utf8_encode($connection->description);?>"></td>
                <td><input type="text" name=failureProbability[<?php echo $row->id;?>] value="<?php echo utf8_encode($connection->failureProbability);?>"></td>
                <td><input type="text" name=failureProbability[<?php echo $row->id;?>] value="<?php echo utf8_encode($connection->failureProbability);?>"></td>
                <td><input type="checkbox" id ="Del<?php echo $row->id;?>" onclick="changeConnection(<?php echo $row->id;?>, 'del')"
                    name=deleteConnection[<?php echo $row->id;?>] value="<?php echo $row->id;?>">
                </td>
            </tr>
  <?php    }
      }
        ?>
    </table>
           <input type="hidden" name="id" value="<?php echo $parentId;?>">
            <input type="submit" name="Speichern" value="save"/>
    </form>
    <br />
    <br />
    Neues System hinzufügen
    <form action="?<?php echo $request->getBaseName()?>" method="post" accept-charset="UTF-8">
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
            <tr>
                <td class="needed">Schweregrad</td><td><input type="text" name="severity"></td>
            </tr>
            <tr>
                <td class="needed">Beschreibung der Abhängigkeit</td><td><input type="text" name="description"></td>
            </tr>
            <tr>
                <td>Ausfallwahrscheinlichkeit</td><td><input type="text" name=failureProbability"></td>
            </tr>
            <tr>
                <td class="needed">Ausfallwirkung</td><td><input type="text" name=malfunctionImpact"></td>
            </tr>
        </table>
        <input type="hidden" name="isForeign" value="1" >
        <input type="hidden" name="id" value="<?php echo $parentId;?>">
        <input type="submit" name="Speichern" value="saveOwn"/>
    </form>