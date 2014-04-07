<?php
/*
 * Copyright 2008 ICMBio
 * Este arquivo é parte do programa SISICMBio
 * O SISICMBio é um software livre; você pode redistribuíção e/ou modifição dentro dos termos
 * da Licença Pública Geral GNU como publicada pela Fundação do Software Livre (FSF); na versão
 * 2 da Licença.
 *
 * Este programa é distribuíção na esperança que possa ser útil, mas SEM NENHUMA GARANTIA; sem
 * uma garantia implícita de ADEQUAÇÃO a qualquer MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
 * Licença Pública Geral GNU/GPL em português para maiores detalhes.
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU, sob o título "LICENCA.txt",
 * junto com este programa, se não, acesse o Portal do Software Público Brasileiro no endereço
 * www.softwarepublico.gov.br ou escreva para a Fundação do Software Livre(FSF)
 * Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301, USA
 * */

$pode_homologar = AclFactory::checaPermissao(
        Controlador::getInstance()->acl, 
        Controlador::getInstance()->usuario, 
        DaoRecurso::getRecursoById(1140404));

$pode_imprimir  = AclFactory::checaPermissao(
        Controlador::getInstance()->acl, 
        Controlador::getInstance()->usuario, 
        DaoRecurso::getRecursoById(1140403));
?>
<script type="text/javascript">
    try{
        var oTabelaAssuntosDoc = null;
        
        $(document).ready(function() {
            
            /* Tabela Assuntos de Documento */
            oTabelaAssuntosDoc = $('#TabelaAssuntosDoc').dataTable({
                aLengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                bStateSave: false,
                bPaginate: true,
                bProcessing: true,
                bServerSide: true,
                bJQueryUI: true,
                sPaginationType: "full_numbers",
<?php
// verifica a existencia da ao menos uma das permissões abaixo
if ($pode_homologar || $pode_imprimir)
{
?>
                "sDom": '<"H"Tlfr>t<"F"ip>',
                "oTableTools": {
                    "sSwfPath": "plugins/datatables-1.9.1/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
                    "sRowSelect": "multi",
                    "fnRowSelected": function ( node ) {
                        var id = $.data(node, 'cid');
                        $("#assunto_d_"+id).attr('checked',true);
                    },
                    "aButtons": [
<?php
if ($pode_imprimir)
{
?>
                        {
                            "sExtends":    "print",
                            "sButtonText": "Imprimir",
                            "sInfo": "Pressione ESC quando finalizar"
                        },
<?php
}
if ($pode_homologar)
{
?>
                        {
                            "sExtends":    "text",
                            "sButtonText": "Selecionar todos",
                            "fnClick": function (nButton, oConfig) {
                                var linhas = oTabelaAssuntosDoc.$('tr',{'filter':'applied'},'none','current','current');
                                var oTT = this;
                                linhas.each(function(index,domE) {
                                    oTT.fnSelect(domE);
                                });
                            }
                        },
                        {
                            "sExtends":    "select",
                            "sButtonText": "Definir assunto correto",
                            "fnClick": function ( nButton, oConfig, oFlash ) {
                                var checks = $('input:checkbox[name="assunto_d[]"]:checked');
                                if (checks.length == 0) {
                                    alert('Selecione ao menos um assunto para corrigir!');
                                    return false;
                                }
                                $('#ASSUNTO_REAL_DOC_ALTERAR').empty();
                                $('#ASSUNTO_REAL_DOC_ALTERAR').html('<option value="" selected="selected">Digite o filtro abaixo</option>');
                                $('#FILTRO_ASSUNTO_REAL_DOC_ALTERAR').val("");
                                $("#FILTRO_ASSUNTO_REAL_DOC_ALTERAR").unbind();
                                $("#FILTRO_ASSUNTO_REAL_DOC_ALTERAR").autocompleteonline({
                                    url: 'modelos/combos/autocomplete.php',
                                    idComboBox: 'ASSUNTO_REAL_DOC_ALTERAR',
                                    minChars: 1,
                                    delay: 2500,
                                    extraParams: {
                                        action: 'documentos-assuntos'
                                    }
                                });

                                $('#div-alterar-assunto-real-doc').dialog('open');
                            }
                        }
<?php
}
?>
                    ],
                    "fnRowDeselected": function ( node ) {
                        var id = $.data(node, 'cid');
                        $("#assunto_d_"+id).attr('checked',false);
                    }
                },
<?php
}
?>
                sAjaxSource: "modelos/administrador/listar_assuntos_documentos.php",
                "aoColumns": [
                    { "sWidth": "6px" },
                    { "sWidth": "180px" },
                    { "sWidth": "180px" },
                    { "sWidth": "90px" },
                    { "sWidth": "25px" },
                    { "sWidth": "90px" }
                ],
                oLanguage: {
                    sProcessing: "Carregando...",
                    sLengthMenu: "_MENU_ por página",
                    sZeroRecords: "Nenhum assunto encontrado.",
                    sInfo: "_START_ a _END_ de _TOTAL_ assuntos",
                    sInfoEmpty: "Nao foi possivel localizar assuntos com o parametros informados!",
                    sInfoFiltered: "",
                    sInfoPostFix: "",
                    sSearch: "Pesquisar:",
                    oPaginate: {
                        sFirst: "Primeiro",
                        sPrevious: "Anterior",
                        sNext: "Próximo",
                        sLast: "Ultimo"
                    }
                },
                fnServerData: function ( sSource, aoData, fnCallback ) {
                    $.getJSON( sSource, aoData, function (json) {
                        fnCallback(json);
                    } );
                },
                fnRowCallback: function( nRow, aData, iDisplayIndex ) {
                    nRow.setAttribute( 'title', aData[1] );
                    nRow.setAttribute( 'id', 'pr_'+aData[0]);
                    $.data(nRow, 'cid', aData[0]);

                    $('td:eq(0)', nRow).html('<input type="checkbox" id="assunto_d_'+aData[0]+'" name="assunto_d[]" value="'+aData[0]+'">');

                    var $line = $('td:eq(5)', nRow);
                    $line.html('<div title="">');
                    
                    /*Assunto*/
                    if(aData[1]==''){
                        $('td:eq(1)', nRow).html('<div title=""></div>');
                    }

                    /*Assunto Correto*/
                    if(aData[2]==null){
                        $('td:eq(2)', nRow).html('O próprio');
                    }

                    /*Situação*/
                    if(aData[4]==1){
                        $('td:eq(4)', nRow).html('Homologado');
                    }else{
                        $('td:eq(4)', nRow).html('Não-homologado');
                    }

<?php
// verifica a existencia da permissao para alterar assunto de processo
if (AclFactory::checaPermissao(Controlador::getInstance()->acl, Controlador::getInstance()->usuario, DaoRecurso::getRecursoById(1140401))) {
?>
                    $("<img/>", {
                        src: 'imagens/alterar.png',
                        title: 'Editar',
                        'class': 'botao32'
                    }).bind( "click", function(){
                        jquery_detalhar_docs(aData[0]);
                    }).appendTo($line);

<?php
}
// verifica a existencia da permissao para homologar
if ($pode_homologar) {
?>
                    $("<img/>", {
                        src: 'imagens/icones/32/alterar-homologacao.png',
                        title: 'Alterar situação',
                        'class': 'botao32'
                    }).bind( "click", function(){
                        jquery_alterar_homologacao_doc(aData[0], aData[4]==0?1:0);
                    }).appendTo($line);

<?php
}
?>
                    $("</div>").appendTo($line);

                    return nRow;
                },
                fnDrawCallback: function (oSettings, nRow) {},
                aoColumnDefs: [
                    { bSortable: false, aTargets: [0, 5] }
                ]
            }).fnFilterOnEnter();


            $('#formAssuntosDocNormalizar').ajaxForm({
                dataType: 'json',
                data: {
                    acao: 'alterar-real'
                },
                beforeSend: function() {
                    $('#progressbar').show();
                },
                beforeSubmit: function(a,f,o) {
                },
                success: function(data) {
                    $('#progressbar').hide();
                    if(data.success == 'true'){
                        $('#div-alterar-assunto-real-doc').dialog("close");
                        alert('Assuntos corrigidos!');
                        oTabelaAssuntosDoc.fnDraw(false);
                    }else{
                        alert('Ocorreu um erro ao tentar definir verdadeiro assunto!\n['+data.error+']');
                    }
                }
            });

            $('#div-alterar-assunto-real-doc').dialog({
                autoOpen: false,
                resizable: false,
                modal: true,
                width: 600,
                autoHeight: true,
                buttons: {
                    Salvar: function() {
                        if($("#ASSUNTO_REAL_DOC_ALTERAR").val() != ''){
                            if (confirm('Você tem certeza que deseja alterar estes assuntos?')) {
                                $("#id_assunto_real_doc").val($("#ASSUNTO_REAL_DOC_ALTERAR").val());
                                $("#formAssuntosDocNormalizar").submit();
                            }
                        }else{
                            alert('Selecione o assunto real dos assuntos que foram marcados para modificação!');
                        }
                    }
                }
            });

        });
    } catch(e){
        alert('Ocorreu um erro:\n['+e+']');
    }

