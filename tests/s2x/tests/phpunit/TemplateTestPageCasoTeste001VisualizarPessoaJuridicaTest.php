<?php

/**
 * @author Michael Fernandes <cerberosnash@gmail.com>
 */
class ManterPessoaJuridicaSgdoceSuite1VisualizarPessoaJuridicaCasoTeste001VisualizarPessoaJuridica extends PHPUnit_Extensions_SeleniumTestCase {

    protected function setUp() {
        $this->setBrowser(PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_BROWSER);
        $this->setBrowserUrl(PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_TESTS_URL);
        $this->setHost(PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_HOST);
        $this->setPort((int) PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_PORT);
    }

    public function testMyTestCase() {
        $this->open("/ProjectSgdoc.ManterPessoaJuridicaSgdoce.Suite1VisualizarPessoaJuridica");
        $this->click("link=Add");
        $this->click("link=Test page");
        $this->waitForPageToLoad("30000");
        $this->type("id=pagename", "CasoTeste001VisualizarPessoaJuridica");
        $this->type("id=pageContent", "!contents -R2 -g -p -f -h\n" . '| script | selenium driver fixture |
| start browser | firefox | on url | https://tcti.sgdoce.sisicmbio.icmbio.gov.br/ |
| save screenshot after | every step | in folder | http://files/ProjectSgdoc/testResults/screenshots/${PAGE_NAME}_on_action |
| set step delay to | slow |
| do | open | on | / |
| ensure | do | type | on | id=nuCpf | with | 737.623.851-49 |
| ensure | do | type | on | id=senha | with | 0123456789 |
| ensure | do | clickAndWait | on | css=button.btn.btn-primary |
| ensure | do | clickAndWait | on | link=Acessar » |
| do | open | on | /artefato/minuta-eletronica/index |
| $nmTipoDocumento= | is | storeExpression | on | CARTA |
| $nmAssunto= | is | storeExpression | on | ASSEMBLEIA GERAL |
| $nmEstado= | is | storeExpression | on | Distrito Federal |
| $nmMunicipio= | is | storeExpression | on | Brasília |
| $nmTipoPessoa= | is | storeExpression | on | Pessoa Jurídica |
| $nmPessoaJuridica= | is | storeExpression | on | João Matuto Ltda |
| $nuCnpj= | is | storeExpression | on | 73.958.270/0001-83 |
| ensure | do | type | on | id=sqTipoDocumento | with | $nmTipoDocumento |
| ensure | do | typeKeys | on | id=sqTipoDocumento | with | keyUp |
| ensure | do | waitForElementPresent | on | class=sel |
| ensure | do | click | on | class=sel |
| ensure | do | type | on | id=sqAssunto | with | $nmAssunto |
| ensure | do | typeKeys | on | id=sqAssunto | with | keyUp |
| ensure | do | waitForElementPresent | on | class=sel |
| ensure | do | click | on | class=sel |
| ensure | do | clickAndWait | on | css=button.btn.btn-primary |
| ensure | do | select | on | id=sqEstado | with | label=$nmEstado |
| ensure | do | type | on | id=sqMunicipio | with | $nmMunicipio |
| ensure | do | typeKeys | on | id=sqMunicipio | with | keyUp |
| ensure | do | waitForElementPresent | on | class=sel |
| ensure | do | click | on | class=sel |
| ensure | do | click | on | link=Destinatário |
| ensure | do | click | on | css=i.icon-plus |
| ensure | do | waitForElementPresent | on | css=h3 | with | Adicionar Destinatário |
| ensure | do | select | on | id=sqTipoPessoa | with | label=Selecione |
| ensure | do | select | on | id=sqTipoPessoa | with | label=$nmTipoPessoa |
| ensure | do | type | on | id=sqPessoaDestinatario | with | $nmPessoaJuridica |
| ensure | do | typeKeys | on | id=sqPessoaDestinatario | with | keyUp |
| ensure | do | waitForElementPresent | on | class=sel |
| ensure | do | click | on | class=sel |
| do | fireEvent | on | id=sqPessoaDestinatario | with | blur |
| ensure | do | click | on | !-xpath=(//button[@type="button"])[4]-! |
| ensure | do | click | on | id=visualizarPJDest |
| ensure | do | waitForText | on | css=#visualizarPJ &gt; div.modal-header &gt; h3 | with | Visualizar Pessoa Jurídica |
| check | is | assertText | on | css=form.form-horizontal.visualizar &gt; div.control-group &gt; label.control-label | CNPJ |
| check | is | assertText | on | !-//div[@id="visualizarPJ"]/div[2]/div/form/div[2]/label-! | Razão Social |
| check | is | assertText | on | !-//div[@id="visualizarPJ"]/div[2]/div/form/div[3]/label-! | Nome Fantasia |
| check | is | assertText | on | !-//div[@id="visualizarPJ"]/div[2]/div/form/div[4]/label-! | Inscrição Estadual |
| check | is | assertText | on | css=form.form-horizontal.visualizar &gt; fieldset &gt; legend | Endereço |
| check | is | assertText | on | css=form.form-horizontal.visualizar &gt; fieldset &gt; div.control-group &gt; label.control-label | Tipo de Endereço |
| check | is | assertText | on | !-//div[@id="visualizarPJ"]/div[2]/div/form/fieldset/div[2]/label-! | CEP |
| check | is | assertText | on | !-//div[@id="visualizarPJ"]/div[2]/div/form/fieldset/div[3]/label-! | Logradouro |
| check | is | assertText | on | !-//div[@id="visualizarPJ"]/div[2]/div/form/fieldset/div[4]/label-! | Complemento |
| check | is | assertText | on | !-//div[@id="visualizarPJ"]/div[2]/div/form/fieldset/div[5]/label-! | Número |
| check | is | assertText | on | !-//div[@id="visualizarPJ"]/div[2]/div/form/fieldset/div[6]/label-! | Bairro |
| check | is | assertText | on | !-//div[@id="visualizarPJ"]/div[2]/div/form/fieldset/div[7]/label-! | UF |
| check | is | assertText | on | !-//div[@id="visualizarPJ"]/div[2]/div/form/fieldset/div[8]/label-! | Município |
| check | is | assertText | on | !-//div[@id="visualizarPJ"]/div[2]/div/form/fieldset[2]/legend-! | Matriz |
| check | is | assertText | on | !-//div[@id="visualizarPJ"]/div[2]/div/form/fieldset[2]/div/label-! | CNPJ |
| check | is | assertText | on | !-//div[@id="visualizarPJ"]/div[2]/div/form/fieldset[2]/div[2]/label-! | Razão Social |
| ensure | do | click | on | link=Fechar |
| stop browser |
');
        $this->click("name=save");
        $this->waitForPageToLoad("30000");
    }

}
