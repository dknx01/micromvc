<?php
class Controller_Input extends Controller_Abstract
{
    public function run()
    {
        $this->_checkFormSend();
        $this->_getAllFromDb();
        parent::run();
    }

    protected function _getAllFromDb()
    {
        $dml = new Db_SystemDml();
        $data = $dml->fetchAll();
        $this->addToView('systemResult', $data);
    }

    protected function _checkFormSend()
    {
        if ($this->getRequest()->getParamByName('Speichern') == 'save') {
            $form = new Form_Input();
            $formCheck = $form->proceedFormRequest()->checkForm();
            if (count($formCheck) == 0) {
                $this->_saveForm();
            }
            $this->addToView('formError', $formCheck);
        }
    }

    protected function _saveForm()
    {
        $modell = new Db_SystemModell();
        $modell->setName($this->getRequest()->getParamByName('systemName'))
               ->setContact($this->getRequest()->getParamByName('systemContact'))
               ->setPlace($this->getRequest()->getParamByName('systemPlace'))
               ->setInfoLink($this->getRequest()->getParamByName('systemInfoLink'))
               ->setClassification($this->getRequest()->getParamByName('systemClassification'))
               ->setIsForeign($this->getRequest()->getParamByName('isForeign'));
        $dml = new Db_SystemDml();
        $dml->insert($modell);
    }
}