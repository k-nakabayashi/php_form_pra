<?php
//Main Role: ServiceProvider

class MiddleWareService {

    private static $m_redirect = null;
    private $m_commandBefore = null;
    private $m_commandAfter = null;

    public function __construct ()
    {
        $this->m_commandBefore = $this->setCommands(MIDDLE_BEFORE);
        $this->m_commandAfter = $this->setCommands(MIDDLE_AFTER);
    }
    
    public function executeBefore ()
    {
        
        $resultOK = false;
        
        $resultOK = $this->executeCommand('global');
        $resultOK = $this->executeCommand('group', $resultOK);
        $resultOK = $this->executeCommand('local', $resultOK);

        //結果を返す
        return $resultOK;
    }

    public function executeAfter()
    {
        return true;
    }


    private function executeCommand($i_type, $o_resultOK = null)
    {
        if ($i_type === 'global') {
            $o_resultOK = true;
        }
        if (!$o_resultOK) {
            return false;
        }

        $commandList = $this->m_commandBefore[$i_type];
        foreach ($commandList as $command) {
            $o_resultOK =  $command->handle();

            if (!$o_resultOK) {
                //結果リダイレクト先を設定する
                self::$m_redirect = $command->m_redirect;
                break;
            }
        }
        return $o_resultOK;
    }
    //以下、設定
    public function setRedirect()
    {
        setResponseRedirect(self::$m_redirect);
    }

    private function setCommands ($i_middlePares) {

        $o_commandList = [
            'global' => [],
            'group' => [],
            'local' => []
        ];

        $keys = null;
        $command = null;
        $level = null;

        //global
        $commandList = $i_middlePares['global'];
        $keys = array_keys($commandList);
        for($keyIndex = 0; $keyIndex < count($keys); $keyIndex ++){
            $commandPath = $commandList[$keys[$keyIndex]];
            $command = getInstanceByPath($commandPath);
            if ($command !== null) {
                array_push($o_commandList['global'], $command);
            }
        }

        //global
        $commandList = $i_middlePares['group'];
        $keys = array_keys($commandList);
        for($keyIndex = 0; $keyIndex < count($keys); $keyIndex ++){
            $commandPath = $commandList[$keys[$keyIndex]];
            $command = getInstanceByPath($commandPath);
            if ($command !== null) {
                array_push($o_commandList['group'], $command);
            }
        }

        //global
        $commandList = $i_middlePares['local'];
        $keys = array_keys($commandList);
        for($keyIndex = 0; $keyIndex < count($keys); $keyIndex ++){
            $commandPath = $commandList[$keys[$keyIndex]];
            $command = getInstanceByPath($commandPath);
            if ($command !== null) {
                array_push($o_commandList['local'], $command);
            }
        }
        
        return $o_commandList;
    }



}