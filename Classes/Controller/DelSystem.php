<?php
class Controller_DelSystem extends Controller_Abstract
{
    public function main()
    {
        $systemDml = new Db_SystemDml();
        if (!is_null($this->getRequest()->getParamByName('id'))) {
            $systemConnectionDml = new Db_SystemConnectionDml();
            $systemName = $systemDml->getAllById($this->getRequest()->getParamByName('id'));
            $systemName = $systemName[0]->name;
            $this->addToView('systemNameDeleted', $systemName);
            $systemDml->deleteById($this->getRequest()->getParamByName('id'));
            $nrOfAffectedConnections = $systemConnectionDml->getAllByParentId($this->getRequest()->getParamByName('id'));
            $this->addToView('nrOfAffectedSystems', $nrOfAffectedConnections);
            $systemConnectionDml->deleteById($this->getRequest()->getParamByName('id'));
        }
        $data = $systemDml->fetchAll();
        $this->addToView('systemResult', $data);
    }
}