</script>      

    <form id="formAssuntosDocNormalizar" method="POST" action="modelos/administrador/assuntos_documentos.php">
        <table class="display" border="0" id="TabelaAssuntosDoc">
            <thead>
                <tr>
                    <th class="style13">#</th>
                    <th class="style13">Assunto</th>
                    <th class="style13">Assunto Correto</th>
                    <th class="style13">Usuário</th>
                    <th class="style13">Situação</th>
                    <th class="style13">Opções</th>
                </tr>
            </thead>
        </table>
        <input type="hidden" name="id_assunto_real" id="id_assunto_real_doc" value="" />
    </form>

    <div id="div-alterar-assunto-real-doc" class="div-form-dialog" title="Definir Assunto Correto de Documento(s)">
        <fieldset>
            <label>Informações Principais</label>
            <input id="ID_DOCS_ALTERAR" type="hidden" value="" />
            <div class="row">
                <label class="label">*ASSUNTO CORRETO:</label>
                <span class="conteudo">
                    <select class="FUNDOCAIXA1" id="ASSUNTO_REAL_DOC_ALTERAR">
                        <option value="" selected="selected">Digite o filtro abaixo</option>
                    </select>
                </span>
            </div>
            <div class="row">
                <label class="label" for="FILTRO_ASSUNTO_REAL_DOC_ALTERAR">FILTRAR:</label>
                <span class="conteudo">
                    <input id="FILTRO_ASSUNTO_REAL_DOC_ALTERAR" onkeyup="DigitaLetraSeguro(this)" class="FUNDOCAIXA1" style="border: 1px solid #9AC619;-moz-border-radius: 5px;-webkit-border-radius: 5px;padding: 2px;">
                </span>
            </div>
        </fieldset>
    </div>