<?php
class Controller_AddChildren extends Controller_Abstract
{
    public function run()
    {
        $this->_checkFormSend()
             ->_proccedConnections()
             ->_getAllFromDb();
        parent::run();
    }
    /**
     *
     * @return Controller_AddChildren
     */
    protected function _proccedConnections()
    {
        $systemDml = new Db_SystemDml();
        $systemConnectionDml = new Db_SystemConnectionDml();
        $this->addToView('parent', $systemDml->getAllById($this->getRequest()->getParamByName('id')));
        return $this;
    }
    /**
     *
     * @return Controller_AddChildren
     */
    protected function _getAllFromDb()
    {
        $dml = new Db_SystemDml();
        $data = $dml->fetchAll();
        $this->addToView('systemResult', $data);
        return $this;
    }

    protected function _checkFormSend()
    {
        if ($this->getRequest()->getParamByName('Speichern') == 'saveOwn') {
            $form = new Form_NewSystem();
            $formCheck = $form->proceedFormRequest()->checkForm();
            if (count($formCheck) == 0) {
                $this->_saveFormOwn();
            }
            $this->addToView('formError', $formCheck);
        } elseif ($this->getRequest()->getParamByName('Speichern') == 'save') {
            $this->_saveForm();
        }
        return $this;
    }
    /**
     *
     * @return Controller_AddChildren
     */
    protected function _saveForm()
    {
        $systemConnectionModell = new Db_SystemConnectionModell();
        $systemConnectionDml = new Db_SystemConnectionDml();
        $systemConnectionModell->setSystemParent((int)$this->getRequest()->getParamByName('id'));
        $this->_saveNewConnections($systemConnectionModell, $systemConnectionDml)
             ->_deleteConnections($systemConnectionModell, $systemConnectionDml);
        return $this;

    }

    /**
     *
     * @param Db_SystemConnectionModell $systemConnectionModell
     * @param Db_SystemConnectionDml $systemConnectionDml
     * @return Controller_AddChildren
     */
    protected function _deleteConnections($systemConnectionModell, $systemConnectionDml)
    {
        if (!is_null($this->getRequest()->getParamByName('deleteConnection'))) {
            foreach ($this->getRequest()->getParamByName('deleteConnection') as $value) {
                $systemConnectionModell->setSystemChild((int)$value);
                $systemConnectionDml->deleteByParentChild($systemConnectionModell);
            }
        }

        return $this;
    }
    /**
     *
     * @param Db_SystemConnectionModell $systemConnectionModell
     * @param Db_SystemConnectionDml $systemConnectionDml
     * @return Controller_AddChildren
     */
    protected function _saveNewConnections($systemConnectionModell, $systemConnectionDml)
    {
        $desciptions = $this->getRequest()->getParamByName('description');
        $failureProbapilities = $this->getRequest()->getParamByName('failureProbability');
        $mailfunctionImpacts = $this->getRequest()->getParamByName('malfunctionImpact');
        $severites = $this->getRequest()->getParamByName('severity');

        foreach ($this->getRequest()->getParamByName('child') as $key => $value) {
            $systemConnectionModell->setSystemChild((int)$value)
            ->setDescription($desciptions[(int)$value])
            ->setFailureProbability($failureProbapilities[(int)$value])
            ->setMalfunctionImpact($mailfunctionImpacts[(int)$value])
            ->setSeverity($severites[(int)$value]);
            $systemConnectionDml->insert($systemConnectionModell);
        }

        return $this;
    }
    /**
     *
     * @return Controller_AddChildren
     */
    protected function _saveFormOwn()
    {
        $systemModel = new Db_SystemModell();
        $systemDml = new Db_SystemDml();
        $systemModel->setName($this->getRequest()->getParamByName('systemName'))
                    ->setContact($this->getRequest()->getParamByName('systemContact'))
                    ->setPlace($this->getRequest()->getParamByName('systemPlace'))
                    ->setInfoLink($this->getRequest()->getParamByName('systemInfoLink'))
                    ->setClassification($this->getRequest()->getParamByName('systemClassification'))
                    ->setIsForeign($this->getRequest()->getParamByName('isForeign'));
        $newSystemId = $systemDml->insert($systemModel);

        $systemConnectionModell = new Db_SystemConnectionModell();
        $systemConnectionModell->setSystemParent((int)$this->getRequest()->getParamByName('id'))
                               ->setSystemChild((int)$newSystemId)
                               ->setDescription($this->getRequest()->getParamByName('description'))
                               ->setFailureProbability($this->getRequest()->getParamByName('failureProbability'))
                               ->setMalfunctionImpact($this->getRequest()->getParamByName('malfunctionImpact'))
                               ->setSeverity($this->getRequest()->getParamByName('severity'));

        $systemConnectionDml = new Db_SystemConnectionDml();
        $systemConnectionDml->insert($systemConnectionModell);

        return $this;
    }
}