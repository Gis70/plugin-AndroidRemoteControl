<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('AndroidRemoteControl');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
?>

<div class="row row-overflow">
    <div class="col-lg-2 col-md-3 col-sm-4">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter une AndroidRemoteControl}}</a>
                <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
                <?php
                foreach ($eqLogics as $eqLogic) {
                    $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
                    echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '" style="' . $opacity .'"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
        <legend><i class="fa fa-cog"></i>  {{Gestion}}</legend>
        <div class="eqLogicThumbnailContainer">
            <div class="cursor eqLogicAction" data-action="add" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
                <i class="fa fa-plus-circle" style="font-size : 6em;color:#94ca02;"></i>
                <br>
                <span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02">{{Ajouter}}</span>
            </div>
            <div class="cursor eqLogicAction" data-action="gotoPluginConf" style="text-align: center; background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
                <i class="fa fa-wrench" style="font-size : 6em;color:#767676;"></i>
                <br>
                <span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676">{{Configuration}}</span>
            </div>
        </div>
        <legend><i class="fa fa-table"></i> {{Mes AndroidRemoteControl}}</legend>
        <div class="eqLogicThumbnailContainer">
            <?php
            foreach ($eqLogics as $eqLogic) {
                $opacity = ($eqLogic->getIsEnable()) ? '' : jeedom::getConfiguration('eqLogic:style:noactive');
                echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="text-align: center; background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;' . $opacity . '" >';
                echo '<img src="' . $plugin->getPathImgIcon() . '" height="105" width="95" />';
                echo "<br>";
                echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;">' . $eqLogic->getHumanName(true, true) . '</span>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
        <a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
        <a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
        <a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
            <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li>
            <li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
            <li role="presentation"><a href="#apptab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Liste des applications}}</a></li>

        </ul>
        <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
            <div role="tabpanel" class="tab-pane active" id="eqlogictab">
                <br />

                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header backgroundColor">
                            <h3 class="eqlogic-box-title">{{ Configuration générale }}</h3>
                        </div>
                        <div class="box-body">
                            <form class="form-horizontal">
                                <fieldset>
                                    <legend>{{Général}}</legend>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">{{Nom de l'équipement}}</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
                                            <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement}}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" >{{Objet parent}}</label>
                                        <div class="col-sm-3">
                                            <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
                                                <option value="">{{Aucun}}</option>
                                                <?php
                                                foreach (object::all() as $object) {
                                                    echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">{{Catégorie}}</label>
                                        <div class="col-sm-9">
                                            <?php
                                            foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                                                echo '<label class="checkbox-inline">';
                                                echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                                                echo '</label>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">{{Commentaire}}</label>
                                        <div class="col-sm-3">
                                            <textarea class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="commentaire" ></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-8">
                                            <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
                                            <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
                                        </div>
                                    </div>

                                </fieldset>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="box">
                        <div class="box-header backgroundColor">
                            <h3 class="eqlogic-box-title">{{ Configuration équipement }}</h3>
                        </div>
                        <div class="box-body">
                            <form class="form-horizontal">
                                <fieldset>
                                    <legend>{{Paramètres}}</legend>
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-3 control-label">{{Assistant}}</label>
                                        <div class="col-sm-3">
                                            <a class="btn btn-infos" id="bt_configureAdb"><i class="fa fa-android"></i> {{Connecter un appareil Android}}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="col-sm-3 control-label">{{Methode de connection}}</label>
                                        <div class="col-sm-6">
                                            <select class="eqLogicAttr form-control tooltips" data-l1key="configuration" data-l2key="type_connection" title="{{Veuillez préciser la methode de connection our votre appareil.}}">
                                                <option value="TCPIP">TCPIP</option>
                                                <option value="USB">USB</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">{{Adresse IP}}</label>
                                        <div class="col-sm-3">
                                            <input id="ip_address" data-inputmask="'alias': 'ip'" data-mask="" type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="ip_address"/>
                                        </div>
                                    </div>

                                </fieldset>
                                </br>
                                <fieldset>
                                    <legend>{{Informations}}</legend>
                                    <div class="alert alert-info">
                                        {{Le choix de la connection depend principalement de votre appareil Android. Il y a des avantages et inconvénients pour chaque:<br>
                                        - USB: nécéssite un cable et par consquent que votre Android soit a proximité de votre Jeedom<br>
                                        - ADB: Ne nécéssite aucune application tierce sur votre Android mais en focntion des équipements la connection peu etre capricieuse<br>
                                        - SSH: A venir (encours d'étude de faisabilité)<br>}}
                                    </div>
                                    <div class="alert alert-danger">
                                        {{Si vous choisissez la connection USB, seul 1 périphérique peut etre controlé. Le plugin ne gère pas la connection USB et TCPIP en meme temps}}
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <span id="serviceName" class="eqLogicAttr" data-l1key="configuration" data-l2key="serviceName" style="display:none;"></span>
                    </div>

                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="commandtab">
                <table id="table_cmd" class="table table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th>{{Nom}}</th><th>{{Type}}</th><th>{{Afficher}}</th><th>{{Action}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <div role="tabpanel" class="tab-pane" id="apptab">
                <div class="alert alert-info">
                    {{Attention, il faut veillez a selectionner le type "action" et le sous-type "defaut" lors de la création d'une nouvelle application}}
                </div>
                <a class="btn btn-success btn-sm cmdAction pull-right addAppli" data-action="add" style="margin-top:5px;"><i class="fa fa-plus-circle"></i> {{Applications}}</a><br/><br/>
                <table id="table_appli" class="table table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th>{{Icon}}</th><th>{{Nom}}</th><th>{{Type}}</th><th>{{Commande}}</th><th>{{Afficher}}</th><th>{{Action}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<?php include_file('desktop', 'AndroidRemoteControl', 'js', 'AndroidRemoteControl');?>
<?php include_file('core', 'plugin.template', 'js');?>

<script>
    $("#bt_serviceLog").click(function(){
        $('#md_modal').dialog({title: "{{Logs}}"});
        $('#md_modal').load('index.php?v=d&plugin=AndroidRemoteControl&modal=log.AndroidRemoteControl').dialog('open');
    });

    $("#bt_configureAdb").click(function(){
        $('#md_modal').dialog({title: "{{Configuration de votre appareil Android}}"});
        $('#md_modal').load('index.php?v=d&plugin=AndroidRemoteControl&modal=configureadb.AndroidRemoteControl').dialog('open');
    });

</script>
