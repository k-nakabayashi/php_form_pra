<?php
//Main Role: ServiceProvider
//Sub Roke : Cordinator
namespace infru\core\manager;
require_once(UTILITY_BASE.'Middleware.php');


class MiddleWareManeger {

    private $m_commandBefore = null;
    private $m_commandAfter = null;

    public function __construct()
    {
        $this->m_commandBefore = $this->setCommands('before');
        $this->m_commandAfter = $this->setCommands('after');
    }
    
    public function executeBefore()
    {
        $o_resultOK = false;
        $o_resultOK = $this->handleCommand('before');
        return  $o_resultOK;
    }

    public function executeAfter()
    {
        $o_resultOK = false;
        $o_resultOK = $this->handleCommand('after');
        return  $o_resultOK;
    }

    private function handleCommand($i_timing) 
    {

        $o_resultOK = false;
        $o_resultOK = $this->excuteCommand('global', $i_timing);
        $o_resultOK = $this->excuteCommand('wrapper', $i_timing, $o_resultOK);
        $o_resultOK = $this->excuteCommand('single', $i_timing, $o_resultOK);

        //結果を返す
        return $o_resultOK;
    }
    
    private function excuteCommand($i_type, $i_timing, $i_resultOK = false)
    {
        //設定1
        $o_resultOK = $i_resultOK;

        if($i_type === 'global') {
            $o_resultOK = true;
        }
        if(!$o_resultOK) {
            return false;
        }

        //設定2
        $commandList = null;
        if($i_timing === 'before') {
            $commandList = $this->m_commandBefore[$i_type];
        } else if($i_timing === 'after') {
            $commandList = $this->m_commandAfter[$i_type];
        }
        if($commandList === null) {
            //ここがミソ。何もミドルウェアがなければtrueになる。
            return true;
        }
        
        //処理
        foreach($commandList as $commandPath) {
            $command = getInstanceByPath($commandPath);
            if($command !== null) {
                $o_resultOK =  $command->handle();
            }
            if(!$o_resultOK) {
                //結果リダイレクト先を設定する
                $command->failed();
                break;
            }
        }
        return $o_resultOK;
    }

//////以下、設定//////////////////////////////////////////////////////////////////


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
        $o_sortedCommands = null;

        $commandNameList = null;
        if($i_level === 'global') {
            $commandNameList = $i_MiddleWare[$i_timing];
            $i_configMiddle = $i_configMiddle[$i_timing];
        } else {
            $targetMiddleware = $i_MiddleWare[$i_level][$i_timing];
            $commandNameList = $this->selectMiddleNames($targetMiddleware , $i_configMiddle);
        }
        if (isset($commandNameList)) {
            $o_sortedCommands = $this->getSortedCommandList($commandNameList, $i_configMiddle);
        }

        return $o_sortedCommands;
    }

    private function selectMiddleNames($i_tergetMiddlePare, $i_configMiddle)
    {
        $commandNameList = [];
        if (empty($i_tergetMiddlePare)) {
            return null;
        }
        foreach($i_tergetMiddlePare as $middleName) {
            
            $middleExitence = array_key_exists($middleName, $i_configMiddle)? $i_configMiddle[$middleName] : null;
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
                    $existenceOK = class_exists($innerCommandPath);
                    if($existenceOK) {
                        array_push($o_commandList, $innerCommandPath);
                    }
                }
                continue;
            }
            $existenceOK = class_exists($commandPath);
            if($existenceOK) {
                array_push($o_commandList, $commandPath);
            }
        }

        return $o_commandList;
    }
}