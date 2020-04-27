<?php
require_once(UTILITY_BASE.'Middleware.php');
//Main Role: ServiceProvider

class MiddleWareService {

    private static $m_redirect = null;
    private $m_commandBefore = null;
    private $m_commandAfter = null;

    public function __construct()
    {
        $this->m_commandBefore = $this->setCommands('before');
        $this->m_commandAfter = $this->setCommands('after');
    }
    

    public function executeBefore()
    {
        $resultOK = false;
        $resultOK = $this->excuteCommand('before');
        return  $resultOK;
    }

    public function executeAfter()
    {
        $resultOK = false;
        $resultOK = $this->excuteCommand('after');
        return  $resultOK;
    }

    private function excuteCommand($i_timing) 
    {

        $resultOK = false;
        $resultOK = $this->handleCommand('global', $i_timing);
        $resultOK = $this->handleCommand('wrapper', $i_timing, $resultOK);
        $resultOK = $this->handleCommand('single', $i_timing, $resultOK);

        //結果を返す
        return $resultOK;
    }
    
    private function handleCommand($i_type, $i_timing, $o_resultOK = false)
    {
        //設定1
        $resultOK = $o_resultOK;

        if($i_type === 'global') {
            $resultOK = true;
        }
        if(!$resultOK) {
            return false;
        }

        //設定2
        $commandList = null;
        if($i_timing === 'before') {
            $commandList = $this->m_commandBefore[$i_type];
        } else if($i_timing === 'after') {
            $commandList = $this->m_commandAfter[$i_type];
        }
        if($commandList = null) {
            return true;
        }
        //処理
        foreach($commandList as $commandPath) {
            $command = getInstanceByPath($commandPath);
            if($command !== null) {
                $resultOK =  $command->handle();
            }
            if(!$resultOK) {
                //結果リダイレクト先を設定する
                self::$m_redirect = $command->m_redirect;
                break;
            }
        }
        return $resultOK;
    }

//////以下、設定//////////////////////////////////////////////////////////////////
    public function setRedirect()
    {
        setResponseRedirect(self::$m_redirect);
    }

    private function setCommands($i_middleTiming) {

        //該当するmiddlewareだけに絞り込みたい。
        $o_commandList = [
            'global' => [],
            'wrapper' => [],
            'single' => []
        ];
   
        $targetMiddleWare = null;
      
        //global
        $targetMiddleWare[$i_middleTiming] = array_keys(MIDDLE_GLOBAL[$i_middleTiming]);
        $o_commandList['global'] = $this->getSortedCommands(
            'global', $targetMiddleWare, $i_middleTiming, MIDDLE_GLOBAL);

        $targetMiddleWare = getTargetMiddleWare();
        //ラッパー vistorとcompist?
        $o_commandList['wrapper'] = $this->getSortedCommands(
            'wrapper', $targetMiddleWare, $i_middleTiming, MIDDLE_LOCAL);

        //個別
        $o_commandList['single'] = $this->getSortedCommands(
            'single',  $targetMiddleWare, $i_middleTiming, MIDDLE_LOCAL);

        
        return $o_commandList;
    }

    private function getSortedCommands($i_level, $i_MiddleWare, $i_timing, $i_configMiddle)
    {
        $commandNameList = null;
        if($i_level === 'global') {
            $commandNameList = $i_MiddleWare[$i_timing];
            $i_configMiddle = $i_configMiddle[$i_timing];
        } else {
            $targetMiddleware = $i_MiddleWare[$i_level][$i_timing];
            $commandNameList = $this->selectMiddleNames($targetMiddleware , $i_configMiddle);
        }
        $sortedCommands = $this->getSortedCommandList($commandNameList, $i_configMiddle);
        return $sortedCommands;
    }

    private function selectMiddleNames($i_tergetMiddlePare, $i_configMiddle)
    {
        $commandNameList = [];
        foreach($i_tergetMiddlePare as $middleName) {
            $middleExitence = $i_configMiddle[$middleName];
            if(!empty($middleExitence)) {
                array_push($commandNameList, $middleName);
            }
        }
        return $commandNameList;
    }

    private function getSortedCommandList($commandNameList, $i_configMiddle) {

        $o_commandList = [];
        for($keyIndex = 0; $keyIndex < count($commandNameList); $keyIndex ++){
            $key = $commandNameList[$keyIndex];
            $commandPath = $i_configMiddle[$key];
            if(gettype($commandPath) === 'array') {
                foreach($commandPath as $innerCommandPath) {
                    $existenceOK = file_exists($innerCommandPath);
                    if($existenceOK) {
                        array_push($o_commandList, $innerCommandPath);
                    }
                }
                continue;
            }
            $existenceOK = file_exists($commandPath);
            if($existenceOK) {
                array_push($o_commandList, $commandPath);
            }
        }

        return $o_commandList;
    }
